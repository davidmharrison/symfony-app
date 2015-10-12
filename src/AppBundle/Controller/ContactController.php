<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller implements PjaxController
{
    public function indexAction()
    {
        return $this->render('AppBundle:Contact:index.html.twig', array(
                // ...
            ));    
    }

    public function postAction(Request $request)
    {
    	$data = $request->request->all();

    	return $this->render('AppBundle:Contact:send.html.twig',$data);
    }

}
