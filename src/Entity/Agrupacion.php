<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgrupacionRepository")
 */
class Agrupacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Explotacion", inversedBy="agrupaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $explotacion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parcela", mappedBy="agrupacion")
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

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getExplotacion(): ?Explotacion
    {
        return $this->explotacion;
    }

    public function setExplotacion(?Explotacion $explotacion): self
    {
        $this->explotacion = $explotacion;

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
            $parcela->setAgrupacion($this);
        }

        return $this;
    }

    public function removeParcela(Parcela $parcela): self
    {
        if ($this->parcelas->contains($parcela)) {
            $this->parcelas->removeElement($parcela);
            // set the owning side to null (unless already changed)
            if ($parcela->getAgrupacion() === $this) {
                $parcela->setAgrupacion(null);
            }
        }

        return $this;
    }

    public function getSuperficie ()
    {
        $sum = 0;
        foreach ($this->getParcelas() as $key => $p) {
            $sum += $p->getSuperficie(); 
        }
        return $sum;
    }

    public function getPi () {
        foreach ($this->getParcelas() as $key => $p) {
            if ($p->getPi()) {
                return true;
            }
        }
        return false;
    }
}
