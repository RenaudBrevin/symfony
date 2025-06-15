<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\User;
use App\Message\NotificationMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class PurchaseService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageBusInterface $bus
    ) {
    }

    public function purchaseProduct(User $user, Product $produit): bool
    {
        if (!$user->isActif()) {
            throw new \Exception('Impossible d\'acheter un produit votre compte est inactif');
        }

        if ($user->getPoints() < $produit->getPrice()) {
            throw new \Exception('Vous n\'avez pas assez de points');
        }

        // Mettre à jour les points de l'utilisateur
        $user->setPoints($user->getPoints() - $produit->getPrice());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->bus->dispatch(new NotificationMessage(
            'ACHAT',
            sprintf('%s %s a acheté %s', $user->getFirstname(), $user->getName(), $produit->getName()),
            $produit->getId(),
            $user->getId()
        ));

        return true;
    }
} 