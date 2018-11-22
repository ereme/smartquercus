<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParcelaRepository")
 */
class Parcela
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
    private $numid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Localidad", inversedBy="parcelas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $localidad;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $poligono;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $parcela;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $recinto;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4)
     */
    private $superficie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SigpacUso", inversedBy="parcelas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sigpacUso;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $marcoPlantacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agrupacion", inversedBy="parcelas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agrupacion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pi;

    /**
     * @ORM\Column(type="boolean")
     */
    private $piayuda;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Variedad", inversedBy="parcelas", cascade={"persist"})
     */
    private $variedades;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tratamiento", mappedBy="parcelas")
     */
    private $tratamientos;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2, nullable=true)
     */
    private $volumenCopa;

    public function __construct()
    {
        $this->variedades = new ArrayCollection();
        $this->tratamientos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumid(): ?int
    {
        return $this->numid;
    }

    public function setNumid(int $numid): self
    {
        $this->numid = $numid;

        return $this;
    }

    public function getLocalidad(): ?Localidad
    {
        return $this->localidad;
    }

    public function setLocalidad(?Localidad $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getPoligono(): ?string
    {
        return $this->poligono;
    }

    public function setPoligono(string $poligono): self
    {
        $this->poligono = $poligono;

        return $this;
    }

    public function getParcela(): ?string
    {
        return $this->parcela;
    }

    public function setParcela(string $parcela): self
    {
        $this->parcela = $parcela;

        return $this;
    }

    public function getRecinto(): ?string
    {
        return $this->recinto;
    }

    public function setRecinto(string $recinto): self
    {
        $this->recinto = $recinto;

        return $this;
    }

    public function getSuperficie()
    {
        return $this->superficie;
    }

    public function setSuperficie($superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getSigpacUso(): ?SigpacUso
    {
        return $this->sigpacUso;
    }

    public function setSigpacUso(?SigpacUso $sigpacUso): self
    {
        $this->sigpacUso = $sigpacUso;

        return $this;
    }

    public function getMarcoPlantacion(): ?string
    {
        return $this->marcoPlantacion;
    }

    public function setMarcoPlantacion(?string $marcoPlantacion): self
    {
        $this->marcoPlantacion = $marcoPlantacion;

        return $this;
    }

    public function getAgrupacion(): ?Agrupacion
    {
        return $this->agrupacion;
    }

    public function setAgrupacion(?Agrupacion $agrupacion): self
    {
        $this->agrupacion = $agrupacion;

        return $this;
    }

    public function getPi(): ?bool
    {
        return $this->pi;
    }

    public function setPi(bool $pi): self
    {
        $this->pi = $pi;

        return $this;
    }

    public function getPiayuda(): ?bool
    {
        return $this->piayuda;
    }

    public function setPiayuda(bool $piayuda): self
    {
        $this->piayuda = $piayuda;

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
            $variedade->addParcela($this);
        }

        return $this;
    }

    public function removeVariedade(Variedad $variedade): self
    {
        if ($this->variedades->contains($variedade)) {
            $this->variedades->removeElement($variedade);
            $variedade->removeParcela($this);
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
            $tratamiento->addParcela($this);
        }

        return $this;
    }

    public function removeTratamiento(Tratamiento $tratamiento): self
    {
        if ($this->tratamientos->contains($tratamiento)) {
            $this->tratamientos->removeElement($tratamiento);
            $tratamiento->removeParcela($this);
        }

        return $this;
    }

    public function getVolumenCopa()
    {
        return $this->volumenCopa;
    }

    public function setVolumenCopa($volumenCopa): self
    {
        $this->volumenCopa = $volumenCopa;

        return $this;
    }
}
