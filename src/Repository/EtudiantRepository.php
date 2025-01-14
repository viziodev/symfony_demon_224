<?php

namespace App\Repository;

use App\Entity\Etudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etudiant>
 */
class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

       /**
        * @return Paginator Returns an array of Etudiant objects
        */
       public function findByEtudiantByClasse($classe,$limit=5,$offset=0):Paginator
       {
          $query=$this->createQueryBuilder('e')
               ->leftJoin("e.classe","c")
               ->andWhere('e.classe = :classe')
               ->setFirstResult($offset)
               ->setParameter('classe', $classe)
               ->orderBy('e.nomComplet', 'ASC')
               ->setMaxResults($limit)
               ->getQuery();
               return new Paginator($query);
   
       }

    //    public function findOneBySomeField($value): ?Etudiant
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
