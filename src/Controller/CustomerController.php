<?php

namespace App\Controller;

use App\Document\Customer;
use App\Document\Order;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    public function __construct(private readonly DocumentManager $dm)
    {
    }

    /**
     * @throws MappingException
     * @throws LockException
     */
    #[Route('/get/customer/orders/{id}', name: 'get_orders_by_customer')]
    public function getOrdersByCustomer(string $id): Response
    {
        $customerRepo = $this->dm->getRepository(Customer::class);

        /**
         * @var Customer $customer
         */
        $customer = $customerRepo->find($id);

        /**
         * @var Order $orders
         */
        $orders = $customer->getOrders();

        return $this->json($customer,200,[],["groups" => "customer"]);
    }
}