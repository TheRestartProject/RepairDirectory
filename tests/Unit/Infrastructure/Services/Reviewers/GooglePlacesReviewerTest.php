<?php
/**
 * Created by PhpStorm.
 * User: joaquim
 * Date: 24/08/2017
 * Time: 17:01
 */

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Services\Reviewers;


use Illuminate\Support\Collection;
use JonnyW\PhantomJs\Client;
use JonnyW\PhantomJs\Http\MessageFactory;
use JonnyW\PhantomJs\Http\Request;
use JonnyW\PhantomJs\Http\Response;
use Mockery;
use SKAgarwal\GoogleApi\PlacesApi;
use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;
use TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers\GooglePlacesReviewer;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

class GooglePlacesReviewerTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_returns_null_for_malformed_url() {
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPhantomJs(500));

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
     * @test
     */
    public function it_returns_null_for_an_unknown_place() {
        $url = 'https://www.google.co.uk/maps/place/Nowhere/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m4!1s0x0:0xdf6f3803ac00dc83!8m2!3d51.3795758!4d-2.3584342';
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPhantomJs(404));
        $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);

        self::assertNull($reviewAggregation);
    }

    /**
     * @test
     */
    public function it_returns_null_for_unexpected_html_response() {
        $url = 'https://www.google.co.uk/maps/place/Nowhere/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m4!1s0x0:0xdf6f3803ac00dc83!8m2!3d51.3795758!4d-2.3584342';
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPhantomJs(200, '<html></html>'));
        $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);

        self::assertNull($reviewAggregation);
    }

    /**
     * @test
     */
    public function it_returns_a_review_aggregation_for_good_url() {
        $url = 'https://www.google.co.uk/maps/place/KFC/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m4!1s0x0:0xdf6f3803ac00dc83!8m2!3d51.3795758!4d-2.3584342';
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPhantomJs());
        $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);

        $expected = new ReviewAggregation();
        $expected->setAverageScore(3.0);
        $expected->setPositiveReviewPc(50);
        $expected->setNumberOfReviews(117);

        self::assertEquals($expected, $reviewAggregation);
    }

    /**
     * @param $status
     * @param $html
     *
     * @return Client
     */
    private function getPhantomJs($status = 200, $html = null) {
        $phantom = Mockery::mock(Client::class);
        $messageFactory = Mockery::mock(MessageFactory::class);
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);

        $phantom->shouldReceive('getMessageFactory')->andReturn($messageFactory);

        $messageFactory->shouldReceive('createRequest')->andReturn($request);
        $request->shouldReceive('setTimeout');
        $request->shouldReceive('setViewportSize');

        $messageFactory->shouldReceive('createResponse')->andReturn($response);
        $response->shouldReceive('isRedirect');

        $phantom->shouldReceive('send');
        $response->shouldReceive('getStatus')->andReturn($status);
        $response->shouldReceive('getContent')->andReturn($html ?: '
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
        ');

        return $phantom;
    }

}