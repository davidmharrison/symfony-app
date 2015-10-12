<?php

namespace AppBundle\Twig;

use \Twig_SimpleFunction;

class AppExtension extends \Twig_Extension
{
	public function getFunctions()
    {
        return array(
            'date' => new Twig_SimpleFunction('date',array($this,'date'))
        );
    }

    public function date($format)
    {
    	return date($format);
    }

    public function getName()
    {
        return 'app_extension';
    }
}