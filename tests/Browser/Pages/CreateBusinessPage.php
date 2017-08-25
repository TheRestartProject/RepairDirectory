<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser\Pages;

use Faker\Factory;
use Laravel\Dusk\Browser;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;

/**
 * Page class that represents the Create Business Page
 *
 * @category Page
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class CreateBusinessPage extends Page
{
    protected $faker;

    /**
     * CreateBusinessPage constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }


    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/map/admin/business';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser The browser object to run tests with
     *
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertRouteIs('admin.business.create');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@name' => 'name',
            '@address' => 'address',
            '@city' => 'city',
            '@postcode' => 'postcode',
            '@localArea' => 'localArea',
            '@description' => 'description',
            '@landline' => 'landline',
            '@mobile' => 'mobile',
            '@website' => 'website',
            '@email' => 'email',
            '@categories' => 'categories[]',
            '@productsRepaired' => '#productsRepaired',
            '@authorisedBrands' => '#authorisedBrands',
            '@qualifications' => 'qualifications',
            '@communityEndorsement' => 'communityEndorsement',
            '@notes' => 'notes',
            '@positiveReviewPc' => 'positiveReviewPc',
            '@reviewSource' => 'reviewSource',
            '@numberOfReviews' => 'numberOfReviews',
            '@averageScore' => 'averageScore',
            '@warrantyOffered' => 'warrantyOffered',
            '@warranty' => 'warranty',
            '@publishingStatus' => 'publishingStatus',
            '@submitButton' => '#submit',
        ];
    }

    /**
     * Assert that a status appears as a disabled option
     *
     * @param Browser $browser
     * @param string  $status
     *
     * @return $this
     */
    public function assertCannotSelectStatus(Browser $browser, $status)
    {
        $browser->assertSelectMissingOption('@publishingStatus', $status);

        return $this;
    }

    /**
     * Sets the publishing status on the form
     *
     * @param Browser $browser
     * @param string  $status
     *
     * @return $this
     */
    public function setPublishedStatusAs(Browser $browser, $status)
    {
        $browser->select('@publishingStatus', $status);

        return $this;
    }

    /**
     * Fills in the form
     *
     * @param Browser $browser
     * @param string  $name
     *
     * @return $this
     */
    public function fillInForm(Browser $browser, $name = null)
    {
        $browser->type('@name', $name ?: $this->faker->company)
            ->type('@address', '12 Westgate St, Bath')
            ->type('@city', 'Bath')
            ->type('@postcode', 'BA1 1EQ')
            ->type('@localArea', $this->faker->word)
            ->type('@description', $this->faker->sentence)
            ->type('@landline', '07141200908')
            ->type('@mobile', '07761901775')
            ->type('@website', $this->faker->url)
            ->type('@email', $this->faker->companyEmail)
            ->select('@categories', 'Fan')
            ->type('@productsRepaired', $this->faker->word)
            ->keys('@productsRepaired', 'enter')
            ->type('@authorisedBrands', $this->faker->company)
            ->keys('@productsRepaired', 'enter')
            ->type('@qualifications', $this->faker->sentence)
            ->type('@communityEndorsement', $this->faker->sentence)
            ->type('@notes', $this->faker->sentence)
            ->type('@positiveReviewPc', $this->faker->numberBetween(0, 100))
            ->select('@reviewSource', ReviewSource::GOOGLE)
            ->type('@numberOfReviews', $this->faker->numberBetween(0, 100))
            ->type('@averageScore', $this->faker->randomFloat(1, 0, 5))
            ->check('@warrantyOffered')
            ->type('@warranty', $this->faker->sentence)
            ->select('@publishingStatus', PublishingStatus::DRAFT);

        return $this;
    }
}