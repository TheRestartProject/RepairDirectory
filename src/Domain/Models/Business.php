<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;

/**
 * Class Business
 *
 * @category Model
 * @package  TheRestartProject\RepairDirectory\Domain\Models
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Business
{

    /**
     * The business ID (generated by the infrastructure layer)
     *
     * @var int
     */
    private $uid;

    /**
     * The common name of the business
     *
     * @var string
     */
    private $name;

    /**
     * The address of the business, excluding postcode
     *
     * @var string
     */
    private $address;

    /**
     * The postcode of the business
     *
     * @var string
     */
    private $postcode;

    /**
     * The city of the business
     *
     * @var string
     */
    private $city;

    /**
     * The location of the business
     *
     * @var Point
     */

    private $geolocation;

    /**
     * A description of the business
     *
     * @var string
     */
    private $description;

    /**
     * Landline phone number for the business
     *
     * @var string
     */
    private $landline;

    /**
     * Mobile number for the business
     *
     * @var string
     */
    private $mobile;

    /**
     * Business website
     *
     * @var string
     */
    private $website;

    /**
     * Business email address
     *
     * @var string
     */
    private $email;

    /**
     * UID of the local area
     *
     * @var int
     */
    private $localArea;

    /**
     * Name of the local area, e.g. 'Brixton'
     *
     * @var string
     */
    private $localAreaName;

    /**
     * Categories of products repaired by the business, e.g. ['Desktop computer', 'Laptop']
     *
     * @var array
     */
    private $categories = [];

    /**
     * List of products repaired, e.g. ['Computers', 'Laptops']
     *
     * @var array
     */
    private $productsRepaired = [];

    /**
     * List of brands that the repairer is officially authorised to repair.
     * E.g. ['Apple', 'Samsung']
     *
     * @var array
     */
    private $authorisedBrands = [];

    /**
     * Official qualifications that the Business has
     *
     * @var string
     */
    private $qualifications;

    /**
     * Text detailing any community endorsement the Business has
     *
     * @var string
     */
    private $communityEndorsement;

    /**
     * Miscellaneous motes
     *
     * @var string
     */
    private $notes;

    /**
     * Percentage of reviews that are positive
     *
     * @var integer
     */
    private $positiveReviewPc;

    /**
     * A URL that points to a review (or collection of reviews) of the Business
     * 
     * @var string
     */
    private $reviewSourceUrl;
    
    /**
     * The source of the review data provided - i.e. Google, yelp, ...
     * Valid sources are enumerated in Enums\ReviewSources
     *
     * @var string
     */
    private $reviewSource;

    /**
     * The average score of the selected source
     *
     * @var float
     */
    private $averageScore;

    /**
     * Number of reviews at the given source
     *
     * @var int
     */
    private $numberOfReviews;

    /**
     * Description of warranty available
     *
     * @var string
     */
    private $warranty;

    /**
     * Whether a warranty is offered or not
     *
     * @var bool
     */
    private $warrantyOffered;

    /**
     * Repair pricing information
     *
     * @var string
     */
    private $pricingInformation;

    /**
     * The publishing status of the business
     *
     * @var string
     */
    private $publishingStatus = PublishingStatus::DRAFT;

    /**
     * The reason for hiding the business.
     *
     * @var string
     */
    private $hideReason = NULL;

    /**
     * The date/time the business was created
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * The primary id of the user this business was created by
     *
     * @var User
     */
    private $createdBy;

    /**
     * The date/time the business was last modified
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * The primary id of the user that last updated this business
     *
     * @var int
     */
    private $updatedBy;

    /**
     * Return the business's unique id
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set the business's unique id
     *
     * @param int $uid The value to set
     *
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Return the business name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the business name
     *
     * @param string $name The value to set
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Return the business description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the business description
     *
     * @param string $description The value to set
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Return the business address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the business address
     *
     * @param string $address The value to set
     *
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Return the business landline
     *
     * @return string
     */
    public function getLandline()
    {
        return $this->landline;
    }

    /**
     * Set the business landline
     *
     * @param string $landline The value to set
     *
     * @return void
     */
    public function setLandline($landline)
    {
        $this->landline = $landline;
    }

    /**
     * Return the business mobile number
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set the business mobile number
     *
     * @param string $mobile The value to set
     *
     * @return void
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * Return the business website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set the business website
     *
     * @param string $website The value to set
     *
     * @return void
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Return the business email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the business email address
     *
     * @param string $email The value to set
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Return the local area of the Business
     *
     * @return string
     */
    public function getLocalAreaName()
    {
        return $this->localAreaName;
    }

    /**
     * Return the UID of the local area of the Business
     *
     * @return integer
     */
    public function getLocalArea()
    {
        return $this->localArea;
    }

    /**
     * Set the local area of the Business
     *
     * @param integer $localArea
     *
     * @return void
     */
    public function setLocalArea($localArea)
    {
        $this->localArea = $localArea;
    }

    /**
     * Set the local area name of the Business
     *
     * @param string $localArea
     *
     * @return void
     */
    public function setLocalAreaName($localArea)
    {
        $this->localAreaName = $localArea;
    }

    /**
     * Return the categories of product repaired by the Business
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set the categories of product repaired by the Business
     *
     * @param array $categories The value to set
     *
     * @return void
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Return a list of products repaired by the Business
     *
     * @return array
     */
    public function getProductsRepaired()
    {
        return $this->productsRepaired;
    }

    /**
     * Set the products repaired by the Business
     *
     * @param array $productsRepaired The list to set
     *
     * @return void
     */
    public function setProductsRepaired($productsRepaired)
    {
        $this->productsRepaired = $productsRepaired;
    }

    /**
     * Return the qualifications held by this business
     *
     * @return string
     */
    public function getQualifications()
    {
        return $this->qualifications;
    }

    /**
     * Set the qualifications held by this business
     *
     * @param string $qualifications The value to set
     *
     * @return void
     */
    public function setQualifications($qualifications)
    {
        $this->qualifications = $qualifications;
    }

    /**
     * Return the percentage of reviews of this business that are positive
     *
     * @return int
     */
    public function getPositiveReviewPc()
    {
        return $this->positiveReviewPc;
    }

    /**
     * Set the positive review percentage of this business
     *
     * @param int $positiveReviewPc The value to set
     *
     * @return void
     */
    public function setPositiveReviewPc($positiveReviewPc)
    {
        $this->positiveReviewPc = $positiveReviewPc;
    }

    /**
     * Returns the source of the review data
     *
     * @return string
     */
    public function getReviewSource()
    {
        return $this->reviewSource;
    }

    /**
     * Set the source of the review data
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
     * Returns the average Score
     *
     * @return float
     */
    public function getAverageScore()
    {
        return $this->averageScore;
    }

    /**
     * Set the average Score
     *
     * @param float $averageScore The value to set
     *
     * @return void
     */
    public function setAverageScore($averageScore)
    {
        $this->averageScore = $averageScore;
    }

    /**
     * Returns the number of reviews
     *
     * @return int
     */
    public function getNumberOfReviews()
    {
        return $this->numberOfReviews;
    }

    /**
     * Set the number of reviews
     *
     * @param int $numberOfReviews The value to set
     *
     * @return void
     */
    public function setNumberOfReviews($numberOfReviews)
    {
        $this->numberOfReviews = $numberOfReviews;
    }

    /**
     * Return this business's warranty information
     *
     * @return string
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Set this business's warranty information
     *
     * @param string $warranty The value to set
     *
     * @return void
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;
    }

    /**
     * Return whether this business provides warranty
     *
     * @return bool
     */
    public function isWarrantyOffered()
    {
        return $this->warrantyOffered;
    }

    /**
     * Set whether this business provides warranty or not
     *
     * @param bool $warrantyOffered The value to set
     *
     * @return void
     */
    public function setWarrantyOffered($warrantyOffered)
    {
        $this->warrantyOffered = $warrantyOffered;
    }

    /**
     * Get this business's pricing information
     *
     * @return string
     */
    public function getPricingInformation()
    {
        return $this->pricingInformation;
    }

    /**
     * Set this business's pricing information
     *
     * @param string $pricingInformation The value to set
     *
     * @return void
     */
    public function setPricingInformation($pricingInformation)
    {
        $this->pricingInformation = $pricingInformation;
    }

    /**
     * Get this business's publishing status
     *
     * @return string
     */
    public function getPublishingStatus()
    {
        return $this->publishingStatus;
    }

    /**
     * Set this business's publishing status
     *
     * @param string $publishingStatus The value to set
     *
     * @return void
     */
    public function setPublishingStatus($publishingStatus)
    {
        $this->publishingStatus = $publishingStatus;
    }

    /**
     * Get this business's hide reason
     *
     * @return string
     */
    public function getHideReason()
    {
        return $this->hideReason;
    }

    /**
     * Set this business's hide reason
     *
     * @param string $hideReason The value to set
     *
     * @return void
     */
    public function setHideReason(string $hideReason)
    {
        $this->hideReason = $hideReason;
    }

    /**
     * Return the [lat, lng] of the business
     *
     * @return Point
     */
    public function getGeolocation()
    {
        return $this->geolocation;
    }

    /**
     * Set the location of the business
     *
     * @param Point $geolocation The point to set
     *
     * @return void
     */
    public function setGeolocation($geolocation)
    {
        $this->geolocation = $geolocation;
    }

    /**
     * Return the postcode of the business
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set the postcode of the business
     *
     * @param string $postcode The value to set
     *
     * @return void
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * Return the city of the business
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the city of the business
     *
     * @param string $city The value to set
     *
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Convert the instance to a [ key => value ] array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = get_object_vars($this);
        $array['geolocation'] = $this->getGeolocation() ? $this->getGeolocation()->toArray() : null;
        return $array;
    }

    /**
     * Return the brands this business is authorised to repair
     * 
     * @return array
     */
    public function getAuthorisedBrands()
    {
        return $this->authorisedBrands;
    }

    /**
     * Set the brands this business is authorised to repair
     * 
     * @param array $authorisedBrands The array to set
     *
     * @return void
     */
    public function setAuthorisedBrands($authorisedBrands)
    {
        $this->authorisedBrands = $authorisedBrands;
    }

    /**
     * Get the business's community endorsement
     * 
     * @return string
     */
    public function getCommunityEndorsement()
    {
        return $this->communityEndorsement;
    }

    /**
     * Set a short community endorsement of the business
     * 
     * @param string $communityEndorsement The value to set
     *
     * @return void
     */
    public function setCommunityEndorsement($communityEndorsement)
    {
        $this->communityEndorsement = $communityEndorsement;
    }

    /**
     * Get miscellaneous notes on the business
     * 
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set miscellaneous notes for the business
     * 
     * @param string $notes The value to set
     *
     * @return void
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Whether the business is published or not
     *
     * Because the status hidden is only settable by an admin user
     * it is considered the same as published for this purpose.
     * Its a subset of published.
     *
     * @return bool
     */
    public function isPublished()
    {
        return in_array(
            $this->getPublishingStatus(),
            [
                PublishingStatus::HIDDEN,
                PublishingStatus::PUBLISHED
            ],
            true
        );
    }

    /**
     * Return a URL that points to a review (or collection of reviews) of the Business
     * 
     * @return string
     */
    public function getReviewSourceUrl()
    {
        return $this->reviewSourceUrl;
    }

    /**
     * Set a URL that points to a review (or collection of reviews) of the Business
     * 
     * @param string $reviewSourceUrl The value to set
     */
    public function setReviewSourceUrl($reviewSourceUrl)
    {
        $this->reviewSourceUrl = $reviewSourceUrl;
    }


    /**
     * Return the date/time the business was created
     * 
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the primary id of the user that created this business
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }


    /**
     * Set the primary id of the user that created this business
     *
     * @param int $userId
     */
    public function setCreatedBy($userId)
    {
        $this->createdBy = $userId;
    }


    /**
     * Get the primary id of the user that last updated this business
     *
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }


    /**
     * Set the primary id of the user that last updated this business
     *
     * @param int $userId
     */
    public function setUpdatedBy($userId)
    {
        $this->updatedBy = $userId;
    }


    /**
     * Return the date/time the business was last modified
     * 
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the date/time the business was last modified
     * 
     * @param \DateTime $updatedAt The value to set
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
