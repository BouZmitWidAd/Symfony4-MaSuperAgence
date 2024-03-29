<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('bedrooms')
            ->add('floor')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('rooms')
            ->add('price')
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
            //systeme de translation pour changer label
            'translation_domain' => 'forms'
        ]);
    }
    private function getChoices(){
        $choices = Property::HEAT;
        $output=[];
        foreach ($choices as $k =>$v){
            $output[$v]=$k;

        }
        return $output;
    }
}
