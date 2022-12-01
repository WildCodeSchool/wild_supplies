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
        $products = $productRepository->selecteverything();
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

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        $product->setDate(new DateTime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);
            return $this->redirectToRoute('products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/add.html.twig', [

            'form' => $form,

        ]);
    }

    #[Route('/{id}/edit', name: 'index_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $product->setDate(new DateTime('now'));
         //   dd($product);
            $productRepository->save($product, true);

            return $this->redirectToRoute('products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'index_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('products_index', [], Response::HTTP_SEE_OTHER);
    }
}
