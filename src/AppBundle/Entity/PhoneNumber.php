<?php

namespace AppBundle\Entity;

class PhoneNumber
{
    private $id;
    private $number;

    private $contact;
    private $phoneNumberType;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumberType()
    {
        return $this->phoneNumberType;
    }

    /**
     * @param mixed $phoneNumberType
     */
    public function setPhoneNumberType($phoneNumberType)
    {
        $this->phoneNumberType = $phoneNumberType;
    }
}