<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AsignaturaAdmin extends AbstractAdmin
{
    protected $parentAssociationMapping = 'grado';

    protected function configureRoutes(RouteCollection $collection)
    {
        if ($this->isChild()) {

            // This is the route configuration as a child
            //$collection->clearExcept(['show', 'edit']);

            return;
        }

        // This is the route configuration as a parent
        //$collection->clear();

    }
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('codigo')
            ->add('nombre')
            ->add('nombreIngles')
            ->add('credects')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('codigo')
            ->add('nombre')
            ->add('nombreIngles')
            ->add('credects')
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
            ->add('codigo')
            ->add('nombre')
            ->add('nombreIngles')
            ->add('credects')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('codigo')
            ->add('nombre')
            ->add('nombreIngles')
            ->add('credects')
        ;
    }
}
