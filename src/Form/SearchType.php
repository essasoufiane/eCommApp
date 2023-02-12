<?php

namespace App\Form;

use App\Entity\Category;
use App\Service\Search;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                    'class' => "
                    form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none",
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
            
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer',
                'attr' => [
                    'class' => 'inline-block px-6 py-2 border-2 border-purple-600 text-purple-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out'
                ]
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
        return '';
    }
}