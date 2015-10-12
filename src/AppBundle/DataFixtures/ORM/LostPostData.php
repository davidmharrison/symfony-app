<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;
use Faker;

class LoadPostData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 20; $i++) { 
            $faker = Faker\Factory::create();

            $userAdmin = new Post();
            $userAdmin->setTitle($faker->sentence(4));
            $userAdmin->setBody($faker->text);
            $userAdmin->setSlug($faker->slug);

            $manager->persist($userAdmin);
        }

        $manager->flush();
    }
}