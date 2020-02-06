<?php

declare(strict_types=1);

namespace App\Domain\Import\Requirement;

use App\Domain\CreditCard\CreditCardModel;
use App\Domain\Customer\CustomerModel;

class CreditCardImportRequirement implements ImportRequirementInterface
{
    public function test(CustomerModel $customer): bool
    {
        if (!$this->testCreditCardNumber($customer->getCreditCard())) {
            return false;
        }

        return true;
    }

    private function testCreditCardNumber(CreditCardModel $creditCard): bool
    {
        return preg_match('/\d*(\d)\1{2}\d*/m', $creditCard->getNumber()) === 1;
    }
}
