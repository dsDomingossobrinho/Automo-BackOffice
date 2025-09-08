<?php
/**
 * Application Configuration
 */

// Start output buffering to prevent headers already sent errors
ob_start();

// Configure session BEFORE starting session
if (session_status() === PHP_SESSION_NONE) {
    // Session file storage configuration
    $sessionPath = __DIR__ . '/../storage/sessions';
    if (!is_dir($sessionPath)) {
        mkdir($sessionPath, 0755, true);
    }
    ini_set('session.save_path', $sessionPath);
    ini_set('session.save_handler', 'files');
    
    // Session security configuration
    ini_set('session.cookie_lifetime', 3600 * 4); // 4 hours
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? '1' : '0');
    ini_set('session.use_strict_mode', 1);
    ini_set('session.name', 'automo_backoffice_session');
}

// Environment settings
define('DEBUG_MODE', $_ENV['DEBUG_MODE'] ?? true);
define('APP_NAME', 'Automo BackOffice');
define('APP_VERSION', '1.0.0');

// Base URLs
define('BASE_URL', $_ENV['BASE_URL'] ?? 'http://localhost:3000');
define('ASSETS_URL', BASE_URL . '/assets');

// Auto-detect API configuration based on environment
require_once __DIR__ . '/../docker/auto-config.php';

// API Configuration with auto-detection fallback
define('API_BASE_URL', $_ENV['API_BASE_URL'] ?? API_BASE_URL_DETECTED);
define('API_TIMEOUT', $_ENV['API_TIMEOUT'] ?? 30);

// Session Configuration
define('SESSION_LIFETIME', 3600 * 4); // 4 hours (same as JWT)
define('SESSION_NAME', 'automo_backoffice_session');

// Security
define('CSRF_TOKEN_NAME', '_token');

// Pagination
define('DEFAULT_PAGE_SIZE', 10);
define('MAX_PAGE_SIZE', 100);

// File upload
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5MB
define('UPLOAD_ALLOWED_TYPES', ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']);

// Timezone
date_default_timezone_set('UTC');