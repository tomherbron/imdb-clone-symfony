<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function save(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBestSeries(){
        /*
            $entityManager = $this->getEntityManager();
            $dql = "SELECT s FROM App\Entity\Serie s
                    WHERE s.vote >= 8 AND s.popularity >= 200 ORDER BY s.popularity DESC";
            $query = $entityManager->createQuery($dql);
            return $query->getResult();
        */

        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->andWhere('s.vote >= 8')
            ->andWhere('s.popularity >= 150')
            ->addOrderBy('s.popularity', 'DESC');

        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function findAllSeries(int $page){
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->addOrderBy('s.popularity', 'DESC');

        $query = $queryBuilder->getQuery();
        $query->setMaxResults(Serie::MAX_RESULT);

        $offset = ($page - 1) * Serie::MAX_RESULT;

        $query->setFirstResult($offset);
        return $query->getResult();
    }

//    /**
//     * @return Serie[] Returns an array of Serie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Serie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
