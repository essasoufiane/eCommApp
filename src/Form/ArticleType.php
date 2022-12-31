<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label"=>"Le nom de l'article",
                'attr' => [
                    "placeholder" => "ecrivez le nom du produit",
                    'class' => "form-control"
                ],
                'constraints' => [
                    new NotBlank([
                        "message" => "Merci de saisir le titre du produit",
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Ce champ doit contenir au moins {{ limit }} caractères',
                       
                        'max' => 40,
                    ]),
                ],
            ])
            ->add('price', IntegerType::class, [
                'label'=>'Prix en Euro',
                'attr' => [
                    'placeholder' => "3.54",
                    'class' => "form-control"
                ],
                'constraints' => [
                    new NotBlank([
                        "message" => "Saisissez le prix du produit",
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Ce champ doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Ce champ ne doit pas depassé {{ limit }} caractères',
                        'max' => 1000,
                    ]),
                ],
            ])
            ->add('quantity', IntegerType::class, [
                'label'=>'Quantité du stock',
                'attr' => [
                    'placeholder' => "23",
                    'class' => "form-control"
                ],
                'constraints' => [
                    new NotBlank([
                        "message" => "Saisissez la quantité du stock du produit",
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Ce champ doit contenir au moins {{ limit }} caractères',
                       
                        'max' => 25,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
