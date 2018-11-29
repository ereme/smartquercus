<?php

namespace App\Repository;

use App\Entity\Vecino;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vecino|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vecino|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vecino[]    findAll()
 * @method Vecino[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VecinoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vecino::class);
    }

//    /**
//     * @return Vecino[] Returns an array of Vecino objects
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
    public function findOneBySomeField($value): ?Vecino
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
