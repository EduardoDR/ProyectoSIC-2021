<?php

namespace App\Repository;

use App\Entity\CuentaMayor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CuentaMayor|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuentaMayor|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuentaMayor[]    findAll()
 * @method CuentaMayor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuentaMayorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuentaMayor::class);
    }

    // /**
    //  * @return CuentaMayor[] Returns an array of CuentaMayor objects
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
    public function findOneBySomeField($value): ?CuentaMayor
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
