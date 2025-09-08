<?php
echo "<h1>Asset Test Page</h1>";
echo "<p>Testing if assets are accessible...</p>";

$assets = [
    '/assets/css/app.css' => 'CSS File',
    '/assets/js/app.js' => 'JavaScript File'
];

foreach ($assets as $path => $name) {
    $fullPath = __DIR__ . $path;
    $exists = file_exists($fullPath);
    $readable = is_readable($fullPath);
    
    echo "<p><strong>{$name} ({$path})</strong>:</p>";
    echo "<ul>";
    echo "<li>Exists: " . ($exists ? '✅ Yes' : '❌ No') . "</li>";
    echo "<li>Readable: " . ($readable ? '✅ Yes' : '❌ No') . "</li>";
    if ($exists) {
        echo "<li>Size: " . filesize($fullPath) . " bytes</li>";
        echo "<li>Permissions: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "</li>";
    }
    echo "</ul>";
}

echo "<p><a href='/'>← Back to Login</a></p>";
?>