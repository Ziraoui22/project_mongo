<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

#[MongoDB\Document]
class Customer
{
    #[MongoDB\Id]
    #[Groups(["customer","order","product"])]
    private mixed $id;

    #[MongoDB\Field(type:"string")]
    #[Groups(["customer","order","product"])]
    private string $name;

    #[MongoDB\Field(type:"string")]
    #[Groups(["customer","order","product"])]
    private string $email;

    #[MongoDB\Field(type:"string")]
    #[Groups(["customer","order","product"])]
    private string $phone;

    #[MongoDB\Field(type:"string")]
    #[Groups(["customer","order","product"])]
    private string $address;

    #[MongoDB\Field(type:"string")]
    #[Groups(["customer","order","product"])]
    private string $company;

    #[MongoDB\Field(type:"string")]
    #[Groups(["customer","order","product"])]
    private string $status;

    #[MongoDB\ReferenceMany(targetDocument:Order::class, mappedBy: 'customer')]
    #[Groups("customer")]
    private ArrayCollection $orders;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
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

    public function setOrder(Order $order): self
    {
        if(!$this->orders->contains($order)){
            $this->orders->add($order);
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeProduct(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }
}
