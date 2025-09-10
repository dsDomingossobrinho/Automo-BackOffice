<?php
/**
 * User Settings View
 */
?>

<div class="global-main-container">
    <!-- Enhanced Page Header -->
    <div class="global-page-header">
        <div class="global-header-content">
            <div class="global-header-left">
                <h2>Configurações</h2>
                <p>Configure as preferências da sua conta, idioma, notificações e opções de interface</p>
            </div>
            <div class="global-header-actions">
                <div class="global-stats-card">
                    <div class="global-stats-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="global-stats-content">
                        <div class="global-stats-number">Claro</div>
                        <div class="global-stats-label">Tema Atual</div>
                    </div>
                </div>
                <div class="global-quick-actions">
                    <div class="global-action-group">
                        <a href="<?= url('/profile') ?>" class="global-btn-add-primary">
                            <div class="global-btn-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="global-btn-content">
                                <div class="global-btn-title">Meu Perfil</div>
                                <div class="global-btn-subtitle">Editar informações</div>
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
                        <i class="fas fa-palette"></i>
                        Preferências de Interface
                    </h3>
                </div>
                <div class="p-4">
                    <form method="POST" action="<?= url('/settings/update') ?>" class="global-search-form">
                        <?= csrfField() ?>
                        
                        <div class="mb-4">
                            <div class="global-form-group">
                                <label class="global-form-label">
                                    <i class="fas fa-palette"></i>
                                    Tema da Interface
                                </label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="theme" id="theme-light" value="light" checked>
                                        <label class="form-check-label d-flex align-items-center" for="theme-light">
                                            <i class="fas fa-sun me-2 text-warning"></i>Modo Claro
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="theme" id="theme-dark" value="dark">
                                        <label class="form-check-label d-flex align-items-center" for="theme-dark">
                                            <i class="fas fa-moon me-2 text-info"></i>Modo Escuro
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="theme" id="theme-auto" value="auto">
                                        <label class="form-check-label d-flex align-items-center" for="theme-auto">
                                            <i class="fas fa-adjust me-2 text-secondary"></i>Automático
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="global-search-row">
                            <div class="global-form-group">
                                <label class="global-form-label">
                                    <i class="fas fa-language"></i>
                                    Idioma
                                </label>
                                <select class="global-form-control">
                                    <option value="pt" selected>Português</option>
                                    <option value="en">English</option>
                                    <option value="es">Español</option>
                                </select>
                            </div>
                            <div class="global-form-group">
                                <label class="global-form-label">
                                    <i class="fas fa-list-ol"></i>
                                    Items por Página
                                </label>
                                <select class="global-form-control" name="items_per_page">
                                    <option value="10">10 items</option>
                                    <option value="25" selected>25 items</option>
                                    <option value="50">50 items</option>
                                    <option value="100">100 items</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="global-search-actions">
                            <div class="global-search-actions-main">
                                <button type="submit" class="global-btn-search">
                                    <i class="fas fa-save"></i>
                                    Salvar Configurações
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
                        <i class="fas fa-bell"></i>
                        Notificações
                    </h3>
                </div>
                <div class="p-4">
                    <form method="POST" action="<?= url('/settings/notifications') ?>">
                        <?= csrfField() ?>
                        
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Email de Notificações</div>
                                        <small class="text-muted">Receber notificações por email</small>
                                    </div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifications-email" checked>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                        <i class="fas fa-desktop"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Notificações do Navegador</div>
                                        <small class="text-muted">Receber notificações push</small>
                                    </div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifications-browser" checked>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Relatórios Semanais</div>
                                        <small class="text-muted">Resumo semanal das atividades</small>
                                    </div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifications-reports">
                                </div>
                            </div>
                        </div>
                        
                        <div class="global-action-buttons-container">
                            <div class="global-action-buttons-group">
                                <button type="submit" class="global-btn-action-table">
                                    <i class="fas fa-bell"></i>
                                    Atualizar Notificações
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="global-data-table-container mt-4">
                <div class="global-table-header">
                    <h3 class="global-table-title">
                        <i class="fas fa-info-circle"></i>
                        Informações do Sistema
                    </h3>
                </div>
                <div class="p-4">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                <i class="fas fa-code-branch"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Versão do Sistema</small>
                                <div class="fw-bold"><?= APP_VERSION ?? '1.0.0' ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Último Acesso</small>
                                <div class="fw-bold"><?= date('d/m/Y H:i:s') ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="global-stats-icon me-3" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                <i class="fas fa-wifi"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Status da Sessão</small>
                                <div class="d-flex align-items-center">
                                    <span class="global-status-badge active me-2">
                                        Ativa
                                    </span>
                                    <small class="text-muted">Conectado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- End global-main-container -->