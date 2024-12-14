<?php

namespace App\Controller;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/subscriptions', name: 'app_subscriptions')]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupérer tous les abonnements
        $subscriptions = $em->getRepository(Subscription::class)->findAll();

        return $this->render('subscription/subscription.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }

    #[Route('/subscriptions/seed', name: 'app_seed_subscriptions')]
    public function seed(EntityManagerInterface $em): Response
    {
   
        $monthly = new Subscription();
        $monthly->setName('Abonnement Mensuel');
        $monthly->setPrice(23.99);
        $monthly->setType('Mensuel');
    
        $yearly = new Subscription();
        $yearly->setName('Abonnement Annuel');
        $yearly->setPrice(round(23.99 * 12 * 0.9, 2)); 
        $yearly->setType('Annuel');
    
        $em->persist($monthly);
        $em->persist($yearly);
        $em->flush();
    
        dd([$monthly, $yearly]);
    
        return new Response('Abonnements créés avec succès.');
    }

    #[Route('/subscriptions/subscribe/{id}', name: 'app_subscribe')]
    public function subscribe(int $id, EntityManagerInterface $em): Response
    {
        
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

   
        $subscription = $em->getRepository(Subscription::class)->find($id);
        if (!$subscription) {
            throw $this->createNotFoundException('Abonnement introuvable.');
        }

        $user->addSubscription($subscription);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_account');
    }

    #[Route('/subscriptions/unsubscribe', name: 'app_unsubscribe')]
    public function unsubscribe(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Supprimer tous les abonnements de l'utilisateur
        foreach ($user->getSubscriptions() as $subscription) {
            $user->removeSubscription($subscription);
        }

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_account');
    }

    #[Route('/subscriptions/change/{id}', name: 'app_change_subscription')]
    public function changeSubscription(int $id, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $subscription = $em->getRepository(Subscription::class)->find($id);
        if (!$subscription) {
            throw $this->createNotFoundException('Abonnement introuvable.');
        }

        // Supprimer tous les abonnements actuels
        foreach ($user->getSubscriptions() as $currentSubscription) {
            $user->removeSubscription($currentSubscription);
        }

        // Ajouter le nouvel abonnement
        $user->addSubscription($subscription);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_account');
    }

    
}
