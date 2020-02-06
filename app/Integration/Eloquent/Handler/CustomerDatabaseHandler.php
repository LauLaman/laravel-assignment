<?php

declare(strict_types=1);

namespace App\Integration\Eloquent\Handler;

use App\Domain\Customer\CustomerDatabaseHandlerInterface;
use App\Domain\Customer\CustomerModel;
use App\Domain\Database\Exception\NoResultException;
use App\Integration\Eloquent\Model\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerDatabaseHandler implements CustomerDatabaseHandlerInterface
{
    /**
     * @throws NoResultException
     */
    public function getByImportFingerPrint(string $fingerprint): Customer
    {
        try {
            return Customer::where('import_fingerprint', '=', $fingerprint)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new NoResultException();
        }
    }

    public function createFromModel(CustomerModel $model, string $fingerprint): Customer
    {
        $customer = new Customer();
        $customer->name = $model->getName();
        $customer->address = $model->getAddress();
        $customer->checked = $model->isChecked();
        $customer->description = $model->getDescription();
        $customer->interest = $model->getInterest();
        $customer->date_of_birth = $model->getDateOfBirth();
        $customer->email = $model->getEmail();
        $customer->account = $model->getAccount();
        $customer->import_fingerprint = $fingerprint;

        $customer->save();

        return  $customer;
    }
}
