<?php

declare(strict_types=1);

namespace App\Domain\Import\Requirement;

use App\Domain\Customer\CustomerModel;

interface ImportRequirementInterface
{
    public function test(CustomerModel $customer): bool;
}
