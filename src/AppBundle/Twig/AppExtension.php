<?php

namespace AppBundle\Twig;

use \Twig_Function_Function;

class AppExtension extends \Twig_Extension
{
	public function getFunctions()
    {
        return array(
            'date' => new Twig_Function_Function('date')
        );
    }

    public function getName()
    {
        return 'app_extension';
    }
}