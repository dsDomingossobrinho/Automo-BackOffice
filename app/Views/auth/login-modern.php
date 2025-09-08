<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= APP_NAME ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/automo-logo.png') ?>">
    
    <!-- Preload Critical Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= asset('css/modern-ui.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Custom Login Styles -->
    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-4);
            position: relative;
            overflow: hidden;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            opacity: 0.3;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 420px;
            padding: var(--space-12);
            position: relative;
            z-index: 1;
            animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @keyframes slideInUp {
            0% {
                opacity: 0;
                transform: translateY(60px) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .login-header {
            text-align: center;
            margin-bottom: var(--space-8);
        }
        
        .login-logo {
            width: 120px;
            height: 120px;
            margin-bottom: var(--space-4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: var(--radius-2xl);
            padding: var(--space-4);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
            border: 3px solid rgba(255, 255, 255, 0.9);
        }
        
        .login-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
        }
        
        .login-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--secondary-800);
            margin: 0 0 var(--space-2) 0;
            letter-spacing: -0.025em;
        }
        
        .login-subtitle {
            color: var(--secondary-600);
            font-size: 0.9375rem;
            margin: 0;
            font-weight: 400;
        }
        
        .login-form {
            display: flex;
            flex-direction: column;
            gap: var(--space-5);
        }
        
        .form-group-enhanced {
            position: relative;
        }
        
        .form-label-enhanced {
            display: block;
            font-weight: 500;
            color: var(--secondary-700);
            margin-bottom: var(--space-2);
            font-size: 0.875rem;
        }
        
        .form-input-enhanced {
            width: 100%;
            padding: var(--space-4) var(--space-4) var(--space-4) 3rem;
            font-size: 1rem;
            border: 2px solid var(--secondary-200);
            border-radius: var(--radius-xl);
            background: rgba(255, 255, 255, 0.9);
            transition: all var(--transition-medium);
            font-family: var(--font-family-sans);
            backdrop-filter: blur(10px);
        }
        
        .form-input-enhanced:focus {
            outline: none;
            border-color: var(--primary-500);
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }
        
        .form-input-enhanced::placeholder {
            color: var(--secondary-400);
            font-weight: 400;
        }
        
        .form-icon {
            position: absolute;
            left: var(--space-4);
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-400);
            font-size: 1.125rem;
            transition: all var(--transition-fast);
            z-index: 2;
            pointer-events: none; /* Prevent icon from blocking input clicks */
        }
        
        .form-group-enhanced:focus-within .form-icon {
            color: var(--primary-500);
            transform: translateY(-50%) scale(1.1);
        }
        
        .login-button {
            width: 100%;
            padding: var(--space-4) var(--space-6);
            font-size: 1rem;
            font-weight: 600;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: var(--radius-xl);
            cursor: pointer;
            transition: all var(--transition-medium);
            position: relative;
            overflow: hidden;
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.3);
            font-family: var(--font-family-sans);
        }
        
        .login-button:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px 0 rgba(59, 130, 246, 0.4);
        }
        
        .login-button:active:not(:disabled) {
            transform: translateY(-1px);
        }
        
        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }
        
        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .login-button:hover::before {
            left: 100%;
        }
        
        .forgot-password-section {
            text-align: center;
            margin-top: var(--space-4);
        }
        
        .forgot-password-link {
            color: var(--primary-600);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: var(--space-1);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-md);
        }
        
        .forgot-password-link:hover {
            color: var(--primary-700);
            background: rgba(59, 130, 246, 0.05);
            transform: translateY(-1px);
        }
        
        .login-footer {
            text-align: center;
            margin-top: var(--space-8);
            padding-top: var(--space-6);
            border-top: 1px solid var(--secondary-200);
        }
        
        .login-footer-text {
            color: var(--secondary-600);
            font-size: 0.8125rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
        }
        
        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background: rgba(16, 185, 129, 0.1);
            color: #065f46;
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: var(--space-4);
        }
        
        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: float 6s infinite ease-in-out;
        }
        
        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 5s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(100vh) translateX(0px) rotate(0deg); opacity: 0; }
            10%, 90% { opacity: 1; }
            50% { transform: translateY(-10vh) translateX(20px) rotate(180deg); }
        }
        
        /* Loading state */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(2px);
            display: none;
            align-items: center;
            justify-content: center;
            border-radius: 2rem;
            z-index: 10;
        }
        
        .loading-overlay.show {
            display: flex;
        }
        
        /* Responsive adjustments */
        @media (max-width: 480px) {
            .login-card {
                padding: var(--space-8);
                margin: var(--space-4);
                max-width: calc(100% - 2rem);
            }
            
            .login-title {
                font-size: 1.5rem;
            }
            
            .form-input-enhanced {
                padding: var(--space-3) var(--space-3) var(--space-3) 2.75rem;
                font-size: 0.9375rem;
            }
            
            .form-icon {
                left: var(--space-3);
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="floating-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        
        <div class="login-card">
            <div class="loading-overlay" id="loadingOverlay">
                <div class="loading-spinner-modern"></div>
            </div>
            
            <div class="login-header">
                <div class="login-logo">
                    <img src="<?= asset('images/automo-logo.png') ?>" alt="Automo Logo" />
                </div>
                <h1 class="login-title"><?= APP_NAME ?></h1>
                <p class="login-subtitle">Acesso seguro ao sistema de gestão</p>
            </div>
            
            <!-- Flash Messages -->
            <?php if (isset($_SESSION['flash_success'])): ?>
                <div class="alert-modern alert-success-modern">
                    <i class="fas fa-check-circle"></i>
                    <span><?= e($_SESSION['flash_success']) ?></span>
                </div>
                <?php unset($_SESSION['flash_success']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['flash_errors'])): ?>
                <div class="alert-modern alert-error-modern">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <?php foreach ($_SESSION['flash_errors'] as $error): ?>
                            <div><?= e($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php unset($_SESSION['flash_errors']); ?>
            <?php endif; ?>
            
            <form method="POST" action="/login" class="login-form" id="loginForm">
                <?= csrfField() ?>
                
                <div class="form-group-enhanced">
                    <label for="email" class="form-label-enhanced">Email ou Contacto</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope form-icon"></i>
                        <input 
                            type="text" 
                            id="email" 
                            name="email" 
                            class="form-input-enhanced"
                            placeholder="Digite seu email ou contacto"
                            value="<?= old('email') ?>"
                            required
                            autocomplete="email"
                            autofocus
                        >
                    </div>
                </div>
                
                <div class="form-group-enhanced">
                    <label for="password" class="form-label-enhanced">Senha</label>
                    <div style="position: relative;">
                        <i class="fas fa-lock form-icon"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input-enhanced"
                            placeholder="Digite sua senha"
                            required
                            autocomplete="current-password"
                        >
                    </div>
                </div>
                
                <button type="submit" class="login-button" id="loginButton">
                    <span class="button-text">
                        <i class="fas fa-sign-in-alt"></i>
                        Entrar no Sistema
                    </span>
                </button>
                
                <div class="forgot-password-section">
                    <a href="#" class="forgot-password-link" id="forgotPasswordLink">
                        <i class="fas fa-question-circle"></i>
                        Esqueceu a senha?
                    </a>
                </div>
            </form>
            
            <div class="login-footer">
                <div class="login-footer-text">
                    <i class="fas fa-shield-alt"></i>
                    Acesso protegido por autenticação de dois fatores
                </div>
                <div class="security-badge">
                    <i class="fas fa-lock"></i>
                    Conexão SSL Segura
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        const loginButton = document.getElementById('loginButton');
        const loadingOverlay = document.getElementById('loadingOverlay');
        
        // Enhanced form validation
        function validateForm() {
            const email = emailField.value.trim();
            const password = passwordField.value.trim();
            const isValid = email.length > 0 && password.length > 0;
            
            loginButton.disabled = !isValid;
            loginButton.style.opacity = isValid ? '1' : '0.5';
            
            return isValid;
        }
        
        // Real-time validation
        emailField.addEventListener('input', validateForm);
        passwordField.addEventListener('input', validateForm);
        
        // Initial validation - delay to ensure DOM is ready
        setTimeout(() => {
            validateForm();
        }, 100);
        
        // AJAX Form submission handling
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default form submission
            
            if (!validateForm()) {
                showNotification('Por favor, preencha todos os campos', 'error');
                return;
            }
            
            // Show loading state immediately
            loadingOverlay.classList.add('show');
            loginButton.disabled = true;
            
            const buttonText = loginButton.querySelector('.button-text');
            const originalButtonText = buttonText.innerHTML;
            if (buttonText) {
                buttonText.innerHTML = '<div class="loading-spinner-modern"></div> Conectando...';
            }
            
            // Enhanced logging
            console.log('🚀 Iniciando login AJAX:', {
                timestamp: new Date().toISOString(),
                email: emailField.value,
                apiUrl: '<?= API_BASE_URL ?>',
                debugMode: <?= DEBUG_MODE ? 'true' : 'false' ?>
            });
            
            // Prepare form data
            const formData = new FormData(form);
            
            // Make AJAX request to API endpoint
            fetch('/api/auth/login', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => Promise.reject(data));
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Login response:', data);
                
                if (data.success) {
                    // Show success notification
                    showNotification(data.message, 'success');
                    
                    // Redirect to OTP page after short delay
                    setTimeout(() => {
                        window.location.href = data.redirect || '/otp';
                    }, 1000);
                } else {
                    throw data;
                }
            })
            .catch(error => {
                console.error('❌ Login error:', error);
                
                // Hide loading state
                loadingOverlay.classList.remove('show');
                loginButton.disabled = false;
                if (buttonText) {
                    buttonText.innerHTML = originalButtonText;
                }
                
                // Show error notification
                const message = error.message || 'Erro na autenticação. Tente novamente.';
                showNotification(message, 'error');
            });
            
            // Auto-timeout for loading state (failsafe)
            setTimeout(() => {
                if (loadingOverlay.classList.contains('show')) {
                    loadingOverlay.classList.remove('show');
                    loginButton.disabled = false;
                    if (buttonText) {
                        buttonText.innerHTML = originalButtonText;
                    }
                    showNotification('Tempo limite excedido. Verifique sua conexão.', 'error');
                }
            }, 30000); // 30 second timeout
        });
        
        // Enhanced notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert-modern alert-${type}-modern`;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';
            notification.style.animation = 'slideInRight 0.3s ease';
            
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-triangle',
                warning: 'fas fa-exclamation-circle',
                info: 'fas fa-info-circle'
            };
            
            notification.innerHTML = `
                <i class="${icons[type]}"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 5000);
        }
        
        // Add CSS for notification animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
        
        // Performance monitoring
        const perfStart = performance.now();
        window.addEventListener('load', () => {
            const loadTime = Math.round(performance.now() - perfStart);
            console.log(`⚡ Página carregada em ${loadTime}ms`);
        });
        
        // Enhanced keyboard navigation
        emailField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                passwordField.focus();
            }
        });
        
        passwordField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && validateForm()) {
                form.submit();
            }
        });
        
        // Auto-focus on load
        if (emailField && !emailField.value) {
            emailField.focus();
        } else if (passwordField) {
            passwordField.focus();
        }
        
        // Forgot password functionality
        const forgotPasswordLink = document.getElementById('forgotPasswordLink');
        
        forgotPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            const email = emailField.value.trim();
            if (!email) {
                showNotification('Por favor, digite seu email primeiro para recuperar a senha', 'warning');
                emailField.focus();
                return;
            }
            
            // Show confirmation dialog
            if (confirm(`Enviar instruções de recuperação de senha para ${email}?`)) {
                forgotPasswordLink.style.pointerEvents = 'none';
                const originalText = forgotPasswordLink.innerHTML;
                forgotPasswordLink.innerHTML = '<div class="loading-spinner-modern" style="width:12px;height:12px;"></div> Enviando...';
                
                console.log('🔑 Iniciando recuperação de senha para:', email);
                
                // Make request to forgot password endpoint
                fetch('/api/auth/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        email: email,
                        _token: document.querySelector('input[name="_token"]').value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        // Show instructions
                        setTimeout(() => {
                            showNotification('Verifique sua caixa de entrada e siga as instruções recebidas', 'info');
                        }, 2000);
                    } else {
                        showNotification(data.message || 'Erro ao enviar email de recuperação', 'error');
                    }
                })
                .catch(error => {
                    console.error('Forgot password error:', error);
                    showNotification('Erro ao processar solicitação. Tente novamente.', 'error');
                })
                .finally(() => {
                    forgotPasswordLink.style.pointerEvents = 'auto';
                    forgotPasswordLink.innerHTML = originalText;
                });
            }
        });
    });
    </script>
</body>
</html>