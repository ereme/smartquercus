<?php

namespace App\Repository;

use App\Entity\Participacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Participacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participacion[]    findAll()
 * @method Participacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipacionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Participacion::class);
    }

//    /**
//     * @return Participacion[] Returns an array of Participacion objects
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
    public function findOneBySomeField($value): ?Participacion
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
