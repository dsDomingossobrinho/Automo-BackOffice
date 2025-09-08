<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação OTP - <?= APP_NAME ?></title>
    
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
            border-radius: 2rem;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 480px;
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
        
        .otp-header {
            text-align: center;
            margin-bottom: var(--space-8);
        }
        
        .otp-icon {
            width: 100px;
            height: 100px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-4);
            box-shadow: var(--shadow-lg);
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
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: rotate 2s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .otp-icon i {
            font-size: 2.5rem;
            color: white;
            z-index: 1;
            position: relative;
        }
        
        .otp-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-800);
            margin: 0 0 var(--space-2) 0;
            letter-spacing: -0.025em;
        }
        
        .otp-subtitle {
            color: var(--secondary-600);
            font-size: 1rem;
            margin: 0 0 var(--space-4) 0;
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
            gap: var(--space-6);
        }
        
        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: var(--space-3);
            margin: var(--space-6) 0;
        }
        
        .otp-input {
            width: 3.5rem;
            height: 3.5rem;
            border: 2px solid var(--secondary-300);
            border-radius: var(--radius-lg);
            text-align: center;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--secondary-800);
            background: rgba(255, 255, 255, 0.9);
            transition: all var(--transition-medium);
            font-family: var(--font-family-mono);
        }
        
        .otp-input:focus {
            outline: none;
            border-color: var(--primary-500);
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: scale(1.05);
        }
        
        .otp-input:not(:placeholder-shown) {
            border-color: var(--success-color);
            background: rgba(16, 185, 129, 0.05);
        }
        
        .verify-button {
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
            gap: var(--space-4);
            margin-top: var(--space-6);
        }
        
        .resend-section {
            text-align: center;
            padding: var(--space-4);
            background: var(--secondary-50);
            border-radius: var(--radius-lg);
            border: 1px solid var(--secondary-200);
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
            transform: none !important;
        }
        
        .countdown-timer {
            font-family: var(--font-family-mono);
            font-weight: 600;
            color: var(--warning-color);
            font-size: 0.875rem;
        }
        
        .back-to-login {
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
        
        .back-to-login:hover {
            background: var(--secondary-100);
            color: var(--secondary-700);
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
            .otp-card {
                padding: var(--space-8);
                margin: var(--space-4);
                max-width: calc(100% - 2rem);
            }
            
            .otp-title {
                font-size: 1.5rem;
            }
            
            .otp-inputs {
                gap: var(--space-2);
            }
            
            .otp-input {
                width: 3rem;
                height: 3rem;
                font-size: 1.125rem;
            }
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <div class="otp-card">
            <div class="loading-overlay" id="loadingOverlay">
                <div class="loading-spinner-modern"></div>
            </div>
            
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
                    <span><?= e($_SESSION['temp_login']['emailOrContact'] ?? '') ?></span>
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
                <?= csrfField() ?>
                
                <div class="otp-inputs">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="one-time-code" data-index="0">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="1">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="2">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="3">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="4">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="5">
                </div>
                
                <input type="hidden" name="otp_code" id="otpCodeHidden">
                
                <button type="submit" class="verify-button" id="verifyButton" disabled>
                    <span class="button-text">
                        <i class="fas fa-check"></i>
                        Verificar Código
                    </span>
                </button>
            </form>
            
            <div class="otp-actions">
                <div class="resend-section">
                    <div class="resend-text">
                        Não recebeu o código?
                    </div>
                    <button type="button" class="resend-button" id="resendButton">
                        <i class="fas fa-redo"></i>
                        Reenviar código
                    </button>
                    <div class="countdown-timer" id="countdownTimer" style="display: none;">
                        Reenviar em: <span id="countdown">60</span>s
                    </div>
                </div>
                
                <a href="/login" class="back-to-login">
                    <i class="fas fa-arrow-left"></i>
                    Voltar ao Login
                </a>
            </div>
        </div>
    </div>
    
    <!-- Enhanced JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('otpForm');
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenInput = document.getElementById('otpCodeHidden');
        const verifyButton = document.getElementById('verifyButton');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const resendButton = document.getElementById('resendButton');
        const countdownTimer = document.getElementById('countdownTimer');
        const countdownSpan = document.getElementById('countdown');
        
        let countdownInterval;
        let countdownTime = 60;
        
        // Enhanced OTP input handling
        inputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                const value = e.target.value;
                
                // Only allow digits
                if (!/^\d*$/.test(value)) {
                    e.target.value = '';
                    return;
                }
                
                if (value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                
                updateOtpCode();
                validateForm();
                
                // Auto-submit when all fields are filled
                if (isFormComplete()) {
                    setTimeout(() => {
                        if (validateForm()) {
                            form.submit();
                        }
                    }, 100);
                }
            });
            
            input.addEventListener('keydown', function(e) {
                // Handle backspace
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
                
                // Handle arrow keys
                if (e.key === 'ArrowLeft' && index > 0) {
                    inputs[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                
                // Handle paste
                if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
                    setTimeout(() => {
                        handlePaste(index);
                    }, 10);
                }
            });
            
            input.addEventListener('focus', function(e) {
                e.target.select();
            });
            
            // Handle direct paste
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                handlePaste(index, paste);
            });
        });
        
        function handlePaste(startIndex, pasteData) {
            if (!pasteData) return;
            
            const digits = pasteData.replace(/\D/g, '').slice(0, 6);
            
            if (digits.length > 0) {
                inputs.forEach((input, index) => {
                    if (index >= startIndex && index < startIndex + digits.length) {
                        input.value = digits[index - startIndex];
                    }
                });
                
                // Focus on the next empty input or the last filled input
                const nextIndex = Math.min(startIndex + digits.length, inputs.length - 1);
                inputs[nextIndex].focus();
                
                updateOtpCode();
                validateForm();
                
                // Auto-submit if complete
                if (isFormComplete()) {
                    setTimeout(() => {
                        if (validateForm()) {
                            form.submit();
                        }
                    }, 300);
                }
            }
        }
        
        function updateOtpCode() {
            const code = Array.from(inputs).map(input => input.value).join('');
            hiddenInput.value = code;
        }
        
        function validateForm() {
            const code = hiddenInput.value;
            const isValid = code.length === 6 && /^\d{6}$/.test(code);
            
            verifyButton.disabled = !isValid;
            verifyButton.style.opacity = isValid ? '1' : '0.5';
            
            return isValid;
        }
        
        function isFormComplete() {
            return hiddenInput.value.length === 6;
        }
        
        // AJAX Form submission handling
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default form submission
            
            if (!validateForm()) {
                showNotification('Digite um código válido de 6 dígitos', 'error');
                return;
            }
            
            // Show loading state immediately
            loadingOverlay.classList.add('show');
            verifyButton.disabled = true;
            
            const buttonText = verifyButton.querySelector('.button-text');
            const originalButtonText = buttonText.innerHTML;
            if (buttonText) {
                buttonText.innerHTML = '<div class="loading-spinner-modern"></div> Verificando...';
            }
            
            console.log('🔐 Verificando OTP AJAX:', {
                timestamp: new Date().toISOString(),
                code: hiddenInput.value,
                debugMode: <?= DEBUG_MODE ? 'true' : 'false' ?>
            });
            
            // Prepare form data
            const formData = new FormData(form);
            
            // Make AJAX request to API endpoint
            fetch('/api/auth/verify-otp', {
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
                console.log('✅ OTP response:', data);
                
                if (data.success) {
                    // Show success notification
                    showNotification(data.message, 'success');
                    
                    // Redirect to Dashboard after short delay
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1500);
                } else {
                    throw data;
                }
            })
            .catch(error => {
                console.error('❌ OTP error:', error);
                
                // Hide loading state
                loadingOverlay.classList.remove('show');
                verifyButton.disabled = false;
                if (buttonText) {
                    buttonText.innerHTML = originalButtonText;
                }
                
                // Show error notification
                const message = error.message || 'Erro na verificação do OTP. Tente novamente.';
                showNotification(message, 'error');
                
                // Handle redirect if needed (expired OTP, etc.)
                if (error.redirect) {
                    setTimeout(() => {
                        window.location.href = error.redirect;
                    }, 2000);
                }
            });
            
            // Auto-timeout for loading state (failsafe)
            setTimeout(() => {
                if (loadingOverlay.classList.contains('show')) {
                    loadingOverlay.classList.remove('show');
                    verifyButton.disabled = false;
                    if (buttonText) {
                        buttonText.innerHTML = originalButtonText;
                    }
                    showNotification('Tempo limite excedido. Verifique sua conexão.', 'error');
                }
            }, 30000); // 30 second timeout
        });
        
        // Countdown timer for resend
        function startCountdown() {
            countdownTime = 60;
            countdownTimer.style.display = 'block';
            resendButton.style.display = 'none';
            
            countdownInterval = setInterval(() => {
                countdownTime--;
                countdownSpan.textContent = countdownTime;
                
                if (countdownTime <= 0) {
                    clearInterval(countdownInterval);
                    countdownTimer.style.display = 'none';
                    resendButton.style.display = 'inline-flex';
                }
            }, 1000);
        }
        
        // Resend button handling
        resendButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (resendButton.disabled) return;
            
            // Disable button during request
            resendButton.disabled = true;
            const originalText = resendButton.innerHTML;
            resendButton.innerHTML = '<div class="loading-spinner-modern"></div> Reenviando...';
            
            console.log('🔄 Calling BackOfficeRequestOTP again for resend');
            
            // Call the AJAX resend API
            fetch('/api/auth/resend-otp', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    startCountdown();
                    
                    // Clear current inputs
                    inputs.forEach(input => {
                        input.value = '';
                    });
                    inputs[0].focus();
                    updateOtpCode();
                    validateForm();
                } else {
                    showNotification(data.message, 'error');
                    // Re-enable button on error
                    resendButton.disabled = false;
                    resendButton.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Resend error:', error);
                showNotification('Erro ao reenviar código. Tente novamente.', 'error');
                // Re-enable button on error
                resendButton.disabled = false;
                resendButton.innerHTML = originalText;
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
        
        // Initialize
        inputs[0].focus();
        startCountdown();
        
        // Debug mode info
        if (<?= DEBUG_MODE ? 'true' : 'false' ?>) {
            console.log('🧪 Debug Mode: Use any 6-digit code (e.g., 123456)');
            showNotification('Debug Mode: Use qualquer código de 6 dígitos', 'info');
        }
    });
    </script>
</body>
</html>