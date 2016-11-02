<?php

namespace Siarme\AusentismoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * DepartamentoRm
 *
 * @ORM\Table(name="departamento_rm")
 * @ORM\Entity(repositoryClass="Siarme\AusentismoBundle\Repository\DepartamentoRmRepository")
 */
class DepartamentoRm
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
     * @ORM\Column(name="departamento_nombre", type="string", length=50)
     */    
    private $departamentoRm;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\ExpedienteBundle\Entity\Tramite", mappedBy="departamentoRm") 
     */
    private $tramite;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\ExpedienteBundle\Entity\Expediente", mappedBy="departamentoRm") 
     */
    private $expediente;


    /** 
     *@ORM\OneToMany(targetEntity="Siarme\UsuarioBundle\Entity\Usuario", mappedBy="departamentoRm") 
     */
    private $usuario;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }



    public function __construct()
    {
        $this->tramite = new ArrayCollection();
    }

    /**
     * Add tramite
     *
     * @param \Siarme\ExpedienteBundle\Entity\Tramite $tramite
     * @return DepartamentoRm
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
     * Add usuario
     *
     * @param \Siarme\UsuarioBundle\Entity\Usuario $usuario
     * @return DepartamentoRm
     */
    public function addUsuario(\Siarme\UsuarioBundle\Entity\Usuario $usuario)
    {
        $this->usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \Siarme\UsuarioBundle\Entity\Usuario $usuario
     */
    public function removeUsuario(\Siarme\UsuarioBundle\Entity\Usuario $usuario)
    {
        $this->usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

  

    public function __toString()
    {
      return  $this->getDepartamentoRm();
    }
    

    /**
     * Set departamentoRm
     *
     * @param string $departamentoRm
     *
     * @return DepartamentoRm
     */
    public function setDepartamentoRm($departamentoRm)
    {
        $this->departamentoRm = $departamentoRm;

        return $this;
    }

    /**
     * Get departamentoRm
     *
     * @return string
     */
    public function getDepartamentoRm()
    {
        return $this->departamentoRm;
    }

    /**
     * Add expediente
     *
     * @param \Siarme\ExpedienteBundle\Entity\Expediente $expediente
     *
     * @return DepartamentoRm
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
}
