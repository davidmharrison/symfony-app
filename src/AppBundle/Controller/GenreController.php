<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GenreController extends Controller
{
    public function indexAction()
    {

        $artistbytagurl = "http://api.ticketline.co.uk//tag?method=getAll&genre=:genre&api-key=NGNkZGRhYjkzY2Z";

        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $artistbytagurl); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

        $recommended = $output;

        $genres = json_decode($recommended);

        $genres = array_filter($genres,function($genre){
        	return $genre->is_ticketline_genre == true;
        });

        return $this->render('AppBundle:Genre:index.html.twig', array(
        	"genres" => $genres
        ));    
    }

}
