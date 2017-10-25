<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Nota
 *
 * @ORM\Table(name="nota")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotaRepository")
 */
class Nota
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Alumno", inversedBy="notas")
     * @ORM\JoinColumn(name="alumno_id", referencedColumnName="id")
     */
    private $alumno;

    /**
     * @ORM\ManyToOne(targetEntity="Asignatura", inversedBy="notas")
     * @ORM\JoinColumn(name="asignatura_id", referencedColumnName="id")
     */
    private $asignatura;

    /**
     * @var int
     *
     * @ORM\Column(name="n_convocatoria", type="integer")
     */
    private $nConvocatoria;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="nota", type="float")
     */
    private $nota;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set alumno
     *
     * @param Alumno $alumno
     *
     * @return Nota
     */
    public function setAlumno($alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return Alumno
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set asignatura
     *
     * @param Asignatura $asignatura
     *
     * @return Nota
     */
    public function setAsignatura($asignatura)
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    /**
     * Get asignatura
     *
     * @return Asignatura
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set nConvocatoria
     *
     * @param integer $nConvocatoria
     *
     * @return Nota
     */
    public function setNConvocatoria($nConvocatoria)
    {
        $this->nConvocatoria = $nConvocatoria;

        return $this;
    }

    /**
     * Get nConvocatoria
     *
     * @return int
     */
    public function getNConvocatoria()
    {
        return $this->nConvocatoria;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Nota
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set nota
     *
     * @param float $nota
     *
     * @return Nota
     */
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Get nota
     *
     * @return float
     */
    public function getNota()
    {
        return $this->nota;
    }
}

