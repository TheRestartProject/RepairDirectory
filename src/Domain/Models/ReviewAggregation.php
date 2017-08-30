<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

/**
 * Class ReviewAggregation
 *
 * Stores aggregated data on a Business, retrieved from a Reviewer (e.g. Google Places).
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Domain\Models
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ReviewAggregation
{
    /**
     * The average score of reviews for the Business, out of 5
     *
     * @var float|null
     */
    private $averageScore;
    
    /**
     * The percentage of reviews for the Business that are positive (3/5 or greater)
     *
     * @var integer|null
     */
    private $positiveReviewPc;

    /**
     * The total number of reviews for the Business
     *
     * @var integer|null
     */
    private $numberOfReviews;
    
    /**
     * Return the average score of reviews for the Business
     *
     * @return float|null
     */
    public function getAverageScore()
    {
        return $this->averageScore;
    }

    /**
     * Set the average score of reviews for the Business
     *
     * @param float|null $averageScore The value to set
     *
     * @return void
     */
    public function setAverageScore($averageScore)
    {
        $this->averageScore = $averageScore;
    }

    /**
     * Get the percentage of reviews that are positive for the Business
     *
     * @return int|null
     */
    public function getPositiveReviewPc()
    {
        return $this->positiveReviewPc;
    }

    /**
     * Set the percentage of reviews that are positive for the Business
     *
     * @param int|null $positiveReviewPc The value to set
     *
     * @return void
     */
    public function setPositiveReviewPc($positiveReviewPc)
    {
        $this->positiveReviewPc = $positiveReviewPc;
    }

    /**
     * Return the ReviewAggregation as a keyed array
     *
     * @return array
     */
    public function toArray() 
    {
        return get_object_vars($this);
    }

    /**
     * Return the total number of reviews of the Business
     *
     * @return int|null
     */
    public function getNumberOfReviews()
    {
        return $this->numberOfReviews;
    }

    /**
     * Set the total number of reviews of the Business
     *
     * @param int|null $numReviews The value to set
     *
     * @return void
     */
    public function setNumberOfReviews($numReviews)
    {
        $this->numberOfReviews = $numReviews;
    }
}