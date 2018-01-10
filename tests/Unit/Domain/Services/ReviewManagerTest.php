<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Domain\Services;

use Mockery;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Responses\ReviewResponse;
use TheRestartProject\RepairDirectory\Domain\Services\ReviewManager;
use TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers\GooglePlacesReviewer;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Tests for the ReviewManager
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Domain\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class ReviewManagerTest extends TestCase
{

    /**
     * Test that URLs that don't refer to a known ReviewSource don't cause errors.
     *
     * @test
     *
     * @return void
     */
    public function it_can_handle_unknown_urls()
    {
        $response = $this->constructReviewManager()->getReviewResponse('bbc.com');
        self::assertEquals(new ReviewResponse(ReviewSource::OTHER), $response);
    }

    /**
     * Test that Google Places review URLs are detected.
     *
     * @test
     *
     * @return void
     */
    public function it_can_handle_google_places_urls()
    {
        $response = $this->constructReviewManager()->getReviewResponse('google.com');
        self::assertEquals(new ReviewResponse(ReviewSource::GOOGLE), $response);
    }

    /**
     * Test that review URLs for other ReviewSources are detected.
     *
     * @test
     *
     * @return void
     */
    public function it_can_handle_non_google_places_urls()
    {
        $response = $this->constructReviewManager()->getReviewResponse('facebook.com');
        self::assertEquals(new ReviewResponse(ReviewSource::FACEBOOK), $response);
    }

    /**
     * Return a ReviewManager with mocked Reviewer implementations.
     *
     * @return ReviewManager
     */
    private function constructReviewManager()
    {
        $mock = Mockery::mock(GooglePlacesReviewer::class);
        $mock->shouldReceive('getReviewAggregation');

        /**
         * Cast to GooglePlacesReviewer to suppress static analysis warnings
         *
         * @var GooglePlacesReviewer $googlePlacesReviewer
         */
        $googlePlacesReviewer = $mock;
        return new ReviewManager($googlePlacesReviewer);
    }

}
