<?php

namespace App\Repository;

use App\Entity\Parcela;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Parcela|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parcela|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parcela[]    findAll()
 * @method Parcela[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcelaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Parcela::class);
    }

//    /**
//     * @return Parcela[] Returns an array of Parcela objects
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
    public function findOneBySomeField($value): ?Parcela
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
