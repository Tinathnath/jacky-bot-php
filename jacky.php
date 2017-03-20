<?php
ini_set('memory_limit', '-1');
require_once __DIR__.'/vendor/autoload.php';

use Jacky\JackyStarter;

echo 'Starting Jacky...'.PHP_EOL;
echo 'Préchauffage en cours...'.PHP_EOL;

$starter = new JackyStarter($configuration->get('jacky.discord_api_token'));
$configuration = $starter->loadConfiguration(__DIR__.'/config');

$discord = $starter->initDiscord();
$standardCommand = $starter->initStandardCommandClient();
$advancedCommand = $starter->initAdvancedCommandClient();

echo 'Démarrage...'.PHP_EOL;

$discord->run();
echo 'Système opérationnel. Jacky écoute le chan.'.PHP_EOL;
