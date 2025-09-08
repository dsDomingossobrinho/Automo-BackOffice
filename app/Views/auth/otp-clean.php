<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação OTP - <?= APP_NAME ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/automo-logo.png') ?>">
    
    <!-- Preload Critical Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= asset('css/modern-ui.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Custom OTP Styles -->
    <style>
        .otp-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-4);
            position: relative;
            overflow: hidden;
        }
        
        .otp-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            opacity: 0.3;
        }
        
        .otp-card {
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
        
        .otp-header {
            text-align: center;
            margin-bottom: var(--space-6);
        }
        
        .otp-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-primary);
            border-radius: var(--radius-xl);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-3);
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }
        
        .otp-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: logoShimmer 3s infinite;
        }
        
        @keyframes logoShimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
            100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        }
        
        .otp-icon i {
            font-size: 1.75rem;
            color: white;
            z-index: 1;
            position: relative;
        }
        
        .otp-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-800);
            margin: 0;
            letter-spacing: -0.025em;
        }
        
        .otp-subtitle {
            color: var(--secondary-600);
            font-size: 0.9375rem;
            margin: 0 0 var(--space-2) 0;
            font-weight: 400;
            line-height: 1.6;
        }
        
        .email-display {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background: var(--primary-50);
            color: var(--primary-700);
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-full);
            font-weight: 500;
            font-size: 0.875rem;
            margin-top: var(--space-2);
        }
        
        .otp-form {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }
        
        .form-group-otp {
            position: relative;
        }
        
        .form-label-otp {
            display: block;
            font-weight: 500;
            color: var(--secondary-700);
            margin-bottom: var(--space-3);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }
        
        .otp-input {
            width: 100%;
            padding: var(--space-3);
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: 0.4rem;
            text-align: center;
            border: 2px solid var(--secondary-200);
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, 0.9);
            transition: all var(--transition-medium);
            font-family: var(--font-family-mono);
        }
        
        .otp-input:focus {
            outline: none;
            border-color: var(--primary-500);
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }
        
        .otp-input::placeholder {
            color: var(--secondary-400);
            letter-spacing: 0.25rem;
            font-weight: 400;
        }
        
        .verify-button {
            width: 100%;
            padding: var(--space-3) var(--space-5);
            font-size: 0.95rem;
            font-weight: 600;
            background: var(--gradient-primary);
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
            box-shadow: 0 3px 12px 0 rgba(59, 130, 246, 0.3);
            font-family: var(--font-family-sans);
        }
        
        .verify-button:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px 0 rgba(59, 130, 246, 0.4);
        }
        
        .verify-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }
        
        .verify-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .verify-button:hover::before {
            left: 100%;
        }
        
        .otp-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-3);
            margin-top: var(--space-3);
            padding-top: var(--space-3);
            border-top: 1px solid var(--secondary-200);
        }
        
        .resend-section {
            text-align: center;
        }
        
        .resend-text {
            color: var(--secondary-600);
            font-size: 0.875rem;
            margin-bottom: var(--space-2);
        }
        
        .resend-button {
            color: var(--primary-600);
            background: transparent;
            border: none;
            font-weight: 500;
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            cursor: pointer;
            font-family: var(--font-family-sans);
            font-size: 0.875rem;
        }
        
        .resend-button:hover:not(:disabled) {
            background: var(--primary-50);
            color: var(--primary-700);
            transform: translateY(-1px);
        }
        
        .resend-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .countdown-timer {
            font-family: var(--font-family-mono);
            font-weight: 600;
            color: var(--warning-color);
            font-size: 0.875rem;
        }
        
        .back-link {
            color: var(--secondary-600);
            text-decoration: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }
        
        .back-link:hover {
            background: var(--secondary-100);
            color: var(--secondary-700);
            transform: translateY(-1px);
        }
        
        /* Small hint text */
        .otp-hint {
            text-align: center;
            font-size: 0.75rem;
            color: var(--secondary-500);
            margin-top: var(--space-2);
        }
        
        /* Responsive adjustments */
        @media (max-width: 480px) {
            .otp-card {
                padding: var(--space-8);
                margin: var(--space-4);
                max-width: calc(100% - 2rem);
            }
            
            .otp-title {
                font-size: 1.5rem;
            }
            
            .otp-input {
                font-size: 1.25rem;
                letter-spacing: 0.375rem;
            }
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <div class="otp-card">
            <div class="otp-header">
                <div class="otp-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1 class="otp-title">Verificação de Segurança</h1>
                <p class="otp-subtitle">
                    Digite o código de 6 dígitos enviado para:
                </p>
                <div class="email-display">
                    <i class="fas fa-envelope"></i>
                    <span><?= e($email) ?></span>
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
            
            <form method="POST" action="/verify-otp" class="otp-form" id="otpForm">
                <input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?? '' ?>">
                
                <div class="form-group-otp">
                    <label for="otp_code" class="form-label-otp">
                        <i class="fas fa-key"></i>
                        Código de Verificação
                    </label>
                    <input 
                        type="text" 
                        id="otp_code" 
                        name="otp_code" 
                        class="otp-input"
                        placeholder="000000"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        required
                        autocomplete="one-time-code"
                        autofocus
                    >
                    <div class="otp-hint">Digite o código de 6 dígitos recebido</div>
                </div>
                
                <button type="submit" class="verify-button" id="verifyButton" disabled>
                    <span class="button-text">
                        <i class="fas fa-check"></i>
                        Verificar Código
                    </span>
                </button>
            </form>
            
            <div class="otp-actions">
                <div class="resend-section">
                    <div class="resend-text">Não recebeu o código?</div>
                    <button type="button" class="resend-button" id="resendButton">
                        <i class="fas fa-redo"></i>
                        <span id="resendText">Reenviar código</span>
                    </button>
                    <div class="countdown-timer" id="countdownTimer" style="display: none;">
                        Reenviar em: <span id="countdown">60</span>s
                    </div>
                </div>
                
                <a href="/login" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Voltar ao Login
                </a>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('otpForm');
        const otpInput = document.getElementById('otp_code');
        const verifyButton = document.getElementById('verifyButton');
        const resendButton = document.getElementById('resendButton');
        const resendText = document.getElementById('resendText');
        const countdownTimer = document.getElementById('countdownTimer');
        const countdownSpan = document.getElementById('countdown');
        
        let countdownInterval;
        let timeLeft = 60;
        
        // OTP input handling
        otpInput.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Enable/disable button based on input
            const isValid = this.value.length === 6;
            verifyButton.disabled = !isValid;
            verifyButton.style.opacity = isValid ? '1' : '0.5';
        });
        
        // AJAX Form submission with pop-up error messages
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default to use AJAX
            
            if (otpInput.value.length !== 6) {
                showNotification('Digite um código válido de 6 dígitos', 'error');
                return;
            }
            
            // Show loading state during submission
            verifyButton.disabled = true;
            const buttonText = verifyButton.querySelector('.button-text');
            const originalText = buttonText.innerHTML;
            buttonText.innerHTML = '<div class="loading-spinner-modern"></div> Verificando...';
            
            // Prepare form data
            const formData = {
                _token: form.querySelector('input[name="_token"]').value,
                otp_code: otpInput.value.trim()
            };
            
            console.log('🔐 Verificando OTP via AJAX:', {
                timestamp: new Date().toISOString(),
                otp_length: otpInput.value.length,
                debugMode: <?= DEBUG_MODE ? 'true' : 'false' ?>
            });
            
            // Make AJAX request to verify OTP
            fetch('/api/verify-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                console.log('✅ OTP verification response:', data);
                
                if (data.success) {
                    // Success - show success message and redirect
                    showNotification(data.message, 'success');
                    
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1000);
                } else {
                    // Error - show pop-up error message and allow retry
                    showNotification(data.message || 'Código OTP inválido', 'error');
                    
                    // Clear the OTP field and focus for retry
                    otpInput.value = '';
                    otpInput.focus();
                }
            })
            .catch(error => {
                console.error('❌ OTP verification error:', error);
                showNotification('Erro na verificação OTP. Tente novamente.', 'error');
                
                // Clear the OTP field and focus for retry
                otpInput.value = '';
                otpInput.focus();
            })
            .finally(() => {
                // Reset button state
                verifyButton.disabled = false;
                buttonText.innerHTML = originalText;
            });
        });
        
        // Countdown timer
        function startCountdown() {
            timeLeft = 60;
            countdownTimer.style.display = 'block';
            resendButton.style.display = 'none';
            
            countdownInterval = setInterval(() => {
                timeLeft--;
                countdownSpan.textContent = timeLeft;
                
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    countdownTimer.style.display = 'none';
                    resendButton.style.display = 'inline-flex';
                }
            }, 1000);
        }
        
        // Resend button
        resendButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (this.disabled) return;
            
            this.disabled = true;
            resendText.innerHTML = '<div class="loading-spinner-modern" style="width:12px;height:12px;"></div> Reenviando...';
            
            console.log('🔄 Reenviando código OTP de login');
            
            // Make request to resend OTP endpoint for login
            fetch('/api/resend-otp', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('🔄 Resend OTP response:', data);
                
                if (data.success) {
                    showNotification(data.message || 'Código reenviado com sucesso!', 'success');
                    
                    // Success - restart countdown and reset form
                    startCountdown();
                    otpInput.value = '';
                    otpInput.focus();
                    verifyButton.disabled = true;
                    verifyButton.style.opacity = '0.5';
                } else {
                    showNotification(data.message || 'Erro ao reenviar código', 'error');
                }
            })
            .catch(error => {
                console.error('❌ Resend OTP error:', error);
                showNotification('Erro ao reenviar código. Tente novamente.', 'error');
            })
            .finally(() => {
                this.disabled = false;
                resendText.textContent = 'Reenviar código';
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
        
        // Show inline error message instead of popup
        function showInlineError(message) {
            // Remove existing error if any
            const existingError = document.querySelector('.inline-error');
            if (existingError) {
                existingError.remove();
            }
            
            // Create error message element
            const errorDiv = document.createElement('div');
            errorDiv.className = 'inline-error';
            errorDiv.style.cssText = `
                background: #fee2e2;
                border: 1px solid #fecaca;
                color: #dc2626;
                padding: 12px 16px;
                border-radius: 8px;
                margin-top: 16px;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 8px;
                animation: fadeIn 0.3s ease;
            `;
            errorDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle"></i>
                <span>${message}</span>
            `;
            
            // Insert after the form
            form.parentNode.insertBefore(errorDiv, form.nextSibling);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (errorDiv && errorDiv.parentNode) {
                    errorDiv.style.animation = 'fadeOut 0.3s ease';
                    setTimeout(() => {
                        if (errorDiv && errorDiv.parentNode) {
                            errorDiv.remove();
                        }
                    }, 300);
                }
            }, 5000);
        }
        
        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(-10px); }
            }
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
        
        // Start initial countdown
        startCountdown();
    });
    </script>
</body>
</html>