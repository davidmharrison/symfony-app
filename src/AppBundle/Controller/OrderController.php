<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{

	public function showAction($id)
	{
		$orderurl = "http://api.ticketline.co.uk//order";

 		$ch = curl_init(); 

		$user = file_get_contents("user.xml");
		$user = json_decode($user);

        $encoded = "";
        $time = time();

        $apitoken = $time."YWFmOGMzNWJlNjk";
        $apitoken = sha1($apitoken);
		
		$user_token = sha1("123456" . $user->email_address . "YWFmOGMzNWJlNjk");

        $encoded .= urlencode('api-key').'='.urlencode('NGNkZGRhYjkzY2Z').'&';
        $encoded .= urlencode('method').'='.urlencode('getPrices').'&';
        $encoded .= urlencode('user-token').'='.urlencode($user_token).'&';
        $encoded .= urlencode('timestamp').'='.urlencode($time).'&';
        $encoded .= urlencode('api-token').'='.urlencode($apitoken).'&';
        $encoded .= urlencode('event-id').'='.urlencode($id).'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $orderurl); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

        $order = json_decode($output);

        // print_r($order);
        // die;

        return $this->render('AppBundle:Order:post.html.twig', array(
            "order" => $order[0]
        ));
	}

    public function postAction($id)
    {

    	$orderurl = "http://api.ticketline.co.uk//order";

        $ch = curl_init(); 

        $encoded = "";
        $time = time();

        $apitoken = $time."YWFmOGMzNWJlNjk";
        $apitoken = sha1($apitoken);

        $user = file_get_contents("user.xml");
		$user = json_decode($user);

        $user_token = sha1("123456" . $user->email_address . "YWFmOGMzNWJlNjk");

        $encoded .= urlencode('api-key').'='.urlencode('NGNkZGRhYjkzY2Z').'&';
        $encoded .= urlencode('method').'='.urlencode('getDeliveryMethods').'&';
        $encoded .= urlencode('user-token').'='.urlencode($user_token).'&';
        $encoded .= urlencode('timestamp').'='.urlencode($time).'&';
        $encoded .= urlencode('api-token').'='.urlencode($apitoken).'&';
        $encoded .= urlencode('event-id').'='.urlencode($id).'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $orderurl); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

        print_r($output);
        die;

        return $this->render('AppBundle:Order:post.html.twig', array(
                // ...
            ));    }

}
