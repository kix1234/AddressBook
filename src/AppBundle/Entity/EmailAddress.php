<?php

namespace AppBundle\Entity;

class EmailAddress
{
    private $id;
    private $email;

    private $contact;
    private $emailAddressType;

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmailAddressType()
    {
        return $this->emailAddressType;
    }

    /**
     * @param mixed $emailAddressType
     */
    public function setEmailAddressType($emailAddressType)
    {
        $this->emailAddressType = $emailAddressType;
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
}