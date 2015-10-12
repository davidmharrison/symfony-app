<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AToZController extends Controller
{
    public function indexAction(Request $request)
    {
    	$letetrparam = $request->query->get('letter');
    	$letter = !empty($letetrparam) ? $letetrparam : "A";
    	// echo $letter;
    	// die;

    	$atozurl = "http://api.ticketline.co.uk//artist?method=getByAtoZ&first-char=".$letter."&api-key=NGNkZGRhYjkzY2Z&on-sale=true";

    	$ch = curl_init();

        // set url 
        curl_setopt($ch, CURLOPT_URL, $atozurl); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

        $recommended = $output;

        $artists = json_decode($recommended);

        // print_r($output);
        // die;

        $letters = array();

        for ($i="A"; $i < "Z"; $i++) { 
        	$letters[] = $i;
        }

        return $this->render('AppBundle:AToZ:index.html.twig', array(
            "artists" => $artists,
            "letters" => $letters
        ));
    }

}
