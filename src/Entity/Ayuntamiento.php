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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Imagen", orphanRemoval=true, cascade={"all"})
     */
    private $imagen;

    /*
     * @ORM\OneToMany(targetEntity="App\Entity\Vecino", mappedBy="ayuntamiento")
     */
    private $vecinos;

    public function __construct()
    {
        parent::__construct();
        $this->telefonos = new ArrayCollection();
        $this->roles = array('ROLE_AYTO');
        $this->isActive = true;
        $this->encuestas = new ArrayCollection();
        $this->vecinos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id; 
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

    public function getImagen(): ?Imagen
    {
        return $this->imagen;
    }

    public function setImagen(?Imagen $imagen): self
    {
        $this->imagen = $imagen;

    /**
     * @return Collection|Vecino[]
     */
    public function getVecinos(): Collection
    {
        return $this->vecinos;
    }

    public function addVecino(Vecino $vecino): self
    {
        if (!$this->vecinos->contains($vecino)) {
            $this->vecinos[] = $vecino;
            $vecino->setAyuntamiento($this);
        }

        return $this;
    }

    public function removeVecino(Vecino $vecino): self
    {
        if ($this->vecinos->contains($vecino)) {
            $this->vecinos->removeElement($vecino);
            // set the owning side to null (unless already changed)
            if ($vecino->getAyuntamiento() === $this) {
                $vecino->setAyuntamiento(null);
            }
        }

        return $this;
    }
}
