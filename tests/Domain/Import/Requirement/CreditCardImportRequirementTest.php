<?php

declare(strict_types=1);

namespace Tests\Domain\Import\Requirement;

use App\Domain\Customer\CustomerModel;
use App\Domain\Import\Requirement\CreditCardImportRequirement;
use PHPUnit\Framework\TestCase;
use Tests\Domain\Customer\CustomerDataTrait;

class CreditCardImportRequirementTest extends TestCase
{
    use CustomerDataTrait;

    /**
     * @dataProvider getCreditCardNumbersWithNoRepeatingNumbers
     */
    public function testWithoutThreeRepeatingDigitsReturnsFalse(string $number): void
    {
        $data = $this->getCustomerData();
        $data['credit_card']['number'] = $number;

        $customer = new CustomerModel();
        $customer->__unserialize($data);

        $requirement = new CreditCardImportRequirement();

        $this->assertFalse($requirement->test($customer));
    }

    /**
     * @dataProvider getCreditCardNumbersWithRepeatingNumbers
     */
    public function testWithThreeRepeatingDigitsReturnsTrue(string $number): void
    {
        $data = $this->getCustomerData();
        $data['credit_card']['number'] = $number;

        $customer = new CustomerModel();
        $customer->__unserialize($data);

        $requirement = new CreditCardImportRequirement();

        $this->assertTrue($requirement->test($customer));
    }

    public function getCreditCardNumbersWithNoRepeatingNumbers()
    {
        return [
            '#4532383564703' => ['4532383564703'],
            '#5530501534343780' => ['5530501534343780'],
            '#5100145515704915' => ['5100145515704915'],
            '#379638474514189' => ['379638474514189'],
            '#4916004684638' => ['4916004684638'],
            '#370661810910506' => ['370661810910506'],
            '#4539807878668' => ['4539807878668'],
            '#5400456679598614' => ['5400456679598614'],
            '#4929008649903' => ['4929008649903'],
            '#4532054928658' => ['4532054928658'],
            '#3741498733880801' => ['3741498733880801'],
        ];
    }

    public function getCreditCardNumbersWithRepeatingNumbers()
    {
        return [
            '#5552356494721423' => ['5552356494721423'],
            '#4532093592333' => ['4532093592333'],
            '#374149873388808' => ['374149873388808'],
            '#4532059727774' => ['4532059727774'],
            '#4539222300777' => ['4539222300777'],
        ];
    }
}
