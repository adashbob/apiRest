<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Consultation;
use ApiBundle\Form\ConsultationType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConsultationController extends Controller
{

   /**
    * @Rest\View(serializerGroups={"consultation"})
    * @Rest\Get("/patients/{id}/consultations")
    */
   public function getConsultationsAction(Request $request)
   {
      $patient = $this->getPatient($request);

      if(empty($patient))
         throw new NotFoundHttpException("Patient not found");

      if(empty($consultation))
         throw new NotFoundHttpException("No consultations");

      return $patient->getConsultations();
   }

   /**
    * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"consultation"})
    * @Rest\Post("/patients/{id}/consultations")
    */
   public function postConsultationAction(Request $request){
      $patient = $this->getPatient($request);

      if(empty($patient))
         throw new NotFoundHttpException("Patient not found");

      $consultation = new Consultation();

      $form = $this->createForm(ConsultationType::class, $consultation);
      $form->submit($request->request->all());

      if($form->isValid()){
         $em = $this->get('doctrine.orm.entity_manager');
         $consultation->setPatient($patient);
         $em->persist($consultation);
         $em->flush();
      }
      else{
         return $form;
      }
   }

   /**
    * @param Request $request
    * @return \ApiBundle\Entity\Patient|null|object
    */
   private function getPatient(Request $request)
   {
      $patient = $this->getDoctrine()
         ->getRepository('ApiBundle:Patient')
         ->find($request->get('id'));

      return $patient;
   }
}
