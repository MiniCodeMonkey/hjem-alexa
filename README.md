![Hjem and Amazon Alexa](http://i.imgur.com/RkM4oBO.png)

# Amazon Alexa controller for Hjem

## Installation

### Set up Alexa Controller
The Alexa controller is a Laravel (PHP) app, it just needs to be available on any public facing URL so Amazon can reach it.

You can install the Alexa controller like any other composer-based PHP app.

```bash
git clone git@github.com:hjem/hjem-alexa.git
cd hjem-alexa
composer install
```

### Create Alexa App
Go to the [Amazon Developer Console](https://developer.amazon.com) and register a new Alexa app.

I would recommend creating an app for each primary feature in order to make voice commands simple and easy. Currently that means creating a `thermostat` and `speaker` app.

Here is the details I used for the thermostat app:
![image](http://i.imgur.com/Dpria9Z.png)
![image](http://i.imgur.com/PViQkLk.png)


You can find the full `intents` and `utterances` in the `schema` folder in this project. Feel free to contribute with more if you'd like!

The invocation name is the trigger word that Alexa uses to interact with your app, you can pick anything you'd like.

## Usage

Here's a few examples of what you can say:

* Alexa, tell {invocation} set temperature to seventy degrees
* Alexa, tell {invocation} it is too hot
* Alexa, tell {invocation} it is too cold
* Alexa, tell {invocation} what is the temperature

Where invocation would be the name you selected when creating the Alexa app (e.g. `thermostat`)
