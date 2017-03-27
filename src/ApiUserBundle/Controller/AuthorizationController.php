<?php

namespace ApiUserBundle\Controller;

use ApiUserBundle\Entity\Authorization;
use ApiUserBundle\Form\AuthorizationType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AuthorizationController extends Controller
{

   /**
    * Remove User
    *
    * @Rest\View(StatusCode=Response::HTTP_CREATED)
    * @Rest\Post("/removeauth")
    * @Security("has_role('ROLE_ADMIN')")
    */
   public function removeAuthorizationAction(Request $request)
   {
      $authorization = new Authorization();
      $form = $this->createForm(AuthorizationType::class, $authorization);
      $form->submit($request->request->all());

      if($form->isValid()){
         return $this->get('doctrine.orm.entity_manager')
            ->getRepository('ApiUserBundle:User')
            ->removeAuthorization($authorization);
      }
      else
         return $form;
   }

   /**
    * Remove User
    *
    * @Rest\View(StatusCode=Response::HTTP_CREATED)
    * @Rest\Post("/addauth")
    * @Security("has_role('ROLE_ADMIN')")
    */
   public function postAuthorizationAction(Request $request)
   {
      $authorization = new Authorization();
      $form = $this->createForm(AuthorizationType::class, $authorization);
      $form->submit($request->request->all());

      if($form->isValid()){
         return $this->get('doctrine.orm.entity_manager')
            ->getRepository('ApiUserBundle:User')
            ->addAuthorization($authorization);
      }
      else
         return $form;
   }

}
