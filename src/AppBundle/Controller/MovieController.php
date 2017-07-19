<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class MovieController
{
    /**
     * @Route("/movies", name="homepage")
     */
    public function indexAction(Request $request)
    {
        ddd("in");
    }
}