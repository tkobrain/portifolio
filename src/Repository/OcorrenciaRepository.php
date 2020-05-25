<?php

namespace App\Repository;

use App\Entity\Ocorrencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ocorrencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ocorrencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ocorrencia[]    findAll()
 * @method Ocorrencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OcorrenciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ocorrencia::class);
    }

    // /**
    //  * @return Ocorrencia[] Returns an array of Ocorrencia objects
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
    public function findOneBySomeField($value): ?Ocorrencia
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
