<?php

use App\Domain\CreditCard\CreditCardType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditCardsTable extends Migration
{
    public function up(): void
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', CreditCardType::getValidOptions());
            $table->string('number');
            $table->string('name');
            $table->dateTime('expirationDate');
            $table->integer('customer_id')->unsigned();
//            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
}
