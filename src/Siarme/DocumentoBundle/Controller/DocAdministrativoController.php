<?php

namespace Siarme\DocumentoBundle\Controller;

use Siarme\ExpedienteBundle\Entity\Tramite;
use Siarme\DocumentoBundle\Entity\DocAdministrativo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Docadministrativo controller.
 *
 * @Route("intranet/docadministrativo")
 */
class DocAdministrativoController extends Controller
{
    /**
     * Creates a new docAdministrativo entity.
     *
     * @Route("/{slug}/{id}/new", name="extranet_docadministrativo_new")
     * 
     * @ParamConverter("tramite", class="ExpedienteBundle:Tramite")
     */
    public function newAction(Request $request, $slug, Tramite $tramite)
    {
        $docAdministrativo = new Docadministrativo();
        $docAdministrativo->setFechaDocumento( new \DateTime());
        $docAdministrativo->setTramite($tramite);
        $docAdministrativo->setSlug($slug);

         // ### Buscar El tipo de documento y sus valores ##
        $tipo_docs = $this->getParameter('tipodoc');
        $tipodoc = $tipo_docs['administrativo'];
        $docAdministrativo->setTipoDocumento($tipodoc[$slug]);

        $form = $this->createForm('Siarme\DocumentoBundle\Form\DocAdministrativoType', $docAdministrativo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $numero = $em->getRepository('DocumentoBundle:DocAdministrativo')->findAll();
            $docAdministrativo->setNumero(count($numero) + 1 );
            $em->persist($docAdministrativo);
            $em->flush($docAdministrativo);

            return $this->redirectToRoute('extranet_docadministrativo_show', array('id' => $docAdministrativo->getId()));
        }

        return $this->render('DocumentoBundle:docadministrativo:/'.$slug.'/new.html.twig', array(
            'documento' => $docAdministrativo,
            'form' => $form->createView(),
        ));
    }

     /**
     * Finds and displays a docAdministrativo entity.
     *
     * @Route("/{id}/show", name="extranet_docadministrativo_show")
     * @Method("GET")
     */
    public function showAction(DocAdministrativo $docAdministrativo)
    {
        $deleteForm = $this->createDeleteForm($docAdministrativo);

        $slug = $docAdministrativo->getSlug();

        return $this->render('DocumentoBundle:docadministrativo:/'.$slug.'/show.html.twig', array(
            'documento' => $docAdministrativo,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing docAdministrativo entity.
     *
     * @Route("/{id}/edit", name="extranet_docadministrativo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DocAdministrativo $docAdministrativo)
    {
        $deleteForm = $this->createDeleteForm($docAdministrativo);
        $editForm = $this->createForm('Siarme\DocumentoBundle\Form\DocAdministrativoType', $docAdministrativo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                    'mensaje-info',
                    'Se guardaron los cambios del documento <strong> '.$docAdministrativo.' </strong> con EXITO...');

            return $this->redirectToRoute('extranet_docadministrativo_show', array('id' => $docAdministrativo->getId()));
        }
        $slug = $docAdministrativo->getSlug();
        return $this->render('DocumentoBundle:docadministrativo:/'.$slug.'/edit.html.twig', array(
            'documento' => $docAdministrativo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a docAdministrativo entity.
     *
     * @Route("/{id}/delete", name="extranet_docadministrativo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DocAdministrativo $docAdministrativo)
    {
        $form = $this->createDeleteForm($docAdministrativo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($docAdministrativo);
            $em->flush($docAdministrativo);
            $this->get('session')->getFlashBag()->add(
                    'mensaje-info',
                    'El documento <strong> '.$docAdministrativo.' </strong> fue ELIMINADO...');
        }

        return $this->redirectToRoute('extranet');
    }

    /**
     * Creates a form to delete a docAdministrativo entity.
     *
     * @param DocAdministrativo $docAdministrativo The docAdministrativo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DocAdministrativo $docAdministrativo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('extranet_docadministrativo_delete', array('id' => $docAdministrativo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
