<?php

namespace BVDS\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BVDS\ImageBundle\Entity\Album;
use BVDS\ImageBundle\Form\AlbumType;

class AlbumController extends Controller
{
    public function viewAction($id)
    {

        return $this->render('BVDSImageBundle:Album:view.html.twig');
    }

    public function addAction(Request $request)
    {
    	$album = new Album();
    	$form = $this->createForm(AlbumType::class, $album);

    	if ($form->handleRequest($request)->isValid()) {
      		$em = $this->getDoctrine()->getManager();
      		$em->persist($album);
      		$em->flush();

      		$request->getSession()->getFlashBag()->add('notice', 'L\'album a bien été ajouté');

      		return $this->redirect($this->generateUrl('bvds_image_albumview', array('id' => $album->getId())));
    	}

    	return $this->render('BVDSImageBundle:Album:add.html.twig', array(
      		'form' => $form->createView(),
    	));
    }

    public function modAction(Request $request)
    {
    	$repo = $this->getDoctrine()->getManager()->getRepository("BVDSImageBundle:Album");
    }
}
