<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;

class ReGeocode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geocode:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-gecode all businesses ';

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
     * From https://stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php with
     * thanks.
     *
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                               cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
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
                $address = $business->getPostcode();

                if ($address == 'N23 6HL') {
                    $address = '13 Market Street, Ebbw Vale NP23 6HL';
                } else if ($address == 'EC1 Y8QP' || $address == 'EC1Y8QP') {
                    $address = '195 Whitecross Street, London, EC1Y 8QP';
                } else if ($address == 'W1T 1BZ') {
                    $address = '38 Tottenham Court Road, London, W1T 1BZ';
                }

                $point = $geocoder->geocode($address);

                if (!$point) {
                    // The address doesn't geocode.  Log an error, with the expectation that the spreadsheet
                    // will then get fixed.
                    $this->error("{$business->getUid()} can't geocode $address");
                    $invalid++;
                } else {
                    $geolocation = $business->getGeolocation();

                    $dist = round($this->haversineGreatCircleDistance($geolocation->getLatitude(), $geolocation->getLongitude(), $point->getLatitude(), $point->getLongitude()));
                    #$this->info("{$business->getUid()} geocoded $address to " . $point->getLatitude() . "," . $point->getLongitude()) . " distance $dist";

                    if ($dist > 500) {
                        $this->error("{$business->getUid()} was {$geolocation->getLatitude()}, {$geolocation->getLongitude()} geocoded $address to {$point->getLatitude()},{$point->getLongitude()} distance {$dist}m");
                        $invalid++;
                    } else {
                        $business->setGeolocation($point);
                    }
                }
            }
        } else {
            $this->error("No businesses found");
        }

        $this->info("Checked $count, found $invalid invalid");
    }
}
