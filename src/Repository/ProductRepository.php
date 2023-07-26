<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Doctrine\ODM\MongoDB\UnitOfWork;

class ProductRepository extends DocumentRepository
{
    public function __construct(DocumentManager $dm, UnitOfWork $uow, ClassMetadata $classMetadata)
    {
        parent::__construct($dm, $uow, $classMetadata);
    }

    /**
     * @throws MongoDBException
     */
    public function getProductByName(string $name): array
    {
        return $this->createQueryBuilder()
            ->field('name')->equals($name)
            ->getQuery()
            ->execute();
    }

    /**
     * @throws MongoDBException
     */
    public function getProductsByPriceRange(float $min, float $max)
    {
        return $this->createQueryBuilder()
            ->field('price')->gte($min)->lte($max)
            ->getQuery()
            ->execute();
    }

    /**
     * @throws MongoDBException
     */
    public function getProductsByDate(\DateTime $date)
    {
        //dd($date->format('Y-m-d\TH:i:s.P'));
        return $this->createQueryBuilder()
            ->field('createdAt')->equals($date)
            ->getQuery()
            ->execute();
    }

    /**
     * @throws MongoDBException
     */
    public function getProductsByPriceRangeAndName(float $min, float $max, string $name)
    {
        $qb = $this->createQueryBuilder();

        $qb->addAnd($qb->expr()->field("price")->gte($min)->lte($max))
            ->addAnd($qb->expr()->field("name")->equals($name));

        return $qb->getQuery()->execute();
    }

    public function getProductCountByStatus(string $status)
    {
        $qb = $this->createAggregationBuilder();

        return $qb->match()
            ->field('status')
            ->equals($status)
            ->group()
            ->field('_id')
            ->expression('$status')
            ->field('count')
            ->sum(1)
            ->getAggregation();
    }

    public function getProductGroupingByStatus()
    {
        $qb = $this->createAggregationBuilder();

        return $qb->group()
            ->field('_id')
            ->expression('$status')
            ->field('count')
            ->sum(1)
            ->getAggregation();
    }
}