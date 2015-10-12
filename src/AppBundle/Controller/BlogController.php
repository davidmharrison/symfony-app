<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller implements PjaxController
{
    public function indexAction()
    {

    	$articles = array(array("title"=>"Test","body"=>"Lorem ipsum Nulla occaecat quis mollit laborum Ut ea exercitation aliquip dolor."));
    	$tags = array(array("name"=>"Foo"),array("name"=>"Bar"));

        return $this->render('AppBundle:Blog:index.html.twig', array(
                'articles' => $articles,
                'tags' => $tags
            ));    
    }

}
