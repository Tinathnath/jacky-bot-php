<?php
ini_set('memory_limit', '-1');
require_once __DIR__.'/vendor/autoload.php';

use Jacky\JackyStarter;
use Jacky\Config\ConfigurationLoader;
use Jacky\Config\ParametersLoader;
use Jacky\Factory\DiscordFactory;
use Jacky\Jacky;

echo 'Starting Jacky...'.PHP_EOL;
echo 'Préchauffage en cours...'.PHP_EOL;

$starter = new JackyStarter();

$configurationLoader = new ConfigurationLoader();
$configuration = $configurationLoader->load(__DIR__.'/config', 'config.yml');

$parametersLoader = new ParametersLoader();
$parameters = $parametersLoader->load(__DIR__.'/config', 'parameters.yml');

/*
$parameters = $starter->loadParameters(__DIR__.'/config');
$starter->setApiToken($parameters->get('parameters.discord_api_token'));
$discord = $starter->initDiscord();
$standardCommand = $starter->initStandardCommandClient();
$advancedCommand = $starter->initAdvancedCommandClient();
*/

$factory = new DiscordFactory($parameters->get('discord_api_token'));
$discord = $factory->create();

echo 'Démarrage...'.PHP_EOL;
$discord->on('ready', function() use ($discord) {
    $jacky = new Jacky($discord);





            // Listen for messages.
     /*       $discord->on('message', function ($message, $discord) {
                echo "{$message->author->username}: {$message->content}",PHP_EOL;
                $message->reply("Hola camarade");
            });*/

    echo 'Système opérationnel. Jacky écoute le chan.'.PHP_EOL;
});

/* Hey */
$discord->registerCommand('coucou', [ 'Salut !', 'M\'jour vieille branche', 'HEY bonjour enculé', ':wave:', 'Salut ! Comment vont ta femme et mes gosses ? :nerd:', 'Bonjour biloute !' ],
    [
        'aliases' => ['salut', 'hello', ':wave:', 'beat', 'bonjour', 'bonsoir', 'hi', 'lu', 'yo', 'yop']
    ]);

$discord->run();

