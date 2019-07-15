<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="category_id")
     */
    public function show($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Category #'. $id . ' not found.');
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
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
            'categories' => $categoryRepository->findAll(),
        ]);
    }


}
