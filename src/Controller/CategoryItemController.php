<?php

namespace App\Controller;

//Category entity namespace using
use App\Entity\CategoryItem;
use App\Form\CategoryType;
use App\Repository\CategoryItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

#[ROUTE('/category', name: 'category_')]
class CategoryItemController extends AbstractController
{
    #[ROUTE('/', name: 'index')]
    public function index(Request $request, CategoryItemRepository $categoryRepository): Response
    {
        $categoriesItems = $categoryRepository->findAll();
        $category = new CategoryItem();
        $form = $this->createForm(CategoryType::class, $category);


        // if ($request === "add") {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }
        // }
        // if ($request === "select") {

        //     $errors2 = [];
        //     // Retrieve selected categories
        //     $categoriesSelect = $this->insertPostCategory();

        //     // Checked errors
        //     if (count($categoriesSelect) < 4 || count($categoriesSelect) > 4) {
        //         $errors2[] = "Tu as sélectionné " .
        //             count($categoriesSelect) .
        //             " catégorie(s) tu dois sélectionner 4 catégories";
        //     }

        //     // return $errors2;
        //     if (!empty($errors2)) {
        //         return $this->twig->render('CategoryItem/index.html.twig', [
        //             "errors2" => $errors2,
        //             "categoriesItems" => $categoriesItems
        //         ]);
        //     } else {
        //         $categoryItemManager = new CategoryItemRepository();
        //         $categoryItemManager->updateNotIncarousel();
        //         $categoryItemManager->updateIncarousel($categoriesSelect);
        //         header('Location:/');
        //     }

        return $this->renderForm(
            'CategoryItem/index.html.twig',
            [

                'categoriesItems' => $categoriesItems,
                'category' => $category,
                'form' => $form,
            ]
        );
    }


    // private function insertPostCategory(): array
    // {
    //     $categoriesSelect = [];
    //     $categoryItemManager = new CategoryItemRepository();
    //     $categoriesItems = $categoryItemManager->selectAll('id');
    //     if (empty($_POST['category'])) {
    //         $_POST['category'] = [];
    //     }
    //     foreach ($_POST['category'] as $title) {
    //         foreach ($categoriesItems as $categoryItem) {
    //             if ($title === $categoryItem['title']) {
    //                 $categoriesSelect[] = $categoryItem;
    //             };
    //         };
    //     };
    //     return $categoriesSelect;
    // }

    public function edit(CategoryItemRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = 'uploads/';
            // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client
            // (mais d'autre stratégies de nommage sont possibles)
            $uploadFilePhoto = $uploadDir . basename($_FILES['photo']['name']);
            $uploadFileLogo = $uploadDir . basename($_FILES['logo']['name']);

            $_POST['title'] =  ucfirst($_POST['title']);
            $_POST['description'] = ucfirst($_POST['description']);
            // clean $_POST data
            $categoryItem = array_map('trim', $_POST);

            // TODO validations (length, format...)
            $errors = $this->checkdata($categoryItem);

            //Add in categoryItem array the entry photo, logo and id for insertion
            $categoryItem['photo'] = $uploadFilePhoto;
            $categoryItem['logo'] = $uploadFileLogo;
            $categoryItem['id'] = $_GET['id'];


            // if validation is ok, insert and redirection
            if (!empty($errors)) {
                return $this->twig->render('CategoryItem/edit.html.twig', [
                    "errors" => $errors,
                    "categoryItem" => $categoryItem
                ]);
            } else {
                move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilePhoto);
                move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFileLogo);
                $categoryItemManager = new CategoryItemRepository();
                $categoryItemManager->update($categoryItem);
                header('Location:/categories_items');
                return null;
            }
        }

        return $this->twig->render('CategoryItem/edit.html.twig', [
            "categoryItem" => $categoryItem

        ]);
    }
}
