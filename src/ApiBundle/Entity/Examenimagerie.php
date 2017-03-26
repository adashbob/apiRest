<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Examenimagerie
 *
 * @ORM\Table(name="examenimagerie")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\ExamenimagerieRepository")
 */
class Examenimagerie extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="ei_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="ei_isPaid", type="boolean")
     */
    private $isPaid;

   /**
    * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Patient", inversedBy="examenimageries")
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
     * @return Examenimagerie
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Examenimagerie
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
     * @return Examenimagerie
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
     * @return Examenimagerie
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
