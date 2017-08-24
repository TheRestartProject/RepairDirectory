<?php

namespace TheRestartProject\RepairDirectory\Domain\Services;


use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Responses\ReviewResponse;
use TheRestartProject\RepairDirectory\Domain\Services\Reviewers\Reviewer;
use TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers\GooglePlacesReviewer;

class ReviewManager
{
    /** @var Reviewer[] */
    private $reviewers;
    
    public function __construct(GooglePlacesReviewer $googlePlacesReviewer)
    {
        $this->reviewers = [
            ReviewSource::GOOGLE => $googlePlacesReviewer
        ];
    }

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