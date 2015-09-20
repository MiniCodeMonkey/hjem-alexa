<?php

namespace App\Intents;

use Alexa\Request\Request;

abstract class HelpIntent extends Intent {

	protected $examples = [];

	public function handle(Request $request) {
		$examples = $this->getExamples();

		// Pick two random examples
		$selectedExampleIndexes = array_rand($examples, 2);

		return $this->response
			->respond('You can say things like: ' . $examples[$selectedExampleIndexes[0]] . ' or ' . $examples[$selectedExampleIndexes[1]])
        	->withCard('Here\'s some examples', implode(PHP_EOL, $examples));
	}

	private function getExamples() {
		return $this->examples;
	}
}