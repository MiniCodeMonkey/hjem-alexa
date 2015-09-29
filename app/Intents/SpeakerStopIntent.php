<?php

namespace App\Intents;

use Alexa\Request\Request;

use RuntimeException;

class SpeakerStopIntent extends SpeakerIntent {

	public function handle(Request $request) {
		try {
			$this->stop();
		} catch (RuntimeException $e) {
			return $this->response->respond($e->getMessage());
		}

		return $this->response
			->respond('Got it!')
			->endSession();
	}
	
}