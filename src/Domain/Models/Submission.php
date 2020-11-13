<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

class Submission
{
    private $externalId;
    private $businessName;
    private $businessWebsite;
    private $businessBorough;
    private $reviewSource;
    private $extraInfo;
    private $createdAt;
    private $submittedByEmployee;

    public function __construct($submissionData)
    {
        $this->externalId = $submissionData->id;
        $this->businessName = $submissionData->{'1'};
        $this->businessWebsite = $submissionData->{'5'};
        $this->businessBorough = $submissionData->{'2'};
        $this->reviewSource = $submissionData->{'3'};
        $this->extraInfo = $submissionData->{'4'};
        $this->submittedByEmployee = $submissionData->{'6'};
        $this->createdAt = $submissionData->date_created;
    }

    public function getExternalId()
    {
        return $this->externalId;
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

    public function getExtraInfo()
    {
        return $this->extraInfo;
    }

    public function getSubmittedByEmployee()
    {
        return $this->submittedByEmployee;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

}
