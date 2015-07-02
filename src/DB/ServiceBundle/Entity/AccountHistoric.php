<?php

namespace DB\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * AccountHistoric
 *
 * @ORM\Table(name="account_historic", indexes={@ORM\Index(name="website_id_idx", columns={"website_id"}), @ORM\Index(name="user_id_idx", columns={"user_id"})})
 * @ORM\Entity
 * 
 * @ExclusionPolicy("all")
 */
class AccountHistoric
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=false)
     * @Expose
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="action_type", type="string", length=255, nullable=false)
     * @Expose
     */
    private $actionType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     * @Expose
     */
    private $date;

    /**
     * @var \Account
     *
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Website
     *
     * @ORM\ManyToOne(targetEntity="Website")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="website_id", referencedColumnName="id")
     * })
     * @Expose
     */
    private $website;
    
     /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return AccountHistoric
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set actionType
     *
     * @param string $actionType
     * @return AccountHistoric
     */
    public function setActionType($actionType)
    {
        $this->actionType = $actionType;

        return $this;
    }

    /**
     * Get actionType
     *
     * @return string 
     */
    public function getActionType()
    {
        return $this->actionType;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return AccountHistoric
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \DB\ServiceBundle\Entity\Account $user
     * @return AccountHistoric
     */
    public function setUser(\DB\ServiceBundle\Entity\Account $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \DB\ServiceBundle\Entity\Account 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set website
     *
     * @param \DB\ServiceBundle\Entity\Website $website
     * @return AccountHistoric
     */
    public function setWebsite(\DB\ServiceBundle\Entity\Website $website = null)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return \DB\ServiceBundle\Entity\Website 
     */
    public function getWebsite()
    {
        return $this->website;
    }


}
