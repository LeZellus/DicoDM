<?php

namespace App\DataFixtures;

use App\Entity\Category;
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
        $categories = ['Prénom', 'Mot'];
        for ($i = 0; $i <= 1; $i++) {
            $category = new Category();
            $category->setName($categories[$i]);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
