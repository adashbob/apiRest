<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ordonnance
 *
 * @ORM\Table(name="ordonnance")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\OrdonnanceRepository")
 */
class Ordonnance extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="od_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

   /**
    * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Patient", inversedBy="ordonnances")
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Ordonnance
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
     * @return Ordonnance
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
     * @return Ordonnance
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
