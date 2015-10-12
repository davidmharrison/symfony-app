<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecommendedController extends Controller
{
    public function indexAction()
    {
    	$recommendationurl = "http://api.ticketline.co.uk//recommendation?method=getHighlights&limit=8&api-key=NGNkZGRhYjkzY2Z&on-sale=true";
    	// $recommendationurl
    	$ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $recommendationurl); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

    	$recommended = $output;

    	$recommended = json_decode($recommended);
    	// var_dump($recommended);
    	// die;

        return $this->render('AppBundle:Recommended:index.html.twig', array(
			"events" => $recommended
        ));
    }

}
