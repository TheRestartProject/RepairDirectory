<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

/**
 * Class Business
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Domain\Models
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
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
     * Name of the local area, e.g. 'Brixton'
     *
     * @var string
     */
    private $localArea;

    /**
     * Category of business, e.g. 'Computer repairs'
     *
     * @var string
     */
    private $category;

    /**
     * List of products repaired, e.g. ['Computers', 'Laptops']
     *
     * @var array
     */
    private $productsRepaired;

    /**
     * Has this Business been verified by an admin?
     *
     * @var boolean
     */
    private $authorised = false;

    /**
     * Official qualifications that the Business has
     *
     * @var string
     */
    private $qualifications;

    /**
     * List of links to reviews of the Business
     *
     * @var array
     */
    private $reviews;

    /**
     * Percentage of reviews that are positive
     *
     * @var integer
     */
    private $positiveReviewPc;

    /**
     * Description of warranty available
     *
     * @var string
     */
    private $warranty;

    /**
     * Repair pricing information
     *
     * @var string
     */
    private $pricingInformation;

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
    public function getLocalArea()
    {
        return $this->localArea;
    }

    /**
     * Set the local area of the Business
     *
     * @param string $localArea The value to set
     *
     * @return void
     */
    public function setLocalArea($localArea)
    {
        $this->localArea = $localArea;
    }

    /**
     * Return the category of business
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the category of Business
     *
     * @param string $category The value to set
     *
     * @return void
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
     * Return true if this business has been authorised by The Restart Project
     *
     * @return bool
     */
    public function isAuthorised()
    {
        return $this->authorised;
    }

    /**
     * Set whether this business has been authorised by The Restart Project
     *
     * @param bool $authorised The value to set
     *
     * @return void
     */
    public function setAuthorised($authorised)
    {
        $this->authorised = $authorised;
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
     * Return a list of links to reviews of this business
     *
     * @return array
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Set the list of reviews of this business
     *
     * @param array $reviews The value to set
     *
     * @return void
     */
    public function setReviews($reviews)
    {
        $this->reviews = $reviews;
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
        $array['geolocation'] = $this->getGeolocation()->toArray();
        return $array;
    }

}
