<?php

namespace Siarme\ExpedienteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
/**
 * ExpedienteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExpedienteRepository extends EntityRepository
{

      /**
     * Encuentra el departamentoRm indicado
     *
     *  @return array
     */
	public function findMenu()
	{

        $em = $this->getEntityManager();

        $clasificaciones = $em->getRepository('ExpedienteBundle:Clasificacion')->findAll();
        $departamentos = $em->getRepository('AusentismoBundle:DepartamentoRm')->findAll();

        $menu = array();
        $menu_principal = array();

        foreach ($departamentos as $departamento) { 

              $consulta = $em->createQuery(
                       'SELECT e
                        FROM ExpedienteBundle:Expediente e 
                      WHERE e.departamentoRm = :id 
                       ');
              $consulta->setParameter('id', $departamento->getId());
              $expedientes = $consulta->getResult();  

              $menu=array();         

            foreach($expedientes as $expediente)

            {
                if(isset($menu[$expediente->getClasificacion()->getClasificacion()]))

                {  // si ya existe, le añadimos uno

                    $menu[$expediente->getClasificacion()->getClasificacion()]+=1;

                }else{

                    // si no existe lo añadimos al array

                    $menu[$expediente->getClasificacion()->getClasificacion()]=1;
                }
                 $menu['Citacion'] = count($this->queryFindCitacion($departamento->getId())->getResult());
                 $menu['Turno'] = count($this->queryFindTurno($departamento->getId())->getResult());
            }



            $menu_principal[$departamento->getDepartamentoRm()]= $menu;
            
        }
        return $menu_principal;
    }

 /**
     * Encuentra el los Expedientes con Citacion
     *
     *  @param string $id El id de DepartamentoRm
     *  @return Query
     */
    public function  queryFindCitacion($id)
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
                
        return  $consulta;  
    }

 /**
     * Encuentra el los Expedientes con Citacion
     *
     *  @param string $id El id de DepartamentoRm
     *  @return Query
     */
    public function  queryFindTurno($id)
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
        $consulta->setParameter('tipo', "turno");
                
        return  $consulta;  
    }


    /**
     * Encuentra todos los Expedientes
     *
     *  @return array
     */

    public function findTodos()
    {

        $em = $this->getEntityManager();

        $consulta = $em->createQuery(
            'SELECT e, a, t, c, d
             FROM ExpedienteBundle:Expediente e 
             JOIN e.agente a  
             JOIN e.tramite t 
             JOIN e.clasificacion c
             JOIN e.departamentoRm d
            ORDER BY a.apellidoNombre ASC'
            );

       return  $consulta->getResult();
    }


      /**
     * Encuentra el los Expedientes por departamentoRm indicado
     *
     *  @param string $id El id del departamentoRm
     *  @return array
     */
    public function findExpedienteByDepartamento($id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery(
                        'SELECT e
                        FROM ExpedienteBundle:Expediente e
                        WHERE e.departamentoRm = :id 
                        ');
        $consulta->setParameter('id', $id);
                
        return  $consulta->getResult();  
    }

    /**
     * Encuentra el los Expedientes por Clasificacion indicado
     *
     *  @param string $id El id de DepartamentoRm
     *  @param string $clasificacion_id El id de Clasificacion
     *  @return array
     */
    public function findExpedienteByClasificacion($id, $clasificacion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery(
                        'SELECT e
                        FROM ExpedienteBundle:Expediente e
                        WHERE e.departamentoRm = :id AND e.clasificacion = :clasificacion_id
                        ');
        $consulta->setParameter('id', $id);
        $consulta->setParameter('clasificacion_id', $clasificacion_id);
                
        return  $consulta->getResult();  
    }

    /**
     * Encuentra el los Expedientes por Clasificacion indicado
     *
     *  @param string $id El id de DepartamentoRm
     *  @return array
     */
    public function  findExpedienteIniciadoByDepartamento($id)
    {
        $em = $this->getEntityManager();

         $consulta = $em->createQuery(
            'SELECT e, a, t, c, d
             FROM ExpedienteBundle:Expediente e 
             JOIN e.agente a  
             JOIN e.tramite t 
             JOIN e.clasificacion c
             JOIN e.departamentoRm d
             WHERE e.departamentoRm = :id AND e.estado = :estado
             ORDER BY a.apellidoNombre ASC'
            );

        $consulta->setParameter('id', $id);

        $consulta->setParameter('estado', false);
                
        return  $consulta->getResult();  
    }



    /**
     * Encuentra el los Expedientes con Turno o Citacion
     *
     *  @param string $id El id de DepartamentoRm
     *  @return array
     */
    public function  findExpedienteTurno($id)
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
        $consulta->setParameter('tipo', "turno");
                
        return  $consulta->getResult();  
    }

    /**
     * Encuentra el los Expedientes con Citacion
     *
     *  @param string $id El id de DepartamentoRm
     *  @return array
     */
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