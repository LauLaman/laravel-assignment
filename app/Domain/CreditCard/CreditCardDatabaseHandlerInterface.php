<?php

declare(strict_types=1);

namespace App\Domain\CreditCard;

use App\Integration\Eloquent\Model\CreditCard;
use App\Integration\Eloquent\Model\Customer;

interface CreditCardDatabaseHandlerInterface
{
    public function createFromModel(Customer $customer, CreditCardModel $model): CreditCard;
}
