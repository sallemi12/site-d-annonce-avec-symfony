<?php

namespace VoitureBundle\Controller;

use VoitureBundle\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;
use VoitureBundle\Form\RechercheType;
use VoitureBundle\Form\ContactType;

/**
 * Voiture controller.
 *
 */
class VoitureController extends Controller
{


     public function ModeleAction(Request $request ,$marque_id)
    {
              
                $em = $this->getDoctrine()->getManager();
                $modele_marque=$em->getRepository('VoitureBundle:Modele')->findBy(array('marque' =>$marque_id));
                if($modele_marque){
                    $modeles=array();
                    foreach ( $modele_marque as $prod) {
                        $modeles[]=$prod->getNom();
                    }
                   
                }
                  else{
                    $produit=null;
                  }
                  $response =new JsonResponse();
                  return $response->setData(array('modeles'=>$modeles));



       
    }

     public function TrouverAnnonceAction(Request $request )
    {           

              
                $em = $this->getDoctrine()->getManager();
                $user = $this->getUser();
                $user_name=(string)$user;
                $annonce_trouve=$em->getRepository('VoitureBundle:Voiture')->findByajouterpar($user_name);         
               return $this->render('voiture/user_annonce.html.twig', array(
                'voitures' =>   $annonce_trouve,
               
               ));
    }

    /**
     * Lists all voiture entities.
     *
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $voitures_liste = $em->getRepository('VoitureBundle:Voiture')->findAll();
          $nb_user=$em->getRepository('AppBundle:User')->findAll();
          $nb =$em->getRepository('VoitureBundle:Voiture')->getNb();
            $voiture  = $this->get('knp_paginator')->paginate(
       $voitures_liste,
        $request->query->get('page', 1)/*page number*/,
        2/*limit per page*/
    );


        return $this->render('voiture/index.html.twig', array(
            
            'voitures' => $voiture,
            'nb'=>$nb,

        ));
    }


    /**
     * Creates a new voiture entity.
     *
     */
    public function newAction(Request $request)
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }else{
        $user = $this->getUser();
        $voiture = new Voiture();
        $form = $this->createForm('VoitureBundle\Form\VoitureType', $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $voiture->upload();
            $voiture->setAjouterpar($user);
            $em->persist($voiture);
            $em->flush($voiture);

            return $this->redirectToRoute('voiture_show', array('id' => $voiture->getId()));
        }
        }
       

        return $this->render('voiture/new.html.twig', array(
            'voiture' => $voiture,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a voiture entity.
     *
     */
    public function showAction(Voiture $voiture)
    {
        $deleteForm = $this->createDeleteForm($voiture);

        return $this->render('voiture/show.html.twig', array(
            'voiture' => $voiture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing voiture entity.
     *
     */
    public function editAction(Request $request, Voiture $voiture)
    {
        $deleteForm = $this->createDeleteForm($voiture);
        $editForm = $this->createForm('VoitureBundle\Form\VoitureType', $voiture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voiture_edit', array('id' => $voiture->getId()));
        }

        return $this->render('voiture/edit.html.twig', array(
            'voiture' => $voiture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a voiture entity.
     *
     */
    public function deleteAction(Request $request, Voiture $voiture)
    {
        $form = $this->createDeleteForm($voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($voiture);
            $em->flush($voiture);
        }

        return $this->redirectToRoute('voiture_index');
    }

    /**
     * Creates a form to delete a voiture entity.
     *
     * @param Voiture $voiture The voiture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Voiture $voiture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('voiture_delete', array('id' => $voiture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



        public function rechercheAction()
    {
     $form = $this->createForm(RechercheType::class);
     return $this->render('voiture/recherche.html.twig', array(
        'recherche_form'=>$form->createView()
        ));
 }


 /***********************contact ************************************
  public function  ContactAction()
    {
     $form = $this->createForm(ContactType::class);
     return $this->render('voiture/contact.html.twig', array(
        'contact_form'=>$form->createView()
        ));
 }




 return $this->render('voiture/contact.html.twig');
}

*/











 public function rechercheTraitementAction(Request $request)
 {

    $form = $this->createForm(RechercheType::class);


       $form->handleRequest($request);

   if($form->isValid()){

          $marque = $form['marque']->getData();
       
           $region = $form['region']->getData();
           $prix_min = $form['prix_min']->getData();
           $prix_max = $form['prix_max']->getData();
           $carburant = $form['carburant']->getData();
           $date = $form['date']->getData();
          $transmission = $form['transmission']->getData();
           $Kilometrage = $form['Kilometrage']->getData();

           $em = $this->getDoctrine()->getManager();
           $voiture=$em->getRepository('VoitureBundle:Voiture')->recherche($marque,$region,$prix_max,$prix_min,$carburant,$date,$transmission,$Kilometrage);
      
    

    }
     else {
            throw $this->createNotFoundException('La page n\'existe pas.');
        }
      
  

 
   return $this->render('voiture/resultat.html.twig',array('voitures'=>$voiture));
  }


}
