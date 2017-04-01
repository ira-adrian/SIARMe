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
       
        $tramites = $manager->getRepository('ExpedienteBundle:Tramite')->findAll();


        $tipo_docs =  $this->container->getParameter('tipodoc');


       // $docAdministrativos = $manager->getRepository('DocumentoBundle:DocAdministrativo')->findByTipoDocumento($tipodoc);            

        $docAdministrativos = $manager->getRepository('DocumentoBundle:DocAdministrativo')->findAll();
        $numero=count($docAdministrativos);

foreach ($tramites as $tramite) {  
                $usuarios = $manager->getRepository('UsuarioBundle:Usuario')->findByRol("ROLE_ADMINISTRATIVO");
                
                for ($i=1; $i <= rand(0,4); $i++) { 
                $numero++; 
                $tipodoc = $tipo_docs['administrativo']; //array (slug => documento) 
                $organismo = $organismos[array_rand($organismos)];
                $usuario = $usuarios[array_rand($usuarios)];
                $slug = array_rand( $tipodoc, 1 );
                $docAdministrativo = New DocAdministrativo();
                $docAdministrativo->setFechaDocumento(new \DateTime('now - '.rand(1, 365).' days'));
                $docAdministrativo->setNumero($numero);
                $docAdministrativo->setDirigidoA($organismo->getOrganismo()."\n".$organismo->getResponsable());
                $docAdministrativo->setTexto($this->getTexto());
                $docAdministrativo->setUsuario($usuario);                
                $docAdministrativo->setTramite($tramite);
                $docAdministrativo->setTipoDocumento($tipodoc[$slug]);
                $docAdministrativo->setSlug($slug);
                if ((strcmp ($slug, "citacion") ==0) or (strcmp ($slug, "turno") ==0))  {
                      $docAdministrativo->setEstado(true);
                      } else {
                      $docAdministrativo->setEstado(false);
                      }
                $manager->persist($docAdministrativo);  
                }
                  $manager->flush();                


         // Crear entre 0 y 5 Documentos de Prueba Para cada Usuario 
        $usuarios = $manager->getRepository('UsuarioBundle:Usuario')->findByRol("ROLE_MEDICO");
        $tipodoc = $tipo_docs['medico']; //array (slug => documento) 

        $docMedicos = $manager->getRepository('DocumentoBundle:DocMedico')->findAll();
        $numero=count($docMedicos);

            $organismo = $organismos[array_rand($organismos)];
            for ($i=1; $i <= rand(0,4); $i++) { 
                $numero++; 

                $slug = array_rand( $tipodoc , 1 );
                $usuario = $usuarios[array_rand($usuarios)];
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