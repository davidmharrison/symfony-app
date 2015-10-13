<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\TicketLine;

class OrderController extends Controller
{

	public function showAction($id)
	{

        $ticketline = $this->get('ticketline');

		$order = $ticketline->getEventPricesByEventId($id);

        $orders = count($order) > 0 ? $order[0] : null;

        return $this->render('AppBundle:Order:post.html.twig', array(
            "order" => $orders
        ));
	}

    public function postAction($id)
    {

    	$ticketline = $this->get('ticketline');

        $methods = $ticketline->getDeliveryMethodsById($id);

        return $this->render('AppBundle:Order:post.html.twig', array(
                // ...
            ));    
    	}

}
