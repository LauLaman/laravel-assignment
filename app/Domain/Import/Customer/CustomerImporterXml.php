<?php

declare(strict_types=1);

namespace App\Domain\Import\Customer;

use LogicException;

class CustomerImporterXml extends CustomerImporter
{
    public function load(string $file): void
    {
        throw new LogicException('The XML import feature not ready yet.');
    }
}
