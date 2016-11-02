<?php

namespace Siarme\AusentismoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articulo
 *
 * @ORM\Table(name="articulo")
 * @ORM\Entity(repositoryClass="Siarme\AusentismoBundle\Repository\ArticuloRepository")
 */
class Articulo
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
     * @ORM\Column(name="codigoArticulo", type="string", length=5, unique=true)
     */
    private $codigoArticulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, unique=true)
     */
    private $descripcion;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\AusentismoBundle\Entity\Licencia", mappedBy="articulo") 
     */
    private $licencia;

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
     * Set codigoArticulo
     *
     * @param string $codigoArticulo
     * @return Articulo
     */
    public function setCodigoArticulo($codigoArticulo)
    {
        $this->codigoArticulo = $codigoArticulo;

        return $this;
    }

    /**
     * Get codigoArticulo
     *
     * @return string 
     */
    public function getCodigoArticulo()
    {
        return $this->codigoArticulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Articulo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function __toString()
    {
         return $this->getCodigoArticulo().' - '.$this->getDescripcion();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->licencia = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add licencia
     *
     * @param \Siarme\AusentismoBundle\Entity\Licencia $licencia
     * @return Articulo
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
}
