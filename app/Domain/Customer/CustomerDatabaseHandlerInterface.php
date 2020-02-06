<?php

declare(strict_types=1);

namespace App\Domain\Customer;

use App\Domain\Database\Exception\NoResultException;
use App\Integration\Eloquent\Model\Customer;

interface CustomerDatabaseHandlerInterface
{
    /**
     * @throws NoResultException
     */
    public function getByImportFingerPrint(string $fingerprint): Customer;

    public function createFromModel(CustomerModel $model, string $fingerprint): Customer;
}
