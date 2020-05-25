<?php

namespace App\Repository;

use App\Entity\Atividade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Atividade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Atividade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Atividade[]    findAll()
 * @method Atividade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtividadeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Atividade::class);
    }

    // /**
    //  * @return Atividade[] Returns an array of Atividade objects
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
    public function findOneBySomeField($value): ?Atividade
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
