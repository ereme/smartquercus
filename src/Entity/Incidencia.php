<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncidenciaRepository")
 */
class Incidencia
{

    const ESTADO_RECIBIDO = "RECIBIDO";
    const ESTADO_ENPROCESO = "PROCESO";
    const ESTADO_COMPLETADO = "COMPLETADO";
    const ESTADO_RECHAZADO = "RECHAZADO";

    const ESTADOS = array(self::ESTADO_RECIBIDO => "RECIBIDO", 
                            self::ESTADO_ENPROCESO => "PROCESO", 
                            self::ESTADO_COMPLETADO => "COMPLETADO", 
                            self::ESTADO_RECHAZADO=> "RECHAZADO"
                        );

    const ESTADOS_COLOR = array(self::ESTADO_RECIBIDO => "primary", 
                            self::ESTADO_ENPROCESO => "warning", 
                            self::ESTADO_COMPLETADO => "success", 
                            self::ESTADO_RECHAZADO=> "danger"
                        );

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitud;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitud;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ayuntamiento", inversedBy="incidencias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ayuntamiento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getLatitud(): ?string
    {
        return $this->latitud;
    }

    public function setLatitud(string $latitud): self
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud(): ?string
    {
        return $this->longitud;
    }

    public function setLongitud(string $longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getColorEstado () {
        return self::ESTADOS_COLOR[$this->getEstado()];
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
}
