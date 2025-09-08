<?php
/**
 * Auto Configuration for Different Environments
 * Automatically detects and configures based on environment
 */

// Environment detection
function detectEnvironment() {
    // Check if we're in a container
    $isContainer = file_exists('/.dockerenv');
    
    // Check for production indicators
    $isProduction = getenv('APP_ENV') === 'production' || 
                   getenv('NODE_ENV') === 'production' ||
                   !empty(getenv('PRODUCTION'));
    
    // Check for Docker Gateway (development)
    $dockerGateway = '172.17.0.1';
    $isDevelopment = $isContainer && !$isProduction;
    
    return [
        'is_container' => $isContainer,
        'is_production' => $isProduction,
        'is_development' => $isDevelopment,
        'docker_gateway' => $dockerGateway
    ];
}

// Auto-configure API URL based on environment
function getApiUrl() {
    $env = detectEnvironment();
    
    // Priority order:
    // 1. Environment variable (highest priority)
    $envUrl = getenv('API_BASE_URL');
    if ($envUrl) {
        return rtrim($envUrl, '/');
    }
    
    // 2. Development with Docker Gateway
    if ($env['is_development']) {
        return "http://{$env['docker_gateway']}:8080";
    }
    
    // 3. Production fallback
    if ($env['is_production']) {
        return 'https://your-backend-domain.com'; // Should be set via environment
    }
    
    // 4. Local development fallback
    return 'http://localhost:8080';
}

// Usage in config.php
if (!defined('API_BASE_URL_DETECTED')) {
    define('API_BASE_URL_DETECTED', getApiUrl());
}

// Debug info (only in development)
if (!($_ENV['DEBUG_MODE'] ?? false)) {
    $env = detectEnvironment();
    error_log("Auto-Config Debug: " . json_encode([
        'environment' => $env,
        'api_url' => API_BASE_URL_DETECTED,
        'is_container' => $env['is_container'] ? 'yes' : 'no'
    ]));
}