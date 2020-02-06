<?php

declare(strict_types=1);

namespace App\Domain\Import\Customer;

use App\Domain\CreditCard\CreditCardDatabaseHandlerInterface;
use App\Domain\Customer\CustomerDatabaseHandlerInterface;
use App\Domain\Customer\CustomerModel;
use App\Domain\Database\Exception\NoResultException;
use App\Domain\Import\Requirement\CreditCardImportRequirement;
use App\Domain\Import\Requirement\CustomerImportRequirement;
use App\Domain\Import\Requirement\ImportRequirementInterface;

abstract class CustomerImporter
{
    private string $fileFingerprint;

    protected array $data;

    private CustomerDatabaseHandlerInterface $customerRepository;

    private CreditCardDatabaseHandlerInterface $cardRepository;

    public function __construct(
        CustomerDatabaseHandlerInterface $customerRepository,
        CreditCardDatabaseHandlerInterface $cardRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->cardRepository = $cardRepository;
    }

    public function load(string $file): void
    {
        $this->fileFingerprint = hash_file('sha256', $file);
    }

    public function import(?callable $callback = null): void
    {
        if (!isset($this->data)) {
            throw new \LogicException('No data loaded. Load a file first with ::load()');
        }

        foreach ($this->data as $line => $json) {
            $customerModel = new CustomerModel();
            $customerModel->__unserialize($json);

            $alreadyImported = $this->isCustomerDataAlreadyImported($line);
            $doesMeetsImportRequirement = $this->doesMeetImportRequirements($customerModel);

            if (!$alreadyImported && $doesMeetsImportRequirement) {
                $customer = $this->customerRepository->createFromModel($customerModel, $this->getImportFingerprint($line));
                $this->cardRepository->createFromModel($customer, $customerModel->getCreditCard());
            }

            $callback($customerModel, $alreadyImported, $doesMeetsImportRequirement);
        }
    }

    private function isCustomerDataAlreadyImported(int $line): bool
    {
        try {
            $this->customerRepository->getByImportFingerPrint($this->getImportFingerprint($line));
        } catch (NoResultException $e) {
            return false;
        }

        return true;
    }

    private function doesMeetImportRequirements(CustomerModel $customerModel): bool
    {
        foreach ($this->getRequirements() as $requirement) {
            if (!$requirement->test($customerModel)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return ImportRequirementInterface[]
     */
    private function getRequirements(): array
    {
        return [
            new CustomerImportRequirement(),
//            new CreditCardImportRequirement(),
        ];
    }

    private function getImportFingerprint(int $line): string
    {
        return sprintf('%s-%s', $this->fileFingerprint, $line);
    }
}
