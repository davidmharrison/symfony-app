<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArtistController extends Controller
{
    public function indexAction(Request $request)
    {
        $tag = $request->query->get('tag');

        $artistbytagurl = "http://api.ticketline.co.uk//artist?method=getByTag&tag-slug=".$tag."&api-key=NGNkZGRhYjkzY2Z&on-sale=true";

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

        $artists = json_decode($recommended);
        // var_dump($recommended);
        // die;
        // 
        return $this->render('AppBundle:Artist:index.html.twig', array(
            "artists" => $artists,
            "tag" => $tag
        ));    
    }

    public function showAction($slug)
    {
        $artistbytagurl = "http://api.ticketline.co.uk//artist";

        $ch = curl_init(); 

        $encoded = "";

        $encoded .= urlencode('api-key').'='.urlencode('NGNkZGRhYjkzY2Z').'&';
        $encoded .= urlencode('method').'='.urlencode('getBySlug').'&';
        $encoded .= urlencode('slug').'='.urlencode($slug).'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $artistbytagurl); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

        $artist = json_decode($output);

        $artisturl = "http://api.ticketline.co.uk//event";

        $ch = curl_init(); 

        $encoded = "";

        $encoded .= urlencode('api-key').'='.urlencode('NGNkZGRhYjkzY2Z').'&';
        $encoded .= urlencode('method').'='.urlencode('getByArtist').'&';
        $encoded .= urlencode('artist-id').'='.urlencode($artist->id).'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $artisturl); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $eventoutput = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

        $events = json_decode($eventoutput);

        $artist->events = $events;

        // print_r($artist->events);
        // die;

        return $this->render('AppBundle:Artist:show.html.twig', array(
            "artist" => $artist
        ));    
    }

}
