<?php

namespace App\Repository;

use App\Entity\Insumos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Insumos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Insumos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Insumos[]    findAll()
 * @method Insumos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InsumosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Insumos::class);
    }

    // /**
    //  * @return Insumos[] Returns an array of Insumos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Insumos
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
