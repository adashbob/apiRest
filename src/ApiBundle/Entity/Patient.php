<?php

namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Patient
 *
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\PatientRepository")
 * @ORM\Table(name="patient",
 *    uniqueConstraints={@ORM\UniqueConstraint(name="pt_patient_unique", columns={"pt_firstname", "pt_lastname", "pt_adresse", "pt_telephone", "pt_date_naissance"})})
 * @Serializer\ExclusionPolicy("all")
 */
class Patient extends BaseEntity
{
    /**
     * Identifiant unique d'un patient
     *
     * @var int
     * @ORM\Column(name="pt_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Prénom du patient
     *
     * @var string
     * @ORM\Column(name="pt_firstname", type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    protected $firstname;

    /**
     * nom du patient
     *
     * @var string
     * @ORM\Column(name="pt_lastname", type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    protected $lastname;

    /**
     * nom du patient
     *
     * @var string
     * @ORM\Column(name="pt_telephone", type="string", length=15)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    protected $telephone;

    /**
     * nom du patient
     *
     * @var string
     * @ORM\Column(name="pt_date_naissance", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    protected $dateNaissance;

    /**
     * Adresse du patient
     *
     * @var string
     * @ORM\Column(name="pt_adresse", type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    protected $adresse;

   /**
    * Liste des consultations du patient
    *
    * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Consultation", mappedBy="patient")
    */
    protected $consultations;

   /**
    * Liste des consultations BilanSanguin du patient
    *
    * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Bilansanguin", mappedBy="patient")
    */
    protected $bilansanguins;

   /**
    * Liste des examens imagerie du patient
    *
    * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Examenimagerie", mappedBy="patient")
    */
    protected $examenimageries;

   /**
    * Liste des hospitalisations du patient
    *
    * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Hospitalisation", mappedBy="patient")
    */
    protected $hospitalisations;

   /**
    * Liste des consultations du patient
    *
    * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Ordonnance", mappedBy="patient")
    */
    protected $ordonnances;

   /**
    * Liste des consultations du patient
    *
    * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Soininfirmier", mappedBy="patient")
    */
    protected $soininfirmiers;

   /**
    * Liste des rv du patient
    *
    * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Rv", mappedBy="patient")
    */
    protected $rvs;

