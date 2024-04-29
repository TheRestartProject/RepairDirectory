<?php

namespace App\Console\Commands;

use Illuminate\Auth\AuthManager;
use App\Notifications\AdminBusinessWebsiteInvalid;
use App\Notifications\AdminNewBusinessReadyForReview;
use Illuminate\Console\Command;
use TheRestartProject\Fixometer\Domain\Entities\Role;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;
use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Enums\Region;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;
use TheRestartProject\RepairDirectory\Validation\Validators\WebsiteValidator;
use Illuminate\Notifications\Notification;

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
     * The Laravel auth manager
     *
     * @var AuthManager
     */
    private $authManager;

    /**
     * Create a new command instance.
     *
     * @param UserRepository $userRepository    The user repository
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, AuthManager $authManager)
    {
        $this->userRepository = $userRepository;
        $this->authManager = $authManager;

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

        $businesses = $repository->findBy($criteria);
        $this->info(count($businesses) . " businesses");

        $errors = [];

        $validate = new WebsiteValidator();

        foreach ($businesses as $business) {
            $url = $business->getWebsite();

            if ($url) {
                try {
                    $validate->validate($url);
                } catch (ValidationException $e) {
                    $this->error($business->getName() . " " . $e->getMessage());

                    $errors[] = [
                        'uid' => $business->getUid(),
                        'name' => $business->getName(),
                        'url' => $url,
                        'message' => $e->getMessage()
                    ];
                }
            }
        }

        if (count($errors)) {
            $this->info("Found " . count($errors) . " errors");

            try {
                $user = $this->authManager->guard()->user();

                if ($user) {
                    // In a Platform environment we will be automatically logged in, and we notify that user rather
                    // than look in the Restarters database (which isn't present).
                    $this->error("Notify logged in user");
                    $this->error("Email is " . $user->getEmail());
                    Notification::route('mail', $user->getEmail())->notify(new AdminBusinessWebsiteInvalid($errors));
                    $this->error("Notified logged in user");
                } else {
                    // Currently superadmins (i.e. a Restart team member) get notified regarding website issues.
                    // They then forward on to the relevant regional admins.
                    // In future, we may wish to split this out by regional admin.
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
            } catch (\Exception $e) {
                $this->error("Failed to notify " . $e->getMessage());
            }
        }
    }
}
