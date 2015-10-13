<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\TicketLine;

class ArtistController extends Controller
{
    public function indexAction(Request $request)
    {
        $tag = $request->query->get('tag');

        $ticketline = $this->get('ticketline');

        $artists = $ticketline->getArtistByTag($tag);
        
        return $this->render('AppBundle:Artist:index.html.twig', array(
            "artists" => $artists,
            "tag" => $tag
        ));    
    }

    public function showAction($slug)
    {
       
        $ticketline = $this->get('ticketline');

        $artist = $ticketline->getArtistBySlug($slug);

        $events = $ticketline->getEventsByArtist($artist->id);

        $artist->events = $events;

        return $this->render('AppBundle:Artist:show.html.twig', array(
            "artist" => $artist
        ));    
    }

}
