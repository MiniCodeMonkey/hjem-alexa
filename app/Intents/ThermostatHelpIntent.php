<?php

namespace App\Intents;

use Alexa\Request\Request;

class ThermostatHelpIntent extends HelpIntent {

	protected $examples = [
		'Set temperature to seventy two degrees',
		'It is too hot',
		'It is too cold',
		'What is the temperature',
		'I\'m too cold',
		'Turn the temperature up',
		'Turn the temperature down',
		'It is as hot as the fiery pits of hell',
	];

	protected $invocationName = 'thermostat';
}