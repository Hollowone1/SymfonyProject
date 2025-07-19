<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Regex;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre',
                Constraint::class => [
                    new \Symfony\Component\Validator\Constraints\NotBlank([
                        'message' => 'Le titre ne peut pas être vide.',
                    ]),
                    new \Symfony\Component\Validator\Constraints\Length([
                        'max' => 255,
                        'maxMessage' => 'Le titre ne peut pas dépasser {{ limit }} caractères.',
                        'min' => 3,
                        'minMessage' => 'Le titre doit comporter au moins {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern'=>'/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{1,16}$/',
                        'message' => 'ne peut contenir que des lettres minuscules et majuscules, des chiffres et des tirets',
                    ]),
                ],
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'required' => false,
                Constraint::class => [
                    new \Symfony\Component\Validator\Constraints\Length([
                        'max' => 255,
                        'maxMessage' => 'Le slug ne peut pas dépasser {{ limit }} caractères.',
                        'min' => 3,
                        'minMessage' => 'Le slug doit comporter au moins {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern'=>'/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{1,16}$/',
                        'message' => 'ne peut contenir que des lettres minuscules et majuscules, des chiffres et des tirets',
                    ]),
                ],
            ])
            ->add('content')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('updated_at', null, [
                'widget' => 'single_text',
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'autoSlug'])
        ;
    }

    public function autoSlug(PreSubmitEvent $event):void
    {
        $data = $event->getData();
        if (empty($data['slug'])){
            $slugger = new \Symfony\Component\String\Slugger\AsciiSlugger();
            $data['slug'] = $slugger->slug($data['title'])->lower();
            $event->setData($data);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
