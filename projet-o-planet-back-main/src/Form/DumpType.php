<?php

namespace App\Form;

use App\Entity\Dump;
use App\Entity\User;
use App\Entity\Waste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DumpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du dump : ',
                'invalid_message' => "wrong title",
            ])
            ->add('latitudeCoordinate', NumberType::class, [
                'label' => 'Latitude : ',
                'invalid_message' => "wrong lat coordinate",
            ])
            ->add('longitudeCoordinate', NumberType::class, [
                'label' => 'Longitude : ',
                'invalid_message' => "wrong long coordinate",
            ])
            ->add('picture1', TextType::class, [
                'label' => 'Photo 1 : ',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du dump : ',
                'required' => false,
                'invalid_message' => "wrong descrip",
            ])
            ->add('isClosed', ChoiceType::class, [
                'label' => 'Etat du Dump : ',
                'choices' => [
                    'Ouvert' => 0,
                    'Clos' => 1,
                ],
            ])
            ->add('emergency', null, [
                'label' => 'Urgence : ',
                'expanded' => true,
            ])
            ->add('wastes', null, [
                'label' => 'Type de déchet : ',
                'required' => true,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('removals', null, [
                'label' => "Campagnes de ramassage : ",
                'required' => false
            ])
            ->add('user', null, [
                'label' => 'Utilisateur : ',
                'invalid_message' => "wrong user value",
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
