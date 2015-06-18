<?php

namespace DB\porteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * account
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DB\porteBundle\Entity\accountRepository")
 */
class account {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="limit_date", type="datetime")
     */
    private $limitDate;

    public function __construct() {
        $this->limitDate = new \Datetime();
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('limitDate', 'datetime');
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
     * Set mail
     *
     * @param string $mail
     * @return account
     */
    public function setMail($mail) {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return account
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
     * Set limitDate
     *
     * @param \DateTime $limitDate
     * @return account
     */
    public function setLimitDate($limitDate) {
        $this->limitDate = $limitDate;

        return $this;
    }

    /**
     * Get limitDate
     *
     * @return \DateTime 
     */
    public function getLimitDate() {
        return $this->limitDate;
    }

}
