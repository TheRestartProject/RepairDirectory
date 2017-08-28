<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers;


use JonnyW\PhantomJs\Client;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;
use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;
use TheRestartProject\RepairDirectory\Domain\Services\Reviewers\Reviewer;

class GooglePlacesReviewer implements Reviewer
{
    /** @var Client */
    private $phantom;

    public function __construct(Client $phantom)
    {
        $this->phantom = $phantom;
    }

    /**
     * @param string $url
     * @return ReviewAggregation
     */
    public function getReviewAggregation($url)
    {
        $numReviews = null;
        $averageScore = null;
        $positiveReviewPc = null;
        
        $response = $this->doRequest($url);

        if ($response->isRedirect()) {
            $response = $this->doRequest($response->getRedirectUrl());
        }

        if ($response->getStatus() === 200) {
            $html = $response->getContent();

            $dom = new Dom;
            $dom->load($html);
            $numReviewsSelection = $dom->find('.ml-panes-entity-ratings-histogram-summary-reviews-number');
            if (count($numReviewsSelection)) {
                $numReviewsText = $numReviewsSelection[0]->text;
                $numReviews = (integer) explode('review', $numReviewsText)[0];
            }

            $averageScoreContainerSelection = $dom->find('.ml-panes-entity-review-number');
            if (count($averageScoreContainerSelection)) {
                /** @var HtmlNode $averageScoreContainer */
                $averageScoreContainer = $averageScoreContainerSelection[0];
                $averageScore = (float) $averageScoreContainer->find('span')[0]->text;
            }

            // derive positive review percentage from the bar chart
            $reviewBarChartSelection = $dom->find('.ml-panes-entity-ratings-histogram-bucket');
            if (count($reviewBarChartSelection) === 5) {
                $totalBarSize = 0;
                $barSizeByRating = [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0
                ];
                $currentRating = 5; // nodes come back in reverse order
                foreach ($reviewBarChartSelection as $reviewBar) {
                    /** @var HtmlNode $reviewBar */
                    $css = $reviewBar->getAttribute('style');
                    $padding = explode('padding-left:', $css)[1];
                    $barSizeByRating[$currentRating] = (float) $padding;
                    $totalBarSize += (float) $padding;
                    $currentRating--;
                }
                $positiveReviewPc = ($barSizeByRating[5] + $barSizeByRating[4] + $barSizeByRating[3]) * 100 / $totalBarSize;
            }
        }
        if (!$positiveReviewPc || !$averageScore || !$numReviews) {
            return null;
        }
        $aggregation = new ReviewAggregation();
        $aggregation->setAverageScore($averageScore);
        $aggregation->setPositiveReviewPc((integer) $positiveReviewPc);
        $aggregation->setNumberOfReviews($numReviews);
        return $aggregation;
    }

    private function doRequest($url) {
        $request = $this->phantom->getMessageFactory()->createRequest($url, 'GET');
        $request->setTimeout(2000);
        $request->setViewportSize(320, 1024);

        $response = $this->phantom->getMessageFactory()->createResponse();

        $this->phantom->send($request, $response);

        return $response;
    }
}