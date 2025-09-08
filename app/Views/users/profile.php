<?php
/**
 * User Profile View
 */
?>

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-user me-3 text-primary"></i>
                Meu Perfil
            </h1>
            <p class="page-subtitle text-muted">Gerencie as informações do seu perfil</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2"></i>
                    Informações Pessoais
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= url('/profile/update') ?>">
                    <?= csrfField() ?>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control" name="name" 
                                   value="<?= e($user['username'] ?? $user['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" 
                                   value="<?= e($user['email'] ?? '') ?>" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Contacto</label>
                            <input type="text" class="form-control" name="contact" 
                                   value="<?= e($user['contact'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Função</label>
                            <input type="text" class="form-control" 
                                   value="<?= $user['role_id'] == 1 ? 'Administrador' : 'Usuário' ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Salvar Alterações
                        </button>
                        <a href="<?= url('/dashboard') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2"></i>
                    Informações da Conta
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">ID da Conta</small>
                    <div class="fw-bold"><?= e($user['id'] ?? 'N/A') ?></div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Tipo de Conta</small>
                    <div class="fw-bold">
                        <?= $user['account_type_id'] == 1 ? 'BackOffice' : 'Padrão' ?>
                    </div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Permissões</small>
                    <div class="fw-bold">
                        <?php if (!empty($user['allRoleIds'])): ?>
                            <?php foreach ($user['allRoleIds'] as $roleId): ?>
                                <span class="badge bg-primary me-1">
                                    <?= $roleId == 1 ? 'Admin' : 'Role ' . $roleId ?>
                                </span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted">Nenhuma permissão atribuída</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-key me-2"></i>
                    Alterar Senha
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    Para alterar sua senha, contacte o administrador do sistema.
                </p>
                <button class="btn btn-outline-warning btn-sm" disabled>
                    <i class="fas fa-lock me-2"></i>
                    Alterar Senha
                </button>
            </div>
        </div>
    </div>
</div>