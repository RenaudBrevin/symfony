<?php

namespace App\EventListener;

use App\Entity\Product;
use App\Entity\User;
use App\Message\NotificationMessage;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Product::class)]
#[AsEntityListener(event: Events::postUpdate, method: 'postUpdate', entity: Product::class)]
#[AsEntityListener(event: Events::postRemove, method: 'postRemove', entity: Product::class)]
#[AsEntityListener(event: Events::postUpdate, method: 'postUpdateUser', entity: User::class)]
class EntityChangeListener
{
    public function __construct(
        private MessageBusInterface $bus
    ) {
    }

    public function postPersist(Product $produit, PostPersistEventArgs $event): void
    {
        $this->bus->dispatch(new NotificationMessage(
            'CREATE',
            'Product: ' . $produit->getName(),
            $produit->getId()
        ));
    }

    public function postUpdate(Product $produit, PostUpdateEventArgs $event): void
    {
        $this->bus->dispatch(new NotificationMessage(
            'UPDATE',
            'Product: ' . $produit->getName(),
            $produit->getId()
        ));
    }

    public function postRemove(Product $produit, PostRemoveEventArgs $event): void
    {
        $entityId = $produit->getId();
        if ($entityId === null) {
            return;
        }
        
        $this->bus->dispatch(new NotificationMessage(
            'DELETE',
            'Product: ' . $produit->getName(),
            $entityId
        ));
    }

    public function postUpdateUser(User $user, PostUpdateEventArgs $event): void
    {
        $changes = $event->getObjectManager()->getUnitOfWork()->getEntityChangeSet($user);
        if (isset($changes['actif']) && !$user->isActif()) {
            $notif = new \App\Entity\Notification();
            $notif->setLabel('Votre compte a été désactivé - ' . (new \DateTime())->format('d/m/Y H:i:s'));
            $notif->setUser($user);
            
            $em = $event->getObjectManager();
            $em->persist($notif);
            $em->flush();
        }
    }
}
