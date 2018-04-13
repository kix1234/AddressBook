<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Address;
use AppBundle\Entity\City;
use AppBundle\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


class AddressForm extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('street', TextType::class);
        $builder->add('postalCode', TextType::class);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
    }

    protected function addElements(FormInterface $form, Country $country = null)
    {
        $form->add('country', EntityType::class,
            ['placeholder' => 'Country',
                'class' => Country::class,
                'choice_label' => function ($country) {
                    return $country->getName();
                }
            ]);

        $cities = array();

        if ($country) {
            $cities = $this->em->getRepository(City::class)
                ->createQueryBuilder("city")
                ->where("city.country = :countryId")
                ->setParameter("countryId", $country->getId())
                ->getQuery()
                ->getResult();
        }

        $form->add('city', EntityType::class,
            ['class' => City::class,
                'choices' => $cities
            ]);
    }

    function onPreSetData(FormEvent $event) {

        $this->addElements($event->getForm());
    }

    function onPreSubmit(FormEvent $event) {

        $data = $event->getData();
        $country = $this->em->getRepository(Country::class)->find($data['country']);
        $this->addElements($event->getForm(), $country);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Address::class]);
    }
}