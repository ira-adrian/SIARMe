<?php

namespace Siarme\AusentismoBundle\Controller;

use Siarme\AusentismoBundle\Entity\Agente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Agente controller.
 *
 * @Route("backend/agente")
 */
class AgenteController extends Controller
{
    /**
     * Lists all agente entities.
     *
     * @Route("/", name="backend_agente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agentes = $em->getRepository('AusentismoBundle:Agente')->findAll();

        return $this->render('agente/index.html.twig', array(
            'agentes' => $agentes,
        ));
    }

    /**
     * Creates a new agente entity.
     *
     * @Route("/new", name="backend_agente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $agente = new Agente();
        $form = $this->createForm('Siarme\AusentismoBundle\Form\AgenteType', $agente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agente);
            $em->flush($agente);

            return $this->redirectToRoute('backend_agente_show', array('id' => $agente->getId()));
        }

        return $this->render('agente/new.html.twig', array(
            'agente' => $agente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a agente entity.
     *
     * @Route("/{id}", name="backend_agente_show")
     * @Method("GET")
     */
    public function showAction(Agente $agente)
    {
        $deleteForm = $this->createDeleteForm($agente);

        return $this->render('agente/show.html.twig', array(
            'agente' => $agente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing agente entity.
     *
     * @Route("/{id}/edit", name="backend_agente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Agente $agente)
    {
        $deleteForm = $this->createDeleteForm($agente);
        $editForm = $this->createForm('Siarme\AusentismoBundle\Form\AgenteType', $agente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_agente_edit', array('id' => $agente->getId()));
        }

        return $this->render('agente/edit.html.twig', array(
            'agente' => $agente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a agente entity.
     *
     * @Route("/{id}", name="backend_agente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Agente $agente)
    {
        $form = $this->createDeleteForm($agente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($agente);
            $em->flush($agente);
        }

        return $this->redirectToRoute('backend_agente_index');
    }

    /**
     * Creates a form to delete a agente entity.
     *
     * @param Agente $agente The agente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Agente $agente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_agente_delete', array('id' => $agente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
