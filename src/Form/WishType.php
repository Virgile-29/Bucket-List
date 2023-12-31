<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('author', TextType::class)
            ->add('Category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name'])
            ->add('image_file', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(['maxSize' => '10048k', 'mimeTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                        'image/webp'
                    ],
                        'maxSizeMessage' => 'Ce fichier est trop lourd'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'wish-submit']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
