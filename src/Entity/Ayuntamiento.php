<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AyuntamientoRepository")
 */
class Ayuntamiento extends User
{

    const USER_AYTO = "AYTO";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagenescudo;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $localidad;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Telefono", mappedBy="ayto")
     */
    private $telefonos;

    /** 
     * @ORM\OneToMany(targetEntity="App\Entity\Opina", mappedBy="ayuntamiento")
     */
    private $encuestas;

    public function __construct()
    {
        parent::__construct();
        $this->telefonos = new ArrayCollection();
        $this->roles = array('ROLE_AYTO');
        $this->isActive = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagenescudo(): ?string
    {
        return $this->imagenescudo;
    }

    public function setImagenescudo(string $imagenescudo): self
    {
        $this->imagenescudo = $imagenescudo;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * @return Collection|Telefono[]
     */
    public function getTelefonos(): Collection
    {
        return $this->telefonos;
    }

    public function addTelefono(Telefono $telefono): self
    {
        if (!$this->telefonos->contains($telefono)) {
            $this->telefonos[] = $telefono;
            $telefono->setAytoid($this);
        }

        return $this;
    }

    public function removeTelefono(Telefono $telefono): self
    {
        if ($this->telefonos->contains($telefono)) {
            $this->telefonos->removeElement($telefono);
            // set the owning side to null (unless already changed)
            if ($telefono->getAytoid() === $this) {
                $telefono->setAytoid(null);
            }
        }

        return $this;
    }

<<<<<<< HEAD
    /**
     * @return Collection|Opina[]
     */
    public function getEncuestas(): Collection
    {
        return $this->encuestas;
    }

    public function addEncuesta(Opina $encuesta): self
    {
        if (!$this->encuestas->contains($encuesta)) {
            $this->encuestas[] = $encuesta;
            $encuesta->setAyuntamiento($this);
        }

        return $this;
    }

    public function removeEncuesta(Opina $encuesta): self
    {
        if ($this->encuestas->contains($encuesta)) {
            $this->encuestas->removeElement($encuesta);
            // set the owning side to null (unless already changed)
            if ($encuesta->getAyuntamiento() === $this) {
                $encuesta->setAyuntamiento(null);
            }
        }

        return $this;
    }
=======

    
>>>>>>> c6f709b95a55c66a21bafc3f813f77a013c1622f
}
