<?php

declare(strict_types=1);

namespace App\Integration\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    public $timestamps = false;

    public function setCustomer(Customer $customer): void
    {
        $this->customer_id = $customer->id;
    }
}
