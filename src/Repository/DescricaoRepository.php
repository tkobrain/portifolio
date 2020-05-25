<?php

namespace App\Repository;

use App\Entity\Descricao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Descricao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Descricao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Descricao[]    findAll()
 * @method Descricao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescricaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Descricao::class);
    }

    // /**
    //  * @return Descricao[] Returns an array of Descricao objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Descricao
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
