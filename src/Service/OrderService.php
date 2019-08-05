<?php


namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderService
{
    const SESSION_KEY = 'currentOrder';

    /**
     * @var EntityManagerInterface
     */
    private $entityMenager;

    /**
     * @var SessionInterface
     */
    private $sessions;

    private $orderRepo;

    public function __construct(
        EntityManagerInterface $entityMenager,
        SessionInterface $sessions,
        OrderRepository $orderRepo
    )
    {
        $this->entityMenager = $entityMenager;
        $this->sessions = $sessions;
        $this->orderRepo = $orderRepo;
    }

    public function getOrder()
    {
        $order = null;
        $orderId = $this->sessions->get(self::SESSION_KEY);

        if($orderId) {
            $order = $this->orderRepo->find($orderId);
        }

        if(!$order) {
            $order = new Order();
        }

        return $order;
    }

    public function add(Product $product, int $count): Order
    {
        $order = $this->getOrder();
        $existingItem = null;

        foreach ($order->getItems() as $item) {
            if($item -> getProduct() === $product) {
                $existingItem = $item;
                break;
            }
        }

        if ($existingItem) {
            $newCount = $existingItem->getCount() + $count;
            $existingItem->setCount($newCount);
        } else {
            $existingItem = new OrderItem();
            $existingItem->setProduct($product);
            $existingItem->setCount($count);
            $order->addItem($existingItem);

        }

        $this->save($order);

        return $order;

    }

    public function save(Order $order)
    {
        $this->entityMenager->persist($order);
        $this->entityMenager->flush();

        $this->sessions->set(self::SESSION_KEY, $order->getId());
    }

    public function deleteItem(OrderItem $item)
    {
        $order = $item->getCart();
        $order->removeItem($item);
        $this->entityMenager->remove($item);
        $this->save($order);
    }
}