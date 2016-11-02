<?php

namespace Siarme\DocumentoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TurnoCitacion
 *
 * @ORM\Table(name="turno_citacion")
 * @ORM\Entity(repositoryClass="Siarme\DocumentoBundle\Repository\TurnoCitacionRepository")
 */
class TurnoCitacion
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
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_turno_citacion", type="datetime")
     */
    private $fechaTurnoCitacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="datetime")
     */
    private $hora;

    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_documento", type="string", length=255)
     */
    private $tipoDocumento;

    /** 
     * @ORM\ManyToOne(targetEntity="Siarme\ExpedienteBundle\Entity\Tramite", inversedBy="turnoCitacion") 
     * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id")
     */
    private $tramite;

    /** 
     * @ORM\ManyToOne(targetEntity="Siarme\AusentismoBundle\Entity\Agente", inversedBy="turnoCitacion") 
     * @ORM\JoinColumn(name="agente_id", referencedColumnName="id")
     */
    private $agente;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaDocumento
     *
     * @param \DateTime $fechaDocumento
     *
     * @return TurnoCitacion
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
     * Set fechaTurnoCitacion
     *
     * @param \DateTime $fechaTurnoCitacion
     *
     * @return TurnoCitacion
     */
    public function setFechaTurnoCitacion($fechaTurnoCitacion)
    {
        $this->fechaTurnoCitacion = $fechaTurnoCitacion;

        return $this;
    }

    /**
     * Get fechaTurnoCitacion
     *
     * @return \DateTime
     */
    public function getFechaTurnoCitacion()
    {
        return $this->fechaTurnoCitacion;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return TurnoCitacion
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

 
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return TurnoCitacion
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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
     * Set tipoDocumento
     *
     * @param string $tipoDocumento
     *
     * @return TurnoCitacion
     */
    public function setTipoDocumento($tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;

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
     * Set agente
     *
     * @param \Siarme\AusentismoBundle\Entity\Agente $agente
     *
     * @return TurnoCitacion
     */
    public function setAgente(\Siarme\AusentismoBundle\Entity\Agente $agente = null)
    {
        $this->agente = $agente;

        return $this;
    }

    /**
     * Get agente
     *
     * @return \Siarme\AusentismoBundle\Entity\Agente
     */
    public function getAgente()
    {
        return $this->agente;
    }

    public function __construct()
    {
        
     $this->setEstado(false);
    }

    public function __toString( )
    {
        return $this->getTipoDocumento();
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return TurnoCitacion
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set tramite
     *
     * @param \Siarme\ExpedienteBundle\Entity\Tramite $tramite
     *
     * @return TurnoCitacion
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
