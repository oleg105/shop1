<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;

class ProductAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add('categories')
            ->addIdentifier('price')
            ->addIdentifier('description')
            ->add('isTop')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('name')
            ->add('categories')
            ->add('price')
            ->add('description')
            ->add('isTop')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name')
            ->add('categories', null, [
                'attr' => [
                    'class' => 'js-product-category',
                ]
            ])
            ->add('price')
            ->add('description')
            ->add('isTop')
            ->add(
                'images',
                CollectionType::class,
                [
                    'by_reference' => false
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                ]
            )
            ->add(
            'attributeValues',
            CollectionType::class,
            [
                'by_reference' => false
            ],
            [
                'edit' => 'inline',
                'inline' => 'table',
            ]
            );


        ;
    }
}