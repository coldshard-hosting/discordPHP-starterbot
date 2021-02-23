<?php

include __DIR__.'/vendor/autoload.php';

use Discord\Discord;

$configPath = "config.json";
$defaults = ["token" => ""];
if (!file_exists($configPath)) {
    $writer = fopen($configPath, "c");
    fwrite($writer, json_encode($defaults, JSON_PRETTY_PRINT));
    fclose($writer);
}

$configFile = file_get_contents($configPath);
$config = json_decode($configFile, true);
$token = $config["token"];
if ($token === "") {
    die("Please edit config.json");
}

$discord = new Discord([
	'token' => $token,
]);

$discord->on('ready', function ($discord) {
	echo "Bot is ready!", PHP_EOL;

	// Listen for messages.
	$discord->on('message', function ($message, $discord) {
		echo "{$message->author->username}: {$message->content}",PHP_EOL;
	});
});

$discord->run();