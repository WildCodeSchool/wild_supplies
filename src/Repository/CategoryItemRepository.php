<?php

namespace App\Repository;

use App\Entity\CategoryItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryItem>
 *
 * @method CategoryItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryItem[]    findAll()
 * @method CategoryItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryItem::class);
    }

    public function save(CategoryItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Select all categories in carousel from home page
    public function selectAllInCarousel(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.inCarousel = true')
            ->getQuery()
            ->getResult();
    }

    // Clean categories in carousel from home page
    // public function updateNotIncarousel(): void
    // {

    //     $query = "UPDATE " . self::TABLE . " SET in_carousel = FALSE";
    //     $statement = $this->pdo->prepare($query);
    //     $statement->execute();
    // }

    // // Insert new categories in carousel from home page
    // public function updateIncarousel(array $array): void
    // {
    //     $value = [];
    //     foreach ($array as $item) {
    //         $value[] = $item['id'];
    //     }

    //     $query = "UPDATE " . self::TABLE .
    //         " SET in_carousel = TRUE WHERE id IN ($value[0], $value[1], $value[2], $value[3])";
    //     $statement = $this->pdo->prepare($query);
    //     $statement->execute();
    // }

    //    /**
    //     * @return CategoryItem[] Returns an array of CategoryItem objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CategoryItem
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
