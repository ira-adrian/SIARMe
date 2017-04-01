<?php
// Siarme/DocumentoBundle/Controller/DocMedicoController.php
namespace Siarme\DocumentoBundle\Controller;

use Siarme\ExpedienteBundle\Entity\Tramite;
use Siarme\DocumentoBundle\Entity\DocMedico;
use Siarme\AusentismoBundle\Entity\Agente;
use Siarme\AusentismoBundle\Entity\Licencia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Docmedico controller.
 *
 * @Route("intranet/docmedico")
 */
class DocMedicoController extends Controller
{

    /**
     * Creates a new docMedico entity.
     *
     * @Route("/{slug}/{id}/new", name="extranet_docmedico_new")
     * 
     * @ParamConverter("tramite", class="ExpedienteBundle:Tramite")
     */
    public function newAction(Request $request, $slug, Tramite $tramite )
    {

        $docmedico = new DocMedico();

        // ### Buscar El tipo de documento y sus valores ##
        $tipo_docs = $this->getParameter('tipodoc');
        $tipodoc = $tipo_docs['medico'];

        $docmedico->setTramite($tramite);
        $docmedico->setSlug($slug);
        $docmedico->setTipoDocumento($tipodoc[$slug]);

        $licencia = new Licencia();
        $docmedico->setLicencia($licencia);
        $licencia->setAgente($tramite->getExpediente()->getAgente());
        $licencia->setDocMedico($docmedico);


        $docmedico->setLicencia($licencia);
        $form = $this->createForm('Siarme\DocumentoBundle\Form\DocMedicoType', $docmedico);
       

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $docmedicos= $em->getRepository('DocumentoBundle:DocMedico')->findAll();
            $docmedico->setNumero((count($docmedicos) + 1) );

            $em->persist($docmedico);
            $em->flush($docmedico);

            return $this->redirectToRoute('extranet_docmedico_show', array('id' => $docmedico->getId()));
        }

        return $this->render('DocumentoBundle:docmedico:/'.$slug.'/new.html.twig', array(
            'documento' => $docmedico,
            'agente' => $tramite->getExpediente()->getAgente(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a docMedico entity.
     *
     * @Route("/{id}/show", name="extranet_docmedico_show")
     * @Method("GET")
     */
    public function showAction(DocMedico $docMedico)
    {
        $deleteForm = $this->createDeleteForm($docMedico);
        $slug= $docMedico->getSlug();

       return $this->render('DocumentoBundle:docmedico:/'.$slug.'/show.html.twig', array(
            'documento' => $docMedico,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing docMedico entity.
     *
     * @Route("/{id}/edit", name="extranet_docmedico_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DocMedico $docMedico)
    {
        $deleteForm = $this->createDeleteForm($docMedico);
        $editForm = $this->createForm('Siarme\DocumentoBundle\Form\DocMedicoType', $docMedico);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add(
                    'mensaje-info',
                    'Se guardaron los cambios del documento <strong> '.$docMedico.' </strong> con EXITO...');
            return $this->redirectToRoute('extranet_docmedico_show', array('id' => $docMedico->getId()));
        }
        $slug= $docMedico->getSlug();
        return $this->render('DocumentoBundle:docmedico:/'.$slug.'/edit.html.twig', array(
            'documento' => $docMedico,
            'agente' => $docMedico->getLicencia()->getAgente(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a docMedico entity.
     *
     * @Route("/{id}/delete", name="extranet_docmedico_delete")
     * 
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DocMedico $docMedico)
    {
        $form = $this->createDeleteForm($docMedico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($docMedico);
            $em->flush($docMedico);
            $this->get('session')->getFlashBag()->add(
                    'mensaje-info',
                    'El documento <strong> '.$docMedico.' </strong> fue ELIMINADO...');
        }

        return $this->redirectToRoute('extranet');
    }

    /**
     * Creates a form to delete a docMedico entity.
     *
     * @param DocMedico $docMedico The docMedico entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DocMedico $docMedico)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('extranet_docmedico_delete', array('id' => $docMedico->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
