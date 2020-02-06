<?php

declare(strict_types=1);

namespace Tests\Domain\Import\Customer;

use App\Domain\CreditCard\CreditCardDatabaseHandlerInterface;
use App\Domain\Customer\CustomerDatabaseHandlerInterface;
use App\Domain\Database\Exception\NoResultException;
use App\Domain\Import\Customer\CustomerImporterJson;
use App\Integration\Eloquent\Model\Customer;
use JsonException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CustomerImporterJsonTest extends TestCase
{
    private CustomerImporterJson $importer;

    /**
     * @var CustomerDatabaseHandlerInterface|MockObject
     */
    private CustomerDatabaseHandlerInterface $customerRepository;

    /**
     * @var CreditCardDatabaseHandlerInterface|MockObject
     */
    private CreditCardDatabaseHandlerInterface $cardRepository;

    protected function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerDatabaseHandlerInterface::class);
        $this->cardRepository = $this->createMock(CreditCardDatabaseHandlerInterface::class);
        $this->importer = new CustomerImporterJson($this->customerRepository, $this->cardRepository);
    }

    public function testInvalidJsonThrowsException(): void
    {
        $this->expectException(JsonException::class);
        $this->expectExceptionMessage('File could not be parsed. Error: Syntax error');

        $this->importer->load(__DIR__ . '/../../../files/json/invalid.json');
    }

    public function testValidEmptyJsonDoesNothing(): void
    {
        $this->importer->load(__DIR__ . '/../../../files/json/valid_empty.json');

        $this->customerRepository->expects($this->never())->method('getByImportFingerPrint');
        $this->customerRepository->expects($this->never())->method('createFromModel');
        $this->cardRepository->expects($this->never())->method('createFromModel');

        $this->importer->import();
    }
}
