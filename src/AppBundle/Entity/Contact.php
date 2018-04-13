<?php

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Config\Definition\Exception\Exception;

class Contact
{
    private $id;
    private $firstName;
    private $lastName;
    private $isFavorite;
    private $defaultNumber;

    private $phoneNumbers;
    private $addresses;
    private $emails;
    private $groups;


    public function __construct()
    {
        $this->phoneNumbers = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getisFavorite()
    {
        return $this->isFavorite;
    }

    /**
     * @param mixed $isFavorite
     */
    public function setIsFavorite($isFavorite)
    {
        $this->isFavorite = $isFavorite;
    }

    /**
     * @return mixed
     */
    public function getDefaultNumber()
    {
        return $this->defaultNumber;
    }

    /**
     * @param mixed $defaultNumber
     */
    public function setDefaultNumber($defaultNumber)
    {
        $this->defaultNumber = $defaultNumber;
    }

    /**
     * @return ArrayCollection phoneNumbers
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @return Contact
     */
    public function addPhoneNumber(PhoneNumber $phoneNumber)
    {
        if (!$this->phoneNumbers->contains($phoneNumber)) {
            if($this->phoneNumbers->count() < 6) {
                $phoneNumber->setContact($this);
                $this->phoneNumbers->add($phoneNumber);
            }
            else {
                throw new Exception("It is not possible to add more than 5 phoneNumber fields");
            }
        }
        return $this;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @return Contact
     */
    public function removePhoneNumber(PhoneNumber $phoneNumber)
    {
        if ($this->phoneNumbers->contains($phoneNumber)) {
            $this->phoneNumbers->removeElement($phoneNumber);
        }
        return $this;
    }

    /**
     * @return ArrayCollection $groups
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param ContactGroup $group
     * @return Contact
     */
    public function addGroup(ContactGroup $group)
    {
        if (!$this->groups->contains($group)) {
            $group->addContact($this);
            $this->groups->add($group);
        }
        return $this;
    }

    /**
     * @param ContactGroup $group
     * @return Contact
     */
    public function removeGroup(ContactGroup $group)
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }
        return $this;
    }


    /**
     * @return ArrayCollection $addresses
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param Address $address
     * @return Contact
     */
    public function addAddress(Address $address)
    {
        if (!$this->addresses->contains($address)) {
            $address->setContact($this);
            $this->addresses->add($address);
        }
        return $this;
    }

    /**
     * @param Address $address
     * @return Contact
     */
    public function removeAddress(Address $address)
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }
        return $this;
    }


    /**
     * @return ArrayCollection $emails
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param EmailAddress $email
     * @return Contact
     */
    public function addEmail(EmailAddress $email)
    {
        if (!$this->emails->contains($email)) {
            $email->setContact($this);
            $this->emails->add($email);
        }
        return $this;
    }

    /**
     * @param EmailAddress $email
     * @return Contact
     */
    public function removeEmail(EmailAddress $email)
    {
        if ($this->emails->contains($email)) {
            $this->emails->removeElement($email);
        }
        return $this;
    }
}