<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Encuesta
 *
 * @ORM\Table(name="encuesta", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Encuesta
{
    /**
     * @var string
     *
     * @ORM\Column(name="idasignatura", type="string", length=10, nullable=false)
     */
    private $idasignatura;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=128, nullable=true)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="curso_academico", type="smallint", nullable=true)
     */
    private $cursoAcademico;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_ini", type="string", length=12, nullable=true)
     */
    private $fechaIni;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_fin", type="string", length=12, nullable=true)
     */
    private $fechaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_cierre", type="string", length=12, nullable=true)
     */
    private $fechaCierre;

    /**
     * @var string
     *
     * @ORM\Column(name="gestor", type="string", length=15, nullable=true)
     */
    private $gestor;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="smallint", nullable=true)
     */
    private $estado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modificable", type="boolean", nullable=true)
     */
    private $modificable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="anonima", type="boolean", nullable=true)
     */
    private $anonima;

    /**
     * @var boolean
     *
     * @ORM\Column(name="multiconcepto", type="boolean", nullable=true)
     */
    private $multiconcepto;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    function getIdasignatura() {
      return $this->idasignatura;
    }

    function getDescripcion() {
      return $this->descripcion;
    }

    function getCursoAcademico() {
      return $this->cursoAcademico;
    }

    function getFechaIni() {
      return $this->fechaIni;
    }

    function getFechaFin() {
      return $this->fechaFin;
    }

    function getFechaCierre() {
      return $this->fechaCierre;
    }

    function getGestor() {
      return $this->gestor;
    }

    function getEstado() {
      return $this->estado;
    }

    function getModificable() {
      return $this->modificable;
    }

    function getAnonima() {
      return $this->anonima;
    }

    function getMulticoncepto() {
      return $this->multiconcepto;
    }

    function getId() {
      return $this->id;
    }

    function setIdasignatura($idasignatura) {
      $this->idasignatura = $idasignatura;
      return $this;
    }

    function setDescripcion($descripcion) {
      $this->descripcion = $descripcion;
      return $this;
    }

    function setCursoAcademico($cursoAcademico) {
      $this->cursoAcademico = $cursoAcademico;
      return $this;
    }

    function setFechaIni($fechaIni) {
      $this->fechaIni = $fechaIni;
      return $this;
    }

    function setFechaFin($fechaFin) {
      $this->fechaFin = $fechaFin;
      return $this;
    }

    function setFechaCierre($fechaCierre) {
      $this->fechaCierre = $fechaCierre;
      return $this;
    }

    function setGestor($gestor) {
      $this->gestor = $gestor;
      return $this;
    }

    function setEstado($estado) {
      $this->estado = $estado;
      return $this;
    }

    function setModificable($modificable) {
      $this->modificable = $modificable;
      return $this;
    }

    function setAnonima($anonima) {
      $this->anonima = $anonima;
      return $this;
    }

    function setMulticoncepto($multiconcepto) {
      $this->multiconcepto = $multiconcepto;
      return $this;
    }

    function setId($id) {
      $this->id = $id;
      return $this;
    }


}

