<?php


// src/Entity/User.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\Column;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="El email del usuario ya está registrado")
 * @UniqueEntity(fields="username", message="El usuario ya está registrado")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $password;

    /**
     * @ORM\Column(type="array")
     */
    protected $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Imagen", orphanRemoval=true, cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $imagen;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $vatid;

    public function __construct() {
        $this->roles = array('ROLE_USER');
        $this->isActive = true;
        $this->participaciones = new ArrayCollection();
        //$this->imagen = new Imagen();
    }


    // other properties and methods

    public function getId()
    {
        return $this->id;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // Los algoritmos bcrypt y argon2i no necesitan un SALT porque ya lo llevan internamente
        // Será necesario utilizar un SALT real si se utiliza otro algoritmo
        return null;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function addRole ($role) {
        $this->roles[] = $role;
    }

    public function eraseCredentials()
    {
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

    public function isActive()
    {
        return true; //TODO: da fallo
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }


    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen(Imagen $img): self
    {
        $this->imagen = $img;
        return $this;
    }

    public function getVatid(): ?string
    {
        return $this->vatid;
    }

    public function setVatid(string $vatid): self
    {
        $this->vatid = $vatid;

        return $this;
    }

}