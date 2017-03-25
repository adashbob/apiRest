<?php

namespace ApiUserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="security_users")
 */
class User extends BaseUser
{
   /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   protected $id;

   /**
    * @ORM\ManyToMany(targetEntity="ApiUserBundle\Entity\Role")
    * @ORM\JoinTable(name="security_users_roles",
    *    joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
    *    inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
    *    )
    */
   protected $profils;

   public function __construct()
   {
      parent::__construct();
      $this->profils = new ArrayCollection();
   }

   /**
    * Returns an ARRAY of Role objects with the default Role object appended.
    * @return array
    */
   public function getRoles()
   {
      return array_merge($this->profils->toArray(), array(new Role(parent::ROLE_DEFAULT)));
   }

   /**
    * Pass a string, checks if we have that Role. Same functionality as getRole() except returns a real boolean.
    * @param string $role
    * @return boolean
    */
   public function hasRole($role)
   {
      if ($this->getRole($role))
      {
         return true;
      }
      return false;
   }

   /**
    * Adds a Role OBJECT to the ArrayCollection. Can't type hint due to interface so throws Exception.
    * @param string $role
    * @throws \Exception
    * @return mixed
    *
    */
   public function addRole($role)
   {
      if(!$role instanceof Role)
      {
         throw new \Exception("addRole takes a Role object as the parameter");
      }
      if($this->hasRole($role->getRole()))
      {
         $this->profils->add($role);
      }
   }

   /**
    * Pass a string, remove the Role object from collection.
    * @param string $role
    * @return mixed
    */
   public function removeRole($role)
   {
      $roleElement = $this->getRole($role);
      if ($roleElement)
      {
         $this->roles->removeElement($roleElement);
      }
   }

   /**
    * Pass an ARRAY of Role objects and will clear the collection and re-set it with new Roles.
    * Type hinted array due to interface.
    * @param array $roles Of Role objects.
    * @return mixed
    */
   public function setRoles(array $roles)
   {
      $this->profils->clear();
      foreach ($roles as $role)
      {
         $this->addRole($role);
      }
      return $this;
   }


   /**
    * Returns the true ArrayCollection of Roles.
    */
   public function getRolesCollection()
   {
      return $this->profils;
   }

   /**
    * Pass a string, get the desired Role object or null.
    *
    * @param $role
    * @return mixed|null
    */
   public function getRole($role)
   {
      foreach ($this->getRoles() as $roleItem)
      {
         if ($role == $roleItem->getRole())
         {
            return $roleItem;
         }
      }
      return null;
   }


   /**
    * Directly set the ArrayCollection of Roles. Type hinted as Collection which is the parent of (Array|Persistent)Collection.
    * @param Collection $collection
    */
   public function setRolesCollection(Collection $collection)
   {
      $this->profils = $collection;
   }


}
