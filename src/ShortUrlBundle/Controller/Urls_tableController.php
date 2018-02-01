<?php

namespace ShortUrlBundle\Controller;

use ShortUrlBundle\Entity\Urls_table;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Urls_table controller.
 *
 */
class Urls_tableController extends Controller
{
    /**
     * Lists all urls_table entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $urls_tables = $em->getRepository('ShortUrlBundle:Urls_table')->findAll();

        return $this->render('urls_table/index.html.twig', array(
            'urls_tables' => $urls_tables,
        ));
    }

    /**
     * Creates a new urls_table entity.
     *
     */
    public function newAction(Request $request)
    {
        $urls_table = new Urls_table();
        $form = $this->createForm('ShortUrlBundle\Form\Urls_tableType', $urls_table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($urls_table);
            $em->flush();

            return $this->redirectToRoute('urls_table_show', array('id' => $urls_table->getId()));
        }

        return $this->render('urls_table/new.html.twig', array(
            'urls_table' => $urls_table,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a urls_table entity.
     *
     */
    public function showAction(Urls_table $urls_table)
    {
        $deleteForm = $this->createDeleteForm($urls_table);

        return $this->render('urls_table/show.html.twig', array(
            'urls_table' => $urls_table,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing urls_table entity.
     *
     */
    public function editAction(Request $request, Urls_table $urls_table)
    {
        $deleteForm = $this->createDeleteForm($urls_table);
        $editForm = $this->createForm('ShortUrlBundle\Form\Urls_tableType', $urls_table);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('urls_table_edit', array('id' => $urls_table->getId()));
        }

        return $this->render('urls_table/edit.html.twig', array(
            'urls_table' => $urls_table,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a urls_table entity.
     *
     */
    public function deleteAction(Request $request, Urls_table $urls_table)
    {
        $form = $this->createDeleteForm($urls_table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($urls_table);
            $em->flush();
        }

        return $this->redirectToRoute('urls_table_index');
    }

    /**
     * Creates a form to delete a urls_table entity.
     *
     * @param Urls_table $urls_table The urls_table entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Urls_table $urls_table)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('urls_table_delete', array('id' => $urls_table->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
