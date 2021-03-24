<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use TheRestartProject\RepairDirectory\Application\CommandBus\Exceptions\NotFoundException;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;

class BusinessController extends Controller
{
    public function view($id, BusinessRepository $repository)
    {
        if ($this->isIpRestricted()) {
            return response('', 403);
        }

        $business = $repository->findById($id);

        if (!$business) {
            return response('', 404);
        }

        if (!$business->isPublished() || $business->getPublishingStatus() === PublishingStatus::HIDDEN) {
            throw new NotFoundException();
        }

        return view('businesses.view', [
            'business' => $business,
            'selectedLocation' => $business->getPostcode(),
            'categories' => Category::values(),
            'selectedCategory' => '',
            'radiusOptions' => config('map.radiuses'),
            'selectedRadius' => 2
        ]);
    }

    private function isIpRestricted()
    {
        $allowedIps = getenv('ALLOWED_IPS');
        $currentIp = getenv('REMOTE_ADDR');
        if ($allowedIps && $currentIp) {
            $allowedIps = explode(',', $allowedIps);
            return !in_array($currentIp, $allowedIps);
        }
        return false;
    }

    /**
     * Get the selected radius either from the request of use the default
     *
     * The selected radius is the radius that should be selected when the page is
     * loaded. If the page is loaded without a query string then it should use the
     * default value specified in the config, otherwise it will use the value
     * in the query string for radius.
     *
     * @param Request $request The request object
     *
     * @return int
     */
    protected function selectedRadius(Request $request)
    {
        $selectedRadius = $request->input('radius') ?: config('map.default_radius');

        return (int) $selectedRadius;
    }
}
