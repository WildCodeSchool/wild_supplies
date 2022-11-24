<?php

namespace App\Controller;

use App\Repository\CategoryItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository, CategoryItemRepository $categoryRepository): Response
    {

        $products = $productRepository->selectlast(3);
        $categories = $categoryRepository->selectAllInCarousel();
        return $this->render(
            'home/index.html.twig',
            [
                'products' => $products,
                'categories' => $categories
            ]
        );
    }
}
