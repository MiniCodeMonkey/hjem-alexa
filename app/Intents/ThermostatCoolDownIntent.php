<?php

namespace App\Intents;

use Alexa\Request\Request;

class ThermostatCoolDownIntent extends ThermostatIntent {

	public function handle(Request $request) {
		$targetTemperature = $this->getTemperature(true) - 2;

		try {
			$this->setTemperature($targetTemperature);
		} catch (RuntimeException $e) {
			return $this->response->respond($e->getMessage());
		}

		return $this->response
			->respond('Cool! I decreased the target temperature to ' . $targetTemperature . ' degrees')
			->endSession();
	}

}