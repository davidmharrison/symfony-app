<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller implements PjaxController
{
    public function indexAction(Request $request)
    {
        $params = $request->query->all();

        $user = file_get_contents(__DIR__."/../user.json");

        return $this->forward('AppBundle:Recommended:index',$params);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            // 'user' => $user
        ));
    }
}
