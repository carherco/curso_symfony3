<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Asignatura
 *
 * @ORM\Table(name="asignatura")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AsignaturaRepository")
 */
class Asignatura
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
     * @var int
     *
     * @ORM\Column(name="codigo", type="integer", unique=true)
     */
    private $codigo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Grado", inversedBy="asignaturas")
     * @ORM\JoinColumn(name="grado_id", referencedColumnName="id")
     */
    private $grado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_ingles", type="string", length=255)
     */
    private $nombreIngles;

    /**
     * @var int
     *
     * @ORM\Column(name="credects", type="integer", nullable=true)
     */
    private $credects;
    
    /**
     * 
     * @ORM\ManyToMany(targetEntity="Alumno", inversedBy="asignaturas")
     * @ORM\JoinTable(name="alumnos_asignaturas")
     */
    private $alumnos;
    
    /**
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="asignatura")
     */
    private $notas;
            
    public function __construct()
    {
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
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return Asignatura
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Asignatura
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

    /**
     * Set nombreIngles
     *
     * @param string $nombreIngles
     *
     * @return Asignatura
     */
    public function setNombreIngles($nombreIngles)
    {
        $this->nombreIngles = $nombreIngles;

        return $this;
    }

    /**
     * Get nombreIngles
     *
     * @return string
     */
    public function getNombreIngles()
    {
        return $this->nombreIngles;
    }

    /**
     * Set credects
     *
     * @param integer $credects
     *
     * @return Asignatura
     */
    public function setCredects($credects)
    {
        $this->credects = $credects;

        return $this;
    }

    /**
     * Get credects
     *
     * @return int
     */
    public function getCredects()
    {
        return $this->credects;
    }
    
    function getGrado() {
      return $this->grado;
    }

    function setGrado($grado) {
      $this->grado = $grado;
      return $this;
    }
    
    function getAlumnos() {
      return $this->alumnos;
    }

    function getNotas() {
      return $this->notas;
    }

    function setAlumnos($alumnos) {
      $this->alumnos = $alumnos;
      return $this;
    }

    function setNotas($notas) {
      $this->notas = $notas;
      return $this;
    }

    public function __toString() {
      return $this->nombre;
    }
}

