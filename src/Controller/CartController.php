<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CartRepository;
use App\Entity\Cart;
use App\Entity\User;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index()
    {
        //if (!is_null($this->user)) {
            //$product = new Product();
            //$products = $product->selectProductInCart($this->user['id']);
            $products = [];
            return $this->render('cart/index.html.twig', ['products' => $products, 'cart' => $this]);   /*
        } else {
            header("Location: /");
        }*/
    }
/*
    public function deleteOneProduct(int $productId)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($productId);
        $productManager->deleteProductInCart($product);
        header("Location: /cart");
    }

    public function valideCart(int $cartId)
    {
        $productManager = new ProductManager();
        $productManager->updateProductsFromCartToSold($cartId);
        $cartManager = new CartManager();
        $cartManager->updateValidateCart($cartId);
        header("Location: /book");
    }

    public function addProductToCart(int $id): void
    {
        if (!is_null($this->user)) {
            $cartManager = new CartManager();
            $cartId = $cartManager->getCartId($this->user["id"]);
            $cartManager->addProductToCart($cartId, $id);
            header("Location: /cart");
        } else {
            header("Location: /");
        }
    }*/
}
