<?php

declare(strict_types=1);

namespace Test\Domain\Import\Requirement;

use App\Domain\Customer\CustomerModel;
use App\Domain\Import\Requirement\CustomerImportRequirement;
use DateTime;
use PHPUnit\Framework\TestCase;
use Tests\Domain\Customer\CustomerDataTrait;

class CustomerImportRequirementTest extends TestCase
{
    use CustomerDataTrait;

    /**
     * @dataProvider getOutOfRangeBirthday
     */
    public function testCustomerAgeOutOfRangeReturnsFalse(DateTime $dateOfBirth): void
    {
        $data = $this->getCustomerData();
        $data['date_of_birth'] = $dateOfBirth->format(DateTime::ATOM);

        $customer = new CustomerModel();
        $customer->__unserialize($data);

        $requirement = new CustomerImportRequirement();

        $this->assertFalse($requirement->test($customer));
    }

    public function testCustomerAgeNullReturnsTrue(): void
    {
        $data = $this->getCustomerData();
        $data['date_of_birth'] = null;

        $customer = new CustomerModel();
        $customer->__unserialize($data);

        $requirement = new CustomerImportRequirement();

        $this->assertTrue($requirement->test($customer));
    }

    /**
     * @dataProvider getInRangeBirthday
     */
    public function testCustomerAgeInRangeReturnsTrue(DateTime $dateOfBirth): void
    {
        $data = $this->getCustomerData();
        $data['date_of_birth'] = $dateOfBirth->format(DateTime::ATOM);

        $customer = new CustomerModel();
        $customer->__unserialize($data);

        $requirement = new CustomerImportRequirement();

        $this->assertTrue($requirement->test($customer));
    }

    public function getOutOfRangeBirthday(): array
    {
        return [
            'now' => [new DateTime('now')],
            '18 years ago' => [new DateTime('-18 years')],
            '65 years ago' => [new DateTime('-65 years')],
            '10 years in the future' => [new DateTime('+10 years')],
        ];
    }

    public function getInRangeBirthday()
    {
        $dates = [];
        for ($n = 19; $n <= 64; $n++) {
            $key = sprintf('%s years ago', $n);
            $dates[$key] = [new DateTime(sprintf('-%s years', $n))];
        }

        return $dates;
    }
}
