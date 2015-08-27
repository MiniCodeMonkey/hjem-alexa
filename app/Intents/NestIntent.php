<?php

namespace App\Intents;

use Alexa\Request\Request;

use RuntimeException;

abstract class NestIntent extends Intent {

	protected function validateTemperature($targetTemperature) {
		if (!is_numeric($targetTemperature)) {
			throw new RuntimeException('Please specify a valid number.');
		}

		if ($targetTemperature < 20) {
			throw new RuntimeException($targetTemperature . ' degrees?! I don\'t think you meant to turn the house into an iglo');
		}

		if ($targetTemperature > 100) {
			throw new RuntimeException($targetTemperature . ' degrees?! I don\'t think you meant to turn the house into a fire pit');
		}
	}

	protected function getTemperature($targetTemperature = false) {
		$hjemClient = app()->make('HjemClient');
		$response = $hjemClient->get('current/temperature/' . ($targetTemperature ? 'target' : 'indoor'));
		$json = json_decode($response->getBody());

		return round($json->value);
	}

	protected function setTemperature($targetTemperature) {
		$hjemClient = app()->make('HjemClient');
		$response = $hjemClient->post('set/target_temperature/' . $targetTemperature);
		if ($response->getStatusCode() != 200) {
			throw new \RuntimeException('Could not communicate with hjem and/or nest');
		}
	}
}