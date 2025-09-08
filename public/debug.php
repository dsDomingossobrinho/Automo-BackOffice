<?php
session_start();

echo "<h1>🔧 Automo BackOffice - Debug Info</h1>";

echo "<h2>📋 Environment</h2>";
echo "<ul>";
echo "<li><strong>PHP Version:</strong> " . phpversion() . "</li>";
echo "<li><strong>Session Status:</strong> " . (session_status() === PHP_SESSION_ACTIVE ? '✅ Active' : '❌ Inactive') . "</li>";
echo "<li><strong>Session ID:</strong> " . session_id() . "</li>";
echo "<li><strong>Current Time:</strong> " . date('Y-m-d H:i:s') . "</li>";
echo "</ul>";

echo "<h2>📝 Constants</h2>";
echo "<ul>";
$constants = ['DEBUG_MODE', 'APP_NAME', 'BASE_URL', 'API_BASE_URL', 'CSRF_TOKEN_NAME'];
foreach ($constants as $const) {
    echo "<li><strong>{$const}:</strong> " . (defined($const) ? constant($const) : '❌ Not defined') . "</li>";
}
echo "</ul>";

echo "<h2>🌐 Request Info</h2>";
echo "<ul>";
echo "<li><strong>Request Method:</strong> " . ($_SERVER['REQUEST_METHOD'] ?? 'Unknown') . "</li>";
echo "<li><strong>Request URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . "</li>";
echo "<li><strong>HTTP Host:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'Unknown') . "</li>";
echo "<li><strong>User Agent:</strong> " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown') . "</li>";
echo "</ul>";

echo "<h2>📊 Session Data</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h2>📮 POST Data</h2>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

echo "<h2>📥 GET Data</h2>";
echo "<pre>";
print_r($_GET);
echo "</pre>";

echo "<h2>🧪 Test Links</h2>";
echo "<ul>";
echo "<li><a href='/'>Root (/)</a></li>";
echo "<li><a href='/login'>Login Page</a></li>";
echo "<li><a href='/test-assets.php'>Assets Test</a></li>";
echo "</ul>";

echo "<h2>🔧 Test Form</h2>";
echo "<form method='POST' action='/debug.php'>";
echo "<input type='text' name='test_field' placeholder='Test input' value='" . ($_POST['test_field'] ?? '') . "'>";
echo "<button type='submit'>Test Submit</button>";
echo "</form>";

if ($_POST) {
    echo "<div style='background: #d4edda; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
    echo "✅ Form submission works! POST data received.";
    echo "</div>";
}

echo "<hr>";
echo "<p><a href='/'>← Back to App</a></p>";
?>