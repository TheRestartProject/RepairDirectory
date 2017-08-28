<?php
/**
 * Created by PhpStorm.
 * User: joaquim
 * Date: 24/08/2017
 * Time: 14:09
 */

namespace TheRestartProject\RepairDirectory\Domain\Models;


class ReviewAggregation
{
    /** @var float */
    private $averageScore;
    
    /** @var integer */
    private $positiveReviewPc;

    /** @var integer */
    private $numReviews;
    
    /**
     * @return float
     */
    public function getAverageScore()
    {
        return $this->averageScore;
    }

    /**
     * @param float $averageScore
     */
    public function setAverageScore($averageScore)
    {
        $this->averageScore = $averageScore;
    }

    /**
     * @return integer
     */
    public function getPositiveReviewPc()
    {
        return $this->positiveReviewPc;
    }

    /**
     * @param integer $positiveReviewPc
     */
    public function setPositiveReviewPc($positiveReviewPc)
    {
        $this->positiveReviewPc = $positiveReviewPc;
    }

    public function toArray() {
        return get_object_vars($this);
    }

    /**
     * @return int
     */
    public function getNumReviews()
    {
        return $this->numReviews;
    }

    /**
     * @param int $numReviews
     */
    public function setNumReviews($numReviews)
    {
        $this->numReviews = $numReviews;
    }
}