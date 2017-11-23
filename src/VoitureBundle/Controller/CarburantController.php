<?php

namespace VoitureBundle\Controller;

use VoitureBundle\Entity\Carburant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Carburant controller.
 *
 */
class CarburantController extends Controller
{
    /**
     * Lists all carburant entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $carburants = $em->getRepository('VoitureBundle:Carburant')->findAll();

        return $this->render('carburant/index.html.twig', array(
            'carburants' => $carburants,
        ));
    }

    /**
     * Creates a new carburant entity.
     *
     */
    public function newAction(Request $request)
    {
        $carburant = new Carburant();
        $form = $this->createForm('VoitureBundle\Form\CarburantType', $carburant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carburant);
            $em->flush($carburant);

            return $this->redirectToRoute('admin_carburant_show', array('id' => $carburant->getId()));
        }

        return $this->render('carburant/new.html.twig', array(
            'carburant' => $carburant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a carburant entity.
     *
     */
    public function showAction(Carburant $carburant)
    {
        $deleteForm = $this->createDeleteForm($carburant);

        return $this->render('carburant/show.html.twig', array(
            'carburant' => $carburant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing carburant entity.
     *
     */
    public function editAction(Request $request, Carburant $carburant)
    {
        $deleteForm = $this->createDeleteForm($carburant);
        $editForm = $this->createForm('VoitureBundle\Form\CarburantType', $carburant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_carburant_edit', array('id' => $carburant->getId()));
        }

        return $this->render('carburant/edit.html.twig', array(
            'carburant' => $carburant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a carburant entity.
     *
     */
    public function deleteAction(Request $request, Carburant $carburant)
    {
        $form = $this->createDeleteForm($carburant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($carburant);
            $em->flush($carburant);
        }

        return $this->redirectToRoute('admin_carburant_index');
    }

    /**
     * Creates a form to delete a carburant entity.
     *
     * @param Carburant $carburant The carburant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Carburant $carburant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_carburant_delete', array('id' => $carburant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
