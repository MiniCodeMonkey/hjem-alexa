<?php

namespace App\Intents;

use Alexa\Request\Request;

use RuntimeException;

class SpeakerPlayPlaylistIntent extends SpeakerIntent {

	public function handle(Request $request) {
		$playlistName = $request->slots['playlist'];

		try {
			$playlistName = $this->play($playlistName);
		} catch (RuntimeException $e) {
			return $this->response->respond($e->getMessage());
		}

		return $this->response
			->respond('Now playing ' . $playlistName);
	}
	
}