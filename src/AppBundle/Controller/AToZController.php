<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Artist;

class AToZController extends Controller
{
    public function indexAction(Request $request)
    {
    	$letetrparam = $request->query->get('letter');
    	$letter = !empty($letetrparam) ? $letetrparam : "A";

        // $pheanstalk = $this->get("leezy.pheanstalk.primary");

        // $pheanstalk->useTube('testtube')->put($letter);

        // $pheanstalk->watch('testtube');

        $manager = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Artist');

        // while($job = $pheanstalk->reserve()) {
        //     $letter = $job->getData();

        //     $ticketline = $this->get('ticketline');

        //     $artists = $ticketline->getArtistsByLetter($letter);

        //     // print_r($letter);
        //     // die;

        //     foreach($artists as $artistdata) {

        //         $artist = $repository->findOneBySlug($artistdata->slug);
        //         if(!$artist) {

        //             $artist = new Artist();
        //             $artist->setName($artistdata->name);
        //             $artist->setSlug($artistdata->slug);

        //             $manager->persist($artist);
        //         }
        //     }

        //     $manager->flush();
        //     $pheanstalk->delete($job);
        // }


     //    $recommended = $output;

     //    $artists = json_decode($recommended);

        $artists = $repository->findByFirstLetter($letter);
        // print_r($artists);

        // $manager = $this->getDoctrine()->getManager();

        // foreach ($artists as $artistdata) {
        //     $artist = new Artist();
        //     $artist->setName($artistdata->name);
        //     $artist->setSlug($artistdata->slug);

        //     $manager->persist($artist);
        // }

        // $manager->flush();

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
