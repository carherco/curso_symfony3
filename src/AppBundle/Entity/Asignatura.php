<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asignatura
 *
 * @ORM\Table(name="asignatura", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_9243D6CE20332D99", columns={"codigo"})}, indexes={@ORM\Index(name="IDX_9243D6CE91A441CC", columns={"grado_id"})})
 * @ORM\Entity
 */
class Asignatura
{
    /**
     * @var integer
     *
     * @ORM\Column(name="codigo", type="integer", nullable=false)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_ingles", type="string", length=255, nullable=false)
     */
    private $nombreIngles;

    /**
     * @var integer
     *
     * @ORM\Column(name="credects", type="integer", nullable=true)
     */
    private $credects;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Grado
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Grado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grado_id", referencedColumnName="id")
     * })
     */
    private $grado;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Alumno", inversedBy="asignatura")
     * @ORM\JoinTable(name="alumnos_asignaturas",
     *   joinColumns={
     *     @ORM\JoinColumn(name="asignatura_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="alumno_id", referencedColumnName="id")
     *   }
     * )
     */
    private $alumno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alumno = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

