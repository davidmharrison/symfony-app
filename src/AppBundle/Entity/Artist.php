<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Algolia\AlgoliaSearchBundle\Mapping\Annotation as Algolia;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Artist
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ArtistRepository")
 * @UniqueEntity("email")
 */
class Artist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * 
     * @Algolia\Attribute
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     *
     * @Algolia\Attribute
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="image_base_url", type="string", length=255, nullable=true)
     */
    private $imageBaseUrl = null;

    /**
     * @var string
     *
     * @ORM\Column(name="image_default", type="string", length=255, nullable=true)
     */
    private $imageDefault = null;

    /**
     * @var integer
     *
     * @ORM\Column(name="itunes_artist_id", type="integer", nullable=true)
     *
     * @Algolia\Attribute
     */
    private $itunesArtistId = null;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Algolia\Attribute
     */
    private $description = null;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Artist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Artist
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set imageBaseUrl
     *
     * @param string $imageBaseUrl
     *
     * @return Artist
     */
    public function setImageBaseUrl($imageBaseUrl)
    {
        $this->imageBaseUrl = $imageBaseUrl;

        return $this;
    }

    /**
     * Get imageBaseUrl
     *
     * @return string
     */
    public function getImageBaseUrl()
    {
        return $this->imageBaseUrl;
    }

    /**
     * Set imageDefault
     *
     * @param string $imageDefault
     *
     * @return Artist
     */
    public function setImageDefault($imageDefault)
    {
        $this->imageDefault = $imageDefault;

        return $this;
    }

    /**
     * Get imageDefault
     *
     * @return string
     */
    public function getImageDefault()
    {
        return $this->imageDefault;
    }

    /**
     * Set itunesArtistId
     *
     * @param integer $itunesArtistId
     *
     * @return Artist
     */
    public function setItunesArtistId($itunesArtistId)
    {
        $this->itunesArtistId = $itunesArtistId;

        return $this;
    }

    /**
     * Get itunesArtistId
     *
     * @return integer
     */
    public function getItunesArtistId()
    {
        return $this->itunesArtistId;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Artist
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

