<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testIdnex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'indexAction');
    }

}
