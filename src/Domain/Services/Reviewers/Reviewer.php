<?php

namespace TheRestartProject\RepairDirectory\Domain\Services\Reviewers;

use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;

/**
 * Interface Reviewer
 *
 * Implementations must implement the getReviewAggregation function, which
 * scrapes review data from the provided URL, and returns a ReviewAggregation.
 *
 * @category Interface
 * @package  TheRestartProject\RepairDirectory\Domain\Services\Reviewers
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface Reviewer
{

    /**
     * Scrape the provided URL and return a ReviewAggregation.
     *
     * @param string $url A URL that points to a Business's page on a review site
     *
     * @return ReviewAggregation
     */
    public function getReviewAggregation($url);
    
}