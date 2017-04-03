<?php
ini_set('memory_limit', '-1');
require_once __DIR__.'/vendor/autoload.php';

use Jacky\Config\ConfigurationLoader;
use Jacky\Config\ParametersLoader;
use Jacky\Factory\DiscordFactory;
use Jacky\Jacky;

echo 'Starting Jacky...'.PHP_EOL;
echo 'Préchauffage en cours...'.PHP_EOL;

$configurationLoader = new ConfigurationLoader();
$configuration = $configurationLoader->load(__DIR__.'/config', 'config.yml');

$parametersLoader = new ParametersLoader();
$parameters = $parametersLoader->load(__DIR__.'/config', 'parameters.yml');

$factory = new DiscordFactory($parameters->get('discord_api_token'), $configuration->get('command_prefix'));
$discord = $factory->create([
    'description' => $configuration->get('description')
]);

echo 'Démarrage...'.PHP_EOL;
$discord->on('ready', function() use ($discord) {


            // Listen for messages.
     /*       $discord->on('message', function ($message, $discord) {
                echo "{$message->author->username}: {$message->content}",PHP_EOL;
                $message->reply("Hola camarade");
            });*/

    echo 'Système opérationnel. Jacky écoute le chan.'.PHP_EOL;
});

$jacky = new Jacky($discord);
$jacky->setConfiguration($configuration)
    ->setParameters($parameters)
    ->init()
    ->run();

