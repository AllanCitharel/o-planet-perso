<?php

namespace App\Form;

use App\Entity\Dump;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TestDumpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre du dump : ',
        ])
        ->add('latitudeCoordinate', NumberType::class, [
            'label' => 'Latitude : ',
        ])
        ->add('longitudeCoordinate', NumberType::class, [
            'label' => 'Longitude : ',
        ])
        ->add('picture1', FileType::class, [
            'label' => 'Photo 1 : ',
            'constraints' =>[
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'L\'image est au format {{ type }}. Les formats acceptés sont : {{ types }}',
                    'maxSizeMessage' => 'L\'image est supérieur à {{ limit }} {{ suffix }}',
                ])
            ]
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description du dump : ',
        ])
        ->add('isClosed', ChoiceType::class, [
            'label' => 'Etat du Dump : ',
            'choices' => [
                'Ouvert' => 0,
                'Clos' => 1,
            ]
        ])
        ->add('emergency', null, [
            'label' => 'Urgence : ',
            'expanded' => true,
        ])
        ->add('waste', null, [
            'label' => 'Type de déchet : ',
            'expanded' => true,
            'multiple' => true
        ])
        ->add('user', null, [
            'label' => 'Utilisateur : ',
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dump::class,
        ]);
    }
}
