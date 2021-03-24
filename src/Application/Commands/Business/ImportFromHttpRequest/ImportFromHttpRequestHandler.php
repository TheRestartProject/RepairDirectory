<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;


use App\Notifications\AdminNewBusinessReadyForReview;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Access\Gate;
use TheRestartProject\Fixometer\Domain\Entities\Role;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;
use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Application\Exceptions\EntityNotFoundException;
use TheRestartProject\RepairDirectory\Application\Util\StringUtil;
use TheRestartProject\RepairDirectory\Application\Validators\CustomBusinessValidator;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;
use Doctrine\ORM\EntityManager;
use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;
use Illuminate\Support\Facades\Auth;

/**
 * Handles the ImportFromCsvRowCommand to import a Business
 *
 * @category CommandHandler
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromHttpRequestHandler
{
    /**
     * An implementation of the BusinessRepository
     *
     * @var BusinessRepository
     */
    private $businessRepository;

    /**
     * An implementation of the UserRepository
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * The geocoder to get [lat, lng] of business
     *
     * @var Geocoder
     */
    private $geocoder;

    /**
     * Creates the handler for the ImportBusinessFromCsvRowCommand
     *
     * @param BusinessRepository $businessRepository An implementation of the BusinessRepository
     * @param UserRepository     $userRepository An implementation of the UserRepository
     * @param Geocoder           $geocoder   Geocoder to get [lat, lng] of business
     *
     * @return $this
     */
    public function __construct(BusinessRepository $businessRepository, UserRepository $userRepository, Geocoder $geocoder)
    {
        $this->businessRepository = $businessRepository;
        $this->userRepository = $userRepository;
        $this->geocoder = $geocoder;
    }

    /**
     * Handles the Command by importing a Business from a CSV row
     *
     * @param ImportFromHttpRequestCommand $command The command to handle
     *
     * @return Business
     *
     * @throws EntityNotFoundException
     * @throws BusinessValidationException
     * @throws AuthorizationException
     */
    public function handle(ImportFromHttpRequestCommand $command)
    {
        $data = $command->getData();

        $businessUid = $command->getBusinessUid();

        $business = new Business();
        $isCreate = true;
        $currentPublishingStatus = $business->getPublishingStatus();

        if ($businessUid !== null) {
            $business = $this->businessRepository->findById($businessUid, Auth::user());
        }

        if (!$business) {
            throw new EntityNotFoundException("Business with id of {$businessUid} could not be found");
        }

        $this->updateValues($business, $data);

        $business->setUpdatedBy(auth()->user()->getAuthIdentifier());
        $business->setUpdatedAt(new \DateTime("now"));

        $business->setGeolocation($this->createPoint($data));

        if (is_null($business->getCreatedBy())) {
            $business->setCreatedBy(auth()->user()->getAuthIdentifier());
        }

        if ($isCreate) {
            $this->businessRepository->add($business);
        }

        $newPublishingStatus = $business->getPublishingStatus();

        if ($currentPublishingStatus !== PublishingStatus::READY_FOR_REVIEW && $newPublishingStatus === PublishingStatus::READY_FOR_REVIEW
            && auth()->user()->isEditor()
        ) {
            // We have published the business as an Editor.  We want to alert regional admin.  At the moment
            // editors are not restricted to a region and therefore we alert all of them.
            $admins = $this->userRepository->findBy([
                [
                    'field' => 'repairDirectoryRole',
                    'operator' => Operators::EQUAL,
                    'value' => Role::REGIONAL_ADMIN
                ]
            ]);

            foreach ($admins as $admin) {
                $admin->notify(new AdminNewBusinessReadyForReview($business, auth()->user()));
            }
        }

        return $business;
    }

    /**
     * Update the $business fields from a $data array
     *
     * @param Business $business The business to update
     * @param array    $data     An [ $key => $value ] array of fields to update
     *
     * @return void
     */
    private function updateValues($business, $data)
    {
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($business, $setter)) {
                $business->{$setter}($value);
            }
        }
    }

    /**
     * Creates a Point from the geolocation data
     *
     * @param array $data The array of data
     *
     * @return Point
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function createPoint($data)
    {
        return Point::fromArray($data['geolocation']);
    }
}