   /**
    * Patient constructor
    */
   public function __construct(){
      $this->consultations = new ArrayCollection();
      $this->bilansanguins = new ArrayCollection();
      $this->examenimageries = new ArrayCollection();
      $this->hospitalisations = new ArrayCollection();
      $this->ordonnances = new ArrayCollection();
      $this->rvs = new ArrayCollection();
      $this->soininfirmiers = new ArrayCollection();
   }

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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Patient
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Patient
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Patient
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }


   /**
    * @return string
    */
   public function getTelephone()
   {
      return $this->telephone;
   }

   /**
    * @param string $telephone
    */
   public function setTelephone($telephone)
   {
      $this->telephone = $telephone;
   }

   /**
    * @return string
    */
   public function getDateNaissance()
   {
      return $this->dateNaissance;
   }

   /**
    * @param string $dateNaissance
    */
   public function setDateNaissance($dateNaissance)
   {
      $this->dateNaissance = $dateNaissance;
   }

    /**
     * Add consultation
     *
     * @param \ApiBundle\Entity\Consultation $consultation
     *
     * @return Patient
     */
    public function addConsultation(\ApiBundle\Entity\Consultation $consultation)
    {
        $this->consultations[] = $consultation;

        return $this;
    }

    /**
     * Remove consultation
     *
     * @param \ApiBundle\Entity\Consultation $consultation
     */
    public function removeConsultation(\ApiBundle\Entity\Consultation $consultation)
    {
        $this->consultations->removeElement($consultation);
    }

    /**
     * Get consultations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConsultations()
    {
        return $this->consultations;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Patient
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
     * @return Patient
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
     * Add bilansanguin
     *
     * @param \ApiBundle\Entity\Bilansanguin $bilansanguin
     *
     * @return Patient
     */
    public function addBilansanguin(\ApiBundle\Entity\Bilansanguin $bilansanguin)
    {
        $this->bilansanguins[] = $bilansanguin;

        return $this;
    }

    /**
     * Remove bilansanguin
     *
     * @param \ApiBundle\Entity\Bilansanguin $bilansanguin
     */
    public function removeBilansanguin(\ApiBundle\Entity\Bilansanguin $bilansanguin)
    {
        $this->bilansanguins->removeElement($bilansanguin);
    }

    /**
     * Get bilansanguins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBilansanguins()
    {
        return $this->bilansanguins;
    }

    /**
     * Add examenimagery
     *
     * @param \ApiBundle\Entity\Examenimagerie $examenimagery
     *
     * @return Patient
     */
    public function addExamenimagery(\ApiBundle\Entity\Examenimagerie $examenimagery)
    {
        $this->examenimageries[] = $examenimagery;

        return $this;
    }

    /**
     * Remove examenimagery
     *
     * @param \ApiBundle\Entity\Examenimagerie $examenimagery
     */
    public function removeExamenimagery(\ApiBundle\Entity\Examenimagerie $examenimagery)
    {
        $this->examenimageries->removeElement($examenimagery);
    }

    /**
     * Get examenimageries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExamenimageries()
    {
        return $this->examenimageries;
    }

    /**
     * Add hospitalisation
     *
     * @param \ApiBundle\Entity\Hospitalisation $hospitalisation
     *
     * @return Patient
     */
    public function addHospitalisation(\ApiBundle\Entity\Hospitalisation $hospitalisation)
    {
        $this->hospitalisations[] = $hospitalisation;

        return $this;
    }

    /**
     * Remove hospitalisation
     *
     * @param \ApiBundle\Entity\Hospitalisation $hospitalisation
     */
    public function removeHospitalisation(\ApiBundle\Entity\Hospitalisation $hospitalisation)
    {
        $this->hospitalisations->removeElement($hospitalisation);
    }

    /**
     * Get hospitalisations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHospitalisations()
    {
        return $this->hospitalisations;
    }

    /**
     * Add ordonnance
     *
     * @param \ApiBundle\Entity\Ordonnance $ordonnance
     *
     * @return Patient
     */
    public function addOrdonnance(\ApiBundle\Entity\Ordonnance $ordonnance)
    {
        $this->ordonnances[] = $ordonnance;

        return $this;
    }

    /**
     * Remove ordonnance
     *
     * @param \ApiBundle\Entity\Ordonnance $ordonnance
     */
    public function removeOrdonnance(\ApiBundle\Entity\Ordonnance $ordonnance)
    {
        $this->ordonnances->removeElement($ordonnance);
    }

    /**
     * Get ordonnances
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrdonnances()
    {
        return $this->ordonnances;
    }

    /**
     * Add rv
     *
     * @param \ApiBundle\Entity\Rv $rv
     *
     * @return Patient
     */
    public function addRv(\ApiBundle\Entity\Rv $rv)
    {
        $this->rvs[] = $rv;

        return $this;
    }

    /**
     * Remove rv
     *
     * @param \ApiBundle\Entity\Rv $rv
     */
    public function removeRv(\ApiBundle\Entity\Rv $rv)
    {
        $this->rvs->removeElement($rv);
    }

    /**
     * Get rvs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRvs()
    {
        return $this->rvs;
    }

    /**
     * Add soininfirmier
     *
     * @param \ApiBundle\Entity\Soininfirmier $soininfirmier
     *
     * @return Patient
     */
    public function addSoininfirmier(\ApiBundle\Entity\Soininfirmier $soininfirmier)
    {
        $this->soininfirmiers[] = $soininfirmier;

        return $this;
    }

    /**
     * Remove soininfirmier
     *
     * @param \ApiBundle\Entity\Soininfirmier $soininfirmier
     */
    public function removeSoininfirmier(\ApiBundle\Entity\Soininfirmier $soininfirmier)
    {
        $this->soininfirmiers->removeElement($soininfirmier);
    }

    /**
     * Get soininfirmiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSoininfirmiers()
    {
        return $this->soininfirmiers;
    }
}
