<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CultivoRepository")
 */
class Cultivo
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
     * @ORM\OneToMany(targetEntity="App\Entity\Variedad", mappedBy="cultivo")
     */
    private $variedades;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Plaga", mappedBy="cultivos")
     */
    private $plagas;

    public function __construct()
    {
        $this->variedades = new ArrayCollection();
        $this->plagas = new ArrayCollection();
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
     * @return Collection|Variedad[]
     */
    public function getVariedades(): Collection
    {
        return $this->variedades;
    }

    public function addVariedade(Variedad $variedade): self
    {
        if (!$this->variedades->contains($variedade)) {
            $this->variedades[] = $variedade;
            $variedade->setCultivo($this);
        }

        return $this;
    }

    public function removeVariedade(Variedad $variedade): self
    {
        if ($this->variedades->contains($variedade)) {
            $this->variedades->removeElement($variedade);
            // set the owning side to null (unless already changed)
            if ($variedade->getCultivo() === $this) {
                $variedade->setCultivo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Plaga[]
     */
    public function getPlagas(): Collection
    {
        return $this->plagas;
    }

    public function addPlaga(Plaga $plaga): self
    {
        if (!$this->plagas->contains($plaga)) {
            $this->plagas[] = $plaga;
            $plaga->addCultivo($this);
        }

        return $this;
    }

    public function removePlaga(Plaga $plaga): self
    {
        if ($this->plagas->contains($plaga)) {
            $this->plagas->removeElement($plaga);
            $plaga->removeCultivo($this);
        }

        return $this;
    }
}
