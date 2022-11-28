<?php

namespace App\Controller;

//Category entity namespace using
use App\Entity\CategoryItem;
use App\Form\CategoryType;
use App\Repository\CategoryItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\BrowserKit\Request;

#[ROUTE('/category', name: 'category_')]
class CategoryItemController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryItemRepository $categoryRepository): Response
    {
        $categoriesItems = $categoryRepository->findAll();

        return $this->render(
            'CategoryItem/index.html.twig',
            [

                'categoriesItems' => $categoriesItems
            ]
        );
    }

    public function add(Request $request, CategoryItemRepository $categoryRepository): Response
    {
        $category = new CategoryItem();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('CategoryItem/add.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
}
