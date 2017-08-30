<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers;

use JonnyW\PhantomJs\Client;
use JonnyW\PhantomJs\Http\ResponseInterface;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;
use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;
use TheRestartProject\RepairDirectory\Domain\Services\Reviewers\Reviewer;

/**
 * Class GooglePlacesReviewer
 *
 * Implementations must implement the getReviewAggregation function, which
 * scrapes review data from the provided URL, and returns a ReviewAggregation.
 *
 * @category Reviewer
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class GooglePlacesReviewer implements Reviewer
{
    /**
     * An interface to a PhantomJS process. A headless browser that can be used to
     * get a snapshot of the HTML that a "real user" would see when visiting
     * a URL.
     *
     * @var Client
     */
    private $phantom;

    /**
     * GooglePlacesReviewer constructor.
     *
     * @param Client $phantom An interface to a PhantomJS process
     */
    public function __construct(Client $phantom)
    {
        $this->phantom = $phantom;
    }

    /**
     * Scrape a Google Places URL, returning a ReviewAggregation.
     *
     * @param string $url The URL to scrape
     *
     * @return ReviewAggregation|null
     */
    public function getReviewAggregation($url)
    {
        $response = $this->doRequest($url);

        if ($response->isRedirect()) {
            $response = $this->doRequest($response->getRedirectUrl());
        }

        if ($response->getStatus() !== 200) {
            return null;
        }
        $html = $response->getContent();

        $dom = new Dom;
        $dom->load($html);

        $numReviews = $this->scrapeNumReviews($dom);
        $averageScore = $this->scrapeAverageScore($dom);
        $positiveReviewPc = $this->scrapePositiveReviewPc($dom);

        if (!$positiveReviewPc && !$averageScore && !$numReviews) {
            return null;
        }
        $aggregation = new ReviewAggregation();
        $aggregation->setAverageScore($averageScore);
        $aggregation->setPositiveReviewPc((integer)$positiveReviewPc);
        $aggregation->setNumberOfReviews($numReviews);
        return $aggregation;
    }

    /**
     * Send a URL to the PhantomJS process, instructing it to process and render the resulting
     * web page and return the HTML a user would see.
     *
     * @param String $url The URL of the web page to render
     *
     * @return ResponseInterface
     */
    private function doRequest($url)
    {
        $request = $this->phantom->getMessageFactory()->createRequest($url, 'GET');
        $request->setTimeout(2000);
        $request->setViewportSize(320, 1024);

        $response = $this->phantom->getMessageFactory()->createResponse();

        $this->phantom->send($request, $response);

        return $response;
    }

    /**
     * Extract the number of reviews from the Google Places HTML.
     *
     * @param Dom $dom The Google Places HTML parsed into a Dom object.
     *
     * @return int|null
     */
    private function scrapeNumReviews(Dom $dom)
    {
        $numReviews = null;
        $numReviewsSelection = $dom->find('.ml-panes-entity-ratings-histogram-summary-reviews-number');
        if (count($numReviewsSelection)) {
            $numReviewsText = $numReviewsSelection[0]->text;
            $numReviews = (integer)explode('review', $numReviewsText)[0];
        }
        return $numReviews;
    }

    /**
     * Extract the average score of reviews from the Google Places HTML.
     *
     * @param Dom $dom The Google Places HTML parsed into a Dom object.
     *
     * @return float|null
     */
    private function scrapeAverageScore(Dom $dom)
    {
        $averageScore = null;
        $avgScoreSelection = $dom->find('.ml-panes-entity-review-number');
        if (count($avgScoreSelection)) {
            /**
             * A HtmlNode that contains the Average Score value
             *
             * @var HtmlNode $avgScoreContainer
             */
            $avgScoreContainer = $avgScoreSelection[0];
            $averageScore = (float)$avgScoreContainer->text(true);
        }
        return $averageScore;
    }

    /**
     * Extract the positive review percentage from the Google Places HTML.
     * 
     * Calculated using the widths of bars in the horizontal bar chart
     * displayed on the Google Places page. The width is controlled
     * by the "padding-left" style attribute.
     *
     * @param Dom $dom The Google Places HTML parsed into a Dom object.
     *
     * @return int|null
     */
    private function scrapePositiveReviewPc(Dom $dom)
    {
        $positiveReviewPc = null;
        // derive positive review percentage from the bar chart
        $barChartSelection = $dom->find('.ml-panes-entity-ratings-histogram-bucket');
        if (count($barChartSelection) === 5) {
            $totalBarSize = 0;
            $barSizeByRating = [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0
            ];
            $currentRating = 5; // nodes come back in reverse order
            foreach ($barChartSelection as $reviewBar) {
                /**
                 * A HtmlNode that represents the horizontal bar in a bar chart.
                 *
                 * @var HtmlNode $reviewBar
                 */
                $css = $reviewBar->getAttribute('style');
                $padding = explode('padding-left:', $css)[1];
                $barSizeByRating[$currentRating] = (float)$padding;
                $totalBarSize += (float)$padding;
                $currentRating--;
            }
            $positiveReviewPc = ($barSizeByRating[5] + $barSizeByRating[4] + $barSizeByRating[3]) * 100 / $totalBarSize;
        }
        return $positiveReviewPc;
    }
}