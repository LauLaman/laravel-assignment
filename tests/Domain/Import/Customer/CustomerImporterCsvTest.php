<?php

declare(strict_types=1);

namespace Tests\Domain\Import\Customer;

use App\Domain\CreditCard\CreditCardDatabaseHandlerInterface;
use App\Domain\Customer\CustomerDatabaseHandlerInterface;
use App\Domain\Import\Customer\CustomerImporterCsv;
use LogicException;
use PHPUnit\Framework\TestCase;

class CustomerImporterCsvTest extends TestCase
{
    private CustomerImporterCsv $importer;

    protected function setUp(): void
    {
        $customerRepository = $this->createMock(CustomerDatabaseHandlerInterface::class);
        $cardRepository = $this->createMock(CreditCardDatabaseHandlerInterface::class);
        $this->importer = new CustomerImporterCsv($customerRepository, $cardRepository);
    }

    public function testLoad(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The CSV import feature not ready yet.');

        $this->importer->load('file/does/not/mather.csv');
    }
}
