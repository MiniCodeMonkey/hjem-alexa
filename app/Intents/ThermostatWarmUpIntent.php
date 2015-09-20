<?php

namespace App\Intents;

use Alexa\Request\Request;

class ThermostatWarmUpIntent extends ThermostatIntent {

	public function handle(Request $request) {
		$targetTemperature = $this->getTemperature(true) + 2;

		try {
			$this->setTemperature($targetTemperature);
		} catch (RuntimeException $e) {
			return $this->response->respond($e->getMessage());
		}

		return $this->response
			->respond('Ice ice baby to cold, to cold. I\'m increasing the target temperature to ' . $targetTemperature . ' degrees');
	}
}