<?php

namespace App\Repository;

use App\Entity\EstadoDeResultados;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EstadoDeResultados|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstadoDeResultados|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstadoDeResultados[]    findAll()
 * @method EstadoDeResultados[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadoDeResultadosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstadoDeResultados::class);
    }

    // /**
    //  * @return EstadoDeResultados[] Returns an array of EstadoDeResultados objects
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
    public function findOneBySomeField($value): ?EstadoDeResultados
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
