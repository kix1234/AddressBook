<?php

namespace AppBundle\Controller;

use AppBundle\Entity\City;
use AppBundle\Entity\Contact;
use AppBundle\Entity\ContactGroup;
use AppBundle\Form\Type\ContactForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class ContactController extends Controller
{
    /**
    * @Route("/contact/list", name="list_contact")
    */
    public function indexAction(Request $request)
    {
        $contacts = $this->getDoctrine()
            ->getRepository(Contact::class)->findAll();

        return $this->render('contact/index.html.twig', ['contacts' => $contacts]);
    }

    /**
     * @Route("/contact/details/{id}", name="details_contact")
     */
    public function showAction(Request $request, Contact $contact)
    {
        return $this->render('contact/details.html.twig', ['contact' => $contact]);
    }

    /**
     * @Route("/contact/new", name="new_contact")
     */
    public function newAction(Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactForm::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();

            $em = $this->getDoctrine()->getManager();

            foreach ($contact->getGroups() as $group)
            {
                $existGroup = $em->getRepository(ContactGroup::class)
                    ->findOneBy(['name' => $group->getName()]);

                if($existGroup)
                {
                    $contact->removeGroup($group);
                    $contact->addGroup($existGroup);
                }
            }

            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('list_contact');
        }

        return $this->render('contact/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/contact/edit/{id}", name="edit_contact")
     */
    public function editAction(Request $request, Contact $contact)
    {
        /*
         * In progress
         *
        $form = $this->createForm(ContactForm::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('list_contact');
        }

        return $this->render('contact/edit.html.twig',
            ['form' => $form->createView()]);
        */

        return $this->render('contact/edit.html.twig');
    }

    /**
     * @Route("/contact/delete/{id}", name="delete_contact")
     */
    public function deleteAction(Request $request, Contact $contact)
    {
        if (!$contact) {
            throw $this->createNotFoundException('Contact does not exist!');
        }

        $form = $this->createFormBuilder($contact)->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
            return $this->redirectToRoute('list_contact');
        }

        return $this->render('contact/delete.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/contact/getCities", name="getCities_contact")
     */
    public function getCitiesAction(Request $request)
    {
        $cities = $this->getDoctrine()->getManager()
            ->getRepository(City::class)
            ->createQueryBuilder("city")
            ->where("city.country = :countryId")
            ->setParameter("countryId", $request->query->get("countryId"))
            ->getQuery()
            ->getResult();

        $responseArray = array();

        foreach($cities as $city){
            $responseArray[] = [
                "id" => $city->getId(),
                "name" => $city->getName()
            ];
        }

        return new JsonResponse($responseArray);
    }
}