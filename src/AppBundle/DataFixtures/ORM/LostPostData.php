<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use Faker;

class LoadPostData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $tags = [];

        for ($i=0; $i < 10; $i++) { 
            $faker = Faker\Factory::create();

            $tag = new Tag();
            $tag->setName($faker->word);

            $tags[] = $tag;

            $manager->persist($tag);
        }

        for ($i=0; $i < 20; $i++) { 
            $faker = Faker\Factory::create();

            $post = new Post();
            $post->setTitle($faker->sentence(4));
            $post->setBody($faker->text);
            $post->setSlug($faker->slug);
            $post->setImage($faker->imageUrl(640,480));

            
            $rand_keys = array_rand($tags, 3);
            $post->addTag($tags[$rand_keys[0]]);
            $post->addTag($tags[$rand_keys[1]]);
            $post->addTag($tags[$rand_keys[2]]);

            $manager->persist($post);
        }

        $manager->flush();
    }
}