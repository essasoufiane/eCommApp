<?php

namespace App\Form;

use App\Entity\Category;
use App\Service\Search;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        
        $builder
            ->add('string', TextType::class, [
                "label"=>"Le nom de l'article",
                'required' => false,
                'attr' => [
                    "placeholder" => "Votre recherche ...",
                    'class' => "form-control",
                ]
                // ,

            ])
            ->add('category', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
            
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false,//desactive la secrutié des form de symfony
        ]);
    }

    public function getBlockPrefix()
    {
        return '';//
    }
}