<?php

namespace Siarme\DocumentoBundle\Controller;

use Siarme\ExpedienteBundle\Entity\Tramite;
use Siarme\DocumentoBundle\Entity\TurnoCitacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Turnocitacion controller.
 *
 * @Route("extranet/docadministrativo")
 */
class TurnoCitacionController extends Controller
{
    /**
     * Lists all turnoCitacion entities.
     *
     * @Route("/", name="extranet_turnocitacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $turnoCitacions = $em->getRepository('DocumentoBundle:TurnoCitacion')->findAll();

        return $this->render('DocumentoBundle:docadministrativo:index.html.twig', array(
            'turnoCitacions' => $turnoCitacions,
        ));
    }

    /**
     * Creates a new turnoCitacion entity.
     *
     * @Route("/{slug}/{id}/nuevo", name="extranet_turnocitacion_new")
     * @ParamConverter("tramite", class="ExpedienteBundle:Tramite")
     * 
     */
    public function newAction(Request $request, $slug, Tramite $tramite)
    {
        $turnoCitacion = new TurnoCitacion();
        $turnoCitacion->setTramite($tramite);
        $turnoCitacion->setAgente($tramite->getExpediente()->getAgente());
        $turnoCitacion->setSlug($slug);
        $turnoCitacion->setNumero(count($tramite->getTurnoCitacion()));
        $turnoCitacion->setFechaDocumento( New \DateTime());

        // ### Buscar El tipo de documento y sus valores ##
        $tipo_docs = $this->getParameter('tipodoc');
        $tipodoc = $tipo_docs['administrativo'];
        $turnoCitacion->setTipoDocumento($tipodoc[$slug]["nombre"]);

        $form = $this->createForm('Siarme\DocumentoBundle\Form\TurnoCitacionType', $turnoCitacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($turnoCitacion);
            $em->flush($turnoCitacion);

            return $this->redirectToRoute('extranet_turnocitacion_show', array('id' => $turnoCitacion->getId()));
        }

        return $this->render('DocumentoBundle:docadministrativo:/'.$slug.'/new.html.twig', array(
            'docAdministrativo' => $turnoCitacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a turnoCitacion entity.
     *
     * @Route("/{id}", name="extranet_turnocitacion_show")
     * @Method("GET")
     */
    public function showAction(TurnoCitacion $turnoCitacion)
    {
        $deleteForm = $this->createDeleteForm($turnoCitacion);
        $slug=$turnoCitacion->getSlug();
        return $this->render('DocumentoBundle:docadministrativo:/'.$slug.'/show.html.twig', array(
            'docAdministrativo' => $turnoCitacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing turnoCitacion entity.
     *
     * @Route("/{id}/edit", name="extranet_turnocitacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TurnoCitacion $turnoCitacion)
    {
        $deleteForm = $this->createDeleteForm($turnoCitacion);
        $editForm = $this->createForm('Siarme\DocumentoBundle\Form\TurnoCitacionType', $turnoCitacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('extranet_turnocitacion_edit', array('id' => $turnoCitacion->getId()));
        }
        $slug=$turnoCitacion->getSlug();
        return $this->render('DocumentoBundle:docadministrativo:/'.$slug.'/edit.html.twig', array(
            'docAdministrativo' => $turnoCitacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a turnoCitacion entity.
     *
     * @Route("/{id}", name="extranet_turnocitacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TurnoCitacion $turnoCitacion)
    {
        $form = $this->createDeleteForm($turnoCitacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($turnoCitacion);
            $em->flush($turnoCitacion);
        }

        return $this->redirectToRoute('extranet');
    }

    /**
     * Creates a form to delete a turnoCitacion entity.
     *
     * @param TurnoCitacion $turnoCitacion The turnoCitacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TurnoCitacion $turnoCitacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('extranet_turnocitacion_delete', array('id' => $turnoCitacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
