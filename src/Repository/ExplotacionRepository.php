<?php

namespace App\Repository;

use App\Entity\Explotacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Explotacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Explotacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Explotacion[]    findAll()
 * @method Explotacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExplotacionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Explotacion::class);
    }

//    /**
//     * @return Explotacion[] Returns an array of Explotacion objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Explotacion
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
