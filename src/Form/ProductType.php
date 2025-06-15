<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix'
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Alimentaire' => 'Alimentaire',
                    'Vêtements' => 'Vêtements',
                    'Electronique' => 'Electronique',
                    'Autre' => 'Autre'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}