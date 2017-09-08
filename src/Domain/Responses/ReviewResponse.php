<?php

namespace TheRestartProject\RepairDirectory\Domain\Responses;


use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;

/**
 * Class ReviewResponse
 *
 * Encapsulates the data returned by the Admin\BusinessController\scrapeReview method.
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Domain\Models
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ReviewResponse
{
    /**
     * A ReviewSource value. Where the review aggregation was retrieved from.
     *
     * @var string|null
     */
    private $reviewSource;

    /**
     * An aggregation of the reviews retrieved from the stated ReviewSource.
     *
     * @var ReviewAggregation 
     */
    private $reviewAggregation;

    /**
     * ReviewResponse constructor.
     *
     * @param string|null $reviewSource The value to set (null if unknown)
     */
    public function __construct($reviewSource)
    {
        $this->reviewSource = $reviewSource;
    }

    /**
     * Return the ReviewSource that data has been retrieved from.
     *
     * @return string|null
     */
    public function getReviewSource()
    {
        return $this->reviewSource;
    }

    /**
     * Set the ReviewSource that data was retrieved from.
     *
     * @param string $reviewSource The value to set
     *
     * @return void
     */
    public function setReviewSource($reviewSource)
    {
        $this->reviewSource = $reviewSource;
    }

    /**
     * Get the ReviewAggregation that was created from data from the stated ReviewSource.
     *
     * @return ReviewAggregation
     */
    public function getReviewAggregation()
    {
        return $this->reviewAggregation;
    }

    /**
     * Set the ReviewAggregation that was created from data from the stated ReviewSource.
     *
     * @param ReviewAggregation $reviewAggregation The object to set
     *
     * @return void
     */
    public function setReviewAggregation($reviewAggregation)
    {
        $this->reviewAggregation = $reviewAggregation;
    }

    /**
     * Return the ReviewResponse as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'reviewSource' => $this->reviewSource,
            'reviewAggregation' => $this->reviewAggregation ? $this->reviewAggregation->toArray() : null
        ];
    }

}
