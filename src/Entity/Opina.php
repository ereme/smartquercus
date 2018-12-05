<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OpinaRepository")
 */
class Opina
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
    private $pregunta;

    /**
     * @ORM\Column(type="integer")
     */
    private $votosfavor;

    /**
     * @ORM\Column(type="integer")
     */
    private $votoscontra;

    /**
     * @ORM\Column(type="date")
     */
    private $fechahoralimite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ayuntamiento", inversedBy="encuestas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ayuntamiento;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Imagen", cascade={"all"})
     */
    private $imagen;

    public function __construct()
    {
        $this->imagen = new Imagen();
        $this->votosfavor=0;
        $this->votoscontra=0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPregunta(): ?string
    {
        return $this->pregunta;
    }

    public function setPregunta(string $pregunta): self
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    public function getVotosfavor(): ?int
    {
        return $this->votosfavor;
    }

    public function setVotosfavor(int $votosfavor): self
    {
        $this->votosfavor = $votosfavor;

        return $this;
    }

    public function subirVotosFavor () {
        $this->setVotosFavor($this->getVotosFavor() + 1);
    }

    public function bajarVotosFavor () {
        $this->setVotosFavor($this->getVotosFavor() - 1);
    }

    public function getPorcentajeFavor () {
        if (($this->votosfavor + $this->votoscontra) == 0) {
            return 0;
        } else {
            return round(100 * $this->votosfavor / ($this->votosfavor + $this->votoscontra));
        }
    }

    public function getVotoscontra(): ?int
    {
        return $this->votoscontra;
    }

    public function setVotoscontra(int $votoscontra): self
    {
        $this->votoscontra = $votoscontra;

        return $this;
    }

    public function subirVotosContra () {
        $this->setVotosContra($this->getVotosContra() + 1);
    }

    public function bajarVotosContra () {
        $this->setVotosContra($this->getVotosContra() - 1);
    }

    public function getPorcentajeContra () {
        if (($this->votosfavor + $this->votoscontra) == 0) {
            return 0;
        } else {
            return round(100 * $this->votoscontra / ($this->votosfavor + $this->votoscontra));
        }
    }

    public function getFechahoralimite(): ?\DateTimeInterface
    {
        return $this->fechahoralimite;
    }

    public function setFechahoralimite(\Date $fechahoralimite): self
    {
        $this->fechahoralimite = $fechahoralimite;

        return $this;
    }

    public function getAyuntamiento(): ?Ayuntamiento
    {
        return $this->ayuntamiento;
    }

    public function setAyuntamiento(?Ayuntamiento $ayuntamiento): self
    {
        $this->ayuntamiento = $ayuntamiento;

        return $this;
    }

    public function getImagen(): Imagen
    {
        return $this->imagen;
    }

    public function setImagen(Imagen $img): self
    {
        $this->imagen = $img;
        return $this;
    }
}
