<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 */
class Evento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $titular;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechahora;

    /**
     * @ORM\Column(type="text")
     */
    private $texto;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Imagen", orphanRemoval=true, cascade={"all"})
     */
    private $imagen;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ayuntamiento", inversedBy="eventos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ayuntamiento;


    public function __construct()
    {
        $this->imagen = new Imagen();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitular(): ?string
    {
        return $this->titular;
    }

    public function setTitular(string $titular): self
    {
        $this->titular = $titular;

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

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

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
