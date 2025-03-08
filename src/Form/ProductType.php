<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Product Title',
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Product title is required.']),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Title must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Title cannot exceed {{ limit }} characters.',
                    ]),
                ]
            ])
            ->add('shortDescription', TextareaType::class, [  // Change to TextareaType
                'label' => 'Short Description',
                'attr' => ['class' => 'form-control', 'rows' => 4] // Add Bootstrap class and set rows
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Product Image',
                'mapped' => false, // Important: This field is not mapped to the entity
                'required' => true,
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG, or WebP).',
                    ])
                ],
            ])
            ->add('priceExclVat', MoneyType::class, [
                'label' => 'Price (Excl. VAT)',
                'currency' => 'USD'
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'choices' => [
                    'Books' => 'Books',
                    'Home' => 'Home',
                    'Electronics' => 'Electronics',
                    'Clothing' => 'Clothing',
                ],
                'expanded' => false, // Set to true for radio buttons
                'multiple' => false,
            ])
            ->add('isTop', CheckboxType::class, [
                'label' => 'Is Top Product?',
                'required' => false, // Not required, default is false
            ])
            ->add('isFeatured', CheckboxType::class, [
                'label' => 'Is Featured?',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
