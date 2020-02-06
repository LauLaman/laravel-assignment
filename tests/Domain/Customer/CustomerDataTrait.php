<?php

declare(strict_types=1);

namespace Tests\Domain\Customer;

trait CustomerDataTrait
{
    protected function getCustomerData(): array
    {
        return [
            'account' => '123456',
            'name' => 'John Appleseed',
            'address' => '1 Infinite Loop Cupertino, CA 95014',
            'checked' => true,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
            'interest' => null,
            'email' => 'jack.bauer@ctu.gov',
            'date_of_birth' => '1989-03-21T01:11:13+00:00',
            'credit_card' => [
                'number' => '4845028268448117',
                'type' => 'Visa',
                'name' => 'Pat Macias',
                'expirationDate' => '06/23',
            ],
        ];
    }
}
