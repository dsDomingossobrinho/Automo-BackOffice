<?php
/**
 * Automo BackOffice Frontend
 * Entry Point - Front Controller Pattern
 */

session_start();

// Define constants
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('HELPERS_PATH', ROOT_PATH . '/helpers');

// Autoloader
require_once ROOT_PATH . '/config/autoload.php';

// Load environment variables
require_once CONFIG_PATH . '/env.php';

// Load configuration
require_once CONFIG_PATH . '/config.php';

// Load helpers
require_once HELPERS_PATH . '/functions.php';

// Initialize Router
$router = new App\Core\Router();

// Define routes
require_once ROOT_PATH . '/config/routes.php';

// Handle the request
try {
    $router->dispatch();
} catch (Exception $e) {
    // Error handling
    http_response_code(500);
    if (DEBUG_MODE) {
        echo "<h1>Error</h1><p>" . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    } else {
        include APP_PATH . '/Views/errors/500.php';
    }
}