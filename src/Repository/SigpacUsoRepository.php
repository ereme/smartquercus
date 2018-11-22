<?php

namespace App\Repository;

use App\Entity\SigpacUso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SigpacUso|null find($id, $lockMode = null, $lockVersion = null)
 * @method SigpacUso|null findOneBy(array $criteria, array $orderBy = null)
 * @method SigpacUso[]    findAll()
 * @method SigpacUso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SigpacUsoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SigpacUso::class);
    }

//    /**
//     * @return SigpacUso[] Returns an array of SigpacUso objects
//     */
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
    public function findOneBySomeField($value): ?SigpacUso
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
