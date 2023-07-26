<?php

namespace App\Controller;

use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    public function __construct(private readonly DocumentManager $dm)
    {
    }

    #[Route('/get/products', name: 'get_product')]
    public function index(): Response
    {
        $productRepo = $this->dm->getRepository(Product::class);

       return $this->json($productRepo->findAll());
    }

    #[Route('/create/product', name: 'create_product',methods: 'POST')]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent());
        $product = new Product();
        $product->setName($data->name);
        $product->setPrice($data->price);
        $product->setDescription($data->description);
        $product->setCreatedAt(new \DateTime());

        $this->dm->persist($product);
        $this->dm->flush();

        return $this->json($product);
    }

    #[Route('/get/products/{min}/{max}', name: 'get_product_price_range')]
    public function getProductsByPriceRange(int $min,int $max): Response
    {
        $productRepo = $this->dm->getRepository(Product::class);

        return $this->json($productRepo->getProductsByPriceRange($min,$max));
    }

    #[Route('/get/products/{min}/{max}/{name}', name: 'get_product_price_range_name')]
    public function getProductsByPriceRangeAndName(int $min,int $max,string $name): Response
    {
        $productRepo = $this->dm->getRepository(Product::class);

        return $this->json($productRepo->getProductsByPriceRangeAndName($min,$max,$name));
    }

    /**
     * @throws \Exception
     */
    #[Route('/get/products/{date}', name: 'get_product_date')]
    public function getProductsByDate(string $date): Response
    {
        $productRepo = $this->dm->getRepository(Product::class);

        return $this->json($productRepo->getProductsByDate(new \DateTime($date)));
    }

    #[Route('/get/status/products/{status}', name: 'get_product_status')]
    public function getProductCountByStatus(string $status): Response
    {
        $productRepo = $this->dm->getRepository(Product::class);

        return $this->json($productRepo->getProductCountByStatus($status));
    }

    #[Route('/get/status/products', name: 'get_product_group_status')]
    public function getProductGroupingByStatus(): Response
    {
        $productRepo = $this->dm->getRepository(Product::class);

        return $this->json($productRepo->getProductGroupingByStatus());
    }

    /**
     * @throws MappingException
     * @throws LockException
     */
    #[Route('/get/orders/products/{id}', name: 'get_orders_by_product')]
    public function getOrdersProducts($id): Response
    {
        $productRepo = $this->dm->getRepository(Product::class);

        /**
         * @var Product $product
         */
        $product = $productRepo->find($id);

        return $this->json($product,200,[],["groups" => "product"]);
    }
}
