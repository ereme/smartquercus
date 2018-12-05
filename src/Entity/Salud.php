<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
/**
 * @ORM\Entity(repositoryClass="App\Repository\SaludRepository")
 */
class Salud
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
    private $titulo;

    /**
     * @ORM\Column(type="text")
     */
    private $texto;

    /**
     * @ORM\Column(type="date")
     */
    private $fechahora;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Imagen", orphanRemoval=true, cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $imagen;

    public function __construct()
    {
        $this->imagen = new Imagen();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }

    public function getFechahora(): ?\DateTimeInterface
    {
        return $this->fechahora;
    }

    public function setFechahora(\DateTimeInterface $fechahora): self
    {
        $this->fechahora = $fechahora;

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
