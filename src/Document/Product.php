<?php

namespace App\Document;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

#[MongoDB\Document(repositoryClass: ProductRepository::class)]
class Product
{
    #[MongoDB\Id]
    private mixed $id;

    #[MongoDB\Field(type:"string")]
    #[Groups(["product","order"])]
    private ?string $name;

    #[MongoDB\Field(type:"float")]
    #[Groups(["product","order"])]
    private ?float $price;

    #[MongoDB\Field(type:"string")]
    #[Groups(["product","order"])]
    private ?string $description;

    #[MongoDB\Field(type:"string")]
    #[Groups(["product","order"])]
    private ?string $status;

    #[MongoDB\Field(type:"date")]
    #[Groups(["product","order"])]
    private ?\DateTime $createdAt ;

    #[MongoDB\Field(type:"date")]
    #[Groups(["product","order"])]
    private ?\DateTime $updatedAt;

    #[MongoDB\ReferenceMany(targetDocument:Order::class,mappedBy: 'products')]
    #[Groups(["product"])]
    private ArrayCollection $orders;

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /*public function getFormattedCreatedAt(): ?string
    {
        return $this->createdAt->format('Y-m-d\TH:i:s.000P');
    }*/

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    /**
     * @param ArrayCollection $orders
     */
    public function setOrders(ArrayCollection $orders): void
    {
        $this->orders = $orders;
    }
}
