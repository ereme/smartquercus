<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlagaRepository")
 */
class Plaga
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cultivo", inversedBy="plagas")
     */
    private $cultivos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tratamiento", mappedBy="plaga")
     */
    private $tratamientos;

    public function __construct()
    {
        $this->cultivos = new ArrayCollection();
        $this->tratamientos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Cultivo[]
     */
    public function getCultivos(): Collection
    {
        return $this->cultivos;
    }

    public function addCultivo(Cultivo $cultivo): self
    {
        if (!$this->cultivos->contains($cultivo)) {
            $this->cultivos[] = $cultivo;
        }

        return $this;
    }

    public function removeCultivo(Cultivo $cultivo): self
    {
        if ($this->cultivos->contains($cultivo)) {
            $this->cultivos->removeElement($cultivo);
        }

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
            $tratamiento->setPlaga($this);
        }

        return $this;
    }

    public function removeTratamiento(Tratamiento $tratamiento): self
    {
        if ($this->tratamientos->contains($tratamiento)) {
            $this->tratamientos->removeElement($tratamiento);
            // set the owning side to null (unless already changed)
            if ($tratamiento->getPlaga() === $this) {
                $tratamiento->setPlaga(null);
            }
        }

        return $this;
    }
}
