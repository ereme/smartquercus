<?php

namespace App\Repository;

use App\Entity\Cultivo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cultivo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cultivo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cultivo[]    findAll()
 * @method Cultivo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CultivoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cultivo::class);
    }

//    /**
//     * @return Cultivo[] Returns an array of Cultivo objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cultivo
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
