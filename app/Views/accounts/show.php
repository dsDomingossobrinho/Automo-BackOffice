<?php
/**
 * View Administrator Account Details
 */
?>

<div class="page-header-section mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-user-circle me-3 text-primary"></i>
                Detalhes do Administrador
            </h1>
            <p class="page-subtitle text-muted">Informações completas da conta</p>
        </div>
        <div>
            <a href="<?= url('/accounts') ?>" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar à Lista
            </a>
            <a href="<?= url("/accounts/{$account['id']}/edit") ?>" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>
                Editar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Account Overview -->
    <div class="col-lg-4 mb-4">
        <div class="card modern-card">
            <div class="card-header text-center">
                <div class="user-avatar-lg mx-auto mb-3">
                    <?= strtoupper(substr($account['username'] ?? $account['email'], 0, 1)) ?>
                </div>
                <h5 class="card-title mb-1"><?= e($account['username']) ?></h5>
                <p class="text-muted mb-0"><?= e($account['email']) ?></p>
            </div>
            <div class="card-body">
                <!-- Status -->
                <div class="info-item mb-3 text-center">
                    <?php 
                    $isActive = ($account['state']['name'] ?? '') === 'ACTIVE';
                    if ($isActive): ?>
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check me-1"></i>
                            <?= e($account['state']['name']) ?>
                        </span>
                    <?php else: ?>
                        <span class="badge bg-secondary fs-6">
                            <i class="fas fa-times me-1"></i>
                            <?= e($account['state']['name'] ?? 'INACTIVE') ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Quick Actions -->
                <div class="d-grid gap-2">
                    <?php if ($isActive): ?>
                        <button class="btn btn-outline-warning" 
                                onclick="toggleAccountStatus(<?= $account['id'] ?>, 'deactivate')">
                            <i class="fas fa-user-times me-1"></i>
                            Desativar Conta
                        </button>
                    <?php else: ?>
                        <button class="btn btn-outline-success" 
                                onclick="toggleAccountStatus(<?= $account['id'] ?>, 'activate')">
                            <i class="fas fa-user-check me-1"></i>
                            Ativar Conta
                        </button>
                    <?php endif; ?>
                    
                    <a href="<?= url("/accounts/{$account['id']}/edit") ?>" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-1"></i>
                        Editar Administrador
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Information -->
    <div class="col-lg-8 mb-4">
        <div class="card modern-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações Detalhadas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Basic Info -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-user me-1"></i>
                            Informações Básicas
                        </h6>
                        
                        <div class="info-item mb-3">
                            <label class="text-muted">ID:</label>
                            <div class="fw-bold"><?= e($account['id']) ?></div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="text-muted">Nome de Usuário:</label>
                            <div class="fw-bold"><?= e($account['username']) ?></div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="text-muted">Email:</label>
                            <div class="fw-bold">
                                <a href="mailto:<?= e($account['email']) ?>" class="text-decoration-none">
                                    <?= e($account['email']) ?>
                                </a>
                            </div>
                        </div>

                        <div class="info-item mb-3">
                            <label class="text-muted">Contacto:</label>
                            <div class="fw-bold">
                                <?php if (!empty($account['contact'])): ?>
                                    <a href="tel:<?= e($account['contact']) ?>" class="text-decoration-none">
                                        <?= e($account['contact']) ?>
                                    </a>
                                <?php else: ?>
                                    <em class="text-muted">Não informado</em>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Account Settings -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-cogs me-1"></i>
                            Configurações da Conta
                        </h6>
                        
                        <div class="info-item mb-3">
                            <label class="text-muted">Tipo de Conta:</label>
                            <div class="fw-bold">
                                <span class="badge bg-info">
                                    <?= e($account['accountType']['name'] ?? 'N/A') ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="text-muted">Estado:</label>
                            <div class="fw-bold">
                                <?php if ($isActive): ?>
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
                            <div class="fw-bold">
                                <?= formatDate($account['createdAt'] ?? '') ?>
                            </div>
                        </div>

                        <div class="info-item mb-3">
                            <label class="text-muted">Última Atualização:</label>
                            <div class="fw-bold">
                                <?= formatDate($account['updatedAt'] ?? '') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles and Permissions -->
        <div class="card modern-card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-tag me-2"></i>
                    Papéis e Permissões
                </h5>
            </div>
            <div class="card-body">
                <?php 
                $roles = $account['roles'] ?? [];
                if (!empty($roles)): ?>
                    <div class="row">
                        <?php foreach ($roles as $role): ?>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="mb-2">
                                        <span class="badge bg-info me-2"><?= e($role['name']) ?></span>
                                    </h6>
                                    <?php if (!empty($role['description'])): ?>
                                        <p class="text-muted mb-0"><?= e($role['description']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <h6>Nenhum papel atribuído</h6>
                        <p class="text-muted">Este administrador não possui papéis atribuídos.</p>
                        <a href="<?= url("/accounts/{$account['id']}/edit") ?>" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i>
                            Atribuir Papéis
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.user-avatar-lg {
    width: 80px;
    height: 80px;
    background: linear-gradient(45deg, #007bff, #0056b3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}

.info-item {
    margin-bottom: 1rem;
}

.info-item label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.info-item div {
    font-size: 1rem;
    color: #495057;
}
</style>

<script>
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