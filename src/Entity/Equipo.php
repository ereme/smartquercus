<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipoRepository")
 */
class Equipo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capacidad;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $roma;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaAdquisicion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaUltimaInspeccion;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $bastidor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tratamiento", mappedBy="equipo")
     */
    private $tratamientos;

    public function __construct()
    {
        $this->tratamientos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCapacidad(): ?int
    {
        return $this->capacidad;
    }

    public function setCapacidad(?int $capacidad): self
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    public function getRoma(): ?string
    {
        return $this->roma;
    }

    public function setRoma(?string $roma): self
    {
        $this->roma = $roma;

        return $this;
    }

    public function getFechaAdquisicion(): ?\DateTimeInterface
    {
        return $this->fechaAdquisicion;
    }

    public function setFechaAdquisicion(?\DateTimeInterface $fechaAdquisicion): self
    {
        $this->fechaAdquisicion = $fechaAdquisicion;

        return $this;
    }

    public function getFechaUltimaInspeccion(): ?\DateTimeInterface
    {
        return $this->fechaUltimaInspeccion;
    }

    public function setFechaUltimaInspeccion(?\DateTimeInterface $fechaUltimaInspeccion): self
    {
        $this->fechaUltimaInspeccion = $fechaUltimaInspeccion;

        return $this;
    }

    public function getBastidor(): ?string
    {
        return $this->bastidor;
    }

    public function setBastidor(?string $bastidor): self
    {
        $this->bastidor = $bastidor;

        return $this;
    }

    /**
     * @return Collection|Tratamiento[]
     */
    public function getTratamientos(): Collection
    {
        return $this->tratamientos;
    }

    public function addTratamiento(Tratamiento $tratamiento): self
    {
        if (!$this->tratamientos->contains($tratamiento)) {
            $this->tratamientos[] = $tratamiento;
            $tratamiento->setEquipo($this);
        }

        return $this;
    }

    public function removeTratamiento(Tratamiento $tratamiento): self
    {
        if ($this->tratamientos->contains($tratamiento)) {
            $this->tratamientos->removeElement($tratamiento);
            // set the owning side to null (unless already changed)
            if ($tratamiento->getEquipo() === $this) {
                $tratamiento->setEquipo(null);
            }
        }

        return $this;
    }
}
