<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bloque
 *
 * @ORM\Table(name="bloque", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="idencuesta", columns={"idencuesta"})})
 * @ORM\Entity
 */
class Bloque
{
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=254, nullable=true)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", nullable=false)
     */
    private $orden;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Encuesta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Encuesta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idencuesta", referencedColumnName="id")
     * })
     */
    private $encuesta;
    
    function getDescripcion() {
      return $this->descripcion;
    }

    function getOrden() {
      return $this->orden;
    }

    function getId() {
      return $this->id;
    }

    function getEncuesta() {
      return $this->encuesta;
    }

    function setDescripcion($descripcion) {
      $this->descripcion = $descripcion;
      return $this;
    }

    function setOrden($orden) {
      $this->orden = $orden;
      return $this;
    }

    function setId($id) {
      $this->id = $id;
      return $this;
    }

    function setEncuesta(\AppBundle\Entity\Encuesta $encuesta) {
      $this->encuesta = $encuesta;
      return $this;
    }


    
}

