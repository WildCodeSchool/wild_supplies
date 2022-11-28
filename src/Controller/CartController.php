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
            return $this->render('/index.html.twig');
        }
    }
}
