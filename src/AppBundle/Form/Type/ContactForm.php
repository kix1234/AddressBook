<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName',TextType::class);
        $builder->add('lastName',TextType::class);
        $builder->add('defaultNumber',TextType::class);
        $builder->add('isFavorite',CheckboxType::class, ['required' => false]);


        $builder->add('phoneNumbers', CollectionType::class,
            ['entry_type' => PhoneNumberForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false]);

        $builder->add('emails', CollectionType::class,
            ['entry_type' => EmailAddressForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false]);

        $builder->add('addresses', CollectionType::class,
            ['entry_type' => AddressForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false]);

        $builder->add('groups', CollectionType::class,
            ['entry_type' => ContactGroupForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Contact::class]);
    }
}