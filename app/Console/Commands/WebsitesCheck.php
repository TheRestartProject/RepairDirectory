<?php

namespace App\Console\Commands;

use App\Notifications\AdminBusinessWebsiteInvalid;
use App\Notifications\AdminNewBusinessReadyForReview;
use Illuminate\Console\Command;
use TheRestartProject\Fixometer\Domain\Entities\Role;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;
use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Enums\Region;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;

class WebsitesCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websites:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check business websites to see if any are no longer valid';

    /**
     * An implementation of the UserRepository
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Create a new command instance.
     *
     * @param UserRepository $userRepository    The user repository
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(BusinessRepository $repository)
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

        $businesses = $repository->findAll();
        $this->info(count($businesses) . " businesses");

        $errors = [];

        foreach ($businesses as $business) {
            $url = $business->getWebsite();

            if ($url) {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                // Time out fairly fast.
                curl_setopt($curl, CURLOPT_TIMEOUT, 60);

                // Some sites require a user agent.
                curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

                $response = curl_exec($curl);
                $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if ($status !== 200 && $status !== 302) {
                    $this->error($business->getName() . " url $url returned $status");

                    $errors[] = [
                        'uid' => $business->getUid(),
                        'name' => $business->getName(),
                        'url' => $url,
                        'status' => $status,
                    ];
                }
            }
        }

        if (count($errors)) {
            $this->error("Found " . count($errors) . " errors");

            $admins = $this->userRepository->findBy([
                                                        [
                                                            'field' => 'repairDirectoryRole',
                                                            'operator' => Operators::EQUAL,
                                                            'value' => Role::SUPERADMIN
                                                        ]
                                                    ]);

            foreach ($admins as $admin) {
                $admin->notify(new AdminBusinessWebsiteInvalid($errors));
            }
        }
    }
}
