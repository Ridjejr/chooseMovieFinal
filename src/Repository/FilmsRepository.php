<?php

namespace App\Repository;

use App\Entity\Films;
use App\Model\FiltreFilms;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Films>
 *
 * @method Films|null find($id, $lockMode = null, $lockVersion = null)
 * @method Films|null findOneBy(array $criteria, array $orderBy = null)
 * @method Films[]    findAll()
 * @method Films[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Films::class);
    }

    public function add(Films $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Films $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Films[] Returns an array of Films objects
    */
   public function listeFilmsCompletePaginee(FiltreFilms $filtre=null): ?Query
   {
       $query = $this->createQueryBuilder('f')
           ->select('f')
           ->orderBy('f.dateSortie', 'DESC');
           if (!empty($filtre->titre)) {
               $query->andWhere('f.titre LIKE :titrechercher')
               ->setParameter('titrechercher', '%'.$filtre->titre.'%');
           }    
           if (!empty($filtre->genre)) {
               $query->andWhere('f.genre = :genrechercher')
               ->setParameter('genrechercher', $filtre->genre);
           }    
       ;
    return$query->getQuery();
   }

//    public function findOneBySomeField($value): ?Films
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}