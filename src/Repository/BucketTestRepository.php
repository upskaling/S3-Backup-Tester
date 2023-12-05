<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\BucketTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BucketTest>
 *
 * @method BucketTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method BucketTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method BucketTest[]    findAll()
 * @method BucketTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BucketTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BucketTest::class);
    }

    //    /**
    //     * @return BucketTest[] Returns an array of BucketTest objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BucketTest
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
