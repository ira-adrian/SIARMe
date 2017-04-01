<?php

namespace Siarme\DocumentoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Siarme\AusentismoBundle\Util\Slugger;

/**
 * DocAdministrativo
 *
 * @ORM\Table(name="doc_administrativo")
 * @ORM\Entity(repositoryClass="Siarme\DocumentoBundle\Repository\DocAdministrativoRepository")
 */
class DocAdministrativo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_documento", type="datetime")
     */
    private $fechaDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="dirigidoA", type="string", length=255, nullable=true)
     */
    private $dirigidoA;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_documento", type="string", length=255)
     */
    private $tipoDocumento;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="text")
     */
    private $texto;

     /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fechaCreacion;

    /** 
     * @ORM\ManyToOne(targetEntity="Siarme\UsuarioBundle\Entity\Usuario", inversedBy="docAdministrativo") 
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    /** 
     * @ORM\ManyToOne(targetEntity="Siarme\ExpedienteBundle\Entity\Tramite", inversedBy="docAdministrativo") 
     * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id")
     */
    private $tramite;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

 

    /**
     * Set dirigidoA
     *
     * @param string $dirigidoA
     * @return DocAdministrativo
     */
    public function setDirigidoA($dirigidoA)
    {
        $this->dirigidoA = $dirigidoA;

        return $this;
    }

    /**
     * Get dirigidoA
     *
     * @return string 
     */
    public function getDirigidoA()
    {
        return $this->dirigidoA;
    }

    /**
     * Set destinatario
     *
     * @param string $destinatario
     * @return DocAdministrativo
     */
    public function setDestinatario($destinatario)
    {
        $this->destinatario = $destinatario;

        return $this;
    }

    /**
     * Get destinatario
     *
     * @return string 
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return DocAdministrativo
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }


    public function __construct()
    {
        $this->fechaCreacion = new \DateTime();
    }


    /**
     * Set tramite
     *
     * @param \Siarme\ExpedienteBundle\Entity\Tramite $tramite
     * @return DocAdministrativo
     */
    public function setTramite(\Siarme\ExpedienteBundle\Entity\Tramite $tramite = null)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite
     *
     * @return \Siarme\ExpedienteBundle\Entity\Tramite 
     */
    public function getTramite()
    {
        return $this->tramite;
    }


    /**
     * Set usuario
     *
     * @param \Siarme\UsuarioBundle\Entity\Usuario $usuario
     * @return DocAdministrativo
     */
    public function setUsuario(\Siarme\UsuarioBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Siarme\UsuarioBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return DocAdministrativo
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set fechaDocumento
     *
     * @param \DateTime $fechaDocumento
     * @return DocAdministrativo
     */
    public function setFechaDocumento($fechaDocumento)
    {
        $this->fechaDocumento = $fechaDocumento;

        return $this;
    }

    /**
     * Get fechaDocumento
     *
     * @return \DateTime 
     */
    public function getFechaDocumento()
    {
        return $this->fechaDocumento;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return DocAdministrativo
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set tipoDocumento
     *
     * @param string $tipoDocumento
     *
     * @return DocAdministrativo
     */
    public function setTipoDocumento($tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;
        // $this->slug = Slugger::getSlug($tipoDocumento);

        return $this;
    }

    /**
     * Get tipoDocumento
     *
     * @return string
     */
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }
    


    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return DocAdministrativo
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        // $this->slug = Slugger::getSlug($tipoDocumento);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     *  ToString
     */
        public function __toString()
    {
       return  $this->getTipoDocumento();
    }
    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TurnoCitacion
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
