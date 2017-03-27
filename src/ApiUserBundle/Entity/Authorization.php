<?php

namespace ApiUserBundle\Entity;

use Symfony\Component\Validator\Constraints as Asset;

/**
 * Authorization
 */
class Authorization
{

    /**
     * @var string
     * @Asset\NotBlank()
     */
    private $username;

   /**
    * @var string
    * @Asset\NotBlank()
    */
   private $role;

   /**
    * @return string
    */
   public function getUsername()
   {
      return $this->username;
   }

   /**
    * @param string $username
    */
   public function setUsername($username)
   {
      $this->username = $username;
   }

   /**
    * @return string
    */
   public function getRole()
   {
      return $this->role;
   }

   /**
    * @param string $role
    */
   public function setRole($role)
   {
      $this->role = $role;
   }

}
