<?php

namespace App\DataFixtures;

use App\Entity\CategoryItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryItemFixtures extends Fixture
{
    public const CATEGORIESITEMS = [
        [
            "Ameublement",
            "Votre meuble n'a plus son utilité , Vendez le",
            "https://cdn.pixabay.com/photo/2014/08/11/21/39/wall-416060_960_720.jpg",
            "ameublement2.png",
            true
        ],
        [
            "Décoration",
            "Vous recherchez une décoration unique .",
            "https://cdn.pixabay.com/photo/2017/09/09/18/25/living-room-2732939_960_720.jpg",
            "deco2.png",
            true
        ],
        [
            "Luminaires",
            "Eclairez votre habitation pour mettre en valeur votre décoration.",
            "https://cdn.pixabay.com/photo/2017/08/10/01/45/lights-2616955_960_720.jpg",
            "luminaire2.png",
            true
        ],
        [
            "Electromenager",
            "Un soucis de four. Changez le !",
            "https://cdn.pixabay.com/photo/2022/01/04/05/29/kitchen-6914223_960_720.jpg",
            "electromenager2.png",
            true
        ]
    ];
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::CATEGORIESITEMS as $value) {
            # code...
            $category = new CategoryItem();
            $category->setTitle($value[0]);
            $category->setDescription($value[1]);
            $category->setPhoto($value[2]);
            $category->setLogo($value[3]);
            $category->setInCarousel($value[4]);
            $manager->persist($category);
            $this->addReference('category_' . $value[0], $category);
        }

        $manager->flush();
    }
}
