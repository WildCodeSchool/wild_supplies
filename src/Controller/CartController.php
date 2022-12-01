<?php

namespace App\Controller;

use App\Controller\HomeController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CartRepository;
use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Product;
use App\Repository\ProductRepository;
use DateTime;

#[Route('/cart', name: 'cart_')]
class CartController extends BaseController
{
    #[Route('/', name: 'index')]
    public function index(CartRepository $cartRepository): Response
    {
        $cartCurrent = new Cart();
        $user = $this->getUser();
        if ($user->getId()) {
            $products = [];
            foreach ($user->getCarts() as $cart) {
                if (!$cart->isValidated()) {
                    foreach ($cart->getProducts() as $product) {
                        if ($product->getStatusSold() == 'en panier') {
                            $products[] = $product;
                            $cartCurrent = $cart;
                        }
                    }
                }
            }
            return $this->render(
                'cart/index.html.twig',
                ['products' => $products, 'cart' => $cartCurrent]
            );
        } else {
            return $this->redirect('/login');
        }
    }

    #[Route('/{id<\d+>}', name: 'add')]
    public function add(int $id, CartRepository $cartRepository, ProductRepository $productRepository): Response
    {
        $user = $this->getUser();
        if ($user->getId()) {
            $cart = $cartRepository->findOneBy(['user' => $user->getId(), 'validated' => 0]);
            $product = $productRepository->findOneById($id);
            if (!$cart) {
                $cart = new Cart();
                $cart->setUser($user);
                $cart->addProduct($product);
                $cart->setDate(new DateTime('now'));
                $cartRepository->save($cart, true);
            }
            $product->setCart($cart);
            $product->setStatusSold("en panier");
            $productRepository->save($product, true);
            return $this->render(
                'cart/index.html.twig',
                ['products' => $cart->getProducts(), 'cart' => $cart]
            );
        } else {
            return $this->redirect('/login');
        }
    }

    #[Route('/remove/{id<\d+>}', name: 'remove')]
    public function removeProduct(
        int $id,
        CartRepository $cartRepository,
        ProductRepository $productRepository
    ): Response {

        $user = $this->getUser();
        $product = $productRepository->findOneById($id);
        $cart = $product->getCart();
        $cartUser = $cart->getUser();

        if ($user === $cartUser) {
            $product->setCart(null);
            $product->setStatusSold("en vente");
            $productRepository->save($product, true);
            if (count($cart->getProducts()) === 0) {
                $cartRepository->remove($cart, true);
            }
        }
        return $this->redirectToRoute('cart_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/validate/{id<\d+>}', name: 'validated')]
    public function validateCart(
        int $id,
        CartRepository $cartRepository,
        ProductRepository $productRepository
    ): Response {
        $user = $this->getUser();
        if ($user->getId()) {
            $cart = $cartRepository->findOneBy(['user' => $user->getId(), 'id' => $id]);
            if ($cart) {
                $products = $cart->getProducts();
                foreach ($products as $product) {
                  # code...
                    $product->setStatusSold("vendu");
                    $productRepository->save($product, true);
                }
                $cart->setValidated(true);
                $cartRepository->save($cart, true);
            }
        }
        return $this->redirect('/products/book');
    }
}
