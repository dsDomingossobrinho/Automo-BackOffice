<?php
// Debug script to test different API endpoints
require_once __DIR__ . '/../config/autoload.php';
require_once __DIR__ . '/../config/env.php';  
require_once __DIR__ . '/../config/config.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>API Endpoint Debug</title>
    <style>
        body { font-family: monospace; margin: 20px; }
        .test { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        .success { background: #d4edda; }
        .error { background: #f8d7da; }
        pre { background: #f8f9fa; padding: 10px; }
    </style>
</head>
<body>
    <h1>🔍 API Endpoint Discovery</h1>
    <p><strong>Base URL:</strong> <?= API_BASE_URL ?></p>
    
    <?php
    $apiClient = new App\Core\ApiClient();
    
    // Test different endpoint variations
    $endpoints = [
        '/api/auth/login/backoffice/request-otp',
        '/auth/login/backoffice/request-otp', 
        '/api/login/backoffice/request-otp',
        '/login/backoffice/request-otp',
        '/api/auth/backoffice/request-otp',
        '/auth/backoffice/request-otp',
        '/api/backoffice/request-otp',
        '/backoffice/request-otp',
        '/api/auth/login',
        '/auth/login',
        '/api/login',
        '/login'
    ];
    
    $testData = [
        'emailOrContact' => 'test@test.com',
        'password' => 'test123'
    ];
    
    foreach ($endpoints as $endpoint) {
        echo '<div class="test">';
        echo "<h3>Testing: <code>{$endpoint}</code></h3>";
        
        try {
            $response = $apiClient->post($endpoint, $testData);
            
            if ($response['success']) {
                echo '<div class="success">✅ Success!</div>';
                echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT) . '</pre>';
            } else {
                echo '<div class="error">❌ Failed but got response</div>';
                echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT) . '</pre>';
            }
        } catch (Exception $e) {
            echo '<div class="error">❌ Exception: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        
        echo '</div>';
        
        // Add small delay to avoid overwhelming the server
        usleep(100000); // 0.1 second
    }
    ?>
    
    <hr>
    <p><a href="/">← Back to App</a></p>
</body>
</html>