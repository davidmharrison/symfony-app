<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

	public function indexAction()
	{
		// $user = file_get_contents("user.xml");
		// "user" => json_decode($user)
		

		return $this->render('AppBundle:User:index.html.twig');
	}

    public function showAction()
    {
        $user = file_get_contents("user.xml");

        return $this->render('AppBundle:User:user.html.twig',array(
            "user" => json_decode($user)
        ));
    }

    public function postAction(Request $request)
    {

    	$email = $request->request->get('email');
    	$password = $request->request->get('password');

    	$loginurl = "http://api.ticketline.co.uk//user";

    	$encoded = "";
    	$time = time();

    	$ch = curl_init(); 

    	$apitoken = $time."YWFmOGMzNWJlNjk";
        $apitoken = sha1($apitoken);

    	$encoded .= urlencode('api-key').'='.urlencode('NGNkZGRhYjkzY2Z').'&';
        $encoded .= urlencode('method').'='.urlencode('signIn').'&';
        $encoded .= urlencode('timestamp').'='.urlencode($time).'&';
       
        $encoded .= urlencode('email').'='.urlencode($email).'&';
        $encoded .= urlencode('password').'='.urlencode($password).'&';
        $encoded .= urlencode('api-token').'='.urlencode($apitoken).'&';

        $encoded .= urlencode('device-uuid').'='.urlencode("123456").'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $loginurl); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

        file_put_contents("user.xml",$output);

        $user = file_get_contents("user.xml");
        $user = json_decode($user);

        // print_r($this->get("user"));

        return $this->render('AppBundle:User:user.html.twig', array(
            "user" => $user        
        ));    
    }

    public function logoutAction()
    {
        file_put_contents("user.xml","");

        return $this->forward("AppBundle:Default:index");

        return $this->render('AppBundle:User:user.html.twig', array(
            "user" => null
        ));
    }
}
