<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

use AppBundle\Entity\Artist;
use AppBundle\TicketLine;

class ArtistController extends Controller
{
    public function indexAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter()));

        $serializer = new Serializer($normalizers, $encoders);

        $tag = $request->query->get('tag');

        $tagdata = $this->getDoctrine()->getRepository('AppBundle:Tag')->findBySlug($tag);

        $ticketline = $this->get('ticketline');

        $artists = $ticketline->getArtistByTag($tag);

        $pheanstalk = $this->get("leezy.pheanstalk.primary");

        $pheanstalk->useTube('testtube')->put($tag);

        $repository = $this->getDoctrine()->getRepository('AppBundle:Artist');

        // $artists = $repository->findArtistsByGenre($tag);

        // $artists = $serializer->normalize($artists);

        // $artists = $serializer->serialize($artists,'json');

        // $artists = json_decode($artists);
        
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

        // if(!$artist->getImageBaseUrl()) {

            $artist->setImageBaseUrl($artistdata->image_base_url);
            $artist->setImageDefault($artistdata->image_default);
            $artist->setItunesArtistId($artistdata->itunes_artist_id);
            $artist->setDescription($artistdata->Bio->description);

            $manager->persist($artist);

            $manager->flush();
        // }

        $events = $ticketline->getEventsByArtist($artistdata->id);

        $artistdata->events = $events;

        return $this->render('AppBundle:Artist:show.html.twig', array(
            "artist" => $artistdata
        ));    
    }

}
