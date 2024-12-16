<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $minTime = $options['min_time'];
        $maxTime = $options['max_time'];

        $builder
            ->add('reservationDate', DateType::class, [
                'label' => 'Date de réservation',
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('minReservationTime', TimeType::class, [
                'label' => 'Heure minimale de réservation',
                'widget' => 'single_text',
                'html5' => true,
                'constraints' => [
                    new Assert\Callback(function ($time, ExecutionContextInterface $context) use ($minTime, $maxTime) {
                        if ($time instanceof \DateTimeInterface) {
                            $formattedTime = $time->format('H:i');
                            if ($formattedTime < $minTime || $formattedTime > $maxTime) {
                                $context->buildViolation("L'heure minimale doit être comprise entre {$minTime} et {$maxTime}.")
                                    ->addViolation();
                            }
                        }
                    }),
                ],
            ])
            ->add('maxReservationTime', TimeType::class, [
                'label' => 'Heure maximale de réservation',
                'widget' => 'single_text',
                'html5' => true,
                'constraints' => [
                    new Assert\Callback(function ($time, ExecutionContextInterface $context) use ($minTime, $maxTime) {
                        if ($time instanceof \DateTimeInterface) {
                            $formattedTime = $time->format('H:i');
                            if ($formattedTime < $minTime || $formattedTime > $maxTime) {
                                $context->buildViolation("L'heure maximale doit être comprise entre {$minTime} et {$maxTime}.")
                                    ->addViolation();
                            }
                        }
                    }),
                ],
            ])
            ->add('numberOfPeople', IntegerType::class, [
                'label' => 'Nombre de personnes accompagnantes',
                'attr' => ['min' => 1],
                'data' => 1,
                'constraints' => [
                    new Assert\NotNull(['message' => 'Le nombre de personnes ne peut pas être nul.']),
                    new Assert\GreaterThanOrEqual([
                        'value' => 1,
                        'message' => 'Le nombre de personnes doit être d\'au moins 1.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
        $resolver->setRequired(['min_time', 'max_time']);
    }
}
