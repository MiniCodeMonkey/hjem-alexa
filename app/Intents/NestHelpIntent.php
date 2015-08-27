<?php

namespace App\Intents;

use Alexa\Request\Request;

class NestHelpIntent extends HelpIntent {

	protected $examples = [
		'Alexa, tell {invocation} set temperature to seventy degrees',
		'Alexa, tell {invocation} it is too hot',
		'Alexa, tell {invocation} it is too cold',
		'Alexa, tell {invocation} what is the temperature',
	];

	protected $invocationName = 'thermostat';
}