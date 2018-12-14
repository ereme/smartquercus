<?php

namespace App\Repository;

use App\Entity\Incidencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Incidencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incidencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incidencia[]    findAll()
 * @method Incidencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidenciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Incidencia::class);
    }

//    /**
//     * @return Incidencia[] Returns an array of Incidencia objects
//     */
    
    public function findByAll($incidencia)
    {
        return $this->createQueryBuilder('i')
            ->where('i.incidencia = : incidenciaID')
            ->setParameter(['incidenciaID' => $incidencia])
            ->select("i.fecha, i.estado")
            ->groupBy('i.id')
            ->orderBy('i.fecha', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllOrdenados(){
        return $this->createQueryBuilder('s')
            ->select("s.fecha, s.descripcion, s.estado, s.longitud, s.latitud")
            ->groupBy('s.id')
            ->orderBy('s.fecha', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Incidencia
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
