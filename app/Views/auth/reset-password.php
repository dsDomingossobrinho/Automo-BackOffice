<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Definir Nova Senha - <?= APP_NAME ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/automo-logo.png') ?>">
    
    <!-- Preload Critical Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= asset('css/modern-ui.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Custom Reset Password Styles -->
    <style>
        .reset-password-container {
            min-height: 100vh;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-4);
            position: relative;
            overflow: hidden;
        }
        
        .reset-password-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            opacity: 0.3;
        }
        
        .reset-password-card {
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
        
        .reset-password-header {
            text-align: center;
            margin-bottom: var(--space-6);
        }
        
        .reset-password-logo {
            width: 70px;
            height: 70px;
            margin-bottom: var(--space-3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: var(--radius-xl);
            padding: var(--space-3);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.25);
            border: 2px solid rgba(255, 255, 255, 0.9);
        }
        
        .reset-password-logo i {
            font-size: 1.75rem;
            color: white;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        }
        
        .reset-password-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-800);
            margin: 0;
            letter-spacing: -0.025em;
        }
        
        .reset-password-subtitle {
            color: var(--secondary-600);
            font-size: 0.9375rem;
            margin: 0 0 var(--space-4) 0;
            font-weight: 400;
            line-height: 1.5;
        }
        
        .email-display {
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: var(--radius-md);
            padding: var(--space-2);
            margin-bottom: var(--space-4);
            text-align: center;
        }
        
        .email-display-text {
            color: var(--emerald-700);
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
        }
        
        .reset-password-form {
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
            padding: var(--space-3) var(--space-3) var(--space-3) 2.75rem;
            font-size: 0.95rem;
            border: 2px solid var(--secondary-200);
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, 0.9);
            transition: all var(--transition-medium);
            font-family: var(--font-family-sans);
            backdrop-filter: blur(10px);
        }
        
        .form-input-enhanced:focus {
            outline: none;
            border-color: var(--emerald-500);
            background: white;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            transform: translateY(-2px);
        }
        
        .form-input-enhanced::placeholder {
            color: var(--secondary-400);
            font-weight: 400;
        }
        
        .form-icon {
            position: absolute;
            left: var(--space-3);
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-400);
            font-size: 1rem;
            transition: all var(--transition-fast);
            z-index: 2;
            pointer-events: none;
        }
        
        .form-group-enhanced:focus-within .form-icon {
            color: var(--emerald-500);
            transform: translateY(-50%) scale(1.1);
        }
        
        /* Special styling for OTP input */
        .otp-input {
            text-align: center;
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: 0.25em;
            padding-left: var(--space-4) !important;
        }
        
        /* Password strength indicator */
        .password-strength {
            margin-top: var(--space-2);
            padding: var(--space-2);
            border-radius: var(--radius-md);
            font-size: 0.75rem;
            text-align: center;
            opacity: 0;
            transition: all var(--transition-medium);
        }
        
        .password-strength.show {
            opacity: 1;
        }
        
        .password-strength.weak {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }
        
        .password-strength.medium {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }
        
        .password-strength.strong {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }
        
        .reset-password-button {
            width: 100%;
            padding: var(--space-3) var(--space-5);
            font-size: 0.95rem;
            font-weight: 600;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: all var(--transition-medium);
            position: relative;
            overflow: hidden;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            box-shadow: 0 3px 12px 0 rgba(16, 185, 129, 0.3);
            font-family: var(--font-family-sans);
        }
        
        .reset-password-button:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px 0 rgba(16, 185, 129, 0.5);
        }
        
        .reset-password-button:active:not(:disabled) {
            transform: translateY(-1px);
        }
        
        .reset-password-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }
        
        .resend-otp-section {
            text-align: center;
            margin-top: var(--space-3);
            padding-top: var(--space-3);
            border-top: 1px solid var(--secondary-200);
        }
        
        .resend-otp-text {
            color: var(--secondary-600);
            font-size: 0.875rem;
            margin-bottom: var(--space-2);
        }
        
        .resend-otp-link {
            color: var(--emerald-600);
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
        
        .resend-otp-link:hover {
            color: var(--emerald-700);
            background: rgba(16, 185, 129, 0.05);
            transform: translateY(-1px);
        }
        
        .back-to-login {
            text-align: center;
            margin-top: var(--space-4);
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
            .reset-password-card {
                padding: var(--space-8);
                margin: var(--space-4);
                max-width: calc(100% - 2rem);
            }
            
            .reset-password-title {
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
    <div class="reset-password-container">
        <div class="reset-password-card">
            <div class="loading-overlay" id="loadingOverlay">
                <div class="loading-spinner-modern"></div>
            </div>
            
            <div class="reset-password-header">
                <div class="reset-password-logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1 class="reset-password-title">Definir Nova Senha</h1>
                <p class="reset-password-subtitle">
                    Insira o código recebido e defina sua nova senha
                </p>
            </div>
            
            <div class="email-display">
                <div class="email-display-text">
                    <i class="fas fa-envelope"></i>
                    <span>Código enviado para: <strong><?= e($email ?? 'Não disponível') ?></strong></span>
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
            
            <form method="POST" action="/reset-password" class="reset-password-form" id="resetPasswordForm">
                <?= csrfField() ?>
                
                <div class="form-group-enhanced">
                    <label for="otpCode" class="form-label-enhanced">Código de Verificação</label>
                    <div style="position: relative;">
                        <i class="fas fa-key form-icon"></i>
                        <input 
                            type="text" 
                            id="otpCode" 
                            name="otpCode" 
                            class="form-input-enhanced otp-input"
                            placeholder="000000"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            required
                            autocomplete="one-time-code"
                            autofocus
                        >
                    </div>
                </div>
                
                <div class="form-group-enhanced">
                    <label for="newPassword" class="form-label-enhanced">Nova Senha</label>
                    <div style="position: relative;">
                        <i class="fas fa-lock form-icon"></i>
                        <input 
                            type="password" 
                            id="newPassword" 
                            name="newPassword" 
                            class="form-input-enhanced"
                            placeholder="Digite sua nova senha"
                            required
                            autocomplete="new-password"
                            minlength="6"
                        >
                    </div>
                    <div class="password-strength" id="passwordStrength"></div>
                </div>
                
                <div class="form-group-enhanced">
                    <label for="confirmPassword" class="form-label-enhanced">Confirmar Nova Senha</label>
                    <div style="position: relative;">
                        <i class="fas fa-lock form-icon"></i>
                        <input 
                            type="password" 
                            id="confirmPassword" 
                            name="confirmPassword" 
                            class="form-input-enhanced"
                            placeholder="Confirme sua nova senha"
                            required
                            autocomplete="new-password"
                            minlength="6"
                        >
                    </div>
                </div>
                
                <button type="submit" class="reset-password-button" id="resetPasswordButton">
                    <span class="button-text">
                        <i class="fas fa-check"></i>
                        Alterar Senha
                    </span>
                </button>
            </form>
            
            <div class="resend-otp-section">
                <p class="resend-otp-text">Não recebeu o código?</p>
                <a href="#" class="resend-otp-link" id="resendOtpLink">
                    <i class="fas fa-redo"></i>
                    Reenviar código
                </a>
            </div>
            
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
        const form = document.getElementById('resetPasswordForm');
        const otpField = document.getElementById('otpCode');
        const newPasswordField = document.getElementById('newPassword');
        const confirmPasswordField = document.getElementById('confirmPassword');
        const resetPasswordButton = document.getElementById('resetPasswordButton');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const resendOtpLink = document.getElementById('resendOtpLink');
        const passwordStrength = document.getElementById('passwordStrength');
        
        // Enhanced form validation
        function validateForm() {
            const otp = otpField.value.trim();
            const newPassword = newPasswordField.value.trim();
            const confirmPassword = confirmPasswordField.value.trim();
            
            const isValid = 
                otp.length === 6 && 
                /^[0-9]{6}$/.test(otp) && 
                newPassword.length >= 6 && 
                confirmPassword.length >= 6;
            
            resetPasswordButton.disabled = !isValid;
            resetPasswordButton.style.opacity = isValid ? '1' : '0.5';
            
            return isValid;
        }
        
        // Password strength checker
        function checkPasswordStrength(password) {
            if (!password) {
                passwordStrength.classList.remove('show');
                return;
            }
            
            let strength = 0;
            let message = '';
            let className = '';
            
            // Check length
            if (password.length >= 8) strength++;
            // Check for lowercase
            if (/[a-z]/.test(password)) strength++;
            // Check for uppercase
            if (/[A-Z]/.test(password)) strength++;
            // Check for numbers
            if (/[0-9]/.test(password)) strength++;
            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            if (strength <= 2) {
                className = 'weak';
                message = 'Senha fraca - Use mais caracteres variados';
            } else if (strength <= 3) {
                className = 'medium';
                message = 'Senha média - Adicione caracteres especiais';
            } else {
                className = 'strong';
                message = 'Senha forte';
            }
            
            passwordStrength.className = `password-strength show ${className}`;
            passwordStrength.textContent = message;
        }
        
        // Password matching validation
        function checkPasswordMatch() {
            const newPassword = newPasswordField.value;
            const confirmPassword = confirmPasswordField.value;
            
            if (confirmPassword && newPassword !== confirmPassword) {
                confirmPasswordField.setCustomValidity('As senhas não coincidem');
            } else {
                confirmPasswordField.setCustomValidity('');
            }
        }
        
        // Real-time validation
        otpField.addEventListener('input', function() {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            validateForm();
        });
        
        newPasswordField.addEventListener('input', function() {
            checkPasswordStrength(this.value);
            checkPasswordMatch();
            validateForm();
        });
        
        confirmPasswordField.addEventListener('input', function() {
            checkPasswordMatch();
            validateForm();
        });
        
        // Initial validation
        setTimeout(() => {
            validateForm();
        }, 100);
        
        // Form submission handling with AJAX
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default form submission
            
            if (!validateForm()) {
                showNotification('Por favor, preencha todos os campos corretamente', 'error');
                return;
            }
            
            const newPassword = newPasswordField.value;
            const confirmPassword = confirmPasswordField.value;
            
            if (newPassword !== confirmPassword) {
                showNotification('As senhas não coincidem', 'error');
                return;
            }
            
            // Show loading state
            loadingOverlay.classList.add('show');
            resetPasswordButton.disabled = true;
            
            const buttonText = resetPasswordButton.querySelector('.button-text');
            const originalButtonText = buttonText.innerHTML;
            if (buttonText) {
                buttonText.innerHTML = '<div class="loading-spinner-modern"></div> Alterando senha...';
            }
            
            console.log('🔒 Enviando alteração de senha via AJAX:', {
                timestamp: new Date().toISOString(),
                otpCode: otpField.value,
                apiUrl: '<?= API_BASE_URL ?>',
                debugMode: <?= DEBUG_MODE ? 'true' : 'false' ?>
            });
            
            // Prepare form data
            const formData = new FormData(form);
            
            // Make AJAX request to the new API endpoint
            fetch('/api/reset-password', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('🔒 Reset password response:', data);
                
                if (data.success) {
                    showNotification(data.message || 'Senha alterada com sucesso!', 'success');
                    
                    // Redirect to login after successful reset
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 2000);
                } else {
                    // Show error in pop-up instead of redirecting
                    showNotification(data.message || 'Erro ao alterar senha. Verifique os dados.', 'error');
                    
                    // Clear OTP field to allow user to try again
                    otpField.value = '';
                    otpField.focus();
                }
            })
            .catch(error => {
                console.error('Reset password AJAX error:', error);
                showNotification('Erro de conexão. Verifique sua internet e tente novamente.', 'error');
            })
            .finally(() => {
                // Hide loading state
                loadingOverlay.classList.remove('show');
                resetPasswordButton.disabled = false;
                if (buttonText) {
                    buttonText.innerHTML = originalButtonText;
                }
            });
        });
        
        // Resend OTP functionality
        resendOtpLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            resendOtpLink.style.pointerEvents = 'none';
            const originalText = resendOtpLink.innerHTML;
            resendOtpLink.innerHTML = '<div class="loading-spinner-modern" style="width:12px;height:12px;"></div> Reenviando...';
            
            console.log('🔄 Reenviando código OTP de recuperação');
            
            // Make request to resend OTP endpoint
            fetch('/resend-forgot-password-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    _token: document.querySelector('input[name="_token"]').value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    // Clear OTP field to encourage user to enter new code
                    otpField.value = '';
                    otpField.focus();
                } else {
                    showNotification(data.message || 'Erro ao reenviar código', 'error');
                }
            })
            .catch(error => {
                console.error('Resend OTP error:', error);
                showNotification('Erro ao reenviar código. Tente novamente.', 'error');
            })
            .finally(() => {
                resendOtpLink.style.pointerEvents = 'auto';
                resendOtpLink.innerHTML = originalText;
            });
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
        otpField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                newPasswordField.focus();
            }
        });
        
        newPasswordField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                confirmPasswordField.focus();
            }
        });
        
        confirmPasswordField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && validateForm()) {
                form.submit();
            }
        });
        
        // Auto-focus on load
        if (otpField && !otpField.value) {
            otpField.focus();
        }
        
        // Performance monitoring
        const perfStart = performance.now();
        window.addEventListener('load', () => {
            const loadTime = Math.round(performance.now() - perfStart);
            console.log(`⚡ Página de reset de senha carregada em ${loadTime}ms`);
        });
    });
    </script>
</body>
</html>