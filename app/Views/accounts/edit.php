<?php
/**
 * Edit Administrator Account Form
 */
?>

<div class="page-header-section mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-user-edit me-3 text-primary"></i>
                Editar Administrador
            </h1>
            <p class="page-subtitle text-muted">Atualize as informações do administrador</p>
        </div>
        <div>
            <a href="<?= url('/accounts') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar à Lista
            </a>
        </div>
    </div>
</div>

<!-- Account Info Card -->
<div class="card modern-card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-info-circle me-2"></i>
            Informações Atuais
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="info-item mb-3">
                    <label class="text-muted">Nome de Usuário:</label>
                    <div class="fw-bold"><?= e($account['username']) ?></div>
                </div>
                <div class="info-item mb-3">
                    <label class="text-muted">Email:</label>
                    <div class="fw-bold"><?= e($account['email']) ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item mb-3">
                    <label class="text-muted">Estado Atual:</label>
                    <div>
                        <?php 
                        $isActive = ($account['state']['name'] ?? '') === 'ACTIVE';
                        if ($isActive): ?>
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i>
                                <?= e($account['state']['name']) ?>
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary">
                                <i class="fas fa-times me-1"></i>
                                <?= e($account['state']['name'] ?? 'INACTIVE') ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="info-item mb-3">
                    <label class="text-muted">Data de Criação:</label>
                    <div class="fw-bold"><?= formatDate($account['createdAt'] ?? '') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Form -->
<div class="card modern-card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-edit me-2"></i>
            Atualizar Informações
        </h5>
    </div>
    <div class="card-body">
        <form id="editAdminForm" method="POST" action="<?= url("/accounts/{$account['id']}") ?>">
            <?= csrfField() ?>
            <?= methodField('PUT') ?>
            
            <!-- Role Management -->
            <div class="mb-4">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-user-tag me-2"></i>
                    Gestão de Papéis
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <label for="roleIds" class="form-label">Papéis Atribuídos</label>
                        <select class="form-select" 
                                id="roleIds" 
                                name="roleIds[]" 
                                multiple 
                                size="4">
                            <?php 
                            $currentRoleIds = array_column($account['roles'] ?? [], 'id');
                            foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"
                                    <?= in_array($role['id'], $currentRoleIds) ? 'selected' : '' ?>>
                                    <?= e($role['name']) ?> - <?= e($role['description']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Use Ctrl+Click para selecionar múltiplos papéis</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Papéis Atuais</label>
                        <div class="current-roles-display p-3 border rounded bg-light">
                            <?php 
                            $roles = $account['roles'] ?? [];
                            if (!empty($roles)): 
                                foreach ($roles as $role): ?>
                                    <span class="badge bg-info me-1 mb-1">
                                        <?= e($role['name']) ?>
                                    </span>
                                <?php endforeach; 
                            else: ?>
                                <em class="text-muted">Nenhum papel atribuído</em>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Configuration -->
            <div class="mb-4">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-cogs me-2"></i>
                    Configurações da Conta
                </h6>
                <div class="row">
                    <!-- Account Type -->
                    <div class="col-md-6 mb-3">
                        <label for="accountTypeId" class="form-label">
                            <i class="fas fa-building me-1"></i>
                            Tipo de Conta
                        </label>
                        <select class="form-select" 
                                id="accountTypeId" 
                                name="accountTypeId">
                            <?php foreach ($accountTypes as $type): ?>
                                <option value="<?= $type['id'] ?>"
                                    <?= ($account['accountType']['id'] ?? 0) == $type['id'] ? 'selected' : '' ?>>
                                    <?= e($type['name']) ?> - <?= e($type['description']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- State -->
                    <div class="col-md-6 mb-3">
                        <label for="stateId" class="form-label">
                            <i class="fas fa-toggle-on me-1"></i>
                            Estado da Conta
                        </label>
                        <select class="form-select" 
                                id="stateId" 
                                name="stateId">
                            <?php foreach ($states as $state): ?>
                                <option value="<?= $state['id'] ?>"
                                    <?= ($account['state']['id'] ?? 0) == $state['id'] ? 'selected' : '' ?>>
                                    <?= e($state['name']) ?> - <?= e($state['description']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-4">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-bolt me-2"></i>
                    Ações Rápidas
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <?php if ($isActive): ?>
                            <button type="button" 
                                    class="btn btn-outline-warning me-2 mb-2"
                                    onclick="toggleAccountStatus(<?= $account['id'] ?>, 'deactivate')">
                                <i class="fas fa-user-times me-1"></i>
                                Desativar Conta
                            </button>
                        <?php else: ?>
                            <button type="button" 
                                    class="btn btn-outline-success me-2 mb-2"
                                    onclick="toggleAccountStatus(<?= $account['id'] ?>, 'activate')">
                                <i class="fas fa-user-check me-1"></i>
                                Ativar Conta
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="<?= url('/accounts') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Form validation and submission
document.getElementById('editAdminForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
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
            showNotification('Administrador atualizado com sucesso!', 'success');
            setTimeout(() => {
                window.location.href = '<?= url('/accounts') ?>';
            }, 1500);
        } else {
            showNotification(result.message || 'Erro ao atualizar administrador', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating admin:', error);
        showNotification('Erro de conexão ao atualizar administrador', 'error');
    });
});

// Toggle account status
async function toggleAccountStatus(id, action) {
    try {
        const response = await fetch(`<?= url('/api/accounts') ?>/${id}/${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                _token: '<?= $_SESSION[CSRF_TOKEN_NAME] ?? '' ?>'
            })
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Administrador ' + (action === 'activate' ? 'ativado' : 'desativado') + ' com sucesso!', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showNotification(result.message || 'Erro ao alterar status do administrador', 'error');
        }
    } catch (error) {
        console.error('Error toggling account status:', error);
        showNotification('Erro de conexão ao alterar status', 'error');
    }
}

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
</script>