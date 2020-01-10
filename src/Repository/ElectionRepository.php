<?php

namespace App\Repository;

use App\Entity\Election;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Election|null find($id, $lockMode = null, $lockVersion = null)
 * @method Election|null findOneBy(array $criteria, array $orderBy = null)
 * @method Election[]    findAll()
 * @method Election[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Election::class);
    }

    public function findCurrent(\DateTime $date=null)
    {
        if (is_null($date))
            $date = new \DateTime();

        return $this->createQueryBuilder('e')
            ->andWhere('e.debut <= :date')
            ->andWhere('e.fin >= :date')
            ->setParameter("date",$date->format("Y-m-d H:i:s"))
            ->orderBy('e.fin', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Election[] Returns an array of Election objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Election
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
