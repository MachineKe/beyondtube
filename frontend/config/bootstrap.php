<?php

// Load environment variables from .env if present
$dotenvPath = dirname(__DIR__) . '/.env';
if (file_exists($dotenvPath)) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}
