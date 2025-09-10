<?php
/**
 * Create Administrator Account Form
 */
?>

<div class="page-header-section mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-user-plus me-3 text-primary"></i>
                Criar Administrador
            </h1>
            <p class="page-subtitle text-muted">Cadastre um novo administrador no sistema</p>
        </div>
        <div>
            <a href="<?= url('/accounts') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar à Lista
            </a>
        </div>
    </div>
</div>

<!-- Create Form -->
<div class="card modern-card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-user-cog me-2"></i>
            Informações do Administrador
        </h5>
    </div>
    <div class="card-body">
        <form id="createAdminForm" method="POST" action="<?= url('/accounts') ?>">
            <?= csrfField() ?>
            
            <div class="row">
                <!-- Name -->
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-1"></i>
                        Nome *
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="name" 
                           name="name" 
                           value="<?= e(old('name')) ?>"
                           required>
                    <div class="form-text">Nome completo do administrador</div>
                    <div class="invalid-feedback" id="name-error"></div>
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-1"></i>
                        Email *
                    </label>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           value="<?= e(old('email')) ?>"
                           required>
                    <div class="form-text">Email para login e recuperação</div>
                    <div class="invalid-feedback" id="email-error"></div>
                </div>
            </div>

            <div class="row">
                <!-- Password -->
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-1"></i>
                        Senha *
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               required>
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-text">Mínimo de 8 caracteres</div>
                    <div class="invalid-feedback" id="password-error"></div>
                </div>

                <!-- Contact -->
                <div class="col-md-6 mb-3">
                    <label for="contact" class="form-label">
                        <i class="fas fa-phone me-1"></i>
                        Contacto *
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="contact" 
                           name="contact" 
                           value="<?= e(old('contact')) ?>"
                           placeholder="+244 9xx xxx xxx"
                           required>
                    <div class="form-text">Número de telefone para verificação</div>
                    <div class="invalid-feedback" id="contact-error"></div>
                </div>
            </div>

            <div class="row">
                <!-- Account Type -->
                <div class="col-md-6 mb-3">
                    <label for="accountTypeId" class="form-label">
                        <i class="fas fa-building me-1"></i>
                        Tipo de Conta *
                    </label>
                    <select class="form-select" 
                            id="accountTypeId" 
                            name="accountTypeId" 
                            required>
                        <option value="">Selecione o tipo de conta</option>
                        <?php foreach ($accountTypes as $type): ?>
                            <option value="<?= $type['id'] ?>"
                                <?= old('accountTypeId') == $type['id'] ? 'selected' : '' ?>>
                                <?= e($type['type'] ?? $type['name']) ?> - <?= e($type['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback" id="accountTypeId-error"></div>
                </div>

                <!-- Image Upload -->
                <div class="col-md-6 mb-3">
                    <label for="img" class="form-label">
                        <i class="fas fa-image me-1"></i>
                        Imagem do Perfil
                    </label>
                    <input type="file" 
                           class="form-control" 
                           id="img" 
                           name="img" 
                           accept="image/*">
                    <div class="form-text">Opcional - imagem do perfil do administrador</div>
                    <div class="invalid-feedback" id="img-error"></div>
                </div>
            </div>

            <div class="row">
                <!-- State -->
                <div class="col-md-6 mb-3">
                    <label for="stateId" class="form-label">
                        <i class="fas fa-toggle-on me-1"></i>
                        Estado Inicial
                    </label>
                    <select class="form-select" 
                            id="stateId" 
                            name="stateId">
                        <?php foreach ($states as $state): ?>
                            <option value="<?= $state['id'] ?>"
                                <?= (old('stateId', 1) == $state['id'] || $state['id'] == 1) ? 'selected' : '' ?>>
                                <?= e($state['state'] ?? $state['name']) ?> - <?= e($state['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Estado inicial da conta (padrão: Ativo)</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="<?= url('/accounts') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>
                    Criar Administrador
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Form validation
document.getElementById('createAdminForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Clear previous errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    
    const formData = new FormData(this);
    
    // Submit form via AJAX
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showNotification('Administrador criado com sucesso!', 'success');
            setTimeout(() => {
                window.location.href = '<?= url('/accounts') ?>';
            }, 1500);
        } else {
            // Show validation errors
            if (result.errors) {
                Object.keys(result.errors).forEach(field => {
                    const input = document.getElementById(field);
                    const errorDiv = document.getElementById(field + '-error');
                    if (input && errorDiv) {
                        input.classList.add('is-invalid');
                        errorDiv.textContent = result.errors[field];
                    }
                });
            }
            showNotification(result.message || 'Erro ao criar administrador', 'error');
        }
    })
    .catch(error => {
        console.error('Error creating admin:', error);
        showNotification('Erro de conexão ao criar administrador', 'error');
    });
});

// Show notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <strong>${type === 'error' ? 'Erro!' : type === 'success' ? 'Sucesso!' : 'Info'}</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Contact number formatting
document.getElementById('contact').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    
    // Angola phone number format: +244 9XX XXX XXX
    if (value.length > 0) {
        if (value.startsWith('244')) {
            value = value.substring(3);
        }
        
        if (value.length <= 9) {
            let formatted = '+244 ';
            if (value.length > 0) formatted += value.substring(0, 3);
            if (value.length > 3) formatted += ' ' + value.substring(3, 6);
            if (value.length > 6) formatted += ' ' + value.substring(6, 9);
            this.value = formatted;
        }
    }
});
</script>