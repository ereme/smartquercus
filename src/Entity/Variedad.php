<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VariedadRepository")
 */
class Variedad
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Cultivo", inversedBy="variedades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cultivo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parcela", mappedBy="variedades")
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

    public function getCultivo(): ?Cultivo
    {
        return $this->cultivo;
    }

    public function setCultivo(?Cultivo $cultivo): self
    {
        $this->cultivo = $cultivo;

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
        }

        return $this;
    }

    public function removeParcela(Parcela $parcela): self
    {
        if ($this->parcelas->contains($parcela)) {
            $this->parcelas->removeElement($parcela);
        }

        return $this;
    }
}
