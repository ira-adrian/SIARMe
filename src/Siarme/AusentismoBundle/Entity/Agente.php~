<?php

namespace Siarme\AusentismoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Siarme\AusentismoBundle\Util\Slugger;

/**
 * Agente
 *
 * @ORM\Table(name="agente")
 * @ORM\Entity(repositoryClass="Siarme\AusentismoBundle\Repository\AgenteRepository")
 */
class Agente
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
     * @ORM\Column(name="apellidoNombre", type="string", length=255)
     */
    private $apellidoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="cuil", type="string", length=15)
     */
    private $cuil;

    /**
     * @var int
     *
     * @ORM\Column(name="dni", type="integer", unique=true)
     */
    private $dni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNacimiento", type="datetime")
     */
    private $fechaNacimiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAltaLaboral", type="datetime")
     */
    private $fechaAltaLaboral;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=255)
     */
    private $domicilio;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /** 
     *@ORM\ManyToOne(targetEntity="Siarme\AusentismoBundle\Entity\Localidad") 
     */
    private $localidad;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\AusentismoBundle\Entity\Licencia", mappedBy="agente") 
     */
    private $licencia;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\AusentismoBundle\Entity\Cargo" , mappedBy="agente") 
     */
    private $cargo;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\ExpedienteBundle\Entity\Expediente" , mappedBy="agente") 
     */
    private $expediente;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\DocumentoBundle\Entity\TurnoCitacion", mappedBy="agente") 
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
     * Set apellidoNombre
     *
     * @param string $apellidoNombre
     * @return Agente
     */
    public function setApellidoNombre($apellidoNombre)
    {
        $this->apellidoNombre = $apellidoNombre;
        $this->slug = Slugger::getSlug($apellidoNombre);

        return $this;
    }

    /**
     * Get apellidoNombre
     *
     * @return string 
     */
    public function getApellidoNombre()
    {
        return $this->apellidoNombre;
    }

    /**
     * Set cuil
     *
     * @param string $cuil
     * @return Agente
     */
    public function setCuil($cuil)
    {
        $this->cuil = $cuil;

        return $this;
    }

    /**
     * Get cuil
     *
     * @return string 
     */
    public function getCuil()
    {
        return $this->cuil;
    }

    /**
     * Set dni
     *
     * @param integer $dni
     * @return Agente
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return integer 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Agente
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set fechaAltaLaboral
     *
     * @param \DateTime $fechaAltaLaboral
     * @return Agente
     */
    public function setFechaAltaLaboral($fechaAltaLaboral)
    {
        $this->fechaAltaLaboral = $fechaAltaLaboral;

        return $this;
    }

    /**
     * Get fechaAltaLaboral
     *
     * @return \DateTime 
     */
    public function getFechaAltaLaboral()
    {
        return $this->fechaAltaLaboral;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     * @return Agente
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string 
     */
    public function getDomicilio()
    {
        return $this->domicilio;
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
     * Constructor
     */
    public function __construct()
    {
        $this->licencia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cargo = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add licencia
     *
     * @param \Siarme\AusentismoBundle\Entity\Licencia $licencia
     * @return Agente
     */
    public function addLicencium(\Siarme\AusentismoBundle\Entity\Licencia $licencia)
    {
        $this->licencia[] = $licencia;

        return $this;
    }

    /**
     * Remove licencia
     *
     * @param \Siarme\AusentismoBundle\Entity\Licencia $licencia
     */
    public function removeLicencium(\Siarme\AusentismoBundle\Entity\Licencia $licencia)
    {
        $this->licencia->removeElement($licencia);
    }

    /**
     * Get licencia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLicencia()
    {
        return $this->licencia;
    }

    /**
     * Add cargo
     *
     * @param \Siarme\AusentismoBundle\Entity\Cargo $cargo
     * @return Agente
     */
    public function addCargo(\Siarme\AusentismoBundle\Entity\Cargo $cargo)
    {
        $this->cargo[] = $cargo;

        return $this;
    }

    /**
     * Remove cargo
     *
     * @param \Siarme\AusentismoBundle\Entity\Cargo $cargo
     */
    public function removeCargo(\Siarme\AusentismoBundle\Entity\Cargo $cargo)
    {
        $this->cargo->removeElement($cargo);
    }

    /**
     * Get cargo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

 

    public function __toString()

    {
        return $this->getApellidoNombre();
    }


    /**
     * Set slug
     *
     * @param string $slug
     * @return Agente
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set localidad
     *
     * @param \Siarme\AusentismoBundle\Entity\Localidad $localidad
     * @return Agente
     */
    public function setLocalidad(\Siarme\AusentismoBundle\Entity\Localidad $localidad = null)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \Siarme\AusentismoBundle\Entity\Localidad 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Add expediente
     *
     * @param \Siarme\ExpedienteBundle\Entity\Expediente $expediente
     * @return Agente
     */
    public function addExpediente(\Siarme\ExpedienteBundle\Entity\Expediente $expediente)
    {
        $this->expediente[] = $expediente;

        return $this;
    }

    /**
     * Remove expediente
     *
     * @param \Siarme\ExpedienteBundle\Entity\Expediente $expediente
     */
    public function removeExpediente(\Siarme\ExpedienteBundle\Entity\Expediente $expediente)
    {
        $this->expediente->removeElement($expediente);
    }

    /**
     * Get expediente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExpediente()
    {
        return $this->expediente;
    }

    /**
     * Add turnoCitacion
     *
     * @param \Siarme\DocumentoBundle\Entity\TurnoCitacion $turnoCitacion
     *
     * @return Agente
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
