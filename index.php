<?php

include __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Services\DiscordService;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$discordService = new DiscordService();

$discordService->run();

