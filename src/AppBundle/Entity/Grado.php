<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grado
 *
 * @ORM\Table(name="grado", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_B98F472A3A909126", columns={"nombre"})})
 * @ORM\Entity
 */
class Grado
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

