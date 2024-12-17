<?php

namespace App\Form;

use App\Entity\ModifyUser;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',

            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code Postal',
            ]);

            // ->add('imageProfil', FileType::class, [
            //     'label' => 'Image de profil',
            //     'mapped' => false,
            //     'required' => false,
            //     'constraints' => [
            //         new Image([
            //             'maxSize' => '2M',
            //             'mimeTypes' => ['image/jpeg', 'image/png'],
            //             'mimeTypesMessage' => 'Veuillez télécharger une image au format JPEG ou PNG.',
                        
            //         ]),
            //     ],
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModifyUser::class,
        ]);
    }
}