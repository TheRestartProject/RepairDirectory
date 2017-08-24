<?php
/**
 * Created by PhpStorm.
 * User: joaquim
 * Date: 24/08/2017
 * Time: 14:51
 */

namespace TheRestartProject\RepairDirectory\Tests\Unit\Domain\Services;


use Mockery;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Responses\ReviewResponse;
use TheRestartProject\RepairDirectory\Domain\Services\ReviewManager;
use TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers\GooglePlacesReviewer;
use TheRestartProject\RepairDirectory\Tests\TestCase;

class ReviewManagerTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_handle_unknown_urls()
    {
        $response = $this->constructReviewManager()->getReviewResponse('bbc.com');
        self::assertEquals(new ReviewResponse(null), $response);
    }

    /**
     * @test
     */
    public function it_can_handle_google_places_urls()
    {
        $response = $this->constructReviewManager()->getReviewResponse('google.com');
        self::assertEquals(new ReviewResponse(ReviewSource::GOOGLE), $response);
    }

    /**
     * @test
     */
    public function it_can_handle_non_google_places_urls()
    {
        $response = $this->constructReviewManager()->getReviewResponse('facebook.com');
        self::assertEquals(new ReviewResponse(ReviewSource::FACEBOOK), $response);
    }

    private function constructReviewManager()
    {
        $googlePlacesReviewer = Mockery::mock(GooglePlacesReviewer::class);
        $googlePlacesReviewer->shouldReceive('getReviewAggregation');

        /** @var GooglePlacesReviewer $googlePlacesReviewer */
        return new ReviewManager($googlePlacesReviewer);
    }

}