<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

;

class WishFixtures extends Fixture
{
    private array $categories;

    /**
     * @throws NotSupported
     */
    public function load(ObjectManager $manager): void
    {
        if(!isset($this->categories)) {
            $this->categories = $manager->getRepository(Category::class)->findAll();
        }
        $faker = Factory::create('fr_FR');
        $fakeWishAmount = 10000;

        for($i = 0; $i < $fakeWishAmount ; $i++) {
            $wish = new Wish();
            $wish->setDescription($faker->text(120));
            $wish->setTitle($faker->words(rand(5, 15), true));
            $wish->setAuthor($faker->name(2));
            $wish->setDateCreated($faker->dateTime('now'));
            $wish->setIsPublished($faker->boolean());
            $randCat = $this->categories[rand(0,  count($this->categories) - 1)];
            $wish->setCategory($randCat ?? null);
            $manager->persist($wish);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixture::class];
    }
}
