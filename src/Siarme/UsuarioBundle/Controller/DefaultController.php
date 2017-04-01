<?php

namespace Siarme\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Siarme\UsuarioBundle\Entity\Usuario;
use Siarme\UsuarioBundle\Entity\UsuarioType;
use Siarme\UsuarioBundle\Entity\PerfilUsuarioType;
use Symfony\Component\HttpFoundation\Request;



class DefaultController extends Controller
{
  
	/**
	 * @Route("/usuario/inicio", name="usuario_inicio")
	 * 
	 */
	public function inicioAction()
	{
	    return $this->render('ExpedienteBundel:Extranet:index.html.twig');
	}

	/**
	* @Route("/nuevo", name="usuario_nuevo")
	*/
	public function registroAction()
	{
	$usuario = new Usuario();

	$formulario = $this->createForm('Siarme\UsuarioBundle\Form\UsuarioType', $usuario);
				return $this->render('usuario/registro.html.twig', array(
				'formulario' => $formulario->createView(),
				));
	
	}


   /**
    * @Route("/usuario/password", name="usuario_change_password")
    * 
    */
   public function indexAction(Request $request)
   {
   		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
        throw $this->createAccessDeniedException();
    		}

    $em = $this->getDoctrine()->getManager();
            //$em->persist($usuario);
           


    $password = $request->request->get('password');
        //var_dump($password);
        //exit();
   	$usuario = $this->getUser();
	$usuario->SetPassword($password);
 	$em->flush($usuario);
 	$this->get('session')->getFlashBag()->add(
          'mensaje-info',
          '<strong> La contraseña ha sido modificada </strong>'
          );       
 	return $this->redirectToRoute('extranet');
   }

   /**
    * @Route("/usuario/{id}/ver", name="extranet_usuario_show")
    * 
    */
    public function showAction(Usuario $usuario)
    {
      if ($usuario->getId() == $this->getUser()->getId() ){
       
        return $this->render('UsuarioBundle:usuario:show.html.twig', array(
            'usuario' => $usuario,
             ));
      }else{
      
              throw $this->createAccessDeniedException();

      }
    }

     /**
     *
     * @Route("/usuario/{id}/editar", name="extranet_usuario_edit")
     * 
     */
    public function editAction(Request $request, Usuario $usuario)
    {

        $editForm = $this->createForm('Siarme\UsuarioBundle\Form\PerfilUsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('extranet_usuario_edit', array('id' => $usuario->getId()));
        }

        return $this->render('UsuarioBundle:usuario:edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
        ));
    }




	public function defaultAction()
	{

	if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
        throw $this->createAccessDeniedException();
    }

	$usuario = $this->getUser();
	$nombre = $usuario->getNombre();

		if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
			// El usuario está autenticado y la razón es que acaba de
			// introducir su nombre de usuario y contraseña
			} elseif ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			// El usuario está autenticado, pero no ha introducido su
			// contraseña. La autenticación se ha producido por la
			// cookie de la opción "remember me"
			} elseif ($this->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')) {
			// Se trata de un usuario anónimo. Técnicamente, en Symfony los
			// usuarios anónimos también están autenticados.
		}

	}
}
