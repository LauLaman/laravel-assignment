<?php

declare(strict_types=1);

namespace Tests\Domain\Import\Customer;

use App\Domain\CreditCard\CreditCardDatabaseHandlerInterface;
use App\Domain\Customer\CustomerDatabaseHandlerInterface;
use App\Domain\Import\Customer\CustomerImporterXml;
use LogicException;
use PHPUnit\Framework\TestCase;

class CustomerImporterXmlTest extends TestCase
{
    private CustomerImporterXml $importer;

    protected function setUp(): void
    {
        $customerRepository = $this->createMock(CustomerDatabaseHandlerInterface::class);
        $cardRepository = $this->createMock(CreditCardDatabaseHandlerInterface::class);
        $this->importer = new CustomerImporterXml($customerRepository, $cardRepository);
    }

    public function testLoad(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The XML import feature not ready yet.');

        $this->importer->load('file/does/not/mather.xml');
    }
}
