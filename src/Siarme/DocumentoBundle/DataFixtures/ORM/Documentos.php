<?php

/*
 * (c) Ibañez Raul Adrian <ira.adrian@gmail.com>
 *
 * Este archivo pertenece a la aplicación de prueba SIARMe.
 */

namespace Siarme\DocumentoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Siarme\DocumentoBundle\Entity\DocAdministrativo;
use Siarme\DocumentoBundle\Entity\DocMedico;
use Siarme\AusentismoBundle\Entity\Licencia;
use Siarme\AusentismoBundle\Entity\Agente;
use Siarme\AusentismoBundle\Entity\Enfermedad;
use Siarme\AusentismoBundle\Entity\Organismo;
use Siarme\UsuarioBundle\Entity\Usuario;
use Siarme\ExpedienteBundle\Entity\Tramite;
use Siarme\DocumentoBundle\Entity\TurnoCitacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
/**
 * Fixtures de las entidades del Proyecto para
 * la Direccion de Reconocimientos Medicos.
 * Crea las entidades con las informacion de prueba muy realista.
 */
class Documentos extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 60;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
    
        
         // Crear entre 0 y 5 Documentos de Prueba Para cada Usuario 

        $organismos = $manager->getRepository('AusentismoBundle:Organismo')->findAll();
        $usuarios = $manager->getRepository('UsuarioBundle:Usuario')->findByRol("ROLE_ADMINISTRTIVO");
        $tramites = $manager->getRepository('ExpedienteBundle:Tramite')->findAll();

       // $tipodocs=  array('Nota', 'Proveido', 'Informe' ); 

        $tipo_docs =  $this->container->getParameter('tipodoc');
        $tipodoc = $tipo_docs['administrativo']; //array (slug => documento) 
        $numero = 0;
        $numeroTyC=1;

        foreach ($tramites as $tramite) {

            $organismo = $organismos[array_rand($organismos)];
            $tramite = $tramites[array_rand($tramites)];
            $docAdministrativos = $manager->getRepository('DocumentoBundle:DocAdministrativo')->findByTipoDocumento("proveido");            
            $numero= count($docAdministrativos);
                 $numero=count($docAdministrativos);
                $docAdministrativo = New DocAdministrativo();
                $docAdministrativo->setFechaDocumento(new \DateTime('now - '.rand(1, 365).' days'));
                $docAdministrativo->setNumero($numero);
                $docAdministrativo->setDirigidoA($organismo->getOrganismo()."\n".$organismo->getResponsable());
                $docAdministrativo->setTexto($this->getTexto());
                $docAdministrativo->setUsuario(array_rand($usuarios));                
                $docAdministrativo->setTramite($tramite);
                $manager->persist($docAdministrativo);
                $docAdministrativo->setTipoDocumento("Proveido");
                $docAdministrativo->setSlug("proveido");
 
                    $manager->flush();
             }

        $documento  = array('turno' => "Turno" , 'citacion' => "Citacion" ); 
        foreach ($tramites as $tramite) {

            if ($tramite->getEstadoTurnoCitacion()) {
                $organismo = $organismos[array_rand($organismos)];
                $tramite = $tramites[array_rand($tramites)];    
    
                $slug = array_rand($documento);
                 $numeroTyC++;
                 $docAdministrativo= New TurnoCitacion();
                 $docAdministrativo->setNumero(1);
                 $docAdministrativo->setfechaTurnoCitacion( new \DateTime('now + '.rand(1, 90).' days'));
                 $docAdministrativo->setFechaDocumento(new \DateTime('now - '.rand(30, 90).' days'));
                 $docAdministrativo->setHora( New \DateTime());
                 $docAdministrativo->setAgente($tramite->getExpediente()->getAgente());
                 $docAdministrativo->setEstado($tramite->getEstadoTurnoCitacion(true));
                $docAdministrativo->setTramite($tramite);
                $manager->persist($docAdministrativo);
                $docAdministrativo->setTipoDocumento($documento[$slug]);
                $docAdministrativo->setSlug($slug);
                 $manager->flush();
            }
        }
         // Crear entre 0 y 5 Documentos de Prueba Para cada Usuario 

        $organismos = $manager->getRepository('AusentismoBundle:Organismo')->findAll();
        $usuarios = $manager->getRepository('UsuarioBundle:Usuario')->findAll();
        $tramites = $manager->getRepository('ExpedienteBundle:Tramite')->findAll();

        $tipo_docs =  $this->container->getParameter('tipodoc');
        $tipodoc = $tipo_docs['medico']; //array (slug => documento) 


        foreach ($usuarios as $usuario) {
            $organismo = $organismos[array_rand($organismos)];
            $tramite = $tramites[array_rand($tramites)];

            $docMedicos = $manager->getRepository('DocumentoBundle:DocMedico')->findAll();

            $numero=count($docMedicos);
            for ($i=1; $i <= rand(0,4); $i++) { 
                $numero++; 

                $slug = array_rand( $tipodoc , 1 );
           
                $docMedico = New DocMedico();
                $docMedico->setTipoDocumento($tipodoc[$slug]);
                $docMedico->setSlug($slug);
                $docMedico->setFechaDocumento(new \DateTime('now - '.rand(1, 365).' days'));
                $docMedico->setNumero($numero);
                //$docMedico->setDirigidoA($organismo->getOrganismo."\n".$organismo->getResponsable);
                $docMedico->setDictamen($this->getDictamen());
                $docMedico->setUsuario($usuario);
                $docMedico->setTramite($tramite);
                $manager->persist($docMedico);
            }
                    $manager->flush();
        }


    // Para cada Documento Medico crear  una Licencia

       $docMedicos = $manager->getRepository('DocumentoBundle:DocMedico')->findAll();
       $articulos = $manager->getRepository('AusentismoBundle:Articulo')->findAll();
       $enfermedades = $manager->getRepository('AusentismoBundle:Enfermedad')->findAll();

       foreach ($docMedicos as $docMedico) {

       $expediente = $docMedico->getTramite()->getExpediente();
       $agente =  $expediente->getAgente();

       $licencia = New Licencia();
       $licencia ->setEnfermedad($enfermedades[array_rand($enfermedades)]);
       $licencia ->setArticulo($articulos[array_rand($articulos)]);

       $licencia ->setAgente($agente);

       $fecha = new \DateTime('now - '.rand(0, 180).' days');
       $fechaHasta = new \DateTime('now + '.rand(1, 180).' days');
       $licencia ->setFechaDocumento(new \DateTime('now'));
       $licencia ->setFechaDesde($fecha);
       $licencia ->setFechaHasta($fechaHasta);
       $licencia ->setDocMedico($docMedico);
       $licencia ->setDiagnostico($enfermedades[array_rand($enfermedades)]->getEnfermedad());
        $manager->persist($licencia);
        }

        $manager->flush();
    }
        
     /**
     * Generador aleatorio de textos de Documentos 
     *
     * @return  string Texto aleatorio generado para los Documentos .
     */
    private function getTexto()
    {

        $frases = array_flip(array(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Mauris ultricies nunc nec sapien tincidunt facilisis.',
            'Nulla scelerisque blandit ligula eget hendrerit.',
            'Sed malesuada, enim sit amet ultricies semper, elit leo lacinia massa, in tempus nisl ipsum quis libero.',
            'Aliquam molestie neque non augue molestie bibendum.',
            'Pellentesque ultricies erat ac lorem pharetra vulputate.',
            'Donec dapibus blandit odio, in auctor turpis commodo ut.',
            'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
            'Nam rhoncus lorem sed libero hendrerit accumsan.',
            'Maecenas non erat eu justo rutrum condimentum.',
            'Suspendisse leo tortor, tempus in lacinia sit amet, varius eu urna.',
            'Phasellus eu leo tellus, et accumsan libero.',
            'Pellentesque fringilla ipsum nec justo tempus elementum.',
            'Aliquam dapibus metus aliquam ante lacinia blandit.',
            'Donec ornare lacus vitae dolor imperdiet vitae ultricies nibh congue.',
        ));

        $numeroFrases = rand(2, 10);

        return implode(' ', array_rand($frases, $numeroFrases));
    }




     /**
     * Generador aleatorio de Dictamenes de Documentos Medicos
     *
     * @return  string Dictamen aleatorio generado para los Documentos Medicos.
     */
    private function getDictamen()
    {

        $frases = array_flip(array(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Mauris ultricies nunc nec sapien tincidunt facilisis.',
            'Nulla scelerisque blandit ligula eget hendrerit.',
            'Sed malesuada, enim sit amet ultricies semper, elit leo lacinia massa, in tempus nisl ipsum quis libero.',
            'Aliquam molestie neque non augue molestie bibendum.',
            'Pellentesque ultricies erat ac lorem pharetra vulputate.',
            'Donec dapibus blandit odio, in auctor turpis commodo ut.',
            'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
            'Nam rhoncus lorem sed libero hendrerit accumsan.',
            'Maecenas non erat eu justo rutrum condimentum.',
            'Suspendisse leo tortor, tempus in lacinia sit amet, varius eu urna.',
            'Phasellus eu leo tellus, et accumsan libero.',
            'Pellentesque fringilla ipsum nec justo tempus elementum.',
            'Aliquam dapibus metus aliquam ante lacinia blandit.',
            'Donec ornare lacus vitae dolor imperdiet vitae ultricies nibh congue.',
        ));

        $numeroFrases = rand(2, 10);

        return implode(' ', array_rand($frases, $numeroFrases));
    }





}