<?php

namespace App\Repository;

use App\Entity\Agrupacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Agrupacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agrupacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agrupacion[]    findAll()
 * @method Agrupacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgrupacionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Agrupacion::class);
    }

//    /**
//     * @return Agrupacion[] Returns an array of Agrupacion objects
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
    public function findOneBySomeField($value): ?Agrupacion
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
