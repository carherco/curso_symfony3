<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultado
 *
 * @ORM\Table(name="resultado", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Resultado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idencuesta", type="integer", nullable=false)
     */
    private $idencuesta;

    /**
     * @var string
     *
     * @ORM\Column(name="idconcepto", type="string", length=255, nullable=false)
     */
    private $idconcepto;

    /**
     * @var integer
     *
     * @ORM\Column(name="idpregunta", type="integer", nullable=false)
     */
    private $idpregunta;

    /**
     * @var integer
     *
     * @ORM\Column(name="idrespuesta", type="smallint", nullable=false)
     */
    private $idrespuesta;

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
    private $fechaAuto = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

