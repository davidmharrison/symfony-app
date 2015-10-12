<?php

namespace AppBundle;

class User {
	private $user;
	public $first_name;
	public $last_name;

	function __construct() {
		$user = file_get_contents(__DIR__."/user.json");
		$user = json_decode($user);

		if(!empty($user)) {
			$this->first_name = $user->first_name;
			$this->last_name = $user->last_name;
		}
		
		$this->user = $user;
	}
}