<?php

/**
 * ASMVC Bootstrap and Init System
 * Powered by Composer's PSR4
 */

use App\Core\Containers\Container;
use App\Core\Logger\Logger;
use Dotenv\Dotenv;

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * Load DotEnv Library
 */
$dotenv = Dotenv::createImmutable(base_path());
$dotenv->safeLoad();

/**
 * Boot DI Container for auto injecting.
 */
Container::make();
