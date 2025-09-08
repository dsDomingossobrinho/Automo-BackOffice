<!DOCTYPE html>
<html>
<head>
    <title>Test Form - Automo BackOffice</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-group { margin: 20px 0; }
        input { padding: 10px; width: 300px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .success { background: #d4edda; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .error { background: #f8d7da; padding: 10px; margin: 10px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🧪 Test Form Submission</h1>
    
    <?php if ($_POST): ?>
        <div class="success">
            <h3>✅ Form submitted successfully!</h3>
            <pre><?= print_r($_POST, true) ?></pre>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="/test-form.php">
        <div class="form-group">
            <label>Email:</label><br>
            <input type="text" name="email" value="test@example.com" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label><br>
            <input type="password" name="password" value="password123" required>
        </div>
        
        <div class="form-group">
            <button type="submit">Test Submit</button>
        </div>
    </form>
    
    <hr>
    
    <h2>🔧 Test Login Form</h2>
    <form method="POST" action="/login">
        <input type="hidden" name="_token" value="test-token">
        
        <div class="form-group">
            <label>Email:</label><br>
            <input type="text" name="email" value="admin@automo.com" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label><br>
            <input type="password" name="password" value="admin123" required>
        </div>
        
        <div class="form-group">
            <button type="submit">Login Test</button>
        </div>
    </form>
    
    <hr>
    <p><a href="/">← Back to App</a></p>
    
    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                console.log('Form submitting:', {
                    action: this.action,
                    method: this.method,
                    data: new FormData(this)
                });
            });
        });
    </script>
</body>
</html>