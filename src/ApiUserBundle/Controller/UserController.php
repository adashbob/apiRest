<?php

namespace ApiUserBundle\Controller;

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

      $qb = $this->get('doctrine.orm.entity_manager')->createQueryBuilder();
      $qb->select('u')
         ->from('ApiUserBundle:User', 'u');

      if (!empty($offset))
         $qb->setFirstResult($offset);

      if(!empty($limit))
         $qb->setMaxResults($limit);

      if (in_array($sort, ['asc', 'desc'])) {
         $qb->orderBy('p.username', $sort);
      }

      $users = $qb->getQuery()->getResult();

      return $users;
   }

   /**
    *
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
    * @Rest\View(StatusCode=Response::HTTP_NO_CONTENT, serializerGroups={"user"})
    * @Rest\Delete("/users/{id}")
    */
   public function removeUserAction(Request $request){
      $em = $this->get('doctrine.orm.entity_manager');
      $user = $em->getRepository('ApiUserBundle:User')
         ->find($request->get('id'));

      if(!$user)
         throw new NotFoundHttpException("User not found");

      $em->remove($user);
      $em->flush();
   }

}
