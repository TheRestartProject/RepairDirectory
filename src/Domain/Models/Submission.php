<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

class Submission
{
    private $businessName;
    private $businessWebsite;
    private $businessBorough;
    private $reviewSource;
    private $extraInfo;
    private $createdAt;
    private $submittedByEmployee;

    public function __construct($businessData)
    {
        $this->businessName = $businessData->{'1'};
        $this->businessWebsite = $businessData->{'5'};
        $this->businessBorough = $businessData->{'2'};
        $this->reviewSource = $businessData->{'3'};
        $this->extraInfo = $businessData->{'4'};
        $this->submittedByEmployee = $businessData->{'6'};
        $this->createdAt = $businessData->date_created;
    }

    public function getBusinessName()
    {
        return $this->businessName;
    }

    public function getBusinessWebsite()
    {
        return $this->businessWebsite;
    }

    public function getBusinessBorough()
    {
        return $this->businessBorough;
    }

    public function getReviewSource()
    {
        return $this->reviewSource;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getSubmittedByBusiness()
    {
        return $this->submittedByEmployee;
    }
}
