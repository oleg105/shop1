<?php


namespace App\Controller;


use App\Entity\OrderItem;
use App\Entity\Product;
use App\Form\OrderType;
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
        $orderService->add($product, 1, $this->getUser());

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

    /**
     * @Route("/cart/{id}/count", name="order_set_count")
     */
    public function setCount(OrderItem $item, OrderService $orderService, Request $request)
    {
        $count = $request->request->getInt('count');
        $order = $orderService->getOrder();

        if ($count > 0 && $item->getCart() === $order) {
            $item->setCount($count);
            $orderService->save($item->getCart(), $this->getUser());
        }

        return $this->render('order/_cart_table.html.twig', [
            'order' => $item->getCart(),
        ]);
    }

    /**
     * @Route("/cart/{id}/delete", name="order_delete_item")
     */
    public function deleteItem(OrderItem $item, OrderService $orderService)
    {
        $order = $orderService->getOrder();

        if ($item->getCart() === $order) {
            $orderService->deleteItem($item);
        }

        return $this->render('order/_cart_table.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("cart/order", name="order_make_order")
     */
    public function makeOrder(OrderService $orderService, Request $request)
    {
        $order = $orderService->getOrder();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $orderService->makeOrder($order);

            return $this->redirectToRoute('order_success');
        }

        return $this->render('order/make_order.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/order/success", name="order_success")
     */
    public function orderSuccess()
    {
        return $this->render('order/success.html.twig');
    }
}