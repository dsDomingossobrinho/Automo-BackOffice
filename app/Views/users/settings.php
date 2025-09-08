<?php
/**
 * User Settings View
 */
?>

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-cog me-3 text-primary"></i>
                Configurações
            </h1>
            <p class="page-subtitle text-muted">Configure as preferências da sua conta</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-palette me-2"></i>
                    Preferências de Interface
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= url('/settings/update') ?>">
                    <?= csrfField() ?>
                    
                    <div class="mb-4">
                        <label class="form-label">Tema da Interface</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="theme" id="theme-light" value="light" checked>
                            <label class="form-check-label" for="theme-light">
                                <i class="fas fa-sun me-2"></i>Modo Claro
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="theme" id="theme-dark" value="dark">
                            <label class="form-check-label" for="theme-dark">
                                <i class="fas fa-moon me-2"></i>Modo Escuro
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="theme" id="theme-auto" value="auto">
                            <label class="form-check-label" for="theme-auto">
                                <i class="fas fa-adjust me-2"></i>Automático
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Idioma</label>
                        <select class="form-select">
                            <option value="pt" selected>Português</option>
                            <option value="en">English</option>
                            <option value="es">Español</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Items por Página</label>
                        <select class="form-select" name="items_per_page">
                            <option value="10">10 items</option>
                            <option value="25" selected>25 items</option>
                            <option value="50">50 items</option>
                            <option value="100">100 items</option>
                        </select>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Salvar Configurações
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
                    <i class="fas fa-bell me-2"></i>
                    Notificações
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= url('/settings/notifications') ?>">
                    <?= csrfField() ?>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notifications-email" checked>
                        <label class="form-check-label" for="notifications-email">
                            Email de Notificações
                        </label>
                        <small class="text-muted d-block">Receber notificações por email</small>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notifications-browser" checked>
                        <label class="form-check-label" for="notifications-browser">
                            Notificações do Navegador
                        </label>
                        <small class="text-muted d-block">Receber notificações push</small>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notifications-reports">
                        <label class="form-check-label" for="notifications-reports">
                            Relatórios Semanais
                        </label>
                        <small class="text-muted d-block">Resumo semanal das atividades</small>
                    </div>
                    
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-bell me-2"></i>
                        Atualizar Notificações
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações do Sistema
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">Versão</small>
                    <div class="fw-bold"><?= APP_VERSION ?? '1.0.0' ?></div>
                </div>
                
                <div class="mb-2">
                    <small class="text-muted">Último Acesso</small>
                    <div class="fw-bold"><?= date('d/m/Y H:i:s') ?></div>
                </div>
                
                <div class="mb-2">
                    <small class="text-muted">Sessão</small>
                    <div class="text-success">
                        <i class="fas fa-check-circle me-1"></i>
                        Ativa
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>