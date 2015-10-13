<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Tag;
use AppBundle\TicketLine;

class GenreController extends Controller
{
    public function indexAction()
    {

        // $ticketline = $this->get('ticketline');

        // $genres = $ticketline->getTags();

        $manager = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Tag');

        $genres = $repository->createQueryBuilder('t')->where('t.is_ticketline_genre = true')->getQuery()->getResult();

        return $this->render('AppBundle:Genre:index.html.twig', array(
        	"genres" => $genres
        ));    
    }

}
