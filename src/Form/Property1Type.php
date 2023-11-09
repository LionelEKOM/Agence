<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Property1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', null, [
            'label' => 'Titre',
            'constraints' => [
                new NotBlank(['message' => 'Le titre ne peut pas être vide.']),
                new Length([
                    'min' => 5,
                    'max' => 200,
                    'minMessage' => 'Le titre doit contenir au moins 5 caractères.',
                    'maxMessage' => 'Le titre ne peut pas dépasser 200 caractères.',
                ]),
            ],
        ])
        ->add('description', null, [
            'label' => 'Description',
            'constraints' => [
                new NotBlank(['message' => 'La description ne peut pas être vide.']),
            ],
        ])
        ->add('surface', null, [
            'label' => 'Surface',
            'constraints' => [
                new NotBlank(['message' => 'La surface ne peut pas être vide.']),
                new Range([
                    'min' => 1,
                    'minMessage' => 'La surface doit être d\'au moins 1 m².',
                ]),
            ],
        ])
        ->add('rooms', null, [
            'label' => 'Nombre de pièces',
            'constraints' => [
                new NotBlank(['message' => 'Le nombre de pièces ne peut pas être vide.']),
                new Range([
                    'min' => 1,
                    'minMessage' => 'Il doit y avoir au moins une pièce.',
                ]),
            ],
        ])
        ->add('bedrooms', null, [
            'label' => 'Nombre de chambres',
            'constraints' => [
                new NotBlank(['message' => 'Le nombre de chambres ne peut pas être vide.']),
                new Range([
                    'min' => 0,
                    'minMessage' => 'Le nombre de chambres ne peut pas être négatif.',
                ]),
            ],
        ])
        ->add('price', null, [
            'label' => 'Prix',
            'constraints' => [
                new NotBlank(['message' => 'Le prix ne peut pas être vide.']),
                new Range([
                    'min' => 1,
                    'minMessage' => 'Le prix doit être d\'au moins 1.',
                ]),
            ],
        ])
        ->add('city', null, [
            'label' => 'Ville',
            'constraints' => [
                new NotBlank(['message' => 'La ville ne peut pas être vide.']),
                new Length([
                    'min' => 2,
                    'minMessage' => 'Le nom de la ville doit contenir au moins 2 caractères.',
                ]),
            ],
        ])
        ->add('options', EntityType::class, [
            'class' => Option::class,
            'choice_label' => 'name',
            'multiple' => true,
            'required' => false, // Le champ n'est pas obligatoire
            'constraints' => [
                new Count(['min' => 1, 'minMessage' => 'Sélectionnez au moins une option.'])
            ],
            'attr' => [
                'class' => 'select2',
            ]
        ])
        ->add('sold', null, [
            'label' => 'Vendu',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
