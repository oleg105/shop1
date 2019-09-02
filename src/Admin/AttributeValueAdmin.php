<?php


namespace App\Admin;


use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Repository\AttributeRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AttributeValueAdmin extends AbstractAdmin
{
    protected function  configureFormFields(FormMapper $form)
    {
        /** @var AttributeValue $attributeValue */
        $attributeValue = $this->getSubject();
        $attributeValuesWithAttributes = $this->getAttributesValues();
        $attributeValues = array_keys($attributeValuesWithAttributes);
        $choices = array_combine($attributeValues, $attributeValues);

        $form
            ->add('attribute', null, [
                'query_builder' => function (AttributeRepository $attributeRepository) use ($attributeValue) {
                    $queryBuilder = $attributeRepository->createQueryBuilder('a');
                    if ($attributeValue) {
                        $product = $attributeValue->getProduct();
                        if ( $product ) {
                            $category = $attributeValue->getProduct()->getCategory();
                            if ( $category ) {
                                $queryBuilder->where('a.category = :category')->setParameter('category', $category);
                            }
                        }
                    }
                    return $queryBuilder;
                },
                'attr' => [
                    'class' => 'js-product-attribute',
                ]
            ])
            ->add('value', ChoiceType::class, [
                'choices' => $choices,
                'choice_attr' => function ($choice, $key, $value) use ($attributeValuesWithAttributes) {
                    return [
                        'data-attribute-id' => $attributeValuesWithAttributes[$value],
                    ];
                },
                'attr' => [
                    'class' => 'js-product-attribute-value',
                ]

            ])
        ;
    }

    private function getAttributesValues() {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $em = $modelManager->getEntityManager(Attribute::class);

        /** @var AttributeRepository $repo */
        $repo = $em->getRepository(Attribute::class);
        $attributes = $repo->findAll();
        $values = [];

        foreach ($attributes as $attribute) {
            foreach ($attribute->getValuesList() as $value) {
                $values[$value] = $value;
            }
        }

        return $values;
    }
}