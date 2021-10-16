<?php

namespace App\Repository;

use App\Entity\Ajustes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ajustes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ajustes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ajustes[]    findAll()
 * @method Ajustes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AjustesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ajustes::class);
    }

    // /**
    //  * @return Ajustes[] Returns an array of Ajustes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ajustes
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
