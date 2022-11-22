<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USERS = [
        [
            'azertySteeve',
            'Steeve',
            'Gorgio',
            'Steeve',
            '10 rue nationale 59000 lille',
            'steeve@gmail.com',
            '0608070908',
            'https://cdn.pixabay.com/photo/2022/10/15/21/23/cat-7523894_960_720.jpg',
            ['ROLE_ADMIN']
        ],
        [
            'azertyPierre',
            'Pierre',
            'Pif',
            'Pierre',
            '21 rue faidherbe 59120 loos',
            'pierre@gmail.com',
            '0608070909',
            'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=
            MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2960&q=80',
            []
        ],
        [
            'azertyJean',
            'Jean',
            'touf',
            'Jean',
            '10 avenue de dunkerque 59160 lomme',
            'jean@gmail.com',
            '0608070909',
            'https://images.unsplash.com/photo-1552374196-c4e7ffc6e126?crop=entropy&cs=tinysrgb&fm=jpg&ixlib=rb-1.2.1&q=
            60&raw_url=true&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OHx8cG9ydHJhaXR8ZW58MHx8MHx8&auto=format&fit=crop&w=800',
            []
        ],
        [
            'azertyMarie',
            'Marie',
            'good',
            'Marie',
            '10 rue de la clé 59000 lille',
            'marie@gmail.com',
            '0608070910',
            'https://images.unsplash.com/photo-1563132337-f159f484226c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdl
            fHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
            []
        ]
    ];
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        foreach (self::USERS as $value) {
            # code...
            $user = new User();
            $user->setPassword($value[0]);
            $user->setPseudo($value[1]);
            $user->setLastname($value[2]);
            $user->setFirstname($value[3]);
            $user->setAdress($value[4]);
            $user->setEmail($value[5]);
            $user->setPhoneNumber($value[6]);
            $user->setPhoto($value[7]);
            $user->setRoles($value[8]);
            $manager->persist($user);
            $this->addReference('user_' . $value[1], $user);
        }

        $manager->flush();
    }
}
