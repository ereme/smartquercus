<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class Vecino extends User
{

    const USER_VECINO = "VECINO";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $apellido1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $apellido2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ayuntamiento", inversedBy="vecinos")
     */
    private $ayuntamiento;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Opina", inversedBy="vecinos")
     */
    private $opinas;

    

    public function __construct()
    {
        parent::__construct();
        $this->roles = array('ROLE_VECINO');
        $this->isActive = true;
        $this->opinas = new ArrayCollection();
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

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): self
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(string $apellido2): self
    {
        $this->apellido2 = $apellido2;

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

    /**
     * @return Collection|Opina[]
     */
    public function getOpinas(): Collection
    {
        return $this->opinas;
    }

    public function addOpina(Opina $opina): self
    {
        if (!$this->opinas->contains($opina)) {
            $this->opinas[] = $opina;
        }

        return $this;
    }

    public function removeOpina(Opina $opina): self
    {
        if ($this->opinas->contains($opina)) {
            $this->opinas->removeElement($opina);
        }

        return $this;
    }


}
