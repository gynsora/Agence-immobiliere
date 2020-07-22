<?php

namespace App\Form;

use App\Entity\PropertySearch;
use App\Entity\Option;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //ici required => false = prixmax à remplir si besoin ( non obligatoire)
        //on enleve le label et on ajoute un placeholder à la place
        $builder
            ->add('maxPrice',IntegerType::class,[
                'required'=>false,
                'label' =>false,
                'attr' =>['placeholder' => 'Budget maximale']
            ])
            ->add('minSurface',IntegerType::class,[
                'required'=>false,
                'label' =>false,
                'attr' =>['placeholder' => ' Surface minimale']
            ])
            ->add('options',EntityType::class,[
                'required' => false,
                'label' => false,
                'class' => Option::class,                
                'choice_label' => 'name',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        //ici on précise que l'on veut utiliser la méthode get pour ce formulaire (c'est un filtre a faire sur des données de la meme page)
        //on enleve la csrf_protection puisque le formulaire ne fera pas de requete dans la bdd mais depuis des données deja presente dans le controller PropertyController

        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(){
        return '';
    }
}
