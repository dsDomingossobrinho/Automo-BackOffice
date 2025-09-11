<?php
/**
 * Automo BackOffice Frontend
 * Entry Point - Front Controller Pattern
 */

// Define constants
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('HELPERS_PATH', ROOT_PATH . '/helpers');

// Autoloader
require_once ROOT_PATH . '/config/autoload.php';

// Load environment variables
require_once CONFIG_PATH . '/env.php';

// Load configuration (this will start the session with proper config)
require_once CONFIG_PATH . '/config.php';

// Session is started by config.php with proper settings

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
    // Error handling - Set proper HTTP response code
    http_response_code(500);
    
    // Log the error
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        error_log("500 Error - Message: " . $e->getMessage() . 
                 " - File: " . $e->getFile() . 
                 " - Line: " . $e->getLine() . 
                 " - URI: " . ($_SERVER['REQUEST_URI'] ?? 'unknown'));
    }
    
    // Set error details for debug mode
    $error_details = null;
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        $error_details = "Error: " . $e->getMessage() . "\n" . 
                        "File: " . $e->getFile() . "\n" . 
                        "Line: " . $e->getLine() . "\n" . 
                        "Stack Trace:\n" . $e->getTraceAsString();
    }
    
    // Include custom error page
    $error_file = APP_PATH . '/Views/errors/500.php';
    if (file_exists($error_file)) {
        include $error_file;
    } else {
        // Fallback if error page doesn't exist
        if (DEBUG_MODE) {
            echo "<h1>500 - Internal Server Error</h1>";
            echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
            echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        } else {
            echo '<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Erro Interno do Servidor</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; color: #374151; }
        .error-container { max-width: 500px; margin: 0 auto; }
        .error-code { font-size: 4rem; color: #dc2626; margin-bottom: 1rem; }
        .error-title { font-size: 2rem; margin-bottom: 1rem; }
        .error-desc { color: #6b7280; margin-bottom: 2rem; }
        .btn { background: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">500</div>
        <h1 class="error-title">Erro Interno do Servidor</h1>
        <p class="error-desc">Ocorreu um erro interno. Nossa equipe foi notificada.</p>
        <a href="/" class="btn">Voltar à Página Inicial</a>
    </div>
</body>
</html>';
        }
    }
}