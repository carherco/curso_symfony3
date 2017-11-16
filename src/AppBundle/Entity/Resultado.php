<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultado
 *
 * @ORM\Table(name="resultado", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="idencuesta", columns={"idencuesta"}), @ORM\Index(name="idpregunta", columns={"idpregunta"}), @ORM\Index(name="idrespuesta", columns={"idrespuesta"})})
 * @ORM\Entity
 */
class Resultado
{
    /**
     * @var string
     *
     * @ORM\Column(name="idconcepto", type="string", length=255, nullable=false)
     */
    private $idconcepto;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=15, nullable=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="text", length=65535, nullable=true)
     */
    private $valor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_auto", type="datetime", nullable=true)
     */
    private $fechaAuto;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Respuesta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Respuesta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idrespuesta", referencedColumnName="id")
     * })
     */
    private $respuesta;

    /**
     * @var \AppBundle\Entity\Pregunta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pregunta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idpregunta", referencedColumnName="id")
     * })
     */
    private $pregunta;

    /**
     * @var \AppBundle\Entity\Encuesta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Encuesta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idencuesta", referencedColumnName="id")
     * })
     */
    private $encuesta;

    function getIdconcepto() {
      return $this->idconcepto;
    }

    function getDni() {
      return $this->dni;
    }

    function getValor() {
      return $this->valor;
    }

    function getFechaAuto() {
      return $this->fechaAuto;
    }

    function getId() {
      return $this->id;
    }

    function getRespuesta() {
      return $this->respuesta;
    }

    function getPregunta() {
      return $this->pregunta;
    }

    function getEncuesta() {
      return $this->encuesta;
    }

    function setIdconcepto($idconcepto) {
      $this->idconcepto = $idconcepto;
      return $this;
    }

    function setDni($dni) {
      $this->dni = $dni;
      return $this;
    }

    function setValor($valor) {
      $this->valor = $valor;
      return $this;
    }

    function setFechaAuto(\DateTime $fechaAuto) {
      $this->fechaAuto = $fechaAuto;
      return $this;
    }

    function setId($id) {
      $this->id = $id;
      return $this;
    }

    function setRespuesta(\AppBundle\Entity\Respuesta $respuesta) {
      $this->respuesta = $respuesta;
      return $this;
    }

    function setPregunta(\AppBundle\Entity\Pregunta $pregunta) {
      $this->pregunta = $pregunta;
      return $this;
    }

    function setEncuesta(\AppBundle\Entity\Encuesta $encuesta) {
      $this->encuesta = $encuesta;
      return $this;
    }


}

