<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AlumnoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nExpediente')
            ->add('nombre')
            ->add('apellidos')
            ->add('fechaNacimiento')
            ->add('sexo')
            ->add('email')
            ->add('telefono')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nExpediente')
            ->add('nombre')
            ->add('apellidos')
            ->add('nombreCompleto')
            ->add('fechaNacimiento')
            ->add('sexo')
            ->add('email')
            ->add('telefono')
            ->add('grado.nombre')
            ->add('grado', 'entity', array(
                'class' => 'AppBundle\Entity\Grado',
                'property' => 'nombre',
            ))
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
            ->add('nExpediente')
            ->add('nombre')
            ->add('apellidos')
            ->add('fechaNacimiento')
            ->add('sexo')
            ->add('email')
            ->add('telefono')
            ->add('grado', 'sonata_type_model', array(
                'class' => 'AppBundle\Entity\Grado',
                'property' => 'nombre',
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nExpediente')
            ->add('nombre')
            ->add('apellidos')
            ->add('fechaNacimiento')
            ->add('sexo')
            ->add('email')
            ->add('telefono')
            ->add('grado', 'entity', array(
                'class' => 'AppBundle\Entity\Grado',
                'property' => 'nombre',
            ))
        ;
    }
}
