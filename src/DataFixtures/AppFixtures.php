<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;
    private $categories;
    private $users;

    private UserPasswordHasherInterface $hasher;

    public function __construct (UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
        $this->faker = Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        $this->addCategories($manager);
        $this->addUsers($manager);
        $this->addWords($manager);

        $manager->flush();
    }

    public function addCategories (ObjectManager $manager) {
        $categoriesNames = ['Prénom', 'Mot'];
        for ($i = 0; $i <= 1; $i++) {
            $category = new Category();
            $category->setName($categoriesNames[$i]);
            $category->setDescription($this->faker->paragraph());
            $manager->persist($category);
            $this->categories[] = $category;
        }
    }

    public function addUsers (ObjectManager $manager) {
        for ($i = 0; $i <= 49; $i++) {
            $user = new User();
            $user->setEmail($this->faker->safeEmail());
            $user->setPassword($this->faker->password());
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
            $this->users[] = $user;
        }

        $admin = new User();
        $admin->setEmail("admin@admin.fr");
        $password = $this->hasher->hashPassword($user, 'admin');
        $admin->setPassword($password);
        $admin->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $manager->persist($admin);
    }

    public function addWords (ObjectManager $manager) {
        for ($i = 0; $i <=  100; $i++) {
            $category = $this->categories[array_rand($this->categories)];
            $user = $this->users[array_rand($this->users)];

            $word = new Word();
            $word->setUser($user);
            $word->setName($this->faker->word);
            $word->setCategory($category);
            $word->setDefinition($this->faker->paragraph(2));
            $word->setExemple($this->faker->paragraph(2));
            $word->setIsPublish($this->faker->boolean);
            $word->setIsCrush($this->faker->boolean);
            $word->setIsPub($this->faker->boolean);
            $manager->persist($word);
        }
    }
}
