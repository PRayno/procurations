<?php

namespace App\Repository;

use App\Entity\Scrutin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Scrutin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scrutin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scrutin[]    findAll()
 * @method Scrutin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScrutinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scrutin::class);
    }

    // /**
    //  * @return Scrutin[] Returns an array of Scrutin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Scrutin
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
