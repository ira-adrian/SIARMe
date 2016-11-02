<?php

namespace Siarme\ExpedienteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Siarme\ExpedienteBundle\Entity\Tramite;
use Siarme\ExpedienteBundle\Entity\Expediente;


class DefaultController extends Controller
{

    /**
     * @Route("/")
     * 
     * @Route("/informacion/{pagina}/", 
     * defaults={ "pagina" = "inicio" },
     * requirements={ "pagina"="inicio|ayuda|contacto" },
     * name="portada_estatica"
     *)
     */
   
    public function estaticaAction(Request $request, $pagina="inicio")
    {
       
    $cons = $request->query->get('consulta');

    if (!empty($cons))
    {         
    
     if (!preg_match('/(^[0-9]{1,10})-([0-9]{4,4})/', $cons)) {
      
         // código que procesa el formulario ...

        $this->get('session')->getFlashBag()->add(
        'mensaje-warning',
        'Debe ingresar correctamente los datos del expediente Por Ej. 253-2016.'
        );
        return $this->render('ExpedienteBundle:Portada:'.$pagina.'.html.twig');

        exit(); 
      }

      $a = explode( "-" , $cons);
      $num = intval($a[0]);
      $anio = $a[1];  

      //print_r($numero);
      // exit();

      $em = $this->getDoctrine()->getManager();


      //$consulta = $em->createQuery('SELECT e FROM ExpedienteBundle:Expediente e WHERE e.numero = :num AND e.anio = :anio');
      //$consulta->setParameter('num', $num);
    //  $consulta->setParameter('anio', $anio);
      //$expediente = $consulta->getResult();


        $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findBy(array(
            'numero' => $num,
            'anio' => $anio
        ));


      if (!$expedientes) {
          $this->get('session')->getFlashBag()->add(
          'mensaje-info',
          '<strong> Ops... </strong> No se ha encontrado ningun expediente que conicida con la busqueda:'.$cons
          );

          return $this->render('ExpedienteBundle:Portada:'.$pagina.'.html.twig');
          exit();    
      }
      foreach ($expedientes as $expediente) {
        $tramites  = $expediente->getTramite();
      }
      
      //$relacionados = $expediente ->getAgente()->getExpediente();
     return $this->render('ExpedienteBundle:Portada:consulta.html.twig', 
            array('expediente' => $expediente, 'tramites'=>$tramites,
            ));
      } 
       
    return $this->render('ExpedienteBundle:Portada:'.$pagina.'.html.twig');

    }



