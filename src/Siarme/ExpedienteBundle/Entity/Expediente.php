<?php

namespace Siarme\ExpedienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Expediente
 *
 * @ORM\Table(name="expediente")
 * @ORM\Entity(repositoryClass="Siarme\ExpedienteBundle\Repository\ExpedienteRepository")
 */
class Expediente
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
     * @ORM\Column(name="letra", type="string", length=10)
     */
    private $letra;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="año", type="integer")
     */
    private $anio;

    /** 
     *@ORM\ManyToOne(targetEntity="Siarme\AusentismoBundle\Entity\Agente", inversedBy="expediente")
     *@ORM\JoinColumn(name="agente_id", referencedColumnName="id") 
     */
    private $agente;

    /**
     * @var string
     *
     * @ORM\Column(name="extracto", type="string", length=255)
     */
    private $extracto;

    /** 
     *@ORM\ManyToOne(targetEntity="Siarme\AusentismoBundle\Entity\DepartamentoRm", inversedBy="expediente")
     * @ORM\JoinColumn(name="departamento_rm_id", referencedColumnName="id")
     */
    private $departamentoRm;


    /** 
     *@ORM\ManyToOne(targetEntity="Siarme\ExpedienteBundle\Entity\Clasificacion", inversedBy="expediente") 
     *@ORM\JoinColumn(name="clasificacion_id", referencedColumnName="id")
     */
    private $clasificacion;


    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text")
     */
    private $observacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;


    /** 
     *@ORM\OneToMany(targetEntity="Siarme\ExpedienteBundle\Entity\Tramite", mappedBy="expediente", cascade={"persist","remove"})
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
     * Set letra
     *
     * @param string $letra
     * @return Expediente
     */
    public function setLetra($letra)
    {
        $this->letra = $letra;

        return $this;
    }

    /**
     * Get letra
     *
     * @return string 
     */
    public function getLetra()
    {
        return $this->letra;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     * @return Expediente
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
     * Set extracto
     *
     * @param string $extracto
     * @return Expediente
     */
    public function setExtracto($extracto)
    {
        $this->extracto = $extracto;

        return $this;
    }

    /**
     * Get extracto
     *
     * @return string 
     */
    public function getExtracto()
    {
        return $this->extracto;
    }


    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Expediente
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return Expediente
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


    public function __toString()
    {
         return $this->getLetra().'-'.$this->getNumero().'-'.$this->getAnio();
    }


     public function __construct()
    {
        $this->tramite = new ArrayCollection();
    }


    /**
     * Set clasificacion
     *
     * @param \Siarme\ExpedienteBundle\Entity\Clasificacion $clasificacion
     * @return Expediente
     */
    public function setClasificacion(\Siarme\ExpedienteBundle\Entity\Clasificacion $clasificacion = null)
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    /**
     * Get clasificacion
     *
     * @return \Siarme\ExpedienteBundle\Entity\Clasificacion 
     */
    public function getClasificacion()
    {
        return $this->clasificacion;
    }

    /**
     * Add tramite
     *
     * @param \Siarme\ExpedienteBundle\Entity\Tramite $tramite
     * @return Expediente
     */
    public function addTramite(\Siarme\ExpedienteBundle\Entity\Tramite $tramite)
    {
        $this->tramite[] = $tramite;

        return $this;
    }

    /**
     * Remove tramite
     *
     * @param \Siarme\ExpedienteBundle\Entity\Tramite $tramite
     */
    public function removeTramite(\Siarme\ExpedienteBundle\Entity\Tramite $tramite)
    {
        $this->tramite->removeElement($tramite);
    }

    /**
     * Get tramite
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTramite()
    {
        return $this->tramite;
    }



    /**
     * Set agente
     *
     * @param \Siarme\AusentismoBundle\Entity\Agente $agente
     * @return Expediente
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

    /**
     * Set anio
     *
     * @param integer $anio
     *
     * @return Expediente
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set departamentoRm
     *
     * @param \Siarme\AusentismoBundle\Entity\DepartamentoRm $departamentoRm
     *
     * @return Expediente
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
}
