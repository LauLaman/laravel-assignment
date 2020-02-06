<?php

namespace App\Integration\Laravel\Command;

use App\Domain\Customer\CustomerModel;
use App\Domain\Import\Customer\CustomerImporter;
use App\Domain\Import\Customer\CustomerImporterCsv;
use App\Domain\Import\Customer\CustomerImporterJson;
use App\Domain\Import\Customer\CustomerImporterXml;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use LogicException;

class ImportCustomerCommand extends Command
{
    protected $signature = 'import {file} {--type=json}';

    protected $description = 'Display an inspiring quote';

    private CustomerImporterJson $jsonImporter;

    private CustomerImporterCsv $csvImporter;

    private CustomerImporterXml $xmlImporter;

    public function __construct(
        CustomerImporterJson $jsonImporter,
        CustomerImporterCsv $csvImporter,
        CustomerImporterXml $xmlImporter
    ) {
        parent::__construct();

        $this->jsonImporter = $jsonImporter;
        $this->csvImporter = $csvImporter;
        $this->xmlImporter = $xmlImporter;
    }

    public function handle()
    {
        $this->info(sprintf('Loading file...'));
        if (!$file = $this->getFile()) {
            return;
        }

        $importer = $this->getImporter();

        $importer->load($file);
        $importer->import(function (CustomerModel $customer, bool $alreadyImported, bool $isImported) {
            if ($alreadyImported) {
                $this->line(sprintf('[<fg=cyan>SKIP</>]   <fg=magenta>%s</> is already imported.', $customer->getName()));
            } elseif ($isImported) {
                $this->line(sprintf('[<fg=green>IMPORT</>] <fg=magenta>%s</>', $customer->getName()));
            } else {
                $this->line(sprintf('[<fg=yellow>IGNORE</>] <fg=magenta>%s</> does not met the import requirements.', $customer->getName()));
            }
        });
    }

    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }

    private function getFile(): ?string
    {
        $file = $this->argument('file');
        if (!file_exists($file)) {
            $this->error(sprintf("File '%s' does not exist or is not accessible by this project.", $file));

            return null;
        }

        return $file;
    }

    private function getType(): string
    {
        return strtolower($this->option('type'));
    }

    private function getImporter(): CustomerImporter
    {
        switch ($this->getType()) {
            case 'json':
                return $this->jsonImporter;
            case 'csv':
                return $this->csvImporter;
            case 'xml':
                return $this->xmlImporter;
            default:
                throw  new LogicException(sprintf("'%s' is not a valid type. Valid options: [json|csv|xml]", $this->getType()));
        }
    }
}
