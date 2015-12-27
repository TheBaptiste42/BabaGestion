<?php

namespace BVDS\ComptaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="BVDS\ComptaBundle\Repository\AccountRepository")
 */
class Account
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_lastmod", type="datetime")
     */
    private $dateLastmod;

    /**
     * @ORM\ManyToOne(targetEntity="BVDS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
    */
    private $proprio;

    /**
     * @ORM\OneToMany(targetEntity="BVDS\ComptaBundle\Entity\Transaction", mappedBy="account")
    */
    private $transactions;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Account
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Account
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateLastmod
     *
     * @param \DateTime $dateLastmod
     *
     * @return Account
     */
    public function setDateLastmod($dateLastmod)
    {
        $this->dateLastmod = $dateLastmod;

        return $this;
    }

    /**
     * Get dateLastmod
     *
     * @return \DateTime
     */
    public function getDateLastmod()
    {
        return $this->dateLastmod;
    }

    /**
     * Set proprio
     *
     * @param \BVDS\UserBundle\Entity\User $proprio
     *
     * @return Account
     */
    public function setProprio(\BVDS\UserBundle\Entity\User $proprio)
    {
        $this->proprio = $proprio;

        return $this;
    }

    /**
     * Get proprio
     *
     * @return \BVDS\UserBundle\Entity\User
     */
    public function getProprio()
    {
        return $this->proprio;
    }

    public function __construct($user)
    {
        $this->proprio = $user;
        $this->dateLastmod = new \DateTime();
        $this->dateCreation = new \DateTime();
    }

    /**
     * Add transaction
     *
     * @param \BVDS\ComptaBundle\Entity\Transaction $transaction
     *
     * @return Account
     */
    public function addTransaction(\BVDS\ComptaBundle\Entity\Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        $transaction->setAccount($this);

        return $this;
    }

    /**
     * Remove transaction
     *
     * @param \BVDS\ComptaBundle\Entity\Transaction $transaction
     */
    public function removeTransaction(\BVDS\ComptaBundle\Entity\Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Set montantInitial
     *
     * @param float $montantInitial
     *
     * @return Account
     */
    public function setMontantInitial($montantInitial)
    {
        $this->montant_initial = $montantInitial;

        return $this;
    }

    /**
     * Get montantInitial
     *
     * @return float
     */
    public function getMontantInitial()
    {
        return $this->montant_initial;
    }
}
