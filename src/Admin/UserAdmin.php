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
            ->addIdentifier('first_name')
            ->addIdentifier('last_name')
            ->addIdentifier('address')
            ->addIdentifier('is_email_checked')
            ->addIdentifier('email_check_code')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('first_name')
            ->add('last_name')
            ->add('address')
            ->add('is_email_checked')
            ->add('email_check_code')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('first_name')
            ->add('last_name')
            ->add('address')
            ->add('is_email_checked')
        ;
    }
}