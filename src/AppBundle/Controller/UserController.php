<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use AppBundle\TicketLine;

class UserController extends Controller
{

	public function indexAction()
	{
		return $this->render('AppBundle:User:index.html.twig');
	}

    public function showAction()
    {
        $user = $this->get('session')->get('user');

        return $this->render('AppBundle:User:user.html.twig',array(
            "user" => $user
        ));
    }

    public function postAction(Request $request)
    {

    	$email = $request->request->get('email');
    	$password = $request->request->get('password');

    	$ticketline = $this->get('ticketline');

        $output = $ticketline->loginUser($email,$password);

        // print_r($output);
        // die;

        // set and get session attributes
        $this->get('session')->set('user', $output);
        // $user = $session->get('user');
        // file_put_contents(__DIR__."/../user.json",json_encode($output));

        // $user = file_get_contents(__DIR__."/../user.json");
        // $user = json_decode($user);

        return $this->render('AppBundle:User:user.html.twig', array(
            "user" => $output        
        ));    
    }

    public function logoutAction()
    {

        $this->get('session')->remove('user');

        return $this->forward("AppBundle:Default:index");

        return $this->render('AppBundle:User:user.html.twig', array(
            "user" => null
        ));
    }
}
