<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - <?= APP_NAME ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/automo-logo.png') ?>">
    
    <!-- Preload Critical Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= asset('css/modern-ui.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Custom Forgot Password Styles -->
    <style>
        .forgot-password-container {
            min-height: 100vh;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-4);
            position: relative;
            overflow: hidden;
        }
        
        .forgot-password-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            opacity: 0.3;
        }
        
        .forgot-password-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 400px;
            padding: var(--space-8);
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
        
        .forgot-password-header {
            text-align: center;
            margin-bottom: var(--space-6);
        }
        
        .forgot-password-logo {
            width: 70px;
            height: 70px;
            margin-bottom: var(--space-3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            border-radius: var(--radius-xl);
            padding: var(--space-3);
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.25);
            border: 2px solid rgba(255, 255, 255, 0.9);
        }
        
        .forgot-password-logo i {
            font-size: 1.75rem;
            color: white;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        }
        
        .forgot-password-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-800);
            margin: 0;
            letter-spacing: -0.025em;
        }
        
        .forgot-password-subtitle {
            color: var(--secondary-600);
            font-size: 0.9375rem;
            margin: 0 0 var(--space-3) 0;
            font-weight: 400;
            line-height: 1.5;
        }
        
        .instruction-box {
            background: rgba(59, 130, 246, 0.05);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: var(--radius-md);
            padding: var(--space-3);
            margin-bottom: var(--space-4);
        }
        
        .instruction-text {
            color: var(--primary-700);
            font-size: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: var(--space-2);
            line-height: 1.5;
        }
        
        .instruction-text i {
            font-size: 1rem;
            margin-top: 2px;
            flex-shrink: 0;
        }
        
        .forgot-password-form {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
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
            pointer-events: none;
        }
        
        .form-group-enhanced:focus-within .form-icon {
            color: var(--primary-500);
            transform: translateY(-50%) scale(1.1);
        }
        
        .forgot-password-button {
            width: 100%;
            padding: var(--space-4) var(--space-6);
            font-size: 1rem;
            font-weight: 600;
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
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
            box-shadow: 0 4px 14px 0 rgba(245, 158, 11, 0.4);
            font-family: var(--font-family-sans);
        }
        
        .forgot-password-button:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px 0 rgba(245, 158, 11, 0.5);
        }
        
        .forgot-password-button:active:not(:disabled) {
            transform: translateY(-1px);
        }
        
        .forgot-password-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }
        
        .back-to-login {
            text-align: center;
            margin-top: var(--space-6);
        }
        
        .back-to-login-link {
            color: var(--secondary-600);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-md);
        }
        
        .back-to-login-link:hover {
            color: var(--primary-600);
            background: rgba(59, 130, 246, 0.05);
            transform: translateY(-1px);
        }
        
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
            .forgot-password-card {
                padding: var(--space-8);
                margin: var(--space-4);
                max-width: calc(100% - 2rem);
            }
            
            .forgot-password-title {
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
    <div class="forgot-password-container">
        <div class="forgot-password-card">
            <div class="loading-overlay" id="loadingOverlay">
                <div class="loading-spinner-modern"></div>
            </div>
            
            <div class="forgot-password-header">
                <div class="forgot-password-logo">
                    <i class="fas fa-key"></i>
                </div>
                <h1 class="forgot-password-title">Recuperar Senha</h1>
                <p class="forgot-password-subtitle">
                    Insira seu email ou contacto para receber o código de recuperação
                </p>
            </div>
            
            <div class="instruction-box">
                <div class="instruction-text">
                    <i class="fas fa-info-circle"></i>
                    <span>Enviaremos um código de 6 dígitos para o seu email ou SMS. Use este código para definir uma nova senha.</span>
                </div>
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
            
            <form method="POST" action="/forgot-password" class="forgot-password-form" id="forgotPasswordForm">
                <?= csrfField() ?>
                
                <div class="form-group-enhanced">
                    <label for="emailOrContact" class="form-label-enhanced">Email ou Contacto</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope form-icon"></i>
                        <input 
                            type="text" 
                            id="emailOrContact" 
                            name="emailOrContact" 
                            class="form-input-enhanced"
                            placeholder="Digite seu email ou contacto"
                            value="<?= old('emailOrContact') ?>"
                            required
                            autocomplete="email"
                            autofocus
                        >
                    </div>
                </div>
                
                <button type="submit" class="forgot-password-button" id="forgotPasswordButton">
                    <span class="button-text">
                        <i class="fas fa-paper-plane"></i>
                        Enviar Código de Recuperação
                    </span>
                </button>
            </form>
            
            <div class="back-to-login">
                <a href="/login" class="back-to-login-link">
                    <i class="fas fa-arrow-left"></i>
                    Voltar para o Login
                </a>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('forgotPasswordForm');
        const emailField = document.getElementById('emailOrContact');
        const forgotPasswordButton = document.getElementById('forgotPasswordButton');
        const loadingOverlay = document.getElementById('loadingOverlay');
        
        // Enhanced form validation
        function validateForm() {
            const email = emailField.value.trim();
            const isValid = email.length > 0;
            
            forgotPasswordButton.disabled = !isValid;
            forgotPasswordButton.style.opacity = isValid ? '1' : '0.5';
            
            return isValid;
        }
        
        // Real-time validation
        emailField.addEventListener('input', validateForm);
        
        // Initial validation
        setTimeout(() => {
            validateForm();
        }, 100);
        
        // Form submission handling
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                showNotification('Por favor, preencha seu email ou contacto', 'error');
                return;
            }
            
            // Show loading state
            loadingOverlay.classList.add('show');
            forgotPasswordButton.disabled = true;
            
            const buttonText = forgotPasswordButton.querySelector('.button-text');
            const originalButtonText = buttonText.innerHTML;
            if (buttonText) {
                buttonText.innerHTML = '<div class="loading-spinner-modern"></div> Enviando código...';
            }
            
            console.log('🔑 Enviando solicitação de recuperação de senha:', {
                timestamp: new Date().toISOString(),
                email: emailField.value,
                apiUrl: '<?= API_BASE_URL ?>',
                debugMode: <?= DEBUG_MODE ? 'true' : 'false' ?>
            });
            
            // Auto-timeout for loading state (failsafe)
            setTimeout(() => {
                if (loadingOverlay.classList.contains('show')) {
                    loadingOverlay.classList.remove('show');
                    forgotPasswordButton.disabled = false;
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
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
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
        
        // Enhanced keyboard navigation
        emailField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && validateForm()) {
                form.submit();
            }
        });
        
        // Auto-focus on load
        if (emailField && !emailField.value) {
            emailField.focus();
        }
        
        // Performance monitoring
        const perfStart = performance.now();
        window.addEventListener('load', () => {
            const loadTime = Math.round(performance.now() - perfStart);
            console.log(`⚡ Página de recuperação carregada em ${loadTime}ms`);
        });
    });
    </script>
</body>
</html>