<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Resolve the project root
|--------------------------------------------------------------------------
|
| This keeps local development working with the standard Laravel layout
| and also supports the Aston host deployment where `public/` contents are
| copied into `public_html/` and the full project sits one level above it.
|
*/
$projectRootCandidates = [
    __DIR__.'/..',
    __DIR__.'/../CS2TP_G56',
];

$projectRoot = null;

foreach ($projectRootCandidates as $candidate) {
    if (file_exists($candidate.'/vendor/autoload.php') && file_exists($candidate.'/bootstrap/app.php')) {
        $projectRoot = $candidate;
        break;
    }
}

if ($projectRoot === null) {
    throw new RuntimeException('Unable to locate the Laravel project root.');
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $projectRoot.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $projectRoot.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $projectRoot.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
