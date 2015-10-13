<?php

namespace AppBundle;

class TicketLine {

	private $apikey;

	function __construct($apikey) {
		$this->apikey = $apikey;
	}

	private function submitCurl($ch)
	{
		//return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

		return $output;
	}

	public function getHighlights()
	{
		$url = "http://api.ticketline.co.uk//recommendation?method=getHighlights&limit=8&api-key=".$this->apikey."&on-sale=true";
    	// $recommendationurl
    	$ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 

       	$output = $this->submitCurl($ch);

    	return json_decode($output);
	}

	public function getArtistByTag($tag)
	{
		$ch = curl_init();

		$url = "http://api.ticketline.co.uk//artist?method=getByTag&tag-slug=".$tag."&api-key=".$this->apikey."&on-sale=true";

		// set url 
        curl_setopt($ch, CURLOPT_URL, $url); 
        
        $output = $this->submitCurl($ch);

        return json_decode($output);
	}

	public function getArtistBySlug($slug)
	{
		$artistbytagurl = "http://api.ticketline.co.uk//artist";

        $ch = curl_init(); 

        $encoded = "";

        $encoded .= urlencode('api-key').'='.urlencode($this->apikey).'&';
        $encoded .= urlencode('method').'='.urlencode('getBySlug').'&';
        $encoded .= urlencode('slug').'='.urlencode($slug).'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $artistbytagurl); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

       	$output = $this->submitCurl($ch);

        return json_decode($output);
	}

	public function getEventsByArtist($artistid)
	{
		$artisturl = "http://api.ticketline.co.uk//event";

        $ch = curl_init(); 

        $encoded = "";

        $encoded .= urlencode('api-key').'='.urlencode($this->apikey).'&';
        $encoded .= urlencode('method').'='.urlencode('getByArtist').'&';
        $encoded .= urlencode('artist-id').'='.urlencode($artistid).'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $artisturl); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        $output = $this->submitCurl($ch);

        return json_decode($output);
	}

	public function getEventPricesByEventId($id)
	{
		$url = "http://api.ticketline.co.uk//order";

 		$ch = curl_init(); 

		$user = file_get_contents(__DIR__."/user.json");
		$user = json_decode($user);

        $encoded = "";
        $time = time();

        $apitoken = $time."YWFmOGMzNWJlNjk";
        $apitoken = sha1($apitoken);
		
		$user_token = sha1("123456" . $user->email_address . "YWFmOGMzNWJlNjk");

        $encoded .= urlencode('api-key').'='.urlencode($this->apikey).'&';
        $encoded .= urlencode('method').'='.urlencode('getPrices').'&';
        $encoded .= urlencode('user-token').'='.urlencode($user_token).'&';
        $encoded .= urlencode('timestamp').'='.urlencode($time).'&';
        $encoded .= urlencode('api-token').'='.urlencode($apitoken).'&';
        $encoded .= urlencode('event-id').'='.urlencode($id).'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        $output = $this->submitCurl($ch);

        return json_decode($output);
	}

	public function getDeliveryMethodsById($id)
	{
		$url = "http://api.ticketline.co.uk//order";

        $ch = curl_init(); 

        $encoded = "";
        $time = time();

        $apitoken = $time."YWFmOGMzNWJlNjk";
        $apitoken = sha1($apitoken);

        $user = file_get_contents(__DIR__."/user.json");
		$user = json_decode($user);

        $user_token = sha1("123456" . $user->email_address . "YWFmOGMzNWJlNjk");

        $encoded .= urlencode('api-key').'='.urlencode($this->apikey).'&';
        $encoded .= urlencode('method').'='.urlencode('getDeliveryMethods').'&';
        $encoded .= urlencode('user-token').'='.urlencode($user_token).'&';
        $encoded .= urlencode('timestamp').'='.urlencode($time).'&';
        $encoded .= urlencode('api-token').'='.urlencode($apitoken).'&';
        $encoded .= urlencode('event-id').'='.urlencode($id).'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        $output = $this->submitCurl($ch);

        return json_decode($output);
	}

	public function loginUser($email,$password)
	{
		$url = "http://api.ticketline.co.uk//user";

    	$encoded = "";
    	$time = time();

    	$ch = curl_init(); 

    	$apitoken = $time."YWFmOGMzNWJlNjk";
        $apitoken = sha1($apitoken);

    	$encoded .= urlencode('api-key').'='.urlencode($this->apikey).'&';
        $encoded .= urlencode('method').'='.urlencode('signIn').'&';
        $encoded .= urlencode('timestamp').'='.urlencode($time).'&';
       
        $encoded .= urlencode('email').'='.urlencode($email).'&';
        $encoded .= urlencode('password').'='.urlencode($password).'&';
        $encoded .= urlencode('api-token').'='.urlencode($apitoken).'&';

        $encoded .= urlencode('device-uuid').'='.urlencode("123456").'&';

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_POST, 1);
        $encoded = substr($encoded, 0, strlen($encoded)-1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        $output = $this->submitCurl($ch);

        return json_decode($output);
	}
        
}