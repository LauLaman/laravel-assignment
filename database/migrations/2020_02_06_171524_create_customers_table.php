<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->boolean('checked');
            $table->mediumText('description');
            $table->string('interest')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('email');
            $table->bigInteger('account');
            $table->string('import_fingerprint')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
}
