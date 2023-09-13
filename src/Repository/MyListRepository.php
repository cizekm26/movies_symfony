<?php

namespace App\Repository;

use App\Entity\MyList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MyList>
 *
 * @method MyList|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyList|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyList[]    findAll()
 * @method MyList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyList::class);
    }

   /**
    * @return MyList[] Returns an array of MyList objects
    */
   public function createOrderedByRatingQueryBuilder(string $genre = null): QueryBuilder
   {
       $queryBuilder = $this->addOrderByRatingQueryBuilder();
       if ($genre) {
            $queryBuilder->andWhere('movie.genre = :genre')
                ->setParameter('genre', $genre);
       }
       return $queryBuilder;
   }

   private function addOrderByRatingQueryBuilder(QueryBuilder $queryBuilder = null)
   {
        $queryBuilder = $queryBuilder ?? $this->createQueryBuilder('movie');
        return $queryBuilder->orderBy('movie.rating', 'DESC');
   }

//    public function findOneBySomeField($value): ?MyList
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
