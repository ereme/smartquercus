<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TratamientoRepository")
 */
class Tratamiento
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
    private $registro;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=4)
     */
    private $dosisRecomendada;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $unidades;

    /**
     * @ORM\Column(type="integer")
     */
    private $numAplicaciones;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=4)
     */
    private $dosisEmpleada;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plaga", inversedBy="tratamientos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plaga;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipo", inversedBy="tratamientos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Parcela", inversedBy="tratamientos")
     */
    private $parcelas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto", inversedBy="tratamientos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $producto;

    public function __construct()
    {
        $this->parcelas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistro(): ?int
    {
        return $this->registro;
    }

    public function setRegistro(int $registro): self
    {
        $this->registro = $registro;

        return $this;
    }

    public function getDosisRecomendada()
    {
        return $this->dosisRecomendada;
    }

    public function setDosisRecomendada($dosisRecomendada): self
    {
        $this->dosisRecomendada = $dosisRecomendada;

        return $this;
    }

    public function getUnidades(): ?string
    {
        return $this->unidades;
    }

    public function setUnidades(string $unidades): self
    {
        $this->unidades = $unidades;

        return $this;
    }

    public function getNumAplicaciones(): ?int
    {
        return $this->numAplicaciones;
    }

    public function setNumAplicaciones(int $numAplicaciones): self
    {
        $this->numAplicaciones = $numAplicaciones;

        return $this;
    }

    public function getDosisEmpleada()
    {
        return $this->dosisEmpleada;
    }

    public function setDosisEmpleada($dosisEmpleada): self
    {
        $this->dosisEmpleada = $dosisEmpleada;

        return $this;
    }

    public function getPlaga(): ?Plaga
    {
        return $this->plaga;
    }

    public function setPlaga(?Plaga $plaga): self
    {
        $this->plaga = $plaga;

        return $this;
    }

    public function getEquipo(): ?Equipo
    {
        return $this->equipo;
    }

    public function setEquipo(?Equipo $equipo): self
    {
        $this->equipo = $equipo;

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

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

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

    public function getPi() {
        foreach ($this->getParcelas() as $key => $p) {
            if ($p->getPi()) {
                return true;
            }
        }
        return false;
    }

    public function getAgrupaciones() {
        $agrupaciones = array();
        foreach ($this->getParcelas() as $key => $p) {
            if (!in_array($agrupaciones, $p->getAgrupacion())) {
                $agrupaciones = $p->getAgrupacion();
            }
        }
        return $agrupaciones;
    }
}
