<?php

declare(strict_types=1);

namespace App\Domain\Import\Requirement;

use App\Domain\Customer\CustomerModel;
use DateTime;

class CustomerImportRequirement implements ImportRequirementInterface
{
    public function test(CustomerModel $customer): bool
    {
        if (!$this->testDateOfBirth($customer)) {
            return false;
        }

        return true;
    }

    private function testDateOfBirth(CustomerModel $customer): bool
    {
        if ($customer->getDateOfBirth() === null) {
            return true;
        }

        $age = (new Datetime())->diff($customer->getDateOfBirth())->y;

        if ($age > 18 && $age < 65) {
            return true;
        }

        return false;
    }
}
