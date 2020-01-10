<?php

namespace App\Repository;

use App\Entity\SecteurDisciplinaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SecteurDisciplinaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecteurDisciplinaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecteurDisciplinaire[]    findAll()
 * @method SecteurDisciplinaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecteurDisciplinaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecteurDisciplinaire::class);
    }

    // /**
    //  * @return SecteurDisciplinaire[] Returns an array of SecteurDisciplinaire objects
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
    public function findOneBySomeField($value): ?SecteurDisciplinaire
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
