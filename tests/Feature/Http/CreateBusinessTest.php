<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Http;

use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Tests the ability to
 * @category
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Http
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class CreateBusinessTest extends IntegrationTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function i_cannot_create_a_business_if_i_am_not_logged_in()
    {
        $business = entity(Business::class)->make();
        $this->post(
            route('admin.business.create'),
            $this->serializeBusiness($business)
        )->assertRedirect(route('home'));
    }

    /**
     *
     *
     * @param Business $business The business to serialize
     *
     * @return array
     */
    protected function serializeBusiness(Business $business)
    {
        return [
            'name' => $business->getName(),
            'address' => $business->getAddress(),
            'city' => $business->getCity(),
            'postcode' => $business->getPostcode(),
            'localArea' => $business->getLocalArea(),
            'description' => $business->getDescription(),
            'landline' => $business->getLandline(),
            'mobile' => $business->getMobile(),
            'website' => $business->getWebsite(),
            'email' => $business->getEmail(),
            'categories' => $business->getCategories(),
            'productsRepaired' => implode(',', $business->getProductsRepaired()),
            'authorisedBrands' => implode(',', $business->getAuthorisedBrands()),
            'qualifications' => $business->getQualifications(),
            'communityEndorsement' => $business->getCommunityEndorsement(),
            'notes' => $business->getNotes(),
            'positiveReviewPc' => $business->getPositiveReviewPc(),
            'reviewSource' => $business->getReviewSource(),
            'numberOfReviews' => $business->getNumberOfReviews(),
            'averageScore' => $business->getAverageScore(),
            'warrantyOffered' => $business->isWarrantyOffered(),
            'warranty' => $business->getWarranty(),
            'publishingStatus' => $business->getPublishingStatus()
        ];
    }
}