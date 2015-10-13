<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\TicketLine;

class RecommendedController extends Controller
{
    public function indexAction()
    {

        $ticketline = $this->get('ticketline');

        $recommended = $ticketline->getHighlights();

        return $this->render('AppBundle:Recommended:index.html.twig', array(
			"events" => $recommended
        ));
    }

}
