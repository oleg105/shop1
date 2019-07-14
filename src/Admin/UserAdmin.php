<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('email')
            ->addIdentifier('roles')
            ->addIdentifier('password')
            ->addIdentifier('firstName')
            ->addIdentifier('lastName')
            ->addIdentifier('address')
            ->addIdentifier('isEmailChecked')
            ->addIdentifier('emailCheckCode')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('address')
            ->add('isEmailChecked')
            ->add('emailCheckCode')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('email')
//            ->add('roles')
//            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('address')
            ->add('isEmailChecked')
        ;
    }
}