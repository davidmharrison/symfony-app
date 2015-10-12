<?php

namespace AppBundle\Controller;

use AppBundle\Controller\PjaxController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller implements PjaxController
{
    public function indexAction()
    {
        return $this->render('AppBundle:About:index.html.twig', array(
                // ...
            ));    }

}
