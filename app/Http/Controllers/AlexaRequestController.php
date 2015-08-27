<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Alexa\Request\Request as AlexaRequest;
use Alexa\Request\IntentRequest;
use Alexa\Request\LaunchRequest;
use Alexa\Response\Response as AlexaResponse;
use App\Intents\HelpIntent;

use RuntimeException;

class AlexaRequestController extends Controller
{
    public function handler(Request $request) {
    	info($request->json()->all());
        $alexaRequest = AlexaRequest::fromData($request->json()->all());
        info(print_r($alexaRequest, true));

        if ($alexaRequest instanceof IntentRequest) {
        	$className = '\\App\\Intents\\' . $alexaRequest->intentName;

        	if (class_exists($className)) {
        		$intent = new $className;
        	} else {
        		throw new RuntimeException('Unknown intent ' . $className);
        	}

        	$alexaResponse = $intent->handle($alexaRequest);
        } elseif ($alexaRequest instanceof LaunchRequest) {
            $alexaResponse = new AlexaResponse;
            $alexaResponse->respond('How can I help you?')
                ->reprompt('What do you want to do?');
        } else {
        	$alexaResponse = new AlexaResponse;
        }

        return response()->json($alexaResponse->render());
    }
}
