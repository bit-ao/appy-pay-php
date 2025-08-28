<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use Dotenv\Repository\RepositoryBuilder;

require __DIR__ . '/../vendor/autoload.php';

$root = dirname(__DIR__);
$envFile = is_file("$root/.env.test") ? '.env.test' : '.env';

// Escrever também no getenv():
$repo = RepositoryBuilder::createWithDefaultAdapters()
    ->make();

// Em testes, deixa .env(.test) SOBRESCREVER o que vier do shell:
Dotenv::create($repo, $root, $envFile);

// Default se não vier do ficheiro:
$_ENV['APP_ENV'] = $_ENV['APP_ENV'] ?? 'test';
putenv('APP_ENV=' . $_ENV['APP_ENV']);
