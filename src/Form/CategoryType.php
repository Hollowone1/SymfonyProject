<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Doctrine\DBAL\Types\TextType;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;

class CategoryType extends AbstractType
{
    public function __construct(private FormListenerFactory $formListenerFactory)
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la catégorie',
                'empty_data' => '',
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug de la catégorie',
                'empty_data' => '',
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
             ->addEventListener(FormEvents::PRE_SUBMIT,
                $this->formListenerFactory->autoSlug('title')
            )
            ->addEventListener(FormEvents::POST_SUBMIT,
                $this->formListenerFactory->timestamps()
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
