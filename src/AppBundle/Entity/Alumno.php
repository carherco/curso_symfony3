<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Alumno
 *
 * @ORM\Table(name="alumno")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlumnoRepository")
 */
class Alumno
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
     * @ORM\Column(name="n_expediente", type="integer", unique=true)
     */
    private $nExpediente;
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;
    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;
    /**
     * @var binary
     *
     * @ORM\Column(name="sexo", type="boolean")
     */
    private $sexo;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true, unique=true)
     */
    private $telefono;
    
    /**
     * @ORM\ManyToOne(targetEntity="Grado", inversedBy="alumnos")
     * @ORM\JoinColumn(name="grado_id", referencedColumnName="id")
     */
    private $grado;
    
    /**
     * @ORM\ManyToMany(targetEntity="Asignatura", mappedBy="alumnos")
     */
    private $asignaturas;
    
    /**
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="alumno")
     */
    private $notas;
    public function __construct()
    {
        $this->asignaturas = new ArrayCollection();
        $this->notas = new ArrayCollection();
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
     * @return Alumno
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
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Alumno
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
        return $this;
    }
    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }
    /**
     * Set nExpediente
     *
     * @param integer $nExpediente
     *
     * @return Alumno
     */
    public function setNExpediente($nExpediente)
    {
        $this->nExpediente = $nExpediente;
        return $this;
    }
    /**
     * Get nExpediente
     *
     * @return int
     */
    public function getNExpediente()
    {
        return $this->nExpediente;
    }
    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return Alumno
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
        return $this;
    }
    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }
    /**
     * Set sexo
     *
     * @param binary $sexo
     *
     * @return Alumno
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
        return $this;
    }
    /**
     * Get sexo
     *
     * @return binary
     */
    public function getSexo()
    {
        return $this->sexo;
    }
    /**
     * Set email
     *
     * @param string $email
     *
     * @return Alumno
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Alumno
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
        return $this;
    }
    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }
    
    function getGrado() {
      return $this->grado;
    }
    function getAsignaturas() {
      return $this->asignaturas;
    }
    function getNotas() {
      return $this->notas;
    }
    function setGrado($grado) {
      $this->grado = $grado;
      return $this;
    }
    function setAsignaturas($asignaturas) {
      $this->asignaturas = $asignaturas;
      return $this;
    }
    function setNotas($notas) {
      $this->notas = $notas;
      return $this;
    }
    
    public function nombreCompleto() {
      return (string)($this->nombre. " ". $this->apellidos);
    }
    
    
    public function __toString() {
      return (string)$this->nombreCompleto();
    }
}