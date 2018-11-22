<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExplotacionRepository")
 */
class Explotacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $rexa;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $roppi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Agrupacion", mappedBy="explotacion")
     */
    private $agrupaciones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participacion", mappedBy="explotacion", cascade={"persist"}, orphanRemoval=true)
     */
    private $participaciones;

    public function __construct()
    {
        $this->agrupaciones = new ArrayCollection();
        $this->participaciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRexa(): ?string
    {
        return $this->rexa;
    }

    public function setRexa(string $rexa): self
    {
        $this->rexa = $rexa;

        return $this;
    }

    public function getRoppi(): ?string
    {
        return $this->roppi;
    }

    public function setRoppi(string $roppi): self
    {
        $this->roppi = $roppi;

        return $this;
    }

    /**
     * @return Collection|Agrupacion[]
     */
    public function getAgrupaciones(): Collection
    {
        return $this->agrupaciones;
    }

    public function addAgrupacione(Agrupacion $agrupacione): self
    {
        if (!$this->agrupaciones->contains($agrupacione)) {
            $this->agrupaciones[] = $agrupacione;
            $agrupacione->setExplotacion($this);
        }

        return $this;
    }

    public function removeAgrupacione(Agrupacion $agrupacione): self
    {
        if ($this->agrupaciones->contains($agrupacione)) {
            $this->agrupaciones->removeElement($agrupacione);
            // set the owning side to null (unless already changed)
            if ($agrupacione->getExplotacion() === $this) {
                $agrupacione->setExplotacion(null);
            }
        }

        return $this;
    }

    public function getSuperficie ()
    {
        $sum = 0;
        foreach ($this->getAgrupaciones() as $key => $a) {
            $sum += $a->getSuperficie(); 
        }
        return $sum;
    }

    public function isOwner (User $user): bool
    {
        return $this->getUsers()->contains($user);
    }

    /**
     * @return Collection|Participacion[]
     */
    public function getParticipaciones(): Collection
    {
        return $this->participaciones;
    }

    public function addParticipacione(Participacion $participacione): self
    {
        if (!$this->participaciones->contains($participacione)) {
            $this->participaciones[] = $participacione;
            $participacione->setExplotacion($this);
        }

        return $this;
    }

    public function removeParticipacione(Participacion $participacione): self
    {
        if ($this->participaciones->contains($participacione)) {
            $this->participaciones->removeElement($participacione);
            // set the owning side to null (unless already changed)
            if ($participacione->getExplotacion() === $this) {
                $participacione->setExplotacion(null);
            }
        }

        return $this;
    }
}
