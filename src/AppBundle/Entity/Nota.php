<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nota
 *
 * @ORM\Table(name="nota", indexes={@ORM\Index(name="IDX_C8D03E0DFC28E5EE", columns={"alumno_id"}), @ORM\Index(name="IDX_C8D03E0DC5C70C5B", columns={"asignatura_id"})})
 * @ORM\Entity
 */
class Nota
{
    /**
     * @var integer
     *
     * @ORM\Column(name="n_convocatoria", type="integer", nullable=false)
     */
    private $nConvocatoria;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="nota", type="float", precision=10, scale=0, nullable=false)
     */
    private $nota;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Alumno
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Alumno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="alumno_id", referencedColumnName="id")
     * })
     */
    private $alumno;

    /**
     * @var \AppBundle\Entity\Asignatura
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Asignatura")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asignatura_id", referencedColumnName="id")
     * })
     */
    private $asignatura;


}

