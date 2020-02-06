<?php

declare(strict_types=1);

namespace App\Domain\Import\Customer;

use LogicException;

class CustomerImporterCsv extends CustomerImporter
{
    public function load(string $file): void
    {
        throw new LogicException('feature not ready yet');
    }
}
