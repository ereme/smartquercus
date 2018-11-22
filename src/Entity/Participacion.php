<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipacionRepository")
 */
class Participacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $rol;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="participaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Explotacion", inversedBy="participaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $explotacion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(string $rol): self
    {
        $this->rol = $rol;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
}
