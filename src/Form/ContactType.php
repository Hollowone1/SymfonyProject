<?php

namespace App\Form;

use App\DTO\ContactDTO;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'empty_data' => '',
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'empty_data' => '',
            ])
            ->add('service', ChoiceType::class, [
                'choices' => [
                    'comptabilité' => 'compta@demo.fr',
                    'cuisine' => 'cuisine@demo.fr',
                    'ressources humaines' => 'rh@demo.fr',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'empty_data' => '',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
