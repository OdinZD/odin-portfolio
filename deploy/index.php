<?php

/**
 * Production front controller for cPanel shared hosting.
 *
 * The live web root (public_html) holds a COPY of the app's public/ folder, but
 * the rest of the Laravel app lives OUTSIDE the web root. This file is copied to
 * public_html/index.php during deployment, with __APP_BASE__ replaced by the
 * absolute path to the app folder (see .cpanel.yml). Do not edit by hand.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$base = '__APP_BASE__';

// Maintenance mode...
if (file_exists($maintenance = $base.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer autoloader...
require $base.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $base.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
