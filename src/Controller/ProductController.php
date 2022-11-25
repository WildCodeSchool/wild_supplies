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

/*
use App\Model\CategoryItemManager;
use App\Model\ProductManager;
use App\Utils\ProductSearchTerms;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\EpisodeRepository;

use App\Repository\SeasonRepository;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\ProgramDuration;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;*/

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

   /*


    // check if a key of array is empty
    private function checkArray(string $key): void
    {
        if (empty($_POST[$key])) {
            $_POST[$key] = [];
        }
    }

    private function checkFile(): ?string
    {
        $authorizedExtensions = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 2000000;

        $haveFile = false;
        for ($i = 0; $i < 3; $i++) {
            $extension = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);

            // If the extension is allowed
            if ((in_array($extension, $authorizedExtensions))) {
                $haveFile = true;
            }

            //We check if the image exists and if the weight is authorized in bytes
            if (
                file_exists($_FILES['file']['tmp_name'][$i]) &&
                filesize($_FILES['file']['tmp_name'][$i]) > $maxFileSize
            ) {
                return "Votre fichier doit faire moins de 2M !";
            }
        }

        if (!$haveFile) {
            return 'Tu dois sélectionner une image de type Jpg, Jpeg ou Png !';
        }

        return null;
    }
    // check if a value of key is empty
    private function checkArrayValue(string $key): ?string
    {
        $errors = null;
        if (empty($_POST[$key])) {
            $errors = "Tu dois séléctionner une icône !";
        }

        return $errors;
    }


    private function checkLenghtValue(string $key): ?string
    {
        $errors = null;
        if (strlen($_POST[$key]) < 2 || htmlentities(trim($_POST[$key])) === "") {
            $errors = "Le champ doit comporter 2 caractères minimum!";
        }
        return $errors;
    }

    private function hasFormErrors(array $errors): bool
    {
        foreach ($errors as $error) {
            if (!is_null($error)) {
                return true;
            }
        }
        return false;
    }

    private function processFormErrors(): array
    {
        $errors = [];

        $errors["title"] = $this->checkLenghtValue("title");
        if (strlen($_POST["title"]) > 20) {
            $errors["title"] = "Ton titre est bien trop long (20 caractères max)";
        }

        $errors["description"] = $this->checkLenghtValue("description");
        if (strlen($_POST["description"]) > 255) {
            $errors["description"] = "Ta description est bien trop longue (255 caractères max)";
        }
        if (
            empty($_POST["price"]) ||
            (!filter_var($_POST["price"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]))
        ) {
            $errors["price"] = "Ton objet ne peut pas être gratuit (entre un prix supérieur à 0€)";
        }
        $this->checkArray("matter");
        $this->checkArray("category");
        $this->checkArray("room");
        $this->checkArray("state");
        $this->checkArray("file");
        $this->checkArray("info");
        $errors["matter"] = $this->checkArrayValue("matter");
        $errors["category"] = $this->checkArrayValue("category");
        $errors["room"] = $this->checkArrayValue("room");
        $errors["state"] = $this->checkArrayValue("state");
        $errors["file"] = $this->checkFile("file");
        $errors["info"] = $this->checkArrayValue("info");

        return $errors;
    }

    public function add(): string
    {
        if (!is_null($this->user)) {
            $errors = [];
            $categories = (new CategoryItemManager())->selectAll();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $uploadDir = 'uploads/';
                $uploadFilePhoto = [];
                foreach ($_FILES["file"]["name"] as $fileName) {
                    if ($fileName != "") {
                        $uploadFilePhoto[] = $uploadDir . basename($fileName);
                    }
                }
                $_POST['title'] =  ucfirst($_POST['title']);

                $product = array_map(function ($parameter) {
                    if (!is_array($parameter)) {
                        $parameter = trim($parameter);
                    }
                    return $parameter;
                }, $_POST);

                $errors = $this->processFormErrors();

                if ($this->hasFormErrors($errors)) {
                    return $this->twig->render("Product/form.html.twig", [
                        "errors" => $errors,
                        "categories" => $categories
                    ]);
                } else {
                    $product['matter'] = json_encode($product['matter']);
                    $product['room'] = json_encode($product['room']);
                    $product['palette'] = json_encode($product['palette']);
                    $product['photo'] = json_encode($uploadFilePhoto);
                    $product["user_id"] = $this->user["id"];

                    foreach ($uploadFilePhoto as $index => $fileName) {
                        move_uploaded_file($_FILES['file']['tmp_name'][$index], $uploadFilePhoto[$index]);
                    }
                    $productManager = new ProductManager();
                    $id = $productManager->insert($product);
                    header("Location:/product?id=" . $id);
                }
            }
            return $this->twig->render("Product/form.html.twig", [
                "categories" => $categories
            ]);
        }
        header("Location:/");
        return "";
    }

    public function book(): string
    {
        if ($this->isConnectedElseRedirection()) {
            $productManager = new ProductManager();
            return $this->twig->render("Product/book.html.twig", $productManager->selectForBook($this->user["id"]));
        }

        return "";
    }

    public function deleteSale(int $id): void
    {
        if ($this->isConnectedElseRedirection()) {
            $productManager = new ProductManager();
            $product = $productManager->selectOneById($id);

            if (isset($product) && ($product["user_id"] === $this->user["id"] || $this->user["isAdmin"] === 1)) {
                $productManager->deleteInSale($product["id"]);
            }

            header("Location: /book");
        }
    }*/
}
