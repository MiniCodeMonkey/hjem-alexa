<?php

namespace App\Intents;

use Alexa\Request\Request;

class NestGetTempIntent extends NestIntent {

	public function handle(Request $request) {
		return $this->response
			->respond('It is currently ' . $this->getTemperature() . ' degrees inside');
	}

}