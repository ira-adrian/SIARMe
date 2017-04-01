<?php
//src/Siarme/ExpedienteBundle/Controller/DefaultController.php
namespace Siarme\ExpedienteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Siarme\ExpedienteBundle\Entity\Tramite;
use Siarme\ExpedienteBundle\Entity\Expediente;
use Siarme\AusentismoBundle\Entity\DepartamentoRm;
use Siarme\AusentismoBundle\Entity\Articulo;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DefaultController extends Controller
{

    /**
     * @Route("/")
     * 
     * @Route("/informacion/{pagina}/", 
     * defaults={ "pagina" = "inicio" },
     * requirements={ "pagina"="inicio|contacto" },
     * name="portada_estatica"
     *)
     */
   
    public function estaticaAction(Request $request, $pagina="inicio")
    {
       
    $cons = $request->query->get('consulta');

    if (!empty($cons))
    {         
        
         $var1 = !preg_match('/(^[0-9]{1,8})-([0-9]{4,4})/', $cons);
         $var2 = !is_numeric($cons);
     if ($var1 AND $var2) {
      
         // código que procesa el formulario ...

        $this->get('session')->getFlashBag()->add(
        'mensaje-warning',
        'Debe ingresar correctamente los datos del expediente Por Ej. 253-2016.'
        );
        return $this->render('ExpedienteBundle:Portada:'.$pagina.'.html.twig');

        exit(); 
      }

      if (is_numeric($cons)) { 
        $num = $cons; 
        $anio = date("Y");
       }
        else {
             $a = explode( "-" , $cons);
             $num = intval($a[0]);
              $anio = $a[1]; 
        }


      $em = $this->getDoctrine()->getManager();


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
     * @Route("/intranet", name="extranet")
     */
    public function extranetAction()
    {

        if (!($this->isGranted('ROLE_USUARIO'))) {
            // el usuario NO tiene el role 'ROLE_USUARIO'
            return $this->redirectToRoute('extranet_expediente_iniciado_departamento', 
                         array('id' => $this->getUser()->getDepartamentoRm()->getId()))
                                        ;
        }
            
        $em = $this->getDoctrine()->getManager();

        $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();
        $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findTodos();

        $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();

           


     return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));

    }



      /**
     *
     * @Route("/intranet/informe/tramite", name="extranet_informe_tramite")
     * @param DepartamentoRm $departamento 
     */
    public function informeTramiteAction($fechaDesde, $fechaHasta)
    {
        //var_dump($opcion);
        //exit();
        $em = $this->getDoctrine()->getManager();
        
        $clasificaciones = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
        $tipoTramites = $em->getRepository('ExpedienteBundle:TipoTramite')->findAll();
        $usuario = $this->getUser();
        $departamento  = $usuario->getDepartamentoRm();
        $informe=array();
        $informe_principal = array();

        foreach ($clasificaciones as $clasificacion) { 

           // $expedientes =  $em->getRepository('ExpedienteBundle:Expediente')->findBy(
             //                  array('departamentoRm' => $departamento,
               //                      'clasificacion' => $clasificacion)); 
      //$fechaDesde = new \DateTime('2016-01-01');
      //$fechaHasta = new \DateTime('2017-01-01');
              $consulta = $em->createQuery(
                        'SELECT e
                        FROM ExpedienteBundle:Expediente e JOIN e.tramite t 
                        JOIN e.departamentoRm d
                        JOIN e.clasificacion c
                        WHERE e.departamentoRm= :id 
                        AND e.clasificacion= :idc
                        AND t.fechaOrigen> :fec1 
                        AND t.fechaOrigen< :fec2 
                        ');
               $consulta->setParameter('id', $departamento);
               $consulta->setParameter('idc', $clasificacion);
               $consulta->setParameter('fec1', $fechaDesde);
               $consulta->setParameter('fec2', $fechaHasta);
               $expedientes = $consulta->getResult(); 


            $informe[$clasificacion->getClasificacion()]= count($expedientes);


            foreach ($tipoTramites as $tipoTramite){

                //$tramites = $em->getRepository('ExpedienteBundle:Tramite')
                  //              ->findTramiteClasificacion($departamento, $clasificacion, $tipoTramite, $fechaDesde, $fechaHasta); 
                 $consulta = $em->createQuery(
                'SELECT t
                FROM ExpedienteBundle:Tramite t JOIN t.tipoTramite tt
                JOIN t.expediente e                        
                JOIN t.departamentoRm d
                JOIN e.clasificacion c
                WHERE t.departamentoRm = :id 
                AND e.clasificacion    = :idc 
                AND t.fechaOrigen> :fec1 
                AND t.fechaOrigen< :fec2 
                AND  t.tipoTramite     = :idr');
                $consulta->setParameter('id', $departamento);
                $consulta->setParameter('idc', $clasificacion);
                $consulta->setParameter('idr', $tipoTramite);
                $consulta->setParameter('fec1', $fechaDesde);
                $consulta->setParameter('fec2', $fechaHasta);
                $tramites              = $consulta->getResult(); 

                 $informe[$tipoTramite->getTipoTramite()] = count($tramites);
             }                        

            $informe_principal[$clasificacion->getClasificacion()]= $informe;            
        }
      // var_dump($informe_principal);
       // exit();

     return $this->render('ExpedienteBundle:Default:informe_tramite.html.twig', array(
            'tipoTramites' => $tipoTramites,  
            'clasificaciones'=>$clasificaciones,
            'informe' => $informe_principal,
            'fechaDesde'=>$fechaDesde,
            'fechaHasta'=>$fechaHasta
        ));

    }


    /**
     *
     * @Route("/intranet/informe/licencia", name="extranet_informe_licencia")
     * @param DepartamentoRm $departamento 
     */
    public function informeLicenciaAction($fechaDesde, $fechaHasta)
    {
        //var_dump($opcion);
        //exit();
        $em = $this->getDoctrine()->getManager();
        
        $clasificaciones = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
        $tipoLicencias = $em->getRepository('AusentismoBundle:Articulo')->findAll();
        $usuario = $this->getUser();
        $departamento  = $usuario->getDepartamentoRm();
        $informe=array();
        $informe_principal = array();

        foreach ($clasificaciones as $clasificacion) { 

           // $expedientes =  $em->getRepository('ExpedienteBundle:Expediente')->findBy(
             //                  array('departamentoRm' => $departamento,
               //                      'clasificacion' => $clasificacion)); 
      //$fechaDesde = new \DateTime('2016-01-01');
      //$fechaHasta = new \DateTime('2017-01-01');
              $consulta = $em->createQuery(
                        'SELECT e
                        FROM ExpedienteBundle:Expediente e JOIN e.tramite t 
                        JOIN e.departamentoRm d
                        JOIN e.clasificacion c
                        WHERE e.departamentoRm= :id 
                        AND e.clasificacion= :idc
                        AND t.fechaOrigen> :fec1 
                        AND t.fechaOrigen< :fec2 
                        
                        ');
               $consulta->setParameter('id', $departamento);
               $consulta->setParameter('idc', $clasificacion);
               $consulta->setParameter('fec1', $fechaDesde);
               $consulta->setParameter('fec2', $fechaHasta);
               $expedientes = $consulta->getResult(); 


            $informe[$clasificacion->getClasificacion()]= count($expedientes);


            foreach ($tipoLicencias as $tipoLicencia){

                //$tramites = $em->getRepository('ExpedienteBundle:Tramite')
                  //              ->findTramiteClasificacion($departamento, $clasificacion, $tipoTramite, $fechaDesde, $fechaHasta); 
                 $consulta = $em->createQuery(
               'SELECT l
                FROM AusentismoBundle:Licencia l 
                JOIN l.articulo a
                JOIN l.docMedico dm
                JOIN dm.tramite t 
                JOIN t.expediente e                        
                JOIN t.departamentoRm d
                JOIN e.clasificacion c
                WHERE t.departamentoRm = :id 
                AND e.clasificacion    = :idc 
                AND t.fechaOrigen> :fec1 
                AND t.fechaOrigen< :fec2 
                AND  l.articulo     = :idr');
                $consulta->setParameter('id', $departamento);
                $consulta->setParameter('idc', $clasificacion);
                $consulta->setParameter('idr', $tipoLicencia);
                $consulta->setParameter('fec1', $fechaDesde);
                $consulta->setParameter('fec2', $fechaHasta);
                $tramites              = $consulta->getResult(); 

                 $informe[$tipoLicencia->getDescripcion()] = count($tramites);
             }                        

            $informe_principal[$clasificacion->getClasificacion()]= $informe;            
        }
      // var_dump($informe_principal);
       // exit();

     return $this->render('ExpedienteBundle:Default:informe_licencia.html.twig', array(
            'tipoTramites' => $tipoLicencias,  
            'clasificaciones'=>$clasificaciones,
            'informe' => $informe_principal,
            'fechaDesde'=>$fechaDesde,
            'fechaHasta'=>$fechaHasta
        ));

    }


      /**
     *
     * @Route("/intranet/informe/new", name="extranet_informe_new")
     * @param DepartamentoRm $departamento 
     */
    public function informeNewAction(Request $request)
    {

      //  $defaultData = array('message' => 'Crear Informe');
            $form = $this->createFormBuilder()
            ->add('opcion', 'choice', array(
                 'choices' => array(
                 0   => 'Informe de TRAMITES por CLASIFICACION',
                1 => 'Informe de LICENCIAS por CLASIFICACION'), 'data' =>1))
            ->add('fechaDesde', 'date')
            ->add('fechaHasta', 'date')
            ->getForm();
     

        $form->handleRequest($request);
     
        if ($form->isValid()) {
            // data es un array con claves 'name', 'email', y 'message'
            $data = $form->getData();


           $op=$data['opcion'];
             //var_dump($op);
            //exit();
           
           $fd=$data['fechaDesde'];
           $fh=$data['fechaHasta'];
           if ($op == 0) {
                $response = $this->forward('ExpedienteBundle:Default:informeTramite', array(
                'fechaDesde'=>$fd,
                'fechaHasta'=>$fh,
                ));
                return $response;
                }else{
                 $response = $this->forward('ExpedienteBundle:Default:informeLicencia', array(
                'fechaDesde'=>$fd,
                'fechaHasta'=>$fh, ));
                return $response;

                }
            }

        return $this->render('ExpedienteBundle:Default:informe_new.html.twig', array( 
            'form'=>$form->createView()));
    }




     /**
     * 
     * @Route("/intranet/buscar", name="extranet_buscar" )
     */
   
    public function buscarAction(Request $request, $pagina="inicio")
    {
       
    $cons = $request->query->get('consulta');      
        
         $var1 = !preg_match('/(^[0-9]{1,8})-([0-9]{4,4})/', $cons);
         $var2 = !is_numeric($cons);
     if ($var1 AND $var2) {
      
         // código que procesa el formulario ...

        $this->get('session')->getFlashBag()->add(
        'mensaje-warning',
        'Debe ingresar correctamente los datos del expediente Por Ej. 253-2016.'
        );
        return $this->redirectToRoute('extranet');
      }


      $em = $this->getDoctrine()->getManager();
      if (is_numeric($cons)) { 
        $num = $cons; 
        $anio = date("Y");

        $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findBy(array(
            'numero' => $num
        ));

       }
        else {
             $a = explode( "-" , $cons);
             $num = intval($a[0]);
              $anio = $a[1]; 

        $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findBy(array(
            'numero' => $num,
            'anio' => $anio
        ));
        }




      if (!$expedientes) {
          $this->get('session')->getFlashBag()->add(
          'mensaje-info',
          '<strong> Ops... </strong> No se ha encontrado ningun expediente que conicida con la busqueda:'.$cons
          );

        return $this->redirectToRoute('extranet');
           
      }
        
        $em = $this->getDoctrine()->getManager();

        $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();

        $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();

     
     return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));
}



    /**
     * @Route("/intranet/expediente/{id}/iniciar", name="extranet_expediente_iniciar")
     */
    public function iniciarAction(Request $request, Expediente $expediente)
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
     * @Route("/intranet/expediente/{id}/concluir", name="extranet_expediente_concluir")
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
     * @Route("/intranet/expediente/departamento/{id}", name="extranet_expediente_departamento")
     * 
     */
    public function expedienteByDepartamentoAction($id)
    {
    
        $em = $this->getDoctrine()->getManager();
         $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
        $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteByDepartamento($id);

        $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();
         $dp = $em->getRepository('AusentismoBundle:DepartamentoRm')->find($id);

        $this->get('session')->getFlashBag()->add(
                    'mensaje-success',
                    'Expedientes del departamento:<strong>  '.$dp.'</strong> ');
     return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));
    }



    /**
     * @Route("/intranet/expediente/clasificacion/{id}/{clasificacion_id}", name="extranet_expediente_clasificacion")
     *
     */
    public function expedienteByClasificacionAction($id, $clasificacion_id )
    {
    
        $em = $this->getDoctrine()->getManager();
         $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
        $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteByClasificacion($id, $clasificacion_id);

       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();
        $dp = $em->getRepository('AusentismoBundle:DepartamentoRm')->find($id);
        $cl = $em->getRepository('ExpedienteBundle:Clasificacion')->find($clasificacion_id);
        $this->get('session')->getFlashBag()->add(
                    'mensaje-success',
                    'Expedientes con Clasificacion:<strong>'.$cl.' </strong> del departamento:<strong>  '.$dp.'</strong> ');
     return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));
    }


    /**
     * @Route("/intranet/expediente/iniciado/departamento/{id}", name="extranet_expediente_iniciado_departamento")
     *
     */
    public function expedienteIniciadoByDepartamentoAction($id )
    {

       $em = $this->getDoctrine()->getManager();
       $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
       $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteIniciadoByDepartamento($id);
 
       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();
       $departamentoRm = $em->getRepository('AusentismoBundle:DepartamentoRm')->find($id);
        $this->get('session')->getFlashBag()->add(
                    'mensaje-success',
                    'Expedientes con estado <strong> INICIADO </strong> del departamento:<strong>  '.$departamentoRm->getDepartamentoRm().'</strong> ');
       return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));

    }




    /**
     * @Route("/intranet/expediente/departamento/{id}/turno", name="extranet_expediente_turno")
     *
     */
    public function expedienteTurnoByDepartamentoAction($id )
    {

       $em = $this->getDoctrine()->getManager();
       $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
       $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteTurno($id);
       $departamentoRm = $em->getRepository('AusentismoBundle:DepartamentoRm')->find($id);
       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();
        $this->get('session')->getFlashBag()->add(
                    'mensaje-success',
                    'Expedientes con <strong> TURNOS </strong>del departamento:<strong>  '.$departamentoRm->getDepartamentoRm().'</strong> ');

       return $this->render('ExpedienteBundle:Extranet:index.html.twig', array(
            'expedientes' => $expedientes, 
            'departamentos'=>$departamento, 
            'menu'=>$menu,
            'clasificaciones'=>$clasificacion
        ));

    }


    /**
     * @Route("/intranet/expediente/departamento/{id}/citacion", name="extranet_expediente_citacion")
     *
     */
    public function expedienteCitacionByDepartamentoAction($id )
    {

       $em = $this->getDoctrine()->getManager();
       $menu = $em->getRepository('ExpedienteBundle:Expediente')->findMenu();
       $expedientes = $em->getRepository('ExpedienteBundle:Expediente')->findExpedienteCitacion($id);

       $clasificacion = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
       $departamento = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();

        $departamentoRm = $em->getRepository('AusentismoBundle:DepartamentoRm')->find($id);
        $this->get('session')->getFlashBag()->add(
                    'mensaje-success',
                    'Expedientes <strong>  CITACION </strong> del departamento:<strong>  '.$departamentoRm->getDepartamentoRm().'</strong> ');
  
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
             WHERE e.departamentoRm = :id AND t.estado = :estado AND tc.tipoDocumento = :tipo 
             ORDER BY a.apellidoNombre ASC'
            );

        $consulta->setParameter('id', $id);
        // si estado de expediente es True => INICIADO si False=> CONCLUIDO
        // si estadoTurnoCitacion de tramite es True => con turno  si False=> sin turno
        $consulta->setParameter('estado', false);
       // $consulta->setParameter('estadoTyC', true);
        $consulta->setParameter('tipo', "citacion");
                
        return  $consulta->getResult();  
    }

}
