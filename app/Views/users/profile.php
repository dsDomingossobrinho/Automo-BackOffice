<?php
/**
 * User Profile View
 */
?>

<div class="global-main-container">
    <!-- Enhanced Page Header -->
    <div class="global-page-header">
        <div class="global-header-content">
            <div class="global-header-left">
                <h2>Meu Perfil</h2>
                <p>Gerencie as informações da sua conta, permissões e preferências pessoais</p>
            </div>
            <div class="global-header-actions">
                <div class="global-stats-card">
                    <div class="global-stats-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="global-stats-content">
                        <div class="global-stats-number"><?= $user['account_type_id'] == 1 ? 'Admin' : 'User' ?></div>
                        <div class="global-stats-label">Tipo de Conta</div>
                    </div>
                </div>
                <div class="global-quick-actions">
                    <div class="global-action-group">
                        <a href="<?= url('/settings') ?>" class="global-btn-add-primary">
                            <div class="global-btn-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="global-btn-content">
                                <div class="global-btn-title">Configurações</div>
                                <div class="global-btn-subtitle">Preferências da conta</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="global-data-table-container">
                <div class="global-table-header">
                    <h3 class="global-table-title">
                        <i class="fas fa-user-edit"></i>
                        Informações Pessoais
                    </h3>
                </div>
                <div class="p-4">
                    <form method="POST" action="<?= url('/profile/update') ?>" class="global-search-form">
                        <?= csrfField() ?>
                        
                        <div class="global-search-row">
                            <div class="global-form-group">
                                <label class="global-form-label">
                                    <i class="fas fa-user"></i>
                                    Nome
                                </label>
                                <input type="text" class="global-form-control" name="name" 
                                       value="<?= e($user['username'] ?? $user['name'] ?? '') ?>" required>
                            </div>
                            <div class="global-form-group">
                                <label class="global-form-label">
                                    <i class="fas fa-envelope"></i>
                                    Email
                                </label>
                                <input type="email" class="global-form-control" name="email" 
                                       value="<?= e($user['email'] ?? '') ?>" required>
                            </div>
                        </div>
                        
                        <div class="global-search-row">
                            <div class="global-form-group">
                                <label class="global-form-label">
                                    <i class="fas fa-phone"></i>
                                    Contacto
                                </label>
                                <input type="text" class="global-form-control" name="contact" 
                                       value="<?= e($user['contact'] ?? '') ?>">
                            </div>
                            <div class="global-form-group">
                                <label class="global-form-label">
                                    <i class="fas fa-user-tag"></i>
                                    Função
                                </label>
                                <input type="text" class="global-form-control" 
                                       value="<?= $user['role_id'] == 1 ? 'Administrador' : 'Usuário' ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="global-search-actions">
                            <div class="global-search-actions-main">
                                <button type="submit" class="global-btn-search">
                                    <i class="fas fa-save"></i>
                                    Salvar Alterações
                                </button>
                                <a href="<?= url('/dashboard') ?>" class="global-btn-clear-filters">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="global-data-table-container">
                <div class="global-table-header">
                    <h3 class="global-table-title">
                        <i class="fas fa-shield-alt"></i>
                        Informações da Conta
                    </h3>
                </div>
                <div class="p-4">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">ID da Conta</small>
                                <div class="fw-bold"><?= e($user['id'] ?? 'N/A') ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Tipo de Conta</small>
                                <div class="fw-bold">
                                    <?= $user['account_type_id'] == 1 ? 'BackOffice' : 'Padrão' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-2">
                            <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                <i class="fas fa-key"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Permissões</small>
                                <div class="mt-1">
                                    <?php if (!empty($user['allRoleIds'])): ?>
                                        <?php foreach ($user['allRoleIds'] as $roleId): ?>
                                            <span class="global-status-badge <?= $roleId == 1 ? 'active' : 'pending' ?> me-1 mb-1 d-inline-block">
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
                </div>
            </div>
            
            <div class="global-data-table-container mt-4">
                <div class="global-table-header">
                    <h3 class="global-table-title">
                        <i class="fas fa-key"></i>
                        Segurança da Conta
                    </h3>
                </div>
                <div class="p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block">Alterar Senha</small>
                            <p class="mb-2 small">
                                Para alterar sua senha, contacte o administrador do sistema.
                            </p>
                        </div>
                    </div>
                    <div class="global-action-buttons-container">
                        <div class="global-action-buttons-group">
                            <button class="global-btn-action-table" disabled>
                                <i class="fas fa-lock"></i>
                                Alterar Senha
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- End global-main-container -->