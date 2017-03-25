<?php

namespace ApiUserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Profil
 *
 * @ORM\Table(name="security_roles")
 * @ORM\Entity(repositoryClass="ApiUserBundle\Repository\RoleRepository")
 */
class Role implements RoleInterface
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
     * @ORM\Column(name="role", type="string", unique=true, length=100)
     */
    private $role;

   /**
    * @ORM\ManyToMany(targetEntity="ApiUserBundle\Entity\User")
    */
   protected $users;

   /**
    * Profil constructor.
    * @param $role
    */
   public function __construct($role)
   {
      $this->role = $role;
      $this->users = new ArrayCollection();
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
    * Returns the role.
    *
    * @return string|null A string representation of the role, or null
    */
   public function getRole()
   {
     return $this->role;
   }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Add user
     *
     * @param \ApiUserBundle\Entity\User $user
     *
     * @return Role
     */
    public function addUser(\ApiUserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \ApiUserBundle\Entity\User $user
     */
    public function removeUser(\ApiUserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
