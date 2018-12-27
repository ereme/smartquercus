<?php

namespace App\Repository;

use App\Entity\Opina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Opina|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opina|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opina[]    findAll()
 * @method Opina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpinaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Opina::class);
    }

//z    /**
//     * @return Opina[] Returns an array of Opina objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

   /* public function findOpina($opinaid){
        return $this->createQueryBuilder('m')
            //->select('m.id, m.mensaje, m.fechahora, m.receptor')
            ->where('m.emisor = ?1', $qb->expr()->eq('m.emisor', '?2'))
            ->where($qb->expr()->andX($qb->expr()->eq('m.receptor', '?1'), $qb->expr()->eq('m.emisor', '?2')))
            ->where('m.receptor = ?1 AND u.emisor = ?2')
            ->setParameter('emisor_id', $emisorid)
            ->setParameter('receptor_id', $receptorid)
            ->getQuery()
            ->getResult() //puedo poner: getResult() para muchos, getSingleResult() para uno
        ;

    }*/

    public function findByAyto($id)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('App\Entity\Imagen', 'imagen', 'WITH', 'imagen.id = p.imagen')
            ->select('p.id', 'p.pregunta', 'p.votosfavor', 'p.votoscontra', 'p.fechahoralimite', 
            'imagen.id as imagenid', 'imagen.nombre as imagennombre', 'imagen.original as imagenoriginal')
            ->andWhere('p.ayuntamiento = :val')
            ->setParameter('val', $id)
            ->orderBy('p.fechahoralimite', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
