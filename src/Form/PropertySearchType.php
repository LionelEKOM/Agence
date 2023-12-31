<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget max'
                ],
                'constraints' => [
                    new GreaterThanOrEqual(['value' => 0])
                ]
            ])
            ->add('minSurface', IntegerType::class, [
                    'required' => false,
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Surface minimale'
                    ],
                    'constraints' => [
                        new Regex([
                            'pattern' => '/^\d+$/', // Utilise une expression régulière pour vérifier les chiffres uniquement
                            'message' => 'Entrez uniquement des chiffres.',
                        ]),
                    ]
                ])
                ->add('options', EntityType::class, [
                    'class' => Option::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'required' => false,
                    'label' => false, 
                    'attr' => [
                        'class' => 'select2'
                    ]
                ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
