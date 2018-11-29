<?php

namespace App\Repository;

use App\Entity\Salud;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Salud|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salud|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salud[]    findAll()
 * @method Salud[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaludRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Salud::class);
    }

//    /**
//     * @return Salud[] Returns an array of Salud objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Salud
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllOrdenados(){
        return $this->createQueryBuilder('s')
            ->orderBy('s.fechahora', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
