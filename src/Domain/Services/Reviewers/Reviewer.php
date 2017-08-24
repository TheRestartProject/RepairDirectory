<?php
/**
 * Created by PhpStorm.
 * User: joaquim
 * Date: 24/08/2017
 * Time: 14:08
 */

namespace TheRestartProject\RepairDirectory\Domain\Services\Reviewers;


use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;

interface Reviewer
{

    /**
     * @param string $url
     * @return ReviewAggregation
     */
    public function getReviewAggregation($url);
    
}