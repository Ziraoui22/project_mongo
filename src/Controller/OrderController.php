<?php

namespace App\Controller;

use App\Document\Order;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public function __construct(private readonly DocumentManager $dm)
    {
    }

    /**
     * @throws MappingException
     * @throws LockException
     */
    #[Route('/get/orders/{id}', name: 'get_orders')]
    public function getOrdersByCustomer(string $id): Response
    {
        $orderRepo = $this->dm->getRepository(Order::class);
        /**
         * @var Order $order
         */
        $order = $orderRepo->find($id);

        return $this->json($order,200,[],["groups" => "order"]);
    }
}