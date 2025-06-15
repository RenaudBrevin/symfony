<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\ProductType;
use App\Form\ProfileType;
use App\Message\AddPointsMessage;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/produit', name: 'app_admin_produit_index', methods: ['GET'])]
    public function index(ProductRepository $produitRepository): Response
    {
        return $this->render('admin/produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/produit/new', name: 'app_admin_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Product();
        $produit->setCreateBy($this->getUser());
        
        $form = $this->createForm(ProductType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/produit/{id}/edit', name: 'app_admin_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/produit/{id}', name: 'app_admin_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Product $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/users', name: 'app_admin_users', methods: ['GET'])]
    public function users(UserRepository $userRepository): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/user/{id}/toggle', name: 'app_admin_user_toggle', methods: ['POST'])]
    public function toggleUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('toggle'.$user->getId(), $request->request->get('_token'))) {
            $user->setActif(!$user->isActif());
            $entityManager->flush();
            
            $status = $user->isActif() ? 'activé' : 'désactivé';
            $this->addFlash('success', "L'utilisateur a été $status avec succès.");
        }

        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/add-points', name: 'app_admin_add_points', methods: ['POST'])]
    public function addPoints(Request $request, MessageBusInterface $bus): Response
    {
        if ($this->isCsrfTokenValid('add_points', $request->request->get('_token'))) {
            $bus->dispatch(new AddPointsMessage());
            $this->addFlash('success', 'Les points seront ajoutés aux utilisateurs actifs.');
        }

        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/user/{id}/edit', name: 'app_admin_user_edit', methods: ['GET', 'POST'])]
    public function editUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur modifié avec succès.');
            
            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}/delete', name: 'app_admin_user_delete', methods: ['POST'])]
    public function deleteUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur supprimé avec succès.');
        }

        return $this->redirectToRoute('app_admin_users');
    }
}