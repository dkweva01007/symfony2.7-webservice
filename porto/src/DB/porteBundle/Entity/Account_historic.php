<?php

namespace DB\porteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account_historic
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DB\porteBundle\Entity\Account_historicRepository")
 */
class Account_historic {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="website_id", type="integer")
     */
    private $websiteId;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="action_type", type="string", length=255)
     */
    private $actionType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct() {
        $this->date = new \Datetime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Account_historic
     */
    public function setUserId($userId) {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * Set websiteId
     *
     * @param integer $websiteId
     * @return Account_historic
     */
    public function setWebsiteId($websiteId) {
        $this->websiteId = $websiteId;

        return $this;
    }

    /**
     * Get websiteId
     *
     * @return integer 
     */
    public function getWebsiteId() {
        return $this->websiteId;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Account_historic
     */
    public function setAmount($amount) {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * Set actionType
     *
     * @param string $actionType
     * @return Account_historic
     */
    public function setActionType($actionType) {
        $this->actionType = $actionType;

        return $this;
    }

    /**
     * Get actionType
     *
     * @return string 
     */
    public function getActionType() {
        return $this->actionType;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Account_historic
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }

}
