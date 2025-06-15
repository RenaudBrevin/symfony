<?php

namespace App\MessageHandler;

use App\Entity\Notification;
use App\Entity\User;
use App\Message\NotificationMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class NotificationMessageHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(NotificationMessage $message): void
    {
        // Si un userId est spécifié, envoyer la notification à cet utilisateur
        if ($message->getUserId()) {
            $user = $this->entityManager->getRepository(User::class)->find($message->getUserId());
            if ($user) {
                $notification = new Notification();
                $notification->setLabel($message->getEntityName());
                $notification->setUser($user);
                $notification->setLu(false);
                $this->entityManager->persist($notification);
            }
        }

        // Envoyer la notification aux administrateurs
        $admins = $this->entityManager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_ADMIN%')
            ->getQuery()
            ->getResult();

        $label = sprintf(
            '%s: %s (ID: %d) - %s',
            $message->getType(),
            $message->getEntityName(),
            $message->getEntityId(),
            (new \DateTime())->format('d/m/Y H:i:s')
        );

        foreach ($admins as $admin) {
            $notification = new Notification();
            $notification->setLabel($label);
            $notification->setUser($admin);
            $notification->setLu(false);
            $this->entityManager->persist($notification);
        }

        $this->entityManager->flush();
    }
}