    /**
     *
     * @Route("/extranet", name="extranet")
     */
    public function extranetAction()
    {
        if (!($this->isGranted('IS_AUTHENTICATED_FULLY'))){


        }

        if (!($this->isGranted('ROLE_USUARIO'))) {
            // el usuario NO tiene el role 'ROLE_USUARIO'
            return $this->redirectToRoute('extranet_expediente_iniciado_departamento', 
                         array('id' => $this->getUser()->getDepartamentoRm()->getId()))
                                        ;
        }
            
        $em = $this->getDoctrine()->getManager();

        $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();

           //var_dump($menu);
           //exit();
        $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findTodos();

       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();

     return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));

    }


    /**
     * @Route("/extranet/expediente/{id}/iniciar", name="extranet_expediente_iniciar")
     */
    public function iniciarAction(Request $request, Expediente $expediente, Tramite $tramite)
    {
        $usuario = $this->getUser();

        $tramite = new Tramite();
        $tramite->setDepartamentoRm($usuario->getDepartamentoRm());
        $tramite->setEstado(false);
        $tramite->setExpediente($expediente);
        $expediente->setEstado(false);
        $form = $this->createForm('Siarme\ExpedienteBundle\Form\IniciarTramiteType', $tramite);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramite);
            $expediente->addTramite($tramite);
            $em->flush($tramite);
            $em->flush($expediente);

            $this->get('session')->getFlashBag()->add(
                    'mensaje-info',
                    'El Expediente <strong> '.$expediente.' a sido INICIADO');

            return $this->redirectToRoute('backend_tramite_show', array('id' => $tramite->getId()));
        }

        return $this->render('ExpedienteBundle:expediente:expediente_tramite_iniciar.html.twig', array(
            'tramite' => $tramite,
            'expediente' => $expediente,
            'form' => $form->createView(),
        ));
    }



     /**
     * @Route("/extranet/expediente/{id}/concluir", name="extranet_expediente_concluir")
     */
    public function concluirAction(Request $request, Expediente $expediente)
    {
        $em = $this->getDoctrine()->getManager();
        $tramite = $em->getRepository('ExpedienteBundle:Tramite')->findUltimo($expediente);
        $tramite->setEstado(true);
        $expediente->setEstado(true);

        $form = $this->createForm('Siarme\ExpedienteBundle\Form\ConcluirTramiteType', $tramite);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush($tramite);
            $em->flush($expediente);

            $this->get('session')->getFlashBag()->add(
                    'mensaje-info',
                    'El Expediente <strong> '.$expediente.' ha sido CONCLUIDO </strong>');

            return $this->redirectToRoute('backend_tramite_show', array('id' => $tramite->getId()));
        }

        return $this->render('ExpedienteBundle:expediente:expediente_tramite_concluir.html.twig', array(
            'tramite' => $tramite,
            'expediente' => $expediente,
            'form' => $form->createView(),
        ));
    }

    /**
     *     
     * @Route("/extranet/expediente/departamento/{id}", name="extranet_expediente_departamento")
     * 
     */
    public function expedienteByDepartamentoAction($id)
    {
    
        $em = $this->getDoctrine()->getManager();
         $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
        $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteByDepartamento($id);

       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();

     return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));
    }



    /**
     * @Route("/extranet/expediente/clasificacion/{id}/{clasificacion_id}", name="extranet_expediente_clasificacion")
     *
     */
    public function expedienteByClasificacionAction($id, $clasificacion_id )
    {
    
        $em = $this->getDoctrine()->getManager();
         $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
        $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteByClasificacion($id, $clasificacion_id);

       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();

     return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));
    }


    /**
     * @Route("/extranet/expediente/iniciado/departamento/{id}", name="extranet_expediente_iniciado_departamento")
     *
     */
    public function expedienteIniciadoByDepartamentoAction($id )
    {

       $em = $this->getDoctrine()->getManager();
       $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
       $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteIniciadoByDepartamento($id);

       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();

       return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));

    }




    /**
     * @Route("/extranet/expediente/departamento/{id}/turno", name="extranet_expediente_turno")
     *
     */
    public function expedienteTurnoByDepartamentoAction($id )
    {

       $em = $this->getDoctrine()->getManager();
       $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
       $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteTurno($id);

       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();

       return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));

    }


    /**
     * @Route("/extranet/expediente/departamento/{id}/citacion", name="extranet_expediente_citacion")
     *
     */
    public function expedienteCitacionByDepartamentoAction($id )
    {

       $em = $this->getDoctrine()->getManager();
       $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
       $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteCitacion($id);

       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();


       return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));

    }


    public function  findExpedienteCitacion($id)
    {
        $em = $this->getEntityManager();

         $consulta = $em->createQuery(
            'SELECT e, a, t, c, d, tc
             FROM ExpedienteBundle:Expediente e 
             JOIN e.agente a  
             JOIN e.tramite t JOIN t.turnoCitacion tc
             JOIN e.clasificacion c
             JOIN e.departamentoRm d
             WHERE e.departamentoRm = :id AND e.estado = :estado AND t.estadoTurnoCitacion = :estadoTyC AND tc.tipoDocumento = :tipo 
             ORDER BY a.apellidoNombre ASC'
            );

        $consulta->setParameter('id', $id);
        // si estado de expediente es True => INICIADO si False=> CONCLUIDO
        // si estadoTurnoCitacion de tramite es True => con turno  si False=> sin turno
        $consulta->setParameter('estado', false);
        $consulta->setParameter('estadoTyC', true);
        $consulta->setParameter('tipo', "citacion");
                
        return  $consulta->getResult();  
    }

}
