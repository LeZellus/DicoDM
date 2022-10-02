<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = ['Prénom', 'Mot'];
        for ($i = 0; $i <= 1; $i++) {
            dump($categories[$i]);
            $category = new Category();
            $category->setName($categories[$i]);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
