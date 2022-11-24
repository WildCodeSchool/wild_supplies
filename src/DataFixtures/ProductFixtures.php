<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const PRODUCTS = [
        [
            'Rétroprojecteur', 100, 'Mon vieux rétro de marque acer.',
            [
                "20221109_151527.jpg",
                "20221109_151533.jpg",
                "20221109_151549.jpg"
            ],
            'en vente',
            ["PVC", "Verre"],
            'category_Electromenager',

            ["Bureau", "Chambre", "Salon"],
            ["#000000", "#3d3846"],
            'Correct',
            'user_Jean'
        ],
        [
            'Frigo',
            499,
            'Juste un simple frigo',
            [
                "20221109_151650.jpg",
                "20221109_151658.jpg",
                "20221109_151713.jpg"
            ],
            'en vente',
            ["Métal", "PVC"],
            'category_Electromenager',
            ["Cuisine"],
            ["#ffffff", "#3d3846"],
            'Correct',
            'user_Jean'
        ],
        [
            'Cafetiére',
            78,
            'Fais le café, type senseo. (café offert)',
            [
                "20221109_151731.jpg",
                "20221109_151738.jpg",
                "20221109_151745.jpg"
            ],
            'en vente',
            ["PVC"],
            'category_Electromenager',
            ["Cuisine"],
            ["#000000"],
            'Nouveau',
            'user_Jean'
        ],
        [
            'Micro onde',
            35,
            'Un micro onde de marque Listo.',
            [
                "20221109_151804.jpg",
                "20221109_151808.jpg",
                "20221109_151814.jpg"
            ],
            'en vente',
            ["PVC"],
            'category_Electromenager',
            ["Cuisine"],
            ["#ffffff", "#000000"],
            'Correct',
            'user_Marie'
        ],
        [
            'Ecran 4:3',
            45,
            'Un ecran de PC bof',
            [
                "20221109_151832.jpg",
                "20221109_151838.jpg",
                "20221109_151844.jpg"
            ],
            'en vente',
            ["PVC", "Verre"],
            'category_Electromenager',
            ["Bureau", "Salon"],
            ["#000000", "#5e5c64"],
            'Nouveau',
            'user_Marie'
        ],
        [
            'Une chaise noire',
            12,
            'Une chaise noir en bonne etat',
            [
                "20221109_151907.jpg",
                "20221109_151913.jpg"
            ],
            'en vente',
            ["Bois", "Tissu"],
            'category_Ameublement',
            ["Bureau", "Cuisine", "Salle à manger", "Salon"],
            ["#000000"],
            'Correct',
            'user_Marie'
        ],
        [
            'Bureau',
            299,
            'Un bureau haut de gamme',
            [
                "20221109_151936.jpg",
                "20221109_151942.jpg"
            ],
            'en vente',
            ["Bois"],
            'category_Ameublement',
            ["Bureau"],
            ["#3d3846", "#986a44"],
            'Nouveau',
            'user_Pierre'
        ],
        [
            'Chaise bureau',
            30,
            'Chaise de bureau sur roulettes, réglable en hauteur, très confortable.',
            [
                "20221109_152023.jpg",
                "20221109_152032.jpg"
            ],
            'en vente',
            ["PVC", "Tissu"],
            'category_Ameublement',
            ["Bureau"],
            ["#000000", "#241f31"],
            'Correct',
            'user_Pierre'
        ],
        [
            'Chaise pliante',
            11,
            'Chaise pliante orange, idéale pour la pêche.',
            ["20221109_152050.jpg"],
            'en vente',
            ["PVC"],
            'category_Ameublement',
            ["Salle à manger"],
            ["#ff7800"],
            'Correct',
            'user_Pierre'
        ],
        [
            'Un néon',
            85,
            'Un néon qui fait de la lumière.',
            ["20221109_152107.jpg"],
            'en vente',
            ["Métal", "Verre"],
            'category_Luminaires',
            ["Bureau", "Cuisine", "Salle à manger"],
            ["#ffffff"],
            'Correct', 'user_Steeve'
        ],
        [
            'Table blanche',
            123,
            'Une table fragile, et fragilisé.',
            [
                "20221109_152142.jpg",
                "20221109_152148.jpg"
            ],
            'en vente',
            ["Bois", "Métal"],
            'category_Ameublement',
            ["Bureau", "Salle à manger"],
            ["#deddda", "#ffbe6f"],
            'Usagé',
            'user_Steeve'
        ],
        [
            'Tabouret qui tourne',
            40,
            'Un tabouret de bar pour se croire dans un manège.',
            ["20221109_152234.jpg"],
            'en vente',
            ["Métal", "Tissu"],
            'category_Ameublement',
            ["Bureau", "Cuisine", "Salle à manger"],
            ["#62a0ea", "#ffffff"],
            'Correct',
            'user_Steeve'
        ],
        [
            'Spot',
            5,
            'Un spot de lumière blanche',
            ["20221109_152353.jpg"],
            'en vente',
            ["Verre"],
            'category_Luminaires',
            ["Bureau", "Cuisine", "Salle à manger", "Salon"],
            ["#ffffff"],
            'Correct',
            'user_Steeve'
        ],
        [
            'Tasse',
            4,
            'Un peu sale mais joli.',
            ["20221109_152553.jpg"],
            'en vente',
            ["Verre"],
            'category_Décoration',
            ["Bureau", "Cuisine", "Salle à manger"],
            ["#ffffff", "#ff7800"],
            'Correct',
            'user_Marie'
        ]

    ];
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::PRODUCTS as $value) {
            # code...
            $product = new Product();
            $product->setTitle($value[0]);
            $product->setPrice($value[1]);
            $product->setDescription($value[2]);
            $product->setPhoto($value[3]);
            $product->setStatusSold($value[4]);
            $product->setMaterial($value[5]);
            $product->setCategoryItem($this->getReference($value[6]));
            $product->setCategoryRoom($value[7]);
            $product->setColor($value[8]);
            $product->setState($value[9]);
            $product->setDate(new DateTime('now'));
            $product->setUser($this->getReference($value[10]));
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryItemFixtures::class,
        ];
    }
}
