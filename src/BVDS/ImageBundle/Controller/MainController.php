<?php

namespace BVDS\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('BVDSImageBundle:Main:index.html.twig');
    }
}
