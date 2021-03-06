<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bilansanguin
 *
 * @ORM\Table(name="bilan_sanguin")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\BilansanguinRepository")
 */
class Bilansanguin extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="bs_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="bs_isPaid", type="boolean")
     */
    private $isPaid;

    /**
     * @var string
     *
     * @ORM\Column(name="bs_loboratoire", type="string", length=255)
     */
    private $loboratoire;

   /**
    * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Patient", inversedBy="bilansanguins")
    * @ORM\JoinColumn(name="patient_id", referencedColumnName="pt_id", nullable=false)
    */
   private $patient;


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
     * Set isPaid
     *
     * @param boolean $isPaid
     *
     * @return Bilansanguin
     */
    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    /**
     * Get isPaid
     *
     * @return bool
     */
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * Set loboratoire
     *
     * @param string $loboratoire
     *
     * @return Bilansanguin
     */
    public function setLoboratoire($loboratoire)
    {
        $this->loboratoire = $loboratoire;

        return $this;
    }

    /**
     * Get loboratoire
     *
     * @return string
     */
    public function getLoboratoire()
    {
        return $this->loboratoire;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Bilansanguin
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Bilansanguin
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set patient
     *
     * @param \ApiBundle\Entity\Patient $patient
     *
     * @return Bilansanguin
     */
    public function setPatient(\ApiBundle\Entity\Patient $patient)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get patient
     *
     * @return \ApiBundle\Entity\Patient
     */
    public function getPatient()
    {
        return $this->patient;
    }
}
