<?php

namespace App\Intents;

use Alexa\Request\Request;

use RuntimeException;

class ThermostatSetTempIntent extends ThermostatIntent {

	public function handle(Request $request) {
		$targetTemperature = $request->slots['temp'];

		try {
			$this->validateTemperature($targetTemperature);
			$this->setTemperature($targetTemperature);
		} catch (RuntimeException $e) {
			return $this->response->respond($e->getMessage());
		}

		return $this->response
			->respond('Setting the target temperature to ' . $targetTemperature . ' degrees')
			->endSession();
	}
	
}