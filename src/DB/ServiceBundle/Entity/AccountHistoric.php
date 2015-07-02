<?php

namespace DB\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountHistoric
 *
 * @ORM\Table(name="account_historic", indexes={@ORM\Index(name="website_id_idx", columns={"website_id"}), @ORM\Index(name="user_id_idx", columns={"user_id"})})
 * @ORM\Entity
 */
class AccountHistoric
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="action_type", type="string", length=255, nullable=false)
     */
    private $actionType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
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
     */
    private $website;


}
