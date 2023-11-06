<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category
;

class CategoryFixture extends Fixture
{
    private array $categories  = [
        "Travel & Adventure", "Sport", "Entertainment", "Human Relations", "Others"
    ];
    public function load(ObjectManager $manager): void
    {

        foreach($this->categories as $category) {
            $cat = new Category();
            $cat->setName($category);
            $manager->persist($cat);
        }
        $manager->flush();
    }
}
