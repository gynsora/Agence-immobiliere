<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat',ChoiceType::class,['choices'=> $this->getChoices()])
            ->add('options',EntityType::class,[
                'required'=>false,
                'class' => Option::class,
                'label' => 'Options',
                'multiple' =>true
            ])
            ->add('imageFile',FileType::class,[
                'required' => false
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

    public function getChoices()//permet de crée la liste des choix de chauffage (gaz ou électrique)
    {
        $choices = Property::HEAT;
        $output =[];
        foreach($choices as $k => $v){
            $output[$v] = $k ;
        }
        return $output ;
    }
}
