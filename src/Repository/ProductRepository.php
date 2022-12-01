<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
            $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function selectlast(int $limit): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function selecteverything(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.date', 'DESC')
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function productuser(User $user): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function productuserbuy(User $user): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.cart', 'c')
            ->andWhere("p.statusSold = 'vendu'")
            ->andWhere('c.user = :user')
            ->setParameter('user', $user->getId())
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function productsold(User $user): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere("p.statusSold = 'vendu'")
            ->setParameter('user', $user)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
