<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Artist;
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

        $manager = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Artist');

        $artist = $repository->findOneBySlug($slug);

        $ticketline = $this->get('ticketline');

        $artistdata = $ticketline->getArtistBySlug($slug);

        if(!$artist) {
            $artist = new Artist();
            $artist->setName($artistdata->name);
            $artist->setSlug($artistdata->slug);
        }

        if(!$artist->getImageBaseUrl()) {

            $artist->setImageBaseUrl($artistdata->image_base_url);
            $artist->setImageDefault($artistdata->image_default);
            $artist->setItunesArtistId($artistdata->itunes_artist_id);
            $artist->setDescription($artistdata->Bio->description);

            $manager->persist($artist);

            $manager->flush();
        }

        $events = $ticketline->getEventsByArtist($artistdata->id);

        $artistdata->events = $events;

        return $this->render('AppBundle:Artist:show.html.twig', array(
            "artist" => $artistdata
        ));    
    }

}
