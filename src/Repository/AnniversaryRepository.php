<?php

namespace App\Repository;

use App\Entity\Anniversary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Anniversary>
 *
 * @method Anniversary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anniversary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anniversary[]    findAll()
 * @method Anniversary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnniversaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anniversary::class);
    }

//    /**
//     * @return Anniversary[] Returns an array of Anniversary objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Anniversary
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
