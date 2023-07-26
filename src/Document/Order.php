<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

#[MongoDB\Document]
class Order
{
    #[MongoDB\Id]
    #[Groups(["customer","order","product"])]
    private mixed $id;

    #[MongoDB\Field(type:"date")]
    #[Groups(["customer","order","product"])]
    private \DateTime $orderDate;

    #[MongoDB\Field(type:"float")]
    #[Groups(["customer","order","product"])]
    private float $totalAmount;

    #[MongoDB\ReferenceOne(targetDocument:Customer::class,inversedBy: "orders")]
    #[Groups(["order","product"])]
    private mixed $customer;

    #[MongoDB\ReferenceMany(targetDocument :Product::class,inversedBy: "orders")]
    #[Groups("order")]
    private ArrayCollection $products;


    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate(): \DateTime
    {
        return $this->orderDate;
    }

    /**
     * @param \DateTime $orderDate
     */
    public function setOrderDate(\DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     */
    public function setTotalAmount(float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return mixed
     */
    public function getCustomer(): mixed
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer(mixed $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    public function setProduct(Product $product): self
    {
        if(!$this->products->contains($product)){
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }
}
