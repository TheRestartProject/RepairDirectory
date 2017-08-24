<?php

namespace TheRestartProject\RepairDirectory\Domain\Responses;


use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;

class ReviewResponse
{
    /** @var string */
    private $reviewSource;

    /** @var ReviewAggregation */
    private $reviewAggregation;

    /**
     * ReviewResponse constructor.
     *
     * @param string $reviewSource
     */
    public function __construct($reviewSource)
    {
        $this->reviewSource = $reviewSource;
    }

    /**
     * @return string
     */
    public function getReviewSource()
    {
        return $this->reviewSource;
    }

    /**
     * @param string $reviewSource
     */
    public function setReviewSource($reviewSource)
    {
        $this->reviewSource = $reviewSource;
    }

    /**
     * @return ReviewAggregation
     */
    public function getReviewAggregation()
    {
        return $this->reviewAggregation;
    }

    /**
     * @param ReviewAggregation $reviewAggregation
     */
    public function setReviewAggregation($reviewAggregation)
    {
        $this->reviewAggregation = $reviewAggregation;
    }

    public function toArray()
    {
        return [
            'reviewSource' => $this->reviewSource,
            'reviewAggregation' => $this->reviewAggregation ? $this->reviewAggregation->toArray() : null
        ];
    }

}