<?php

declare(strict_types=1);

namespace App\Domain\Customer;

use App\Domain\CreditCard\CreditCardModel;
use App\Domain\Parser\DateParser;
use DateTimeImmutable;

final class CustomerModel
{
    private string $name;
    private string $address;
    private bool $checked;
    private string $description;
    private ?string $interest;
    private ?DateTimeImmutable $dateOfBirth;
    private string $email;
    private int $account;
    private CreditcardModel $creditCard;

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function isChecked(): bool
    {
        return $this->checked;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getInterest(): ?string
    {
        return $this->interest;
    }

    public function getDateOfBirth(): ?DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAccount(): int
    {
        return $this->account;
    }

    public function getCreditCard(): CreditCardModel
    {
        return $this->creditCard;
    }

    public function __unserialize(array $data)
    {
        $this->account = (int) $data['account'];
        $this->name = $data['name'];
        $this->address = $data['address'];
        $this->checked = $data['checked'];
        $this->description = $data['description'];
        $this->interest = $data['interest'];
        $this->dateOfBirth = null;
        $this->email = $data['email'];

        $creditCard = new CreditCardModel();
        $creditCard->__unserialize($data['credit_card']);
        $this->creditCard = $creditCard;

        if ($data['date_of_birth'] !== null) {
            $this->dateOfBirth = DateParser::parseImmutable($data['date_of_birth']);
        }
    }
}
