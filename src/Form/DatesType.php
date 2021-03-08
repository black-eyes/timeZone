<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
        $builder
            ->add('date',DateType::class)
            ->add('TimeZone',TimezoneType::class)
        ;*/
        $builder
            ->add('date',TextType::class,['required'   => false])
            ->add('TimeZone',TextType::class,['required'   => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
