<?php

namespace DB\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Website
 *
 * @ORM\Table(name="website", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_476F5DE792FC23A8", columns={"username_canonical"}), @ORM\UniqueConstraint(name="UNIQ_476F5DE7A0D96FBF", columns={"email_canonical"})})
 * @ORM\Entity
 * 
 * @ExclusionPolicy("all")
 */
class Website extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     * @Expose
     */
    protected $name;


    public function __construct() {
        parent::__construct();
    }
    
    public function getId()
    {
        return $this->id;
    }

     /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

}
