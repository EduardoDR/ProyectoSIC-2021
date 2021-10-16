<?php

namespace App\Repository;

use App\Entity\CuentaParcial;
use ContainerUKH2oZj\getDoctrine_QueryDqlCommandService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CuentaParcial|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuentaParcial|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuentaParcial[]    findAll()
 * @method CuentaParcial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuentaParcialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuentaParcial::class);
    }

    // /**
    //  * @return CuentaParcial[] Returns an array of CuentaParcial objects
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
    public function findOneBySomeField($value): ?CuentaParcial
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
