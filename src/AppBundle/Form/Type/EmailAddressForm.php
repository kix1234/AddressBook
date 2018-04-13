<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\EmailAddress;
use AppBundle\Entity\EmailAddressType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EmailAddressForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email',EmailType::class);

        $builder->add('emailAddressType',EntityType::class,
            ['class' => EmailAddressType::class,
                'choice_label' => function ($emailAddressType) {
                    return $emailAddressType->getName();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => EmailAddress::class]);
    }
}