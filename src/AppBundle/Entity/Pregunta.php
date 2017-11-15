<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pregunta
 *
 * @ORM\Table(name="pregunta", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Pregunta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idencuesta", type="integer", nullable=false)
     */
    private $idencuesta;

    /**
     * @var integer
     *
     * @ORM\Column(name="idbloque", type="smallint", nullable=true)
     */
    private $idbloque;

    /**
     * @var integer
     *
     * @ORM\Column(name="idtipo", type="integer", nullable=false)
     */
    private $idtipo;

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
    private $salida = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

