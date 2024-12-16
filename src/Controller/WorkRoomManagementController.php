<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\WorkRoom;
use App\Form\ReservationFormType;
use App\Form\WorkRoomType;
use App\Repository\BorrowHistoryRepository;
use App\Repository\WorkRoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkRoomManagementController extends AbstractController
{
    #[Route('/management/workrooms', name: 'workrooms_management')]
    public function index(
        Request $request,
        WorkRoomRepository $workRoomRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $rooms = $workRoomRepository->findAll();

        // Récupérer l'ID pour l'édition
        $editRoomId = $request->query->get('edit');
        $workRoom = $editRoomId ? $workRoomRepository->find($editRoomId) : new WorkRoom();

        // Vérification si la salle existe
        if ($editRoomId && !$workRoom) {
            $this->addFlash('danger', 'La salle à modifier est introuvable.');
            return $this->redirectToRoute('workrooms_management');
        }

        $form = $this->createForm(WorkRoomType::class, $workRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérification des dates et des heures
            $startDate = $workRoom->getStartReservationDate();
            $endDate = $workRoom->getEndReservationDate();

            if ($startDate > $endDate) {
                $this->addFlash('danger', 'La date de début doit être avant la date de fin.');
            } elseif ($workRoom->getMinReservationTime() >= $workRoom->getMaxReservationTime()) {
                $this->addFlash('danger', 'L\'heure minimale doit être antérieure à l\'heure maximale.');
            } else {
                // Nouvelle salle ou mise à jour
                if (!$workRoom->getId()) { // Nouvelle salle
                    $workRoom->setAvailable(true);
                    $maxCustomId = $workRoomRepository->createQueryBuilder('w')
                        ->select('MAX(w.customId)')
                        ->getQuery()
                        ->getSingleScalarResult();

                    $workRoom->setCustomId($maxCustomId ? $maxCustomId + 1 : 1);
                    $entityManager->persist($workRoom);
                }

                $entityManager->flush();
                $this->addFlash('success', $editRoomId ? 'La salle a été mise à jour.' : 'La salle a été créée.');
                return $this->redirectToRoute('workrooms_management');
            }
        }

        return $this->render('management/WorkRoomsManagement.html.twig', [
            'rooms' => $rooms,
            'form' => $form->createView(),
            'editRoomId' => $editRoomId,
        ]);
    }

    #[Route('/management/workrooms/delete/{id}', name: 'workroom_delete')]
    public function delete(WorkRoom $workRoom, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($workRoom);
        $entityManager->flush();

        $this->addFlash('success', 'La salle a été supprimée avec succès.');

        return $this->redirectToRoute('workrooms_management');
    }

   

    #[Route('/management/workrooms/reserve/{id}', name: 'workroom_reserve')]
    public function reserveRoom(
        WorkRoom $workRoom,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();

        // Vérifier si l'utilisateur a un abonnement
        if ($user->getSubscriptions()->isEmpty()) {
            $this->addFlash('danger', 'Vous devez avoir un abonnement pour réserver une salle.');
            return $this->redirectToRoute('workroom_reserve', ['id' => $workRoom->getId()]);
        }

        // Formulaire de réservation
        $form = $this->createForm(ReservationFormType::class, null, [
            'min_time' => $workRoom->getMinReservationTime()->format('H:i'),
            'max_time' => $workRoom->getMaxReservationTime()->format('H:i'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $reservationDate = $data['reservationDate'];
            $minTime = $data['minReservationTime'];
            $maxTime = $data['maxReservationTime'];
            $numberOfPeople = $data['numberOfPeople'];

            // Vérification des heures
            if ($minTime >= $maxTime) {
                $this->addFlash('danger', 'L\'heure minimale doit être inférieure à l\'heure maximale.');
                return $this->redirectToRoute('workroom_reserve', ['id' => $workRoom->getId()]);
            }

            // Vérification des limites horaires
            if ($minTime < $workRoom->getMinReservationTime() || $maxTime > $workRoom->getMaxReservationTime()) {
                $this->addFlash('danger', 'Les heures choisies doivent respecter les limites de la salle.');
                return $this->redirectToRoute('workroom_reserve', ['id' => $workRoom->getId()]);
            }

            // Validation des limites de date
            if ($reservationDate < $workRoom->getStartReservationDate() || $reservationDate > $workRoom->getEndReservationDate()) {
                $this->addFlash('danger', 'La date choisie est en dehors des limites autorisées.');
                return $this->redirectToRoute('workroom_reserve', ['id' => $workRoom->getId()]);
            }

            if ($workRoom->getExcludedDays() && in_array($reservationDate->format('l'), $workRoom->getExcludedDays())) {
                $this->addFlash('danger', 'La date choisie correspond à un jour non disponible.');
                return $this->redirectToRoute('workroom_reserve', ['id' => $workRoom->getId()]);
            }

            if ($numberOfPeople > $workRoom->getMaxCapacity()) {
                $this->addFlash('danger', 'Le nombre de personnes dépasse la capacité maximale autorisée.');
                return $this->redirectToRoute('workroom_reserve', ['id' => $workRoom->getId()]);
            }

            // Vérifier les créneaux disponibles pour la date sélectionnée
            $reservations = $workRoom->getReservations()->filter(function ($reservation) use ($reservationDate) {
                return $reservation->getReservationDate() == $reservationDate;
            });

            foreach ($reservations as $reservation) {
                $existingStart = $reservation->getMinReservationTime();
                $existingEnd = $reservation->getMaxReservationTime();

                if (($minTime >= $existingStart && $minTime < $existingEnd) ||
                    ($maxTime > $existingStart && $maxTime <= $existingEnd) ||
                    ($minTime <= $existingStart && $maxTime >= $existingEnd)) {
                    $this->addFlash('danger', 'Les heures choisies chevauchent une réservation existante.');
                    return $this->redirectToRoute('workroom_reserve', ['id' => $workRoom->getId()]);
                }
            }

            // Ajouter la salle réservée
            $user->addReservedRoom($workRoom);
            $reservation = new Reservation();
            $reservation->setReservationDate($reservationDate);
            $reservation->setStartTime($minTime);
            $reservation->setEndTime($maxTime);
            $reservation->setWorkRoom($workRoom);
            $reservation->setUser($this->getUser());
            $reservation->setNumberOfPeople($numberOfPeople);
            $workRoom->setAvailable(false);

            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Votre réservation a été effectuée avec succès.');
        }

        return $this->render('workroomsres/WorkRoomsReservation.html.twig', [
            'room' => $workRoom,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/workrooms/reservation', name: 'workrooms_reservation')]
    public function reservationList(WorkRoomRepository $workRoomRepository): Response
    {
        $rooms = $workRoomRepository->findAll();

        return $this->render('workroomsres/WorkRoomsList.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    #[Route('/account', name: 'app_account')]
    public function account(
        EntityManagerInterface $entityManager,
        BorrowHistoryRepository $borrowHistoryRepository
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        
        // Récupérer les réservations de l'utilisateur
        $reservations = $entityManager->getRepository(Reservation::class)->findBy(['user' => $user]);

        // Récupérer l'historique des emprunts
        $borrowHistory = $borrowHistoryRepository->findBy(['userId' => $user->getId()]);


        return $this->render('account/account.html.twig', [
            'user' => $user,
            'reservations' => $reservations,
            'borrowHistory' => $borrowHistory,
        ]);
    }

}