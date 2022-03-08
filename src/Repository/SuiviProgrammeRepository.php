<?php

namespace App\Repository;

use App\Entity\SuiviProgramme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SuiviProgramme|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuiviProgramme|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuiviProgramme[]    findAll()
 * @method SuiviProgramme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiviProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuiviProgramme::class);
    }

    // /**
    //  * @return SuiviProgramme[] Returns an array of SuiviProgramme objects
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
    public function findOneBySomeField($value): ?SuiviProgramme
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
