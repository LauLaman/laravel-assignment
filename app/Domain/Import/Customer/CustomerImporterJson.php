<?php

declare(strict_types=1);

namespace App\Domain\Import\Customer;

use JsonException;

class CustomerImporterJson extends CustomerImporter
{
    /**
     * @throws JsonException
     */
    public function load(string $file): void
    {
        parent::load($file);

        $data = json_decode(file_get_contents($file), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonException(sprintf('File could not be parsed. Error: %s', json_last_error_msg()));
        }

        $this->data = $data;
    }
}
