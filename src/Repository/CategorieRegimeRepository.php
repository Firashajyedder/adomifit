<?php

namespace App\Repository;

use App\Entity\CategorieRegime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieRegime|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieRegime|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieRegime[]    findAll()
 * @method CategorieRegime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRegimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieRegime::class);
    }

    // /**
    //  * @return CategorieRegime[] Returns an array of CategorieRegime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategorieRegime
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
