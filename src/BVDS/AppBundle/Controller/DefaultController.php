<?php

namespace BVDS\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BVDSAppBundle:Default:index.html.twig');
    }
}
