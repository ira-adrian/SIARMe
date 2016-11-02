<?php

// src/Siarme/UsuarioBundle/Entity/Usuario.php

namespace Siarme\UsuarioBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
/**
 * Siarme\UsuarioBundle\Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="Siarme\UsuarioBundle\Repository\UsuarioRepository")
 * @DoctrineAssert\UniqueEntity("usuario")
 *
 */
class Usuario implements AdvancedUserInterface, \Serializable

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
     * @ORM\Column(name="apellido_nombre", type="string", length=100)
     *
     * @Assert\NotBlank(message = "Por favor, escribe tu nombre")
     */

    private $apellidoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=20, unique=true)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var int
     *
     * @ORM\Column(name="dni", type="integer", unique=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=20)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_movil", type="string", length=20)
     */
    private $telefonoMovil;

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=50)
     */
    private $rol;
    

    /**
     * @var bool
     *
     * @ORM\Column(name="es_activo", type="boolean")
     */
    private $esActivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_crea", type="datetime")
     */
    private $fechaCrea;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modifica", type="datetime")
     */
    private $fechaModifica;
 
    /** 
    * @ORM\ManyToOne(targetEntity="Siarme\AusentismoBundle\Entity\DepartamentoRm" , inversedBy="usuario") 
    * @ORM\JoinColumn(name="departamento_rm_id", referencedColumnName="id")
    */
    private $departamentoRm;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\DocumentoBundle\Entity\DocMedico", mappedBy="usuario") 
     */
    private $docMedico;

    /** 
     *@ORM\OneToMany(targetEntity="Siarme\DocumentoBundle\Entity\DocAdministrativo", mappedBy="usuario") 
     */
    private $docAdministrativo;

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
     * @return Usuario
     */
    public function setApellidoNombre($apellidoNombre)
    {
        $this->apellidoNombre = $apellidoNombre;

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
     * Set usuario
     *
     * @param string $usuario
     * @return Usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Usuario
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set dni
     *
     * @param integer $dni
     * @return Usuario
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
     * Set telefono
     *
     * @param string $telefono
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set telefonoMovil
     *
     * @param string $telefonoMovil
     * @return Usuario
     */
    public function setTelefonoMovil($telefonoMovil)
    {
        $this->telefonoMovil = $telefonoMovil;

        return $this;
    }

    /**
     * Get telefonoMovil
     *
     * @return string 
     */
    public function getTelefonoMovil()
    {
        return $this->telefonoMovil;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * @return Usuario
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


    public function __toString()
    {
        return $this->getApellidoNombre();
    }

 

    /**
     * Set departamentoRm
     *
     * @param \Siarme\AusentismoBundle\Entity\DepartamentoRm $departamentoRm
     * @return Usuario
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
     * Constructor
     */
    public function __construct()
    {
        $this->docMedico = new \Doctrine\Common\Collections\ArrayCollection();
        $this->docAdministrativo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->esActivo=true;
    }

    /**
     * Add docMedico
     *
     * @param \Siarme\DocumentoBundle\Entity\DocMedico $docMedico
     * @return Usuario
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
     * @return Usuario
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
     * Método requerido por la interfaz UserInterface
     */
    public function eraseCredentials()
    {
        return null;

    }

    /**
     * Método requerido por la interfaz UserInterface
     */
    public function getRoles()
    {
        return array($this->rol);
    }

    /**
     * Método requerido por la interfaz UserInterface
     */
    public function getUsername()
    {
        return $this->getUsuario();
    }
    /**
     * Método requerido por la interfaz UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->esActivo;
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->usuario,
            $this->password,
            $this->esActivo,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->usuario,
            $this->password,
            $this->esActivo,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    /**
     * Set esActivo
     *
     * @param boolean $esActivo
     *
     * @return Usuario
     */
    public function setEsActivo($esActivo)
    {
        $this->esActivo = $esActivo;

        return $this;
    }

    /**
     * Get esActivo
     *
     * @return boolean
     */
    public function getEsActivo()
    {
        return $this->esActivo;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return Usuario
     */
    public function setFechaCrea($fechaCrea)
    {
        $this->fechaCrea = $fechaCrea;

        return $this;
    }

    /**
     * Get fechaCrea
     *
     * @return \DateTime
     */
    public function getFechaCrea()
    {
        return $this->fechaCrea;
    }

    /**
     * Set fechaModifica
     *
     * @param \DateTime $fechaModifica
     *
     * @return Usuario
     */
    public function setFechaModifica($fechaModifica)
    {
        $this->fechaModifica = $fechaModifica;

        return $this;
    }

    /**
     * Get fechaModifica
     *
     * @return \DateTime
     */
    public function getFechaModifica()
    {
        return $this->fechaModifica;
    }
}
