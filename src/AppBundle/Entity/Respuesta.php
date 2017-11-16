<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Respuesta
 *
 * @ORM\Table(name="respuesta", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="idpregunta", columns={"idpregunta"})})
 * @ORM\Entity
 */
class Respuesta
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
     * @ORM\Column(name="descripcion", type="string", length=254, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=32, nullable=true)
     */
    private $valor;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Pregunta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pregunta", inversedBy="respuestas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idpregunta", referencedColumnName="id")
     * })
     */
    private $pregunta;

    function getOrden() {
      return $this->orden;
    }

    function getDescripcion() {
      return $this->descripcion;
    }

    function getValor() {
      return $this->valor;
    }

    function getId() {
      return $this->id;
    }

    function getPregunta() {
      return $this->pregunta;
    }

    function setOrden($orden) {
      $this->orden = $orden;
      return $this;
    }

    function setDescripcion($descripcion) {
      $this->descripcion = $descripcion;
      return $this;
    }

    function setValor($valor) {
      $this->valor = $valor;
      return $this;
    }

    function setId($id) {
      $this->id = $id;
      return $this;
    }

    function setPregunta(\AppBundle\Entity\Pregunta $pregunta) {
      $this->pregunta = $pregunta;
      return $this;
    }



}

