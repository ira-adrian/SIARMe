<?php

namespace Siarme\AusentismoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enfermedad
 *
 * @ORM\Table(name="enfermedad")
 * @ORM\Entity(repositoryClass="Siarme\AusentismoBundle\Repository\EnfermedadRepository")
 */
class Enfermedad
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
     * @ORM\Column(name="codigoEnfermedad", type="string", length=4, unique=true)
     */
    private $codigoEnfermedad;

    /**
     * @var string
     *
     * @ORM\Column(name="enfermedad", type="string", length=150)
     */
    private $enfermedad;

    /**
     * @var string
     *
     * @ORM\Column(name="grupo", type="string", length=2)
     */
    private $grupo;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\AusentismoBundle\Entity\Licencia", mappedBy="enfermedad") 
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
     * Set codigoEnfermedad
     *
     * @param string $codigoEnfermedad
     * @return Enfermedad
     */
    public function setCodigoEnfermedad($codigoEnfermedad)
    {
        $this->codigoEnfermedad = $codigoEnfermedad;

        return $this;
    }

    /**
     * Get codigoEnfermedad
     *
     * @return string 
     */
    public function getCodigoEnfermedad()
    {
        return $this->codigoEnfermedad;
    }

    /**
     * Set enfermedad
     *
     * @param string $enfermedad
     * @return Enfermedad
     */
    public function setEnfermedad($enfermedad)
    {
        $this->enfermedad = $enfermedad;

        return $this;
    }

    /**
     * Get enfermedad
     *
     * @return string 
     */
    public function getEnfermedad()
    {
        return $this->enfermedad;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return Enfermedad
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return string 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    public function __toString()
    {
         return $this->getCodigoEnfermedad().' - '.$this->getEnfermedad();
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
     * @return Enfermedad
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
