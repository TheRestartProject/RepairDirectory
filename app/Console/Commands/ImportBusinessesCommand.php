<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Infrastructure\ModelFactories\BusinessFactory;

class ImportBusinessesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:businesses {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import businesses from a CSV file';

    /**
     * For persisting the imported Businesses
     * 
     * @var BusinessRepository
     */
    private $businessRepository;

    /**
     * Create a new command instance.
     *
     * @param BusinessRepository $businessRepository
     */
    public function __construct(BusinessRepository $businessRepository)
    {
        parent::__construct();
        $this->businessRepository = $businessRepository;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // load the CSV document from a file path
        $csv = Reader::createFromPath($this->argument('file'));
        $rows = $csv->fetchAssoc();
        foreach($rows as $row) {
            $business = BusinessFactory::fromRow($row);
            $this->businessRepository->add($business);
        }
    }
}
