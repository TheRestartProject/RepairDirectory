<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Services\Reviewers;

use JonnyW\PhantomJs\Client;
use JonnyW\PhantomJs\Http\MessageFactory;
use JonnyW\PhantomJs\Http\Request;
use JonnyW\PhantomJs\Http\Response;
use Mockery;
use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;
use TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers\GooglePlacesReviewer;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Tests that the GooglePlacesReviewer can extract a ReviewAggregation from
 * scraped HTML.
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Domain\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class GooglePlacesReviewerTest extends IntegrationTestCase
{
    private $testHtml = '
        <html>
            <body>
                <div class="ml-panes-entity-review-number"><span>3.0</span></div>
                <div class="ml-panes-entity-ratings-histogram-summary-reviews-number">117 reviews</div>
                <div>
                    <span class="ml-panes-entity-ratings-histogram-bucket" style="padding-left:5px"></span>
                    <span class="ml-panes-entity-ratings-histogram-bucket" style="padding-left:10px"></span>
                    <span class="ml-panes-entity-ratings-histogram-bucket" style="padding-left:5px"></span>
                    <span class="ml-panes-entity-ratings-histogram-bucket" style="padding-left:10px"></span>
                    <span class="ml-panes-entity-ratings-histogram-bucket" style="padding-left:10px"></span>
                </div>
            </body>
        </html>
        ';

    /**
     * Test that malformed urls don't cause errors and instead return null
     *
     * @test
     *
     * @return void
     */
    public function it_returns_null_for_malformed_url()
    {
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPhantomJs(500, ''));

        $malformedUrls = [
            'https://sdf',
            'google.com',
            'google.com/maps/',
            'google.com/maps/place/',
            'google.com/maps/place/KFC',
            'google.co.uk/maps/place/KFC/@51.3963959,-2.4904243,12z/data=',
            'google.co.uk/maps/place/KFC/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m'
        ];

        foreach ($malformedUrls as $url) {
            $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);
            self::assertNull($reviewAggregation);
        }
    }

    /**
     * Test that unknown Google Places don't cause errors and instead return null
     *
     * @test
     *
     * @return void
     */
    public function it_returns_null_for_an_unknown_place()
    {
        $url = 'https://www.google.co.uk/maps/place/Nowhere/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m4!1s0x0:0xdf6f3803ac00dc83!8m2!3d51.3795758!4d-2.3584342';
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPhantomJs(404, ''));
        $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);

        self::assertNull($reviewAggregation);
    }

    /**
     * Test that unexpected HTML doesn't cause errors and null is returned
     *
     * @test
     *
     * @return void
     */
    public function it_returns_null_for_unexpected_html_response()
    {
        $url = 'https://www.google.co.uk/maps/place/Nowhere/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m4!1s0x0:0xdf6f3803ac00dc83!8m2!3d51.3795758!4d-2.3584342';
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPhantomJs(200, '<html></html>'));
        $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);

        self::assertNull($reviewAggregation);
    }

    /**
     * Test that expected HTML returns an expected ReviewAggregation
     *
     * @test
     *
     * @return void
     */
    public function it_returns_a_review_aggregation_for_good_url()
    {
        $url = 'https://www.google.co.uk/maps/place/KFC/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m4!1s0x0:0xdf6f3803ac00dc83!8m2!3d51.3795758!4d-2.3584342';
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPhantomJs(200, $this->testHtml));
        $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);

        $expected = new ReviewAggregation();
        $expected->setAverageScore(3.0);
        $expected->setPositiveReviewPc(50);
        $expected->setNumberOfReviews(117);

        self::assertEquals($expected, $reviewAggregation);
    }

    /**
     * Return a mocked PhantomJS client. It will return responses that have
     * the provided status and html.
     *
     * @param integer $status The HTTP Status code to return in the response
     * @param string  $html   The HTML to return in the response
     *
     * @return Client
     */
    private function getPhantomJs($status, $html)
    {
        $mock = Mockery::mock(Client::class);
        $messageFactory = Mockery::mock(MessageFactory::class);
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);

        $mock->shouldReceive('getMessageFactory')->andReturn($messageFactory);

        $messageFactory->shouldReceive('createRequest')->andReturn($request);
        $request->shouldReceive('setTimeout');
        $request->shouldReceive('setViewportSize');

        $messageFactory->shouldReceive('createResponse')->andReturn($response);
        $response->shouldReceive('isRedirect');

        $mock->shouldReceive('send');
        $response->shouldReceive('getStatus')->andReturn($status);
        $response->shouldReceive('getContent')->andReturn($html);

        /**
         * Cast mock to Client
         *
         * @var Client $phantom
         */
        $phantom = $mock;
        return $phantom;
    }

}