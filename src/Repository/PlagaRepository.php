<?php

namespace App\Repository;

use App\Entity\Plaga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Plaga|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plaga|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plaga[]    findAll()
 * @method Plaga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlagaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Plaga::class);
    }

//    /**
//     * @return Plaga[] Returns an array of Plaga objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Plaga
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
