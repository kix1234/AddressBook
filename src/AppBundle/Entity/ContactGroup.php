<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class ContactGroup
{
    private $id;
    private $name;
    private $isFavorite;

    private $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return ArrayCollection $groups
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param Contact $contact
     * @return ContactGroup
     */
    public function addContact(Contact $contact)
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
        }
        return $this;
    }

    /**
     * @param Contact $contact
     * @return ContactGroup
     */
    public function removeContact(Contact $contact)
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
        }
        return $this;
    }
}