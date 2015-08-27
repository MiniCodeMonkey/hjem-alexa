<?php

namespace App\Intents;

use Alexa\Request\Request;
use Alexa\Response\Response;

abstract class Intent {
	public abstract function handle(Request $request);

	protected $response;

	public function __construct() {
		$this->response = new Response;
	}
	
}