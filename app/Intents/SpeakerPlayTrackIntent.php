<?php

namespace App\Intents;

use Alexa\Request\Request;

use RuntimeException;

class SpeakerPlayTrackIntent extends SpeakerIntent {

	public function handle(Request $request) {
		$query = $request->slots['query'];

		try {
			$playResponse = $this->play($query);
		} catch (RuntimeException $e) {
			return $this->response->respond($e->getMessage());
		}

		return $this->response
			->respond($playResponse);
	}
	
}