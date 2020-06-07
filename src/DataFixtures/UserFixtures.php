<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('nikp3h')
            ->setRoles(['ROLE_ADMIN'])
            ->setTelegramId(0)
            ->setIsVerified(true);

        $manager->persist($user);

        $manager->flush();
    }
}
