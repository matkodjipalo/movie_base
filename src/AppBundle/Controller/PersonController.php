<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Form\Type\PersonFormType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{
    /**
     * @Route("/persons/new", name="new_person")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(PersonFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            $this->addFlash('success', 'Person saved!');

            $returnPath = $request->query->get('returnPath');
            if ($returnPath) {
                return $this->redirect($returnPath);
            }

            return $this->redirectToRoute('person_list');
        }

        return $this->render('person/new.html.twig', [
            'personForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/persons/{id}/edit", name="person_edit")
     */
    public function editAction(Request $request, Person $person)
    {
        $form = $this->createForm(PersonFormType::class, $person);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            $this->addFlash('success', 'Person updated!');

            return $this->redirectToRoute('person_list');
        }

        return $this->render('person/edit.html.twig', [
            'personForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/person/{id}/delete", name="person_delete")
     */
    public function deleteAction(Person $person)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();

        $this->addFlash('success', 'Person successfully deleted!');

        return $this->redirectToRoute('person_list');
    }

    /**
     * @Route("/persons", name="person_list")
     */
    public function indexAction(Request $request)
    {
        $page = $request->query->get('page', 1);

        $qb = $this->getDoctrine()->getRepository('AppBundle:Person')->findAllQueryBuilder();

        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setCurrentPage($page);

        return $this->render('person/index.html.twig', [
            'persons' => $pagerfanta,
        ]);
    }
}