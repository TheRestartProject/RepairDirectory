<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

class Submission
{
    /**
     * The unique id of the submission in Gravity Forms.
     *
     * @var string
     */
    private $externalId;

    /**
     * The name of the business.
     *
     * @var string
     */
    private $businessName;

    /**
     * The business website.
     *
     * @var string
     */
    private $businessWebsite;

    /**
     * The borough or council area.
     *
     * @var string
     */
    private $businessBorough;

    /**
     * The URL of the source of review information.
     *
     * @var string
     */
    private $reviewSource;

    /**
     * Any extra information
     *
     * @var string
     */
    private $extraInfo;

    /**
     * The date/time the submission was created
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Whether the business was submitted by one of its employees.
     *
     * @var boolean
     */
    private $submittedByEmployee;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $notes;

    public function __construct($submissionData)
    {
        $this->externalId = $submissionData->id;
        $this->businessName = $submissionData->{'1'};
        $this->businessWebsite = $submissionData->{'5'};
        $this->businessBorough = $submissionData->{'2'};
        $this->reviewSource = $submissionData->{'3'};
        $this->extraInfo = $submissionData->{'4'};
        $this->submittedByEmployee = $submissionData->{'6'};
        $this->createdAt = new \DateTime($submissionData->date_created);
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
        return $this->createdAt->format("Y-m-d H:i:s");
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
}
