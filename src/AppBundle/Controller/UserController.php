<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\TicketLine;

class UserController extends Controller
{

	public function indexAction()
	{
		return $this->render('AppBundle:User:index.html.twig');
	}

    public function showAction()
    {
        $user = file_get_contents(__DIR__."/../user.json");

        return $this->render('AppBundle:User:user.html.twig',array(
            "user" => json_decode($user)
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

        file_put_contents(__DIR__."/../user.json",json_encode($output));

        $user = file_get_contents(__DIR__."/../user.json");
        $user = json_decode($user);

        return $this->render('AppBundle:User:user.html.twig', array(
            "user" => $user        
        ));    
    }

    public function logoutAction()
    {
        file_put_contents(__DIR__."/../user.json","");

        return $this->forward("AppBundle:Default:index");

        return $this->render('AppBundle:User:user.html.twig', array(
            "user" => null
        ));
    }
}
