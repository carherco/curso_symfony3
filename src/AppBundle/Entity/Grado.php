<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Grado
 *
 * @ORM\Table(name="grado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GradoRepository")
 */
class Grado
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;
    
    /**
     * @ORM\OneToMany(targetEntity="Asignatura", mappedBy="grado")
     */
    private $asignaturas;
    
    /**
     * @ORM\OneToMany(targetEntity="Alumno", mappedBy="grado")
     */
    private $alumnos;

    public function __construct()
    {
        $this->asignaturas = new ArrayCollection();
        $this->alumnos = new ArrayCollection();
    }
    
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Grado
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    function getAsignaturas() {
      return $this->asignaturas;
    }

    function setAsignaturas($asignaturas) {
      $this->asignaturas = $asignaturas;
      return $this;
    }
    
    function getAlumnos() {
      return $this->alumnos;
    }

    function setAlumnos($alumnos) {
      $this->alumnos = $alumnos;
      return $this;
    }

}

