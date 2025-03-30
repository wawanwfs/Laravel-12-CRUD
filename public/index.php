<?php

// Path ke folder aplikasi Laravel
define('LARAVEL_START', microtime(true));

// Periksa apakah sedang berjalan di GitHub Pages
$basePath = '/';
if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'github.io') !== false) {
    // Ekstrak nama repository dari URL jika pada github.io
    $uriParts = explode('/', $_SERVER['REQUEST_URI']);
    if (count($uriParts) > 1) {
        $basePath = '/' . $uriParts[1] . '/';
    }
}

// Register Composer autoloader
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    die('Composer autoloader not found. Please run "composer install".');
}

// Load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

// Set base path untuk GitHub Pages
if (strpos($_SERVER['HTTP_HOST'] ?? '', 'github.io') !== false) {
    $_SERVER['SCRIPT_NAME'] = $basePath . 'index.php';
}

// Bootstrap Laravel application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set public path
$app->usePublicPath(__DIR__);

// Run the application
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
