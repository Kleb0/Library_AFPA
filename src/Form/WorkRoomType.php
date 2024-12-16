<?php

namespace App\Form;

use App\Entity\WorkRoom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkRoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, [
                'mapped' => false, // Ce champ n'est pas mappé automatiquement dans l'entité
                'required' => false,
            ])
            ->add('maxCapacity', IntegerType::class, [
                'label' => 'Capacité maximale',
                'attr' => ['min' => 1],
            ])
            ->add('equipment', ChoiceType::class, [
                'label' => 'Équipements disponibles',
                'choices' => [
                    'Wi-Fi' => 'Wi-Fi',
                    'Projecteur' => 'Projecteur',
                    'Tableau blanc' => 'Tableau blanc',
                    'Prises électriques' => 'Prises électriques',
                    'TV' => 'TV',
                    'Air conditionné' => 'Air conditionné',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('startReservationDate', null, [
                'widget' => 'single_text',
                'label' => 'Date de début de réservation',
            ])
            ->add('endReservationDate', null, [
                'widget' => 'single_text',
                'label' => 'Date de fin de réservation',
            ])
            ->add('excludedDays', ChoiceType::class, [
                'label' => 'Jours exclus',
                'choices' => [
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                    'Dimanche' => 'Dimanche',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('minReservationTime', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure minimale de réservation',
            ])
            ->add('maxReservationTime', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure maximale de réservation',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkRoom::class,
        ]);
    }
}
