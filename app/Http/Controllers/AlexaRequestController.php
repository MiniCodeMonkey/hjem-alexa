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
        	$intent = $this->getIntent($alexaRequest->intentName);
        	$alexaResponse = $intent->handle($alexaRequest);
        } elseif ($alexaRequest instanceof LaunchRequest) {
            try {
                $appName = $this->getAppNameFromId($alexaRequest->application->applicationId);
                $intent = $this->getIntent($appName . 'HelpIntent');
            } catch (RuntimeException $e) {
                $alexaResponse = new AlexaResponse;
                $alexaResponse->respond('How can I help you?')
                    ->reprompt('What do you want to do?');
            }
        } else {
        	$alexaResponse = new AlexaResponse;
        }

        return response()->json($alexaResponse->render());
    }

    private function getIntent($intentName) {
        $className = '\\App\\Intents\\' . $intentName;

        if (class_exists($className)) {
            $intent = new $className;
        } else {
            throw new RuntimeException('Unknown intent ' . $className);
        }

        return $intent;
    }

    private function getAppNameFromId($appId) {
        if ($appId === env('THERMOSTAT_APP_ID')) {
            return 'Thermostat';
        } elseif ($appId === env('SPEAKER_APP_ID')) {
            return 'Speaker';
        }

        throw new RuntimeException('Unknown app id ' . $appId . ' please register your app ids as environment variables');
    }


}
