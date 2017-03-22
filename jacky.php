<?php
ini_set('memory_limit', '-1');
require_once __DIR__.'/vendor/autoload.php';

use Jacky\JackyStarter;
use Jacky\Jacky;

echo 'Starting Jacky...'.PHP_EOL;
echo 'Préchauffage en cours...'.PHP_EOL;

$starter = new JackyStarter();
$configuration = $starter->loadConfiguration(__DIR__.'/config');
$parameters = $starter->loadParameters(__DIR__.'/config');
$starter->setApiToken($parameters->get('parameters.discord_api_token'));

$discord = $starter->initDiscord();
$standardCommand = $starter->initStandardCommandClient();
$advancedCommand = $starter->initAdvancedCommandClient();

echo 'Démarrage...'.PHP_EOL;

$jacky = new Jacky($discord);
$jacky->setStandardCommandClient($standardCommand)
    ->registerStandardCommands()
    ->setAdvancedCommandClient($advancedCommand)
    ->registerAdvancedCommands();

    /* Hey */
        $standardCommand->registerCommand('coucou', function($m, $p) { 
            $author = "{$message->author}";
            return [
                "Salut $author !",
                "M'jour vieille branche $author",
                "HEY bonjour enculé $author !",
                ":wave: $author",
                "Salut $author ! Comment vont ta femme et mes gosses ? :nerd:",
                "Bonjour biloute $author !"
            ];
            }, [
            'aliases' => ['salut', 'hello', 'coucou', ':wave:', 'beat', 'bonjour', 'bonsoir', 'hi', 'lu\'', 'lu', 'yo', 'yop'],
            'usage' => 'Dites bonjour à Jacky. Exemple "Salut @Jacky !"'
        ]);

echo 'Système opérationnel. Jacky écoute le chan.'.PHP_EOL;
$discord->run();

