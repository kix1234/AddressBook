<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ContactGroupForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Contact;
use AppBundle\Entity\ContactGroup;

use AppBundle\Repository;

class GroupController extends Controller
{
    /**
     * @Route("/group/list", name="list_group")
     */
    public function indexAction(Request $request)
    {
        $groups = $this->getDoctrine()
            ->getRepository(ContactGroup::class)->findAll();

        return $this->render('group/index.html.twig', ['groups' => $groups]);
    }

    /**
     * @Route("/group/details/{id}", name="details_group")
     */
    public function showAction(Request $request, ContactGroup $group)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $boxes = $request->request->get('cb');

            if($boxes != null) {

                foreach ($boxes as $box) {

                    $contact = $em->getRepository(Contact::class)->find($box);

                    $contact->removeGroup($group);

                    $em->persist($contact);

                    $em->flush();
                }

                return $this->redirectToRoute('details_group', ['id' => $group->getId()]);
            }
        }

        return $this->render('group/details.html.twig',
            ['group' => $group,
                'form' => $form->createView()]);
    }

    /**
     * @Route("/group/new", name="new_group")
     */
    public function newAction(Request $request)
    {
        $group = new ContactGroup();

        $form = $this->createForm(ContactGroupForm::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $group = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('list_group');
        }

        return $this->render('group/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/group/edit/{id}", name="edit_group")
     */
    public function editAction(Request $request, ContactGroup $group)
    {
        $form = $this->createForm(ContactGroupForm::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->merge($group);
            $em->flush();

            return $this->redirectToRoute('list_group');
        }

        return $this->render('group/edit.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/group/delete/{id}", name="delete_group")
     */
    public function deleteAction(Request $request, ContactGroup $group)
    {
        if (!$group) {
            throw $this->createNotFoundException('Group does not exist!');
        }

        $form = $this->createFormBuilder($group)->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
            return $this->redirectToRoute('list_group');
        }

        return $this->render('group/delete.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("group/add/{id}", name="add_contact_from_group")
     */
    public function addContactAction(Request $request, ContactGroup $group)
    {
        $em = $this->getDoctrine()->getManager();

       //$contacts = $em->getRepository(Contact::class)->getContacts();

        $contactsRepos = $em->getRepository(Contact::class)->findAll();

        $contacts = array();

        foreach ($contactsRepos as $c){
            if(!$c->getGroups()->contains($group))
                $contacts[] = $c;
        }

        $form = $this->createFormBuilder()->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $boxes = $request->request->get('cb');

            if($boxes != null) {

                foreach ($boxes as $box) {

                    $contact = $em->getRepository(Contact::class)->find($box);

                    $contact->addGroup($group);

                    $em->persist($contact);

                    $em->flush();
                }

                return $this->redirectToRoute('details_group', ['id' => $group->getId()]);
            }
        }

        return $this->render('group/contact/add.html.twig',
            ['contacts' => $contacts,
                'group' => $group,
                'form' => $form->createView()]);
    }
}