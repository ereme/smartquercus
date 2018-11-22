<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductoRepository")
 */
class Producto
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
     * @ORM\Column(type="string", length=255)
     */
    private $principio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tratamiento", mappedBy="producto")
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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPrincipio(): ?string
    {
        return $this->principio;
    }

    public function setPrincipio(string $principio): self
    {
        $this->principio = $principio;

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
            $tratamiento->setProducto($this);
        }

        return $this;
    }

    public function removeTratamiento(Tratamiento $tratamiento): self
    {
        if ($this->tratamientos->contains($tratamiento)) {
            $this->tratamientos->removeElement($tratamiento);
            // set the owning side to null (unless already changed)
            if ($tratamiento->getProducto() === $this) {
                $tratamiento->setProducto(null);
            }
        }

        return $this;
    }
}
