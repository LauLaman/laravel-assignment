<?php

namespace App\Integration\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false;

    public function creditCard()
    {
        return $this->hasOne(CreditCard::class);
    }
}
