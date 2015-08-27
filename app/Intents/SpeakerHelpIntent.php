<?php

namespace App\Intents;

use Alexa\Request\Request;

class SpeakerHelpIntent extends HelpIntent {

	protected $examples = [
		'Alexa, tell {invocation} to play electro swing',
		'Alexa, tell {invocation} to stop music',
		'Alexa, tell {invocation} I want to listen to electro swing',
		'Alexa, tell {invocation} play me some electro swing',
	];

	protected $invocationName = 'speaker';
}