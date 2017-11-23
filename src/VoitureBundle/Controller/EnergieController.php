<?php

namespace VoitureBundle\Controller;

use VoitureBundle\Entity\Energie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Energie controller.
 *
 */
class EnergieController extends Controller
{
    /**
     * Lists all energie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $energies = $em->getRepository('VoitureBundle:Energie')->findAll();

        return $this->render('energie/index.html.twig', array(
            'energies' => $energies,
        ));
    }

    /**
     * Creates a new energie entity.
     *
     */
    public function newAction(Request $request)
    {
        $energie = new Energie();
        $form = $this->createForm('VoitureBundle\Form\EnergieType', $energie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($energie);
            $em->flush($energie);

            return $this->redirectToRoute('admin_energie_show', array('id' => $energie->getId()));
        }

        return $this->render('energie/new.html.twig', array(
            'energie' => $energie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a energie entity.
     *
     */
    public function showAction(Energie $energie)
    {
        $deleteForm = $this->createDeleteForm($energie);

        return $this->render('energie/show.html.twig', array(
            'energie' => $energie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing energie entity.
     *
     */
    public function editAction(Request $request, Energie $energie)
    {
        $deleteForm = $this->createDeleteForm($energie);
        $editForm = $this->createForm('VoitureBundle\Form\EnergieType', $energie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_energie_edit', array('id' => $energie->getId()));
        }

        return $this->render('energie/edit.html.twig', array(
            'energie' => $energie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a energie entity.
     *
     */
    public function deleteAction(Request $request, Energie $energie)
    {
        $form = $this->createDeleteForm($energie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($energie);
            $em->flush($energie);
        }

        return $this->redirectToRoute('admin_energie_index');
    }

    /**
     * Creates a form to delete a energie entity.
     *
     * @param Energie $energie The energie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Energie $energie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_energie_delete', array('id' => $energie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
