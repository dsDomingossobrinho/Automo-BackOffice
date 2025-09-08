<?php
/**
 * Autoloader for the MVC framework
 */

spl_autoload_register(function ($class) {
    // Convert namespace to directory structure
    $classFile = str_replace(['\\', 'App/'], ['/', ''], $class) . '.php';
    $filePath = APP_PATH . '/' . $classFile;
    
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

// Load core classes
require_once APP_PATH . '/Core/Router.php';
require_once APP_PATH . '/Core/Controller.php';
require_once APP_PATH . '/Core/Model.php';
require_once APP_PATH . '/Core/View.php';
require_once APP_PATH . '/Core/Auth.php';
require_once APP_PATH . '/Core/ApiClient.php';