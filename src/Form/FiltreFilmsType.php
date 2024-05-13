<?php

namespace App\Form;

use App\Entity\Genre;
use App\Model\FiltreFilms;
use App\Repository\GenreRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltreFilmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => "Titre",
                'attr' => [
                    'placeholder' => "Saisir le titre du film"
                ],
                'required' => false,
                ])
                ->add('genre',EntityType::class,[
                    'label' => "Genre",
                    'class' => Genre::class,
                    'query_builder'=>function(GenreRepository $repo){
                        return $repo->listeFilmsSimple();
                    },
                    'choice_label' => 'nom',
                    'required' =>false,
                    // 'multiple' => true,
                    'attr'=>[
                        'class'=>"selectFilms"
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'method' => 'GET',
            'csrf_protection' => false,
            'data_class' => FiltreFilms::class
        ]);
    }
}