<?php

namespace App\Repository;

use App\Entity\Ayuntamiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ayuntamiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ayuntamiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ayuntamiento[]    findAll()
 * @method Ayuntamiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AyuntamientoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ayuntamiento::class);
    }

//    /**
//     * @return Ayuntamiento[] Returns an array of Ayuntamiento objects
//     */
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
    public function findOneBySomeField($value): ?Ayuntamiento
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
