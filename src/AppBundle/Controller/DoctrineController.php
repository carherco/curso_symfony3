<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Grado;

class DoctrineController extends Controller
{
    /**
     * @Route("doctrine/create")
     */
    public function createAction()
    {
        // Podemos obtener el EntityManager a través de $this->getDoctrine()
        // o con inyección de dependencias: createAction(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $grado = new Grado();
        $grado->setNombre('Ingeniería de montes');

        // Informamos a Doctrine de que queremos guardar the Product (todavía no se ejecuta ninguna query)
        $em->persist($grado);

        // Para ejecutar las queries pendientes, se utiliza flush().
        $em->flush();

        return new Response('El id del nuevo grado creado es '.$grado->getId());
    }
    
    /**
     * @Route("doctrine/show/{gradoId}")
     */
    public function showAction($gradoId)
    {
        $grado = $this->getDoctrine()
            ->getRepository(Grado::class)
            ->find($gradoId);

        if (!$grado) {
            throw $this->createNotFoundException(
                'No se ha encontrado ningún grado con el id '.$gradoId
            );
        }
        
        return new Response('El grado buscado es '.$grado->getNombre());
    }
    
    /**
     * @Route("doctrine/delete/{gradoId}")
     */
    public function deleteAction($gradoId, EntityManagerInterface $em)
    {
        $grado = $this->getDoctrine()
            ->getRepository(Grado::class)
            ->find($gradoId);

        if (!$grado) {
            throw $this->createNotFoundException(
                'No se ha encontrado ningún grado con el id '.$gradoId
            );
        }
        
        $em->remove($grado);
        $em->flush();
        
        return new Response('Se ha borrado el grado '.$grado->getNombre());
    }

}
