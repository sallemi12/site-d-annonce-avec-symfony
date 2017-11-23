<?php

namespace VoitureBundle\Controller;

use VoitureBundle\Entity\Transmission;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Transmission controller.
 *
 */
class TransmissionController extends Controller
{
    /**
     * Lists all transmission entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transmissions = $em->getRepository('VoitureBundle:Transmission')->findAll();

        return $this->render('transmission/index.html.twig', array(
            'transmissions' => $transmissions,
        ));
    }

    /**
     * Creates a new transmission entity.
     *
     */
    public function newAction(Request $request)
    {
        $transmission = new Transmission();
        $form = $this->createForm('VoitureBundle\Form\TransmissionType', $transmission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transmission);
            $em->flush($transmission);

            return $this->redirectToRoute('admin_transmission_show', array('id' => $transmission->getId()));
        }

        return $this->render('transmission/new.html.twig', array(
            'transmission' => $transmission,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a transmission entity.
     *
     */
    public function showAction(Transmission $transmission)
    {
        $deleteForm = $this->createDeleteForm($transmission);

        return $this->render('transmission/show.html.twig', array(
            'transmission' => $transmission,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing transmission entity.
     *
     */
    public function editAction(Request $request, Transmission $transmission)
    {
        $deleteForm = $this->createDeleteForm($transmission);
        $editForm = $this->createForm('VoitureBundle\Form\TransmissionType', $transmission);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_transmission_edit', array('id' => $transmission->getId()));
        }

        return $this->render('transmission/edit.html.twig', array(
            'transmission' => $transmission,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a transmission entity.
     *
     */
    public function deleteAction(Request $request, Transmission $transmission)
    {
        $form = $this->createDeleteForm($transmission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transmission);
            $em->flush($transmission);
        }

        return $this->redirectToRoute('admin_transmission_index');
    }

    /**
     * Creates a form to delete a transmission entity.
     *
     * @param Transmission $transmission The transmission entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Transmission $transmission)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_transmission_delete', array('id' => $transmission->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
