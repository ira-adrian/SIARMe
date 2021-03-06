<?php

namespace Siarme\ExpedienteBundle\Controller;

use Siarme\ExpedienteBundle\Entity\Tramite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tramite controller.
 *
 * @Route("intranet/tramite")
 */
class TramiteController extends Controller
{
    /**
     * Lists all tramite entities.
     *
     * @Route("/", name="backend_tramite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tramites = $em->getRepository('ExpedienteBundle:Tramite')->findAll();

        return $this->render('ExpedienteBundle:tramite:index.html.twig', array(
            'tramites' => $tramites,
        ));
    }

    /**
     * Creates a new tramite entity.
     *
     * @Route("/nuevo", name="backend_tramite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tramite = new Tramite();
        $form = $this->createForm('Siarme\ExpedienteBundle\Form\TramiteType', $tramite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramite);
            $em->flush($tramite);

            return $this->redirectToRoute('backend_tramite_show', array('id' => $tramite->getId()));
        }

        return $this->render('ExpedienteBundle:tramite:new.html.twig', array(
            'tramite' => $tramite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tramite entity.
     *
     * @Route("/{id}/ver", name="backend_tramite_show")
     * @Method("GET")
     */
    public function showAction(Tramite $tramite)
    {
        $deleteForm = $this->createDeleteForm($tramite);

        return $this->render('ExpedienteBundle:tramite:show.html.twig', array(
            'tramite' => $tramite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tramite entity.
     *
     * @Route("/{id}/editar", name="backend_tramite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tramite $tramite)
    {
        $deleteForm = $this->createDeleteForm($tramite);
        $editForm = $this->createForm('Siarme\ExpedienteBundle\Form\TramiteType', $tramite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
              $this->get('session')->getFlashBag()->add(
                    'mensaje-info',
                    'EL tramite por :<strong>  '.$tramite.'</strong> fue MODIFICADO');
            return $this->redirectToRoute('backend_tramite_show', array('id' => $tramite->getId()));
        }

        return $this->render('ExpedienteBundle:tramite:edit.html.twig', array(
            'tramite' => $tramite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tramite entity.
     *
     * @Route("/{id}", name="backend_tramite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tramite $tramite)
    {
        $form = $this->createDeleteForm($tramite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramite);
            $em->flush($tramite);
        }

        return $this->redirectToRoute('extranet');
    }

    /**
     * Creates a form to delete a tramite entity.
     *
     * @param Tramite $tramite The tramite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tramite $tramite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_tramite_delete', array('id' => $tramite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
