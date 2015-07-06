<?php

namespace DB\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DBServiceBundle:Default:index.html.twig', array('name' => $name));
    }
}
