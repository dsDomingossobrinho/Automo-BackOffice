<form method="POST" action="<?= url('/otp/verify') ?>" class="auth-form">
    <?= csrfField() ?>
    
    <div class="text-center mb-4">
        <i class="fas fa-mobile-alt" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
        <h4>Verificação OTP</h4>
        <p class="text-muted">
            Foi enviado um código de verificação para:<br>
            <strong><?= e($email) ?></strong>
        </p>
    </div>
    
    <div class="form-group">
        <label for="otp_code" class="form-label">
            <i class="fas fa-key"></i> Código de Verificação
        </label>
        <input 
            type="text" 
            id="otp_code" 
            name="otp_code" 
            class="form-control text-center" 
            placeholder="000000"
            maxlength="6"
            pattern="[0-9]{6}"
            style="font-size: 1.5rem; font-weight: 600; letter-spacing: 0.5rem;"
            required
            autocomplete="one-time-code"
        >
        <small class="text-muted">Digite o código de 6 dígitos</small>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" disabled style="opacity: 0.5;">
            <i class="fas fa-check"></i> Verificar Código
        </button>
    </div>
    
    <div class="form-group text-center">
        <button type="button" id="resend-btn" class="btn btn-link" disabled>
            <i class="fas fa-redo"></i> Reenviar código em <span id="countdown">60</span>s
        </button>
    </div>
    
    <div class="text-center">
        <a href="<?= url('/login') ?>" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Voltar ao Login
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpField = document.getElementById('otp_code');
    const resendBtn = document.getElementById('resend-btn');
    const countdown = document.getElementById('countdown');
    let timeLeft = 60;
    
    // Auto-focus on OTP field
    otpField.focus();
    
    // Only allow numbers in OTP field
    otpField.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Don't auto-submit, let user click button
    otpField.addEventListener('input', function(e) {
        if (this.value.length === 6) {
            // Validate that all characters are numbers
            if (/^\d{6}$/.test(this.value)) {
                // Enable submit button when code is complete
                const submitButton = document.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.style.opacity = '1';
                }
            }
        } else {
            // Disable submit button if code is incomplete
            const submitButton = document.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.style.opacity = '0.5';
            }
        }
    });
    
    // Countdown timer for resend button
    const countdownTimer = setInterval(function() {
        timeLeft--;
        countdown.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(countdownTimer);
            resendBtn.disabled = false;
            resendBtn.innerHTML = '<i class="fas fa-redo"></i> Reenviar Código';
        }
    }, 1000);
    
    // Handle resend button click
    resendBtn.addEventListener('click', function() {
        if (this.disabled) return;
        
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Reenviando...';
        
        // Make request to resend OTP
        fetch('<?= url('/otp/resend') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reset countdown
                timeLeft = 60;
                countdown.textContent = timeLeft;
                this.innerHTML = '<i class="fas fa-redo"></i> Reenviar código em <span id="countdown">60</span>s';
                
                // Restart countdown
                const newCountdown = this.querySelector('#countdown') || countdown;
                const newTimer = setInterval(function() {
                    timeLeft--;
                    newCountdown.textContent = timeLeft;
                    
                    if (timeLeft <= 0) {
                        clearInterval(newTimer);
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = '<i class="fas fa-redo"></i> Reenviar Código';
                    }
                }, 1000);
                
                // Show success message
                showNotification('Código reenviado com sucesso!', 'success');
            } else {
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-redo"></i> Reenviar Código';
                showNotification(data.message || 'Erro ao reenviar código', 'error');
            }
        })
        .catch(error => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-redo"></i> Reenviar Código';
            showNotification('Erro ao reenviar código', 'error');
        });
    });
    
    // Simple notification function
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
});
</script>