<?php

namespace App\Form;

use App\Entity\Films;
use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FilmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,[
                    'attr' =>[
                        "placeholder" => "Saisir le titre du film"
                    ]
            ])

            ->add('image',TextType::class)

            ->add('duree',TimeType::class, [
                'label' => "Durée",
                'input'  => 'datetime',
                'widget' => 'choice',
            ])
            
            ->add('dateSortie',DateType::class,[
                'label' => "Date de sortie",
                'widget' => 'choice',
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31)
            ])

            ->add('description', TextareaType::class)

            ->add('acteurPrincipale',TextType::class,[
                'label' => "Acteur principale ",
                    'attr' =>[
                        "placeholder" => "Saisir le nom de l'acteur principale"
                    ]
            ])

            ->add('realisateur',TextType::class,[
                'label' => "Réalisateur ",
                    'attr' =>[
                        "placeholder" => "Saisir le nom du réalisateur"
                    ]
            ])

            ->add('bandeAnnonce', UrlType::class)

            ->add('genre',EntityType::class,[
                'label' => "Genre",
                'class' => Genre::class,
                'choice_label' => 'nom',
                'required' =>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Films::class,
        ]);
    }
}