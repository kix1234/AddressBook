<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\PhoneNumber;
use AppBundle\Entity\PhoneNumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhoneNumberForm extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder->add('number',NumberType::class);

       $builder->add('phoneNumberType',EntityType::class,
           ['class' => PhoneNumberType::class,
               'choice_label' => function ($phoneNumberType) {
                    return $phoneNumberType->getName();
                }
           ]);
   }

   public function configureOptions(OptionsResolver $resolver)
   {
       $resolver->setDefaults(['data_class' => PhoneNumber::class]);
   }
}