<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pregunta
 *
 * @ORM\Table(name="pregunta", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="idencuesta", columns={"idencuesta"}), @ORM\Index(name="idbloque", columns={"idbloque"}), @ORM\Index(name="idtipo", columns={"idtipo"})})
 * @ORM\Entity
 */
class Pregunta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="smallint", nullable=false)
     */
    private $orden;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=254, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="pie", type="string", length=254, nullable=true)
     */
    private $pie;

    /**
     * @var integer
     *
     * @ORM\Column(name="salida", type="integer", nullable=false)
     */
    private $salida;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\TipoPregunta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoPregunta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtipo", referencedColumnName="id")
     * })
     */
    private $tipo;

    /**
     * @var \AppBundle\Entity\Bloque
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bloque")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idbloque", referencedColumnName="id")
     * })
     */
    private $bloque;

    /**
     * @var \AppBundle\Entity\Encuesta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Encuesta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idencuesta", referencedColumnName="id")
     * })
     */
    private $encuesta;

    function getOrden() {
      return $this->orden;
    }

    function getDescripcion() {
      return $this->descripcion;
    }

    function getPie() {
      return $this->pie;
    }

    function getSalida() {
      return $this->salida;
    }

    function getId() {
      return $this->id;
    }

    function getTipo() {
      return $this->tipo;
    }

    function getBloque() {
      return $this->bloque;
    }

    function getEncuesta() {
      return $this->encuesta;
    }

    function setOrden($orden) {
      $this->orden = $orden;
      return $this;
    }

    function setDescripcion($descripcion) {
      $this->descripcion = $descripcion;
      return $this;
    }

    function setPie($pie) {
      $this->pie = $pie;
      return $this;
    }

    function setSalida($salida) {
      $this->salida = $salida;
      return $this;
    }

    function setId($id) {
      $this->id = $id;
      return $this;
    }

    function setTipo(\AppBundle\Entity\TipoPregunta $tipo) {
      $this->tipo = $tipo;
      return $this;
    }

    function setBloque(\AppBundle\Entity\Bloque $bloque) {
      $this->bloque = $bloque;
      return $this;
    }

    function setEncuesta(\AppBundle\Entity\Encuesta $encuesta) {
      $this->encuesta = $encuesta;
      return $this;
    }



}

