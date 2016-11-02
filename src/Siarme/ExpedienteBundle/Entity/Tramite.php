<?php

namespace Siarme\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tramite
 *
 * @ORM\Table(name="tramite")
 * @ORM\Entity(repositoryClass="Siarme\ExpedienteBundle\Repository\TramiteRepository")
 */
class Tramite
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
     * @var string
     *
     * @ORM\Column(name="organismo_origen", type="string", length=255)
     */
    private $organismoOrigen;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_origen", type="datetime")
     */
    private $fechaOrigen;

    /**
     * @var string
     *
     * @ORM\Column(name="organismo_destino", type="string", length=255, nullable=true )
     */
    private $organismoDestino;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_destino", type="datetime", nullable=true)
     */
    private $fechaDestino;

    /** 
     *@ORM\ManyToOne(targetEntity="Siarme\ExpedienteBundle\Entity\TipoTramite", inversedBy="tramite")
     * @ORM\JoinColumn(name="tipo_tramite_id", referencedColumnName="id")
     */
    private $tipoTramite;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado_turno_citacion", type="boolean")
     */
    private $estadoTurnoCitacion;


    /** 
     *@ORM\ManyToOne(targetEntity="Siarme\AusentismoBundle\Entity\DepartamentoRm", inversedBy="tramite")
     * @ORM\JoinColumn(name="departamento_rm_id", referencedColumnName="id")
     */
    private $departamentoRm;

    /** 
     *@ORM\ManyToOne(targetEntity="Siarme\ExpedienteBundle\Entity\Expediente", inversedBy="tramite") 
     *@ORM\JoinColumn(name="expediente_id", referencedColumnName="id")
     */
    private $expediente;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\DocumentoBundle\Entity\DocMedico", mappedBy="tramite") 
     */
    private $docMedico;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\DocumentoBundle\Entity\DocAdministrativo", mappedBy="tramite") 
     */
    private $docAdministrativo;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\DocumentoBundle\Entity\TurnoCitacion", mappedBy="tramite") 
     */
    private $turnoCitacion;


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
     * Set organismoOrigen
     *
     * @param string $organismoOrigen
     * @return Tramite
     */
    public function setOrganismoOrigen($organismoOrigen)
    {
        $this->organismoOrigen = $organismoOrigen;

        return $this;
    }

    /**
     * Get organismoOrigen
     *
     * @return string 
     */
    public function getOrganismoOrigen()
    {
        return $this->organismoOrigen;
    }

    /**
     * Set fechaOrigen
     *
     * @param \DateTime $fechaOrigen
     * @return Tramite
     */
    public function setFechaOrigen($fechaOrigen)
    {
        $this->fechaOrigen = $fechaOrigen;

        return $this;
    }

    /**
     * Get fechaOrigen
     *
     * @return \DateTime 
     */
    public function getFechaOrigen()
    {
        return $this->fechaOrigen;
    }

    /**
     * Set organismoDestino
     *
     * @param string $organismoDestino
     * @return Tramite
     */
    public function setOrganismoDestino($organismoDestino)
    {
        $this->organismoDestino = $organismoDestino;

        return $this;
    }

    /**
     * Get organismoDestino
     *
     * @return string 
     */
    public function getOrganismoDestino()
    {
        return $this->organismoDestino;
    }

    /**
     * Set fechaDestino
     *
     * @param \DateTime $fechaDestino
     * @return Tramite
     */
    public function setFechaDestino($fechaDestino)
    {
        $this->fechaDestino = $fechaDestino;

        return $this;
    }

    /**
     * Get fechaDestino
     *
     * @return \DateTime 
     */
    public function getFechaDestino()
    {
        return $this->fechaDestino;
    }


  /*
   * ToString
   */
    public function __toString()
    {
         return (string) $this->getTipoTramite();
    }

   /**
   * Constructor
   */
    public function __construct()
    {
        $this->setEstadoTurnoCitacion(false);
        $this->docMedico = new ArrayCollection();
        $this->docAdministrativo = new ArrayCollection();
    }

    /**
     * Set departamentoRm
     *
     * @param \Siarme\AusentismoBundle\Entity\DepartamentoRm $departamentoRm
     * @return Tramite
     */
    public function setDepartamentoRm(\Siarme\AusentismoBundle\Entity\DepartamentoRm $departamentoRm = null)
    {
        $this->departamentoRm = $departamentoRm;

        return $this;
    }

    /**
     * Get departamentoRm
     *
     * @return \Siarme\AusentismoBundle\Entity\DepartamentoRm 
     */
    public function getDepartamentoRm()
    {
        return $this->departamentoRm;
    }



    /**
     * Add docMedico
     *
     * @param \Siarme\DocumentoBundle\Entity\DocMedico $docMedico
     * @return Tramite
     */
    public function addDocMedico(\Siarme\DocumentoBundle\Entity\DocMedico $docMedico)
    {
        $this->docMedico[] = $docMedico;

        return $this;
    }

    /**
     * Remove docMedico
     *
     * @param \Siarme\DocumentoBundle\Entity\DocMedico $docMedico
     */
    public function removeDocMedico(\Siarme\DocumentoBundle\Entity\DocMedico $docMedico)
    {
        $this->docMedico->removeElement($docMedico);
    }

    /**
     * Get docMedico
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocMedico()
    {
        return $this->docMedico;
    }

    /**
     * Add docAdministrativo
     *
     * @param \Siarme\DocumentoBundle\Entity\DocAdministrativo $docAdministrativo
     * @return Tramite
     */
    public function addDocAdministrativo(\Siarme\DocumentoBundle\Entity\DocAdministrativo $docAdministrativo)
    {
        $this->docAdministrativo[] = $docAdministrativo;

        return $this;
    }

    /**
     * Remove docAdministrativo
     *
     * @param \Siarme\DocumentoBundle\Entity\DocAdministrativo $docAdministrativo
     */
    public function removeDocAdministrativo(\Siarme\DocumentoBundle\Entity\DocAdministrativo $docAdministrativo)
    {
        $this->docAdministrativo->removeElement($docAdministrativo);
    }

    /**
     * Get docAdministrativo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocAdministrativo()
    {
        return $this->docAdministrativo;
    }

    /**
     * Set tipoTramite
     *
     * @param \Siarme\ExpedienteBundle\Entity\TipoTramite $tipoTramite
     * @return Tramite
     */
    public function setTipoTramite(\Siarme\ExpedienteBundle\Entity\TipoTramite $tipoTramite = null)
    {
        $this->tipoTramite = $tipoTramite;

        return $this;
    }

    /**
     * Get tipoTramite
     *
     * @return \Siarme\ExpedienteBundle\Entity\TipoTramite 
     */
    public function getTipoTramite()
    {
        return $this->tipoTramite;
    }

    /**
     * Set expediente
     *
     * @param \Siarme\ExpedienteBundle\Entity\Expediente $expediente
     * @return Tramite
     */
    public function setExpediente(\Siarme\ExpedienteBundle\Entity\Expediente $expediente = null)
    {
        $this->expediente = $expediente;

        return $this;
    }

    /**
     * Get expediente
     *
     * @return \Siarme\ExpedienteBundle\Entity\Expediente 
     */
    public function getExpediente()
    {
        return $this->expediente;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return Tramite
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

   
    /**
     * Set estadoTurnoCitacion
     *
     * @param boolean $estadoTurnoCitacion
     *
     * @return Tramite
     */
    public function setEstadoTurnoCitacion($estadoTurnoCitacion)
    {
        $this->estadoTurnoCitacion = $estadoTurnoCitacion;

        return $this;
    }

    /**
     * Get estadoTurnoCitacion
     *
     * @return boolean
     */
    public function getEstadoTurnoCitacion()
    {
        return $this->estadoTurnoCitacion;
    }

    /**
     * Add turnoCitacion
     *
     * @param \Siarme\DocumentoBundle\Entity\TurnoCitacion $turnoCitacion
     *
     * @return Tramite
     */
    public function addTurnoCitacion(\Siarme\DocumentoBundle\Entity\TurnoCitacion $turnoCitacion)
    {
        $this->turnoCitacion[] = $turnoCitacion;

        return $this;
    }

    /**
     * Remove turnoCitacion
     *
     * @param \Siarme\DocumentoBundle\Entity\TurnoCitacion $turnoCitacion
     */
    public function removeTurnoCitacion(\Siarme\DocumentoBundle\Entity\TurnoCitacion $turnoCitacion)
    {
        $this->turnoCitacion->removeElement($turnoCitacion);
    }

    /**
     * Get turnoCitacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTurnoCitacion()
    {
        return $this->turnoCitacion;
    }
}
