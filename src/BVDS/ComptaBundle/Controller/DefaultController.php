<?php

namespace BVDS\ComptaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BVDSComptaBundle:Default:index.html.twig');
    }
}
