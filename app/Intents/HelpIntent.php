<?php

namespace App\Intents;

use Alexa\Request\Request;

abstract class HelpIntent extends Intent {

	protected $examples = [];

	public function handle(Request $request) {
		$examples = $this->getExamples();

		return $this->response
			->respond($this->generateExamplesSentence())
			->reprompt($this->generateExamplesSentence())
        	->withCard('Here\'s some examples', implode(PHP_EOL, $examples));
	}

	private function generateExamplesSentence() {
		// Pick two random examples
		$selectedExampleIndexes = array_rand($this->getExamples(), 2);

		return 'You can say things like: ' . $examples[$selectedExampleIndexes[0]] . ' or ' . $examples[$selectedExampleIndexes[1]];
	}

	private function getExamples() {
		return $this->examples;
	}
}