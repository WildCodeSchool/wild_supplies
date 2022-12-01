<?php

namespace App\DataFixtures;

use App\Entity\CategoryItem;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryItemFixtures extends Fixture
{
    public const CATEGORIESITEMS = [
        [
            "Ameublement",
            "Votre meuble n'a plus son utilité , Vendez le",
            "ameublement3.jpg",
            "ameublement2.png",
            true,
            "2022-11-10 10:00:00"
        ],
        [
            "Décoration",
            "Vous recherchez une décoration unique .",
            "deco1.jpg",
            "deco2.png",
            true,
            "2022-11-10 10:00:00"
        ],
        [
            "Luminaires",
            "Eclairez votre habitation pour mettre en valeur votre décoration.",
            "luminaire1.jpg",
            "luminaire2.png",
            true,
            "2022-11-10 10:00:00"
        ],
        [
            "Electromenager",
            "Un soucis de four. Changez le !",
            "electromenager1.jpg",
            "electromenager2.png",
            true,
            "2022-11-10 10:00:00"
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
            $category->setUpdatedAt(new DateTime($value[5]));
            $this->addReference('category_' . $value[0], $category);
        }

        $manager->flush();
    }
}
