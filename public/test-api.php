<!DOCTYPE html>
<html>
<head>
    <title>API Test - Automo BackOffice</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .test { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        .success { background: #d4edda; border-color: #c3e6cb; }
        .error { background: #f8d7da; border-color: #f5c6cb; }
        .info { background: #d1ecf1; border-color: #bee5eb; }
        pre { background: #f8f9fa; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>🧪 API Connection Test</h1>
    
    <?php
    // Load configuration
    define('ROOT_PATH', dirname(__DIR__));
    require_once ROOT_PATH . '/config/autoload.php';
    require_once ROOT_PATH . '/config/env.php';
    require_once ROOT_PATH . '/config/config.php';
    require_once ROOT_PATH . '/helpers/functions.php';
    
    echo '<div class="test info">';
    echo '<h3>📋 Configuration</h3>';
    echo '<p><strong>DEBUG_MODE:</strong> ' . (DEBUG_MODE ? 'true' : 'false') . '</p>';
    echo '<p><strong>API_BASE_URL:</strong> ' . API_BASE_URL . '</p>';
    echo '</div>';
    
    // Test API connection
    $api = new App\Core\ApiClient();
    
    echo '<div class="test">';
    echo '<h3>🔗 API Health Check</h3>';
    
    $healthCheck = $api->healthCheck();
    
    if ($healthCheck['success']) {
        echo '<div class="success">';
        echo '<p>✅ API connection successful!</p>';
        echo '<pre>' . json_encode($healthCheck['data'], JSON_PRETTY_PRINT) . '</pre>';
        echo '</div>';
    } else {
        echo '<div class="error">';
        echo '<p>❌ API connection failed!</p>';
        echo '<p><strong>Error:</strong> ' . $healthCheck['message'] . '</p>';
        if (isset($healthCheck['details'])) {
            echo '<pre>' . json_encode($healthCheck['details'], JSON_PRETTY_PRINT) . '</pre>';
        }
        echo '</div>';
    }
    echo '</div>';
    
    // Test BackOfficeRequestOTP endpoint
    echo '<div class="test">';
    echo '<h3>🔐 Test BackOfficeRequestOTP Endpoint</h3>';
    
    $loginData = [
        'emailOrContact' => 'admin@automo.com',
        'password' => 'admin123'
    ];
    
    $loginResponse = $api->post('/auth/login/backoffice/request-otp', $loginData);
    
    if ($loginResponse['success']) {
        echo '<div class="success">';
        echo '<p>✅ BackOfficeRequestOTP endpoint responded successfully!</p>';
        echo '<pre>' . json_encode($loginResponse['data'], JSON_PRETTY_PRINT) . '</pre>';
        echo '</div>';
    } else {
        echo '<div class="error">';
        echo '<p>❌ BackOfficeRequestOTP endpoint failed!</p>';
        echo '<p><strong>Error:</strong> ' . $loginResponse['message'] . '</p>';
        if (isset($loginResponse['http_code'])) {
            echo '<p><strong>HTTP Code:</strong> ' . $loginResponse['http_code'] . '</p>';
        }
        if (isset($loginResponse['details'])) {
            echo '<pre>' . json_encode($loginResponse['details'], JSON_PRETTY_PRINT) . '</pre>';
        }
        echo '</div>';
    }
    echo '</div>';
    
    // Test VerifyOTP endpoint (demo)
    echo '<div class="test">';
    echo '<h3>🔒 Test VerifyOTP Endpoint (Demo)</h3>';
    
    $otpData = [
        'contact' => 'admin@automo.com',
        'otpCode' => '123456'
    ];
    
    $otpResponse = $api->post('/auth/login/backoffice/verify-otp', $otpData);
    
    if ($otpResponse['success']) {
        echo '<div class="success">';
        echo '<p>✅ VerifyOTP endpoint responded successfully!</p>';
        echo '<pre>' . json_encode($otpResponse['data'], JSON_PRETTY_PRINT) . '</pre>';
        echo '</div>';
    } else {
        echo '<div class="error">';
        echo '<p>❌ VerifyOTP endpoint failed (expected for demo)!</p>';
        echo '<p><strong>Error:</strong> ' . $otpResponse['message'] . '</p>';
        if (isset($otpResponse['http_code'])) {
            echo '<p><strong>HTTP Code:</strong> ' . $otpResponse['http_code'] . '</p>';
        }
        if (isset($otpResponse['details'])) {
            echo '<pre>' . json_encode($otpResponse['details'], JSON_PRETTY_PRINT) . '</pre>';
        }
        echo '</div>';
    }
    echo '</div>';
    ?>
    
    <hr>
    <p><a href="/">← Back to App</a></p>
</body>
</html>