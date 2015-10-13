<?php

namespace AppBundle\Command;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Artist;
use AppBundle\TicketLine;

class UpdateArtistsCommand extends ContainerAwareCommand {

	const TUBE_NAME = "testtube"; // Tube to Watch
    const WATCH_TIMEOUT = 60; // Watch Tube expires after 60s
    // OutputInterface
    protected $output;

    protected function configure() {
        $this->setName('app:command:beanstalk')->setDescription('Pull Job from Beanstalk Beanstalk');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->output = $output;
        $bsClient = $this->getContainer()->get("leezy.pheanstalk.primary");
        while(true) { // loop until end
            $job = $bsClient
                ->watch(self::TUBE_NAME)
                ->ignore('default')
                ->reserve(self::WATCH_TIMEOUT); 
            /** I do recommend to setup a timeout above. It avoids a tricky bug **/
           if ($job) { // something to do
             $this->processJobData($job->getData()); // process job data
             $bsClient->delete($job); // remove job
           }
        }
   	}
    
   	protected function processJobData($data) {

   		$manager = $this->getContainer()->get('doctrine')->getManager();

   		$tagdata = $manager->getRepository('AppBundle:Tag')->findBySlug($data);

        $ticketline = $this->getContainer()->get('ticketline');

        $artistsdata = $ticketline->getArtistByTag($data);

   		$repository = $manager->getRepository('AppBundle:Artist');

        foreach ($artistsdata as $artist) {

            $artistdata = $repository->findOneBySlug($artist->slug);

            if($artistdata) {

                $hastag = $artistdata->getTags()->contains($tagdata[0]);
                
                $artistdata->setImageBaseUrl($artist->image_base_url);
                $artistdata->setImageDefault($artist->image_default);
                $artistdata->setItunesArtistId($artist->itunes_artist_id);
                // $artistdata->setDescription($artist->Bio->description);

                if(!$hastag) {
                    $artistdata->addTag($tagdata[0]);

                    $manager->persist($artistdata);
                }
            }
        }

        $manager->flush();

     	$this->output->writeln("Finished for: ". $data);
   	}
}