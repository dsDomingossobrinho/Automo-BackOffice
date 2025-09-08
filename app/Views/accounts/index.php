<?php
/**
 * Accounts Management - List View
 */
?>

<div class="page-header-section mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-users-cog me-3 text-primary"></i>
                Contas & Permissões
            </h1>
            <p class="page-subtitle text-muted">Gerencie contas de usuário e suas permissões</p>
        </div>
        <div>
            <a href="<?= url('/accounts/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Nova Conta
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card modern-stat-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($stats['total'] ?? 0) ?></h3>
                <p>Total de Contas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card modern-stat-card">
            <div class="stat-icon bg-success">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($stats['active'] ?? 0) ?></h3>
                <p>Contas Ativas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card modern-stat-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-user-lock"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($stats['inactive'] ?? 0) ?></h3>
                <p>Contas Inativas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card modern-stat-card">
            <div class="stat-icon bg-info">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($stats['admins'] ?? 0) ?></h3>
                <p>Administradores</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card modern-card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= url('/accounts') ?>" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Pesquisar</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="<?= e($search) ?>" placeholder="Nome, email...">
                </div>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Todos os Status</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Ativo</option>
                    <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-filter me-1"></i>
                    Filtrar
                </button>
                <a href="<?= url('/accounts') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Accounts Table -->
<div class="card modern-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            Lista de Contas
        </h5>
        <div class="card-actions">
            <button class="btn btn-sm btn-outline-primary" onclick="exportData('accounts')">
                <i class="fas fa-download me-1"></i>
                Exportar
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (empty($accounts)): ?>
            <div class="empty-state text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5>Nenhuma conta encontrada</h5>
                <p class="text-muted">Não há contas cadastradas ou que correspondam aos filtros aplicados.</p>
                <a href="<?= url('/accounts/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Criar Nova Conta
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover modern-table">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>Usuário</th>
                            <th>Email</th>
                            <th>Papel</th>
                            <th>Status</th>
                            <th>Último Acesso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($accounts as $account): ?>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input row-checkbox" type="checkbox" 
                                               value="<?= $account['id'] ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar-sm me-3">
                                            <?= strtoupper(substr($account['name'] ?? $account['email'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?= e($account['name'] ?? 'Sem nome') ?></h6>
                                            <small class="text-muted">ID: <?= $account['id'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-monospace"><?= e($account['email']) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= e($account['role_name'] ?? 'Usuário') ?></span>
                                </td>
                                <td>
                                    <?php if ($account['is_active']): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>
                                            Ativo
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times me-1"></i>
                                            Inativo
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($account['last_login']): ?>
                                        <span class="text-muted"><?= formatDate($account['last_login']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">Nunca</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= url("/accounts/{$account['id']}") ?>" 
                                           class="btn btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= url("/accounts/{$account['id']}/edit") ?>" 
                                           class="btn btn-outline-secondary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" 
                                                onclick="confirmDelete(<?= $account['id'] ?>, '<?= e($account['name'] ?? $account['email']) ?>')"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (!empty($pagination)): ?>
                <div class="card-footer">
                    <?= renderPagination($pagination, url('/accounts')) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a conta <strong id="accountName"></strong>?</p>
                <p class="text-danger">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?= csrfField() ?>
                    <?= methodField('DELETE') ?>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('accountName').textContent = name;
    document.getElementById('deleteForm').action = `<?= url('/accounts') ?>/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

function exportData(type) {
    const params = new URLSearchParams(window.location.search);
    params.set('export', type);
    window.location.href = `<?= url('/accounts') ?>?${params.toString()}`;
}

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});
</script>