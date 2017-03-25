<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultation
 *
 * @ORM\Table(name="consultation")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\ConsultationRepository")
 */
class Consultation extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="cs_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cs_description", type="string", length=200)
     */
    private $description;


   /**
    * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Patient", inversedBy="consultations")
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
    * @return string
    */
   public function getDescription()
   {
      return $this->description;
   }

   /**
    * @param string $description
    */
   public function setDescription($description)
   {
      $this->description = $description;
   }

    /**
     * Set patient
     *
     * @param \ApiBundle\Entity\Patient $patient
     *
     * @return Consultation
     */
    public function setPatient(\ApiBundle\Entity\Patient $patient = null)
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
