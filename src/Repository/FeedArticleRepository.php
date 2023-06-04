<?php

namespace App\Repository;

use App\Entity\FeedArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FeedArticle>
 *
 * @method FeedArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeedArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedArticle[]    findAll()
 * @method FeedArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeedArticle::class);
    }

    public function save(FeedArticle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FeedArticle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //     public function deleteArticles(): array
    //    {


    //         $query = $this->createQuery(
    //             'SELECT a, u
    //             FROM App\Entity\FeedArticle a
    //             LEFT JOIN a.user u
    //             WHERE a.id NOT NULL'
    //         )->setParameter('id', $articleId);



    //        return $this->createQueryBuilder('feedArticles')
    //             ->leftJoin('a.Category c')
    //            ->andWhere('feedArticles.user_feed_article = IS NOT NULL')
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //DQL: https://symfony.com/doc/5.4/doctrine.html#querying-with-the-query-builder
    public function findAllArticleWithoutUserByDateDQL($date): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('fa')
            ->join('fa.users', 'u')
            ->where('u IS NULL')
            //->setParameter('price', $price)
        ;

        // if (!$includeUnavailableProducts) {
        //     $qb->andWhere('p.available = TRUE');
        // }

        $query = $qb->getQuery();

        return $query->execute();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }

    // SQL: https://symfony.com/doc/5.4/doctrine.html#querying-with-sql
    public function findAllArticleWithoutUserByDateSQL($date): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM feed_article fa
            LEFT JOIN user_favorite_articles u
            ON fa.id = u.feed_article_id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return FeedArticle[] Returns an array of FeedArticle objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FeedArticle
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
