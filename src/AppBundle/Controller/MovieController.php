<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\MovieFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller
{
    /**
     * @Route("/movies/new", name="new_movie")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(MovieFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            $this->addFlash('success', 'Movie saved!');

            return $this->redirectToRoute('movie_list');
        }

        return $this->render('movie/new.html.twig', [
            'movieForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/movies", name="movie_list")
     */
    public function indexAction(Request $request)
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $this->getDoctrine()->getRepository('AppBundle:Movie')
                ->findAll(),
        ]);
    }
}