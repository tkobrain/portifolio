<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail('anderson@alphatorres.com.br')
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$Z3hEMVk3UFJ4MXdXNHI3Vw$pjJEx7sy/pypGnm8ZQ2cAgWBmpR++9VOJllzoWEYFy8');
        $manager->persist($user);

        $manager->flush();
    }
}
