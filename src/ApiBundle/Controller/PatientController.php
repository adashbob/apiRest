<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Patient;
use ApiBundle\Form\PatientType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PatientController extends Controller
{

   /**
    * @ApiDoc(
    *    description="Récupère la liste des patients de l'application",
    *    output= {"class"=Patient::class, "collection"=true, "groups"={"patient"}}
    * )
    *
    * @Rest\View(serializerGroups={"patient"})
    * @Rest\Get("/patients")
    * @QueryParam(name="offset", requirements="\d+", default="", description="Index de debut de la pagination")
    * @QueryParam(name="limit", requirements="\d+", default="", description="Nombre d'éléments à afficher")
    * @QueryParam(name="sort", requirements="(asc|desc)", nullable=true, description="Ordre de tri (basé sur le lastname)")
    *
    * @Security("has_role('ROLE_ADMIN')")
    */
   public function getPatientsAction(Request $request, ParamFetcher $paramFetcher)
   {
      $offset = $paramFetcher->get('offset');
      $limit = $paramFetcher->get('limit');
      $sort = $paramFetcher->get('sort');

      $qb = $this->get('doctrine.orm.entity_manager')->createQueryBuilder();
      $qb->select('p')
         ->from('ApiBundle:Patient', 'p');

      if ($offset != "")
         $qb->setFirstResult($offset);

      if($limit != "")
         $qb->setMaxResults($limit);

      if (in_array($sort, ['asc', 'desc'])) {
         $qb->orderBy('p.lastname', $sort);
      }

      $patients = $qb->getQuery()->getResult();

      return $patients;
   }

   /**
    *
    * @Rest\View(serializerGroups={"patient"})
    * @Rest\Get("/patients/{id}")
    */
   public function getPatientAction(Request $request){
      $patient =  $this->getDoctrine()
         ->getRepository('ApiBundle:Patient')
         ->find($request->get('id'));

      if(empty($patient))
         throw new NotFoundHttpException("Patient not found");

      return $patient;
   }

   /**
    * @ApiDoc(
    *    description="Enregistre un patient en base",
    *    input={"class"=PatientType::class, "name"=""},
    *    statusCodes={
    *       201 = "Création avec succès",
    *       400 = "Formulaire invalide"
    *    },
    *    responseMap={
    *       201 = {"class"=Patient::class, "groups"={"place"}},
    *       400 = { "class"=PatientType::class, "fos_rest_form_errors"=true, "name"=""}
    *    }
    * )
    * @Rest\View(StatusCode=Response::HTTP_CREATED, serializerGroups={"patient"})
    * @Rest\Post("/patients/")
    */
   public function postPatientAction(Request $request)
   {
      $patient = new Patient();

      $form = $this->createForm(PatientType::class, $patient);

      $form->submit($request->request->all());

      if($form->isValid()){
         $em = $this->get('doctrine.orm.entity_manager');
         $em->persist($patient);
         $em->flush();
         return $patient;
      }
      else{
         return $form;
      }
   }

   /**
    * @Rest\View(StatusCode=Response::HTTP_NO_CONTENT, serializerGroups={"patient"})
    * @Rest\Delete("/patients/{id}")
    */
   public function removePatientAction(Request $request){
      $em = $this->get('doctrine.orm.entity_manager');
      $patient = $em->getRepository('ApiBundle:Patient')
         ->find($request->get('id'));

      if(!$patient)
         throw new NotFoundHttpException("Patient not found");

      foreach($patient->getConsultations() as $consultation){
         $em->remove($consultation);
      }
      $em->remove($patient);
      $em->flush();
   }

   /**
    * @Rest\View(serializerGroups={"patient"})
    * @Rest\Put("/patients/{id}")
    */
   public function putPatientAction(Request $request)
   {
      $this->updatePatient($request);
   }

   /**
    * @Rest\View(serializerGroups={"patient"})
    * @Rest\Patch("/patients/{id}")
    */
   public function patchPatientAction(Request $request)
   {
      $this->updatePatient($request, false);
   }

   /**
    * @param Request $request
    * @param bool $clearMissing
    * @return null|object|\Symfony\Component\Form\Form|static
    */
   private function updatePatient(Request $request, $clearMissing = true)
   {
      $em = $this->get('doctrine.orm.entity_manager');

      $patient = $em->getRepository('ApiBundle:Patient')->find($request->get('id'));

      if(empty($patient))
         throw new NotFoundHttpException("Patient not found");

      $form = $this->createForm(PatientType::class, $patient);
      $form->submit($request->request->all(), $clearMissing);

      if($form->isValid()){
         $em->merge($patient);
         $em->flush();
         return $patient;
      }
      else{
         return $form;
      }
   }

}
