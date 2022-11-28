<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use App\Entity\Product;
use DateTime;

#[Route('products', name: 'products_')]
class ProductController extends AbstractController
{
    #[Route('/', methods: ["GET"], name: 'index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }


    #[Route('/show/{id}', methods: ["GET"], name: 'show')]
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        return $this->render('product/show.html.twig', [
        'product' => $product
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, ProductRepository $productRepository): Response
    {

        $product = new Product();
             // Create the form, linked with $category

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        $product->setDate(new DateTime());

        if ($form->isSubmitted()) {
            $productRepository->save($product, true);
        }


        // Render the form (best practice)

        return $this->renderForm('product/add.html.twig', [

            'form' => $form,

        ]);
    }
}
