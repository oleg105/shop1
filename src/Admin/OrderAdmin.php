<?php


namespace App\Admin;


use App\Form\MoneyTransformer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OrderAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('id')
            ->addIdentifier('id')
            ->addIdentifier('id')
            ->addIdentifier('id')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('id')
            ->add('id')
            ->add('id')
            ->add('id')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('orderedAt')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('address')
            ->add('amount', null, [
                'attr' => [
                    'readonly' => true,
                ]
            ])
            ->add(
                'items',
                CollectionType::class,
                [
                    'by_reference' => false
                ],
                [
                    'edit' => 'inline'

                ]

            )
        ;

        $form->get('amount')->addModelTransformer(new MoneyTransformer());
    }

    public function  createQuery($context = 'list')
    {
        /**
         * @var QueryBuilder $query
         */
        $query = parent::createQuery($context);
        list($rootAlias) = $query->getRootAliases();

        $query->andWhere($rootAlias . '.orderedAt IS NOT NULL');

        return $query;
    }
}
