<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 *
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function updateValidateCart(int $cartId): bool
    {
        $query = "UPDATE " . self::TABLE . " SET status_validation = TRUE WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $cartId, PDO::PARAM_INT);
        return $statement->execute();
    }

    public function getCartId(int $userId): int
    {
        $query = "SELECT * FROM cart WHERE user_id = :user_id AND status_validation = FALSE";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();

        $cart = $statement->fetch();

        if ($cart) {
            return $cart["id"];
        } else {
            $query = "INSERT INTO cart (user_id) VALUE (:user_id)";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
            $statement->execute();
            $lastId = (int) $this->pdo->lastInsertId();
            return $lastId;
        }
    }

    public function addProductToCart(int $productId): void
    {

        $query = "UPDATE product SET cart_id = :cartId, `status` = 'en panier' WHERE id = :productId";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('cartId', $cartId, \PDO::PARAM_INT);
        $statement->bindValue('productId', $productId, \PDO::PARAM_INT);
        $statement->execute();
    }


    public function save(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Cart[] Returns an array of Cart objects
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

//    public function findOneBySomeField($value): ?Cart
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
