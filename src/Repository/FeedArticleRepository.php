<?php

namespace App\Repository;

use App\Entity\FeedArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
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

    // Find articles related to selected categories
    public function findByCategories($selectedCategories)
    {
        $qb = $this->createQueryBuilder('fa');

        $qb->join('fa.categories', 'c');
        $qb->andWhere($qb->expr()->in('c.id', ':my_array'))
            ->setParameter('my_array', $selectedCategories);

        return $qb->getQuery()->getResult();
    }


    // DQL: https://symfony.com/doc/5.4/doctrine.html#querying-with-the-query-builder
    public function findAllArticleWithoutUserByDateDQL($date): array
    {
        $qb = $this->createQueryBuilder('fa')
            ->leftJoin('fa.users', 'u')
            ->where('u IS NULL')
            ->andWhere('fa.date < :date')
            ->setParameter('date', $date . ' 00:00:00');

        $query = $qb->getQuery();

        return $query->getResult();
    }

    // SQL: https://symfony.com/doc/5.4/doctrine.html#querying-with-sql
    public function findAllArticleWithoutUserByDateSQL($date): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM feed_article fa
            LEFT JOIN user_favorite_articles u
            ON fa.id = u.feed_article_id
            WHERE u.feed_article_id IS NULL
            AND fa.date < :date';
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
