<?php

namespace App\Repository;

use App\Entity\Variedad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Variedad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Variedad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Variedad[]    findAll()
 * @method Variedad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariedadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Variedad::class);
    }

//    /**
//     * @return Variedad[] Returns an array of Variedad objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Variedad
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
