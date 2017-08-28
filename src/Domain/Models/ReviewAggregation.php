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
    private $numberOfReviews;
    
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
    public function getNumberOfReviews()
    {
        return $this->numberOfReviews;
    }

    /**
     * @param int $numReviews
     */
    public function setNumberOfReviews($numReviews)
    {
        $this->numberOfReviews = $numReviews;
    }
}