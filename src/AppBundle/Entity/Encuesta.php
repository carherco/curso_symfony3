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
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

