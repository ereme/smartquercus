<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SigpacUsoRepository")
 */
class SigpacUso
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
     * @ORM\OneToMany(targetEntity="App\Entity\Parcela", mappedBy="sigpacUso")
     */
    private $parcelas;

    public function __construct()
    {
        $this->parcelas = new ArrayCollection();
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
     * @return Collection|Parcela[]
     */
    public function getParcelas(): Collection
    {
        return $this->parcelas;
    }

    public function addParcela(Parcela $parcela): self
    {
        if (!$this->parcelas->contains($parcela)) {
            $this->parcelas[] = $parcela;
            $parcela->setSigpacUso($this);
        }

        return $this;
    }

    public function removeParcela(Parcela $parcela): self
    {
        if ($this->parcelas->contains($parcela)) {
            $this->parcelas->removeElement($parcela);
            // set the owning side to null (unless already changed)
            if ($parcela->getSigpacUso() === $this) {
                $parcela->setSigpacUso(null);
            }
        }

        return $this;
    }
}
