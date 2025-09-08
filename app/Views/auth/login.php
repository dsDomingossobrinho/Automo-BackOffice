<form method="POST" action="/login" class="auth-form">
    <?= csrfField() ?>
    
    <div class="form-group">
        <label for="email" class="form-label">
            <i class="fas fa-envelope"></i> Email ou Contacto
        </label>
        <input 
            type="text" 
            id="email" 
            name="email" 
            class="form-control" 
            placeholder="Digite seu email ou contacto"
            value="<?= old('email') ?>"
            required
            autocomplete="email"
        >
    </div>
    
    <div class="form-group">
        <label for="password" class="form-label">
            <i class="fas fa-lock"></i> Senha
        </label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-control" 
            placeholder="Digite sua senha"
            required
            autocomplete="current-password"
        >
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block">
            <i class="fas fa-sign-in-alt"></i> Entrar
        </button>
    </div>
    
    <div class="text-center">
        <small class="text-muted">
            <i class="fas fa-shield-alt"></i> 
            Acesso seguro ao sistema BackOffice
        </small>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Login page loaded');
    
    // Auto-focus on email field
    const emailField = document.getElementById('email');
    if (emailField) {
        emailField.focus();
    }
    
    // Debug info
    console.log('🔧 Current URL:', window.location.href);
    console.log('🔧 Form action:', document.querySelector('form').action);
    console.log('🔧 Form method:', document.querySelector('form').method);
    
    // Simple form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const email = this.email.value.trim();
        const password = this.password.value.trim();
        
        console.log('🔧 Form submitting:', {
            email: email,
            password: password ? '[MASKED]' : '[EMPTY]',
            action: this.action,
            method: this.method
        });
        
        if (!email || !password) {
            alert('Por favor, preencha todos os campos');
            e.preventDefault();
            return false;
        }
        
        // Show loading
        const btn = this.querySelector('button[type="submit"]');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Entrando...';
        btn.disabled = true;
    });
});
</script>