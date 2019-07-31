<?php


namespace App\Controller;


use App\Entity\Product;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/add-to-cart/{id}", name="order_add_to_cart")
     */
    public function addToCart(Product $product, OrderService $orderService, Request $request)
    {
        $orderService->add($product, 1);

        if($request->isXmlHttpRequest()) {
            return $this->headerCart($orderService);
        }

        return $this->redirectToRoute('default');
    }

    public function headerCart(OrderService $orderService)
    {
        $order = $orderService->getOrder();

        return $this->render('order/header_cart.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/cart", name="order_cart")
     */
    public function cart(OrderService $orderService)
    {
        $order = $orderService->getOrder();

        return $this->render('order/cart.html.twig', [
            'order' => $order,
        ]);
    }
}