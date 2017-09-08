<?php

namespace TheRestartProject\RepairDirectory\Domain\Services;

use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Responses\ReviewResponse;
use TheRestartProject\RepairDirectory\Domain\Services\Reviewers\Reviewer;
use TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers\GooglePlacesReviewer;

/**
 * Class ReviewManager
 *
 * Provides the getReviewResponse method, which selects the appropriate Reviewer implementation for a given URL
 * and then calls getReviewAggregation to scrape the URL and obtain a ReviewAggregation. This is then
 * returned wrapped in a ReviewResponse that encapsulates the aggregation and the ReviewSource it
 * was scraped from.
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Domain\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ReviewManager
{
    /**
     * An array keyed by ReviewSource value that stores all Reviewer implementations.
     *
     * @var Reviewer[] 
     */
    private $reviewers;

    /**
     * ReviewManager constructor.
     *
     * @param GooglePlacesReviewer $googlePlacesReviewer The reviewer for Google Places URLs
     */
    public function __construct(GooglePlacesReviewer $googlePlacesReviewer)
    {
        $this->reviewers = [
            ReviewSource::GOOGLE => $googlePlacesReviewer
        ];
    }

    /**
     * Derive a ReviewSource from a URL and then use the appropriate Reviewer (if it exists)
     * to retrieve a ReviewAggregation. Return both of these in a ReviewResponse.
     *
     * @param string $url The URL to process and possibly scrape
     *
     * @return ReviewResponse
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getReviewResponse($url)
    {
        $reviewSource = ReviewSource::derive($url);
        $response = new ReviewResponse($reviewSource);
        if ($reviewSource && array_key_exists($reviewSource, $this->reviewers)) {
            $reviewer = $this->reviewers[$reviewSource];
            $reviewAggregation = $reviewer->getReviewAggregation($url);
            $response->setReviewAggregation($reviewAggregation);
        }
        return $response;
    }

}
