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

    public function findByAyto($ayto)
    {
        return $this->createQueryBuilder('t')
            ->select('t.id', 't.nombre', 't.apellido1', 't.apellido2')
            ->where('t.ayuntamiento = :val')
            ->setParameter('val', $ayto)
            ->orderBy('t.apellido1', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Vecino[] Returns an array of Vecino objects
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
