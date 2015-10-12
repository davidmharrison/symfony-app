<?php

namespace AppBundle\EventListener;

use AppBundle\Controller\PjaxController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DomCrawler\Crawler;

class PjaxListener
{

    public function __construct()
    {
        
    }

    public function pjax($request)
    {
        return $request->headers->get('X-PJAX') == true;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        // check to see if onKernelController marked this as a token "auth'ed" request
        // $pjax = $event->getRequest()->attributes->get('pjax');

        $response = $event->getResponse();
        $request =  $event->getRequest();

        // Only handle non-redirections & PJAX requests
        if (!$response->isRedirection() && $this->pjax($request))
        {

            $crawler = new Crawler($response->getContent());;

            // Filter to title (in order to update the browser title bar)
            $response_title = $crawler->filter('head > title');
            // Filter to given container
            $response_container = $crawler->filter($request->headers->get('X-PJAX-CONTAINER'));
            // Container must exist
            if ($response_container->count() != 0)
            {
                $title = $containers = '';
                // If a title-attribute exists
                if ($response_title->count() != 0) {
                    $title = '<title>' . $response_title->html() . '</title>';
                }
                // Set containers
                foreach($response_container as $item) {
                    $containers .= $item->ownerDocument->saveHTML($item);
                }
                // Set new content for the response
                $response->setContent($title.$containers);
            }
            // Updating address bar with the last URL in case there were redirects
            $response->headers->set('X-PJAX-URL', $request->getRequestUri());
        }
        return $response;
    }

}