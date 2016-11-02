<?php

namespace Siarme\AusentismoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AreaRm
 *
 * @ORM\Table(name="area_rm")
 * @ORM\Entity(repositoryClass="Siarme\AusentismoBundle\Repository\AreaRmRepository")
 */
class AreaRm
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
     * @ORM\Column(name="areaRm", type="string", length=100)
     */
    private $areaRm;

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=100)
     */
    private $rol;


    public function __toString()
    {
        return $this->getAreaRm();
    }
  

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
     * Set areaRm
     *
     * @param string $areaRm
     *
     * @return AreaRm
     */
    public function setAreaRm($areaRm)
    {
        $this->areaRm = $areaRm;

        return $this;
    }

    /**
     * Get areaRm
     *
     * @return string
     */
    public function getAreaRm()
    {
        return $this->areaRm;
    }

    /**
     * Set rol
     *
     * @param string $rol
     *
     * @return AreaRm
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }
}
