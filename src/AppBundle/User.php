<?php

namespace AppBundle;

use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class User extends Controller {
	private $user;
	public $first_name;
	public $last_name;

	function __construct($session) {
		// $session = new Session();
		// $session->start();
		// $session = $this->get('session');
		// $session->start();
		// print_r($session);
		// die;

		$user = $session->get('user');

		if(!empty($user)) {
			$this->first_name = $user->first_name;
			$this->last_name = $user->last_name;
		}
		
		$this->user = $user;
	}
}