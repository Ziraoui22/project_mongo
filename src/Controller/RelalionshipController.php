<?php

namespace App\Controller;

use App\Document\Customer;
use App\Document\Order;
use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RelalionshipController extends AbstractController
{
    public function __construct(private readonly DocumentManager $dm)
    {
    }

    #[Route('/test/add/orders', name: 'set_orders')]
    public function testAddOrderToCustomer(): Response
    {
        $orderRepo = $this->dm->getRepository(Order::class);
        $customerRep = $this->dm->getRepository(Customer::class);

        /**
         * @var Order $order
         */
        $order = $orderRepo->find("64c0d32b7ade05bbcac020b5");

        /**
         * @var Customer $customer
         */
        $customer = $customerRep->find("64be85b0730577e85228d2a5");

        $customer->setOrder($order);

        $this->dm->persist($customer);
        $this->dm->flush();

        return $this->json($order,200,[],["groups" => "order"]);
    }

    #[Route('/test/add/products', name: 'set_products')]
    public function testAddProductToOrder(): Response
    {
        $orderRepo = $this->dm->getRepository(Order::class);
        $productRepo = $this->dm->getRepository(Product::class);

        /**
         * @var Order $order
         */
        $order = $orderRepo->find("64c0d32b7ade05bbcac020b5");

        /**
         * @var Product $product
         */
        $product = $productRepo->find("64be4067730577e85228d24a");

        $order->setProduct($product);

        $this->dm->persist($product);
        $this->dm->flush();

        return $this->json($order,200,[],["groups" => "order"]);
    }
}