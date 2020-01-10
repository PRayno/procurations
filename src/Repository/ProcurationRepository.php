<?php

namespace App\Repository;

use App\Entity\Procuration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Procuration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Procuration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Procuration[]    findAll()
 * @method Procuration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Procuration::class);
    }

    // /**
    //  * @return Procuration[] Returns an array of Procuration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Procuration
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
