<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function show(Category $category, ProductRepository $productRepository, Request $request)
    {
        $form = $this->getSearchForm($category);
        $form->handleRequest($request);
        $products = $productRepository->findByFilter($category, $form->getData());

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'products' => $products,
        ]);
    }


//    /**
//     * @Route("/category/{id}", name="category_id")
//     */
//    public function show(Category $category)
//    {
//        return $this->render('category/show.html.twig', [
//            'category' => $category,
//        ]);
//    }


    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->findAll();


        return $this->render('category/index.html.twig',
            [
                'categories' => $category,
            ]
        );
    }

    public function headerList(CategoryRepository $categoryRepository) {

        return $this->render('category/_header_list.html.twig', [
            'categories' => $categoryRepository->findBy(['parent' => null]),
        ]);
    }

    private function getSearchForm(Category $category)
    {
        $formBuilder = $this->createFormBuilder([]);
        $formBuilder->setMethod('GET');

        foreach ($category->getAttributes() as $attribute) {
            $values = $attribute->getValuesList();
            $choices = array_combine($values, $values);

            $formBuilder->add('attr'. $attribute->getId(), ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => $choices,
                'label' => $attribute->getName(),
            ]);
        }

        return $formBuilder->getForm();
    }

}
