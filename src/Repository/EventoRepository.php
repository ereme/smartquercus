<?php

namespace App\Repository;

use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evento::class);
    }

    /**
     * @return Eventos[] Returns an array of Eventos objects
     */
    public function findRecientes($aytoid)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.imagen','i')
            ->innerJoin('e.ayuntamiento','a')
            ->select('e.id, e.titular, e.fechahora, e.texto, i.nombre as imagen, a.localidad')
            ->andWhere('e.ayuntamiento = :aytoid')
            ->setParameter('aytoid', $aytoid)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Eventos
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByAyto($aytoid)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.ayuntamiento = :val')
            ->setParameter('val', $aytoid)
            ->orderBy('o.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

}
