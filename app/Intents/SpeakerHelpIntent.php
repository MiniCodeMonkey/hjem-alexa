<?php

namespace App\Intents;

use Alexa\Request\Request;

class SpeakerHelpIntent extends HelpIntent {

	protected $examples = [
		'Play electro swing',
		'Stop music',
		'I want to listen to electro swing',
		'Play me some electro swing',
	];
}