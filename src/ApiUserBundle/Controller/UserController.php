<?php

namespace ApiUserBundle\Controller;

use ApiUserBundle\Form\UserType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use ApiUserBundle\Entity\User;

class UserController extends Controller
{
   /**
    * @ApiDoc(
    *    description="Récupère la liste des users de l'application",
    *    output= {"class"=User::class, "collection"=true, "groups"={"user"}}
    * )
    *
    * @Rest\View(serializerGroups={"user"})
    * @Rest\Get("/users")
    * @QueryParam(name="offset", requirements="\d+", default="", description="Index de debut de la pagination")
    * @QueryParam(name="limit", requirements="\d+", default="", description="Nombre d'éléments à afficher")
    * @QueryParam(name="sort", requirements="(asc|desc)", nullable=true, description="Ordre de tri (basé sur le lastname)")
    *
    * @Security("has_role('ROLE_ADMIN')")
    */
   public function getUsersAction(Request $request, ParamFetcher $paramFetcher)
   {
      $offset = $paramFetcher->get('offset');
      $limit = $paramFetcher->get('limit');
      $sort = $paramFetcher->get('sort');

      return $this->getDoctrine()
         ->getRepository('ApiUserBundle:User')
         ->getUsersOffsetLimit($offset, $limit, $sort);
   }

   /**
    * @ApiDoc(description="Get user by id")
    * @Rest\View(serializerGroups={"user"})
    * @Rest\Get("/users/{id}")
    */
   public function getUserAction(Request $request){
      $user =  $this->getDoctrine()
         ->getRepository('ApiUserBundle:User')
         ->find($request->get('id'));

      if(empty($user))
         throw new NotFoundHttpException("User not found");

      return $user;
   }

   /**
    * @ApiDoc(description="Remove user")    *
    * @Rest\View(StatusCode=Response::HTTP_NO_CONTENT, serializerGroups={"user"})
    * @Rest\Delete("/users/{id}")
    */
   public function removeUserAction(Request $request){
      $em = $this->get('doctrine.orm.entity_manager');
      $user = $em->getRepository('ApiUserBundle:User')
         ->find($request->get('id'));

      if(!$user)
         throw new NotFoundHttpException("User not found");

      $access_tokens =  $this->getDoctrine()->getRepository('ApiUserBundle:AccessToken')->findAll();
      $auth_codes =  $this->getDoctrine()->getRepository('ApiUserBundle:AuthCode')->findAll();
      $refresh_tokens =  $this->getDoctrine()->getRepository('ApiUserBundle:RefreshToken')->findAll();

      foreach ($access_tokens as $access_token)
      {
         if($access_token->getUser() == $user)
            $em->remove($access_token);
      }
      foreach ($auth_codes as $auth_code)
      {
         if($auth_code->getUser() == $user)
            $em->remove($auth_code);
      }
      foreach ($refresh_tokens as $refresh_token)
      {
         if($refresh_token->getUser() == $user)
            $em->remove($refresh_token);
      }
      $em->remove($user);
      $em->flush();
   }

   /**
    * @ApiDoc(description="Add a user")
    * @param Request $request
    * @return User|\FOS\UserBundle\Model\UserInterface|mixed|\Symfony\Component\Form\Form
    *
    * @Rest\View(StatusCode=Response::HTTP_CREATED, serializerGroups={"user"})
    * @Rest\Post("/users")
    */
   public function postUserAction(Request $request)
   {
      $user = new User();

      $form = $this->createForm(UserType::class, $user);
      $form->submit($request->request->all());

      if($form->isValid())
      {
         $this->get('fos_user.user_manager')->updateUser($user);
         return $user;
      }
      else
         return $form;
   }

   /**
    * @ApiDoc(description="update a user")
    * @param Request $request
    * @return \Symfony\Component\Form\Form
    *
    * @Rest\View(serializerGroups={"user"})
    * @Rest\Patch("/users/{id}")
    */
   public function patchUserAction(Request $request)
   {
      $userManager = $this->get('fos_user.user_manager');
      $em = $this->get('doctrine.orm.entity_manager');
      $user = $em->getRepository('ApiUserBundle:User')->find($request->get('id'));

      if(empty($user))
         throw new NotFoundHttpException('User is not exist');

      $form  = $this->createForm(UserType::class, $user);
      $form->submit($request->request->all(), false);

      if($form->isValid())
      {
         $userManager->updateCanonicalFields($user);
         $userManager->updateUser($user);
         return $user;
      }
      return $form;
   }

   /**
    * @ApiDoc(description="Change user's password")
    * @param Request $request
    * @Rest\View(serializerGroups={"user"})
    * @Rest\Patch("/users/chpass/{id})
    */
   public function changePasswordAction(Request $request)
   {
      $user = $this->getDoctrine()->getRepository('ApiUserBundle:User')->find($request->get('id'));

   }

}
