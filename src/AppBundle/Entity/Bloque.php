<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bloque
 *
 * @ORM\Table(name="bloque", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Bloque
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idencuesta", type="integer", nullable=true)
     */
    private $idencuesta;

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
    private $orden = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

