<?php

namespace Siarme\AusentismoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Localidad
 *
 * @ORM\Table(name="localidad")
 * @ORM\Entity(repositoryClass="Siarme\AusentismoBundle\Repository\LocalidadRepository")
 */
class Localidad
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
     * @ORM\Column(name="localidad", type="string", length=255)
     */
    private $localidad;

    /** 
    * @ORM\ManyToOne(targetEntity="Siarme\AusentismoBundle\Entity\Departamento", inversedBy="localidad") 
    * @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
    */
    private $departamento;

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
     * Set localidad
     *
     * @param string $localidad
     * @return Localidad
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    public function __toString()
    {
        return $this->getLocalidad();
    }

    /**
     * Set departamento
     *
     * @param \Siarme\AusentismoBundle\Entity\Departamento $departamento
     * @return Localidad
     */
    public function setDepartamento(\Siarme\AusentismoBundle\Entity\Departamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \Siarme\AusentismoBundle\Entity\Departamento 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }
}
