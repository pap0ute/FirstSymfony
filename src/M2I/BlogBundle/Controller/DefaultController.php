<?php

namespace M2I\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('M2IBlogBundle:Default:index.html.twig');
    }
}
