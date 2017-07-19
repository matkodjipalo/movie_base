<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\PersonFormType;
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

            return $this->redirectToRoute('person_list');
        }

        return $this->render('person/new.html.twig', [
            'personForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/persons", name="person_list")
     */
    public function indexAction(Request $request)
    {
        return $this->render('person/index.html.twig', [
            'persons' => $this->getDoctrine()->getRepository('AppBundle:Person')
                ->findAll(),
        ]);
    }
}