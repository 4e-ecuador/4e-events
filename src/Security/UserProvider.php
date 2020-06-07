<?php

namespace App\Security;

use App\Entity\User;
use BoShurik\TelegramBotBundle\Guard\UserFactoryInterface;
use BoShurik\TelegramBotBundle\Guard\UserLoaderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider implements UserLoaderInterface, UserFactoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadByTelegramId(string $id): ?UserInterface
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['telegram.id' => $id]);
    }

    public function createFromTelegram(array $data): UserInterface
    {
        $user = new User(
            $data['id'],
            $data['first_name'].' '.$data['last_name'],
            $data['username'] ?? null,
            $data['photo_url'] ?? null
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
