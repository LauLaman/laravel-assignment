<?php

declare(strict_types=1);

namespace App\Integration\Eloquent\Handler;

use App\Domain\CreditCard\CreditCardDatabaseHandlerInterface;
use App\Domain\CreditCard\CreditCardModel;
use App\Integration\Eloquent\Model\CreditCard;
use App\Integration\Eloquent\Model\Customer;

class CreditCardDatabaseHandler implements CreditCardDatabaseHandlerInterface
{
    public function createFromModel(Customer $customer, CreditCardModel $model): CreditCard
    {
        $creditCard = new CreditCard();
        $creditCard->type = $model->getType();
        $creditCard->number = $model->getNumber();
        $creditCard->name = $model->getName();
        $creditCard->expirationDate = $model->getExpirationDate();
        $creditCard->setCustomer($customer);

        $creditCard->save();

        return $creditCard;
    }
}
