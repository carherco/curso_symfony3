<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alumno
 *
 * @ORM\Table(name="alumno", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1435D52D67E69CFE", columns={"n_expediente"}), @ORM\UniqueConstraint(name="UNIQ_1435D52DE7927C74", columns={"email"}), @ORM\UniqueConstraint(name="UNIQ_1435D52DC1E70A7F", columns={"telefono"})}, indexes={@ORM\Index(name="IDX_1435D52D91A441CC", columns={"grado_id"})})
 * @ORM\Entity
 */
class Alumno
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="n_expediente", type="integer", nullable=false)
     */
    private $nExpediente;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255, nullable=false)
     */
    private $apellidos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sexo", type="boolean", nullable=false)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Asignatura", mappedBy="alumno")
     */
    private $asignatura;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asignatura = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

