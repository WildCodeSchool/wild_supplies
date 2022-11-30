<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTime;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public const USERS = [
        [
            'azertySteeve',
            'Steeve',
            'Gorgio',
            'Steeve',
            '10 rue nationale 59000 lille',
            'steeve@gmail.com',
            '0608070908',
            'photo-steeve.jpg',
            ['ROLE_ADMIN'],
            "2022-11-23 00:00:00"
        ],
        [
            'azertyPierre',
            'Pierre',
            'Pif',
            'Pierre',
            '21 rue faidherbe 59120 loos',
            'pierre@gmail.com',
            '0608070909',
            'photo-pierre.jpg',
            [],
            "2022-11-23 00:00:00"
        ],
        [
            'azertyJean',
            'Jean',
            'touf',
            'Jean',
            '10 avenue de dunkerque 59160 lomme',
            'jean@gmail.com',
            '0608070909',
            'photo-jean.jpg',
            [],
            "2022-11-23 00:00:00"
        ],
        [
            'azertyMarie',
            'Marie',
            'good',
            'Marie',
            '10 rue de la clé 59000 lille',
            'marie@gmail.com',
            '0608070910',
            'photo-marie.jpg',
            [],
            "2022-11-23 00:00:00"
        ]
    ];
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        foreach (self::USERS as $value) {
            # code...
            $user = new User();
            $user->setPassword($this->hasher->hashPassword($user, $value[0]));
            $user->setPseudo($value[1]);
            $user->setLastname($value[2]);
            $user->setFirstname($value[3]);
            $user->setAdress($value[4]);
            $user->setEmail($value[5]);
            $user->setPhoneNumber($value[6]);
            $user->setPhoto($value[7]);
            $user->setRoles($value[8]);
            $user->setUpdatedAt(new DateTime($value[9]));
            $manager->persist($user);
            $this->addReference('user_' . $value[1], $user);
        }

        $manager->flush();
    }
}
