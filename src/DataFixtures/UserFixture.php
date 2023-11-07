<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail("john@azerty.com");
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2y$13$lZ1MTjLSx4kWjvYJarmzCuVRGDdcvA4QAMteqbd7eQC9sgkLW7vOe');
        $manager->persist($user);
        $manager->flush();
    }
}
