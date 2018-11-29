<?php

namespace App\Repository;

use App\Entity\Telefono;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Telefono|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telefono|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telefono[]    findAll()
 * @method Telefono[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelefonoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Telefono::class);
    }

//    /**
//     * @return Telefono[] Returns an array of Telefono objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Telefono
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
