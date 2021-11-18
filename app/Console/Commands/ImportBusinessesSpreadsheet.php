<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Doctrine\ORM\EntityManagerInterface;
use LaravelDoctrine\ORM\IlluminateRegistry;
use LaravelDoctrine\ORM\DoctrineManager;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TheRestartProject\RepairDirectory\Application\Util\AddressUtil;
use TheRestartProject\RepairDirectory\Application\Util\StringUtil;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Enums\Cluster;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;

class ImportBusinessesSpreadsheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restart:import:spreadsheet {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from a multi-tabbed Excel spreadsheet';

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
    public function handle(EntityManagerInterface $em, Geocoder $geocoder, BusinessRepository $repository, IlluminateRegistry $IlluminateRegistry)
    {
        // Delete any existing businesses within the bounding box for Wales.
        $conn = $em->getConnection();
        $swlat = 51.32990102458417;
        $swlng = -5.371793182658548;
        $nelat = 53.46775372527346;
        $nelng = -2.6032384951585485;

        $stmt = $conn->prepare("DELETE FROM businesses WHERE X(geolocation) >= $swlng AND X(geolocation) <= $nelng AND Y(geolocation) >= $swlat AND Y(geolocation) <= $nelat;");
        $stmt->execute();

        // load the CSV document from a file path
        $file = $this->argument('file');
        $this->output->writeln('Reading ' . $file);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);

        // Iterate through each tab.  Last one is just info; others are one per council.
        $councils = $spreadsheet->getSheetNames();
        array_pop($councils);

        // Ensure we don't run foul of unique index.
        $uniques = [];

        foreach ($councils as $council) {
            $this->line("Process council $council");

            $sheet = $spreadsheet->getSheetByName($council);

            // First row is council name.
            // Second row is column headings.
            // Third and subsequent rows are data.
            $row = 3;

            $this->line("Start at " . $sheet->getCellByColumnAndRow(1, $row)->getValue());
            while ($sheet->getCellByColumnAndRow(1, $row)->getValue()) {
                try {
                    // Get the fields in the first set of columns.
                    $fields = [
                        'name', 'address', 'postcode', 'borough', 'city', 'description', 'landline', 'mobile', 'website',
                        'email',
                        'ignored1', 'ignored2', 'ignored3', 'ignored4', 'ignored5',
                        'notes', 'review_url', 'review_source', 'review_count', 'positive_percent', 'average_score',
                        'warranty_offered', 'warranty_details', 'publish'
                    ];

                    for ($i = 0; $i < count($fields); $i++) {
                        $field = $fields[$i];
                        $$field = trim($sheet->getCellByColumnAndRow($i + 1, $row)->getValue());
                    }

                    $key = $name . $address;

                    if (array_key_exists($key, $uniques)) {
                        $this->error("Duplicate business $name, $address");
                    } else if (strlen($review_url) > 1000) {
                        $this->error("$name has overlong review URL $review_url");
                    } else {
                        $uniques[$key] = TRUE;

                        // Tweak the URL.
                        if ($website) {
                            if (stripos($website, 'http') === FALSE) {
                                $website = "https://$website";
                            }

                            // Ensure we don't end in /, or /#.
                            $website = preg_replace('/\/#$/', '', $website);
                            $website = preg_replace('/\/$/', '', $website);
                        }

                        // The items repaired are the next columns, until we hit an empty one.
                        $products = [];
                        $col = count($fields) + 1;

                        while ($sheet->getCellByColumnAndRow($col, $row)->getValue()) {
                            $prod = $sheet->getCellByColumnAndRow($col++, $row)->getValue();

                            if (strcmp(strtolower($prod),  'games console') === 0) {
                                # Special case - list the individual brands.
                                $products[] = Category::NINTENDO_CONSOLE;
                                $products[] = Category::XBOX_CONSOLE;
                                $products[] = Category::PLAYSTATION_CONSOLE;
                            } else {
                                $products[] = $prod;
                            }
                        }

                        $products = array_unique($products);

                        $business = new Business();
                        $business->setName($name);
                        $business->setUpdatedAt(new \DateTime("now"));

                        $point = null;

                        try {
                            $point = $geocoder->geocode("$address,$city,$borough,$postcode");

                            if ($point && ($point->getLatitude() < $swlat || $point->getLatitude() > $nelat || $point->getLongitude() < $swlng || $point->getLongitude() > $nelng)) {
                                // The address doesn't geocode.  Log an error, with the expectation that the spreadsheet
                                // will then get fixed.
                                $this->error("$name address $address geocodes to invalid lat/lng " . $point->getLatitude() . "," . $point->getLongitude());
                                $point = null;
                            }
                        } catch (\Exception $e) {
                            $this->error("$name geocode error on $address");
                        }

                        if ($point) {
                            $business->setGeolocation($point);

                            $business->setPostcode($postcode);
                            $business->setAddress($address);
                            $business->setCity($city);
                            $business->setDescription($description);

                            if ($average_score) {
                                $business->setAverageScore($average_score);
                            }

                            if ($landline) {
                                $business->setLandline($landline);
                            }

                            if ($mobile) {
                                $business->setMobile($mobile);
                            }

                            if ($website) {
                                $business->setWebsite($website);
                            }

                            if ($email) {
                                $business->setEmail($email);
                            }

                            $localArea = $repository->findLocalArea($business->getGeolocation()->getLatitude(), $business->getGeolocation()->getLongitude());
                            $business->setLocalArea($localArea);

                            $business->setCategories($products);

                            $business->setReviewSourceUrl($review_url);
                            $business->setReviewSource($review_source);

                            $business->setPositiveReviewPc((int)$positive_percent);
                            $business->setNumberOfReviews((int)$review_count);

                            if ($warranty_details) {
                                $business->setWarranty($warranty_details);
                            }

                            $business->setWarrantyOffered((boolean)$warranty_offered);

                            $business->setPublishingStatus(stripos($publish, 'publish') !== FALSE ? PublishingStatus::PUBLISHED : PublishingStatus::HIDDEN);
                            $repository->add($business);
                            $this->line("...$name added");

                            // We need to flush out the current business create, because there's a listener which creates
                            // suggestions, and that listener doesn't handle the case where you create multiple businesses
                            // with the same suggestion.
                            $em->flush();
                        }
                    }
                } catch (\Exception $e) {
                    $this->error("$name import failed " . $e->getMessage());
                    $em = $IlluminateRegistry->resetManager();
                }

                $row++;
            }
        }
    }
}
