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
        return $this->entityManager->getRepository(User::class)
            ->findOneBy(['telegram_id' => $id]);
    }

    //     $data['id'],
    //     $data['first_name']
    //     $data['last_name'],
    //     $data['username'] ?? null,
    //     $data['photo_url'] ?? null
    public function createFromTelegram(array $data): UserInterface
    {
        $userName = $data['username'] ?? null;

        if (!$userName) {
            throw new \Exception('Telegram user must have a username');
        }

        $existingUser = $this->entityManager->getRepository(User::class)
            ->findOneBy(['username' => $userName]);

        if ($existingUser) {
            $existingUser->setTelegramId($data['id']);
            $user = $existingUser;
        } else {
            $user = new User();

            $user->setTelegramId($data['id'])
                ->setUsername($userName);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
