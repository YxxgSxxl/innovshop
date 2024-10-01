<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllProducts(): array
    {
        return $this->createQueryBuilder('pa')
            ->select('pa.id, pa.name, pa.description, pa.image, pa.createdAt, pa.updatedAt')
            ->getQuery()
            ->getResult();
    }

    public function findByID($id)
    {
        return $this->createQueryBuilder('pa')
            ->select('pa.id, pa.name, pa.description, pa.image, pa.createdAt, pa.updatedAt')
            ->where('pa.id = :id')->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findLastProducts(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
