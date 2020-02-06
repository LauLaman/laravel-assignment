<?php

declare(strict_types=1);

namespace App\Domain\CreditCard;

use DateTimeImmutable;

final class CreditCardModel
{
    private CreditCardType $type;
    private string $number;
    private string $name;
    private DateTimeImmutable $expirationDate;

    public function getType(): CreditCardType
    {
        return $this->type;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExpirationDate(): DateTimeImmutable
    {
        return $this->expirationDate;
    }

    public function __unserialize(array $data): void
    {
        $this->number = $data['number'];
        $this->type = CreditCardType::get($data['type']);
        $this->name = $data['name'];
        $this->expirationDate = DateTimeImmutable::createFromFormat('m/y', $data['expirationDate']);
    }
}
