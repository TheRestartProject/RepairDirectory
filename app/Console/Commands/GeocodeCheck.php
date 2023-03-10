<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;

class GeocodeCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geocode:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check business addresses to see if they geocode';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(BusinessRepository $repository, Geocoder $geocoder)
    {
        // We only want to check businesses that we would show.
        $criteria = [
            [
                'field' => 'address',
                'operator' => Operators::NOT_EQUAL,
                'value' => ''
            ],
            [
                'field' => 'postcode',
                'operator' => Operators::NOT_EQUAL,
                'value' => ''
            ],
            [
                'field' => 'city',
                'operator' => Operators::NOT_EQUAL,
                'value' => ''
            ],
            [
                'field' => 'publishingStatus',
                'operator' => Operators::EQUAL,
                'value' => PublishingStatus::PUBLISHED
            ]
        ];

        $businesses = $repository->findBy($criteria);
        $count = 0;
        $invalid = 0;

        if ($businesses) {
            foreach ($businesses as $business) {
                $count++;
                $point = $geocoder->geocode($business->getPostcode());

                if (!$point) {
                    // The address doesn't geocode.  Log an error, with the expectation that the spreadsheet
                    // will then get fixed.
                    $this->error("{$business->getUid()} can't geocode {$business->getPostcode()}");
                    $invalid++;
                } else {
                    #$this->info("{$business->getUid()} geocoded {$business->getPostcode()} to " . $point->getLatitude() . "," . $point->getLongitude());
                }
            }
        } else {
            $this->error("No businesses found");
        }

        $this->info("Checked $count, found $invalid invalid");
    }
}
