<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator|\Faker\Generator
     */
    private Generator $faker;

    public function __construct (){
        $this->faker = Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager): void
    {
        //Create Categories
        $categories = ['Prénom', 'Mot'];
        for ($i = 0; $i <= 1; $i++) {
            $category = new Category();
            $category->setName($categories[$i]);
            $manager->persist($category);
        }

        $manager->flush();

        //Create Users
        for ($i = 0; $i <= 49; $i++) {
            $user = new User();
            $user->setEmail($this->faker->safeEmail());
            $user->setPassword($this->faker->password());
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
