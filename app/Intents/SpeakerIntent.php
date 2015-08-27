<?php

namespace App\Intents;

use Alexa\Request\Request;

use RuntimeException;

abstract class SpeakerIntent extends Intent {

	protected function stop() {
		$hjemClient = app()->make('HjemClient');
		$response = $hjemClient->post('set/speaker/off');
		if ($response->getStatusCode() != 200) {
			throw new \RuntimeException('Could not communicate with hjem and/or speaker');
		}
	}

	protected function play($playlistName) {
		$hjemClient = app()->make('HjemClient');
		$response = $hjemClient->post('set/speaker/playlist/' . $playlistName);
		if ($response->getStatusCode() != 200) {
			throw new \RuntimeException('Could not communicate with hjem and/or speaker');
		}

		$json = json_decode($response->getBody());

		return $json->value;
	}
}