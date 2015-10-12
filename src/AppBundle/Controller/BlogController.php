<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class BlogController extends Controller implements PjaxController
{
    public function indexAction(Request $request)
    {
    	$params = $request->query->all();

    	$tagsrepo = $this->getDoctrine()->getRepository('AppBundle:Tag');

    	$repo = $this->getDoctrine()->getRepository('AppBundle:Post');

    	if(isset($params['tag'])) {
    		$posts = $repo->findAllWithTagName($params['tag']);
    	} else {
    		$posts = $repo->findAllOrderedByTitle();
    	}

        return $this->render('AppBundle:Blog:index.html.twig', array(
            'articles' => $posts,
            'tag' => isset($params['tag']) ? $params['tag'] : null,
            'tags' => $tagsrepo->findAll()
        ));  
    }

    public function showAction($id)
    {
    	$repo = $this->getDoctrine()->getRepository('AppBundle:Post');
   
    	$product = $repo->find($id);

    	return $this->render('AppBundle:Blog:post.html.twig', array(
            'article' => $product
        ));
    }

    public function createAction()
    {
    	$product = new Post();
	    $product->setName('Lorem ipsum Aute enim mollit.');
	    $product->setBody('Lorem ipsum Tempor commodo consequat officia dolore exercitation aute culpa laborum consequat officia ut deserunt dolore amet proident officia amet in anim et anim consectetur velit nisi officia eiusmod nostrud magna reprehenderit aliqua aute sit pariatur culpa sint esse exercitation voluptate.');
	    $product->setSlug('lorem-ipsum');

	    $em = $this->getDoctrine()->getManager();

	    $em->persist($product);
	    $em->flush();

	    return new JsonResponse($product);
    }

}
