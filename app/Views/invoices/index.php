<?php
/**
 * Invoices - RPP (Recibo, Pagamentos e Planos) View
 */
?>

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-file-invoice-dollar me-3 text-primary"></i>
                RPP - Recibo, Pagamentos e Planos
            </h1>
            <p class="page-subtitle text-muted">Gestão completa de documentos financeiros</p>
        </div>
        <div class="page-actions">
            <button class="btn btn-outline-secondary me-2">
                <i class="fas fa-filter me-2"></i>
                Filtros
            </button>
            <button class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Novo Documento
            </button>
        </div>
    </div>
</div>

<!-- Document Statistics -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-gradient-primary me-3">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <h3 class="stat-value"><?= number_format($stats['total'] ?? 0) ?></h3>
                        <p class="stat-label">Total Documentos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-gradient-success me-3">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <h3 class="stat-value"><?= number_format($stats['receipts'] ?? 0) ?></h3>
                        <p class="stat-label">Recibos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-gradient-warning me-3">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div>
                        <h3 class="stat-value"><?= number_format($stats['payments'] ?? 0) ?></h3>
                        <p class="stat-label">Pagamentos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-gradient-info me-3">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h3 class="stat-value"><?= number_format($stats['plans'] ?? 0) ?></h3>
                        <p class="stat-label">Planos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Pesquisar</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" name="search" 
                           value="<?= e($search ?? '') ?>" placeholder="Cliente, número...">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tipo</label>
                <select class="form-select" name="type">
                    <option value="">Todos</option>
                    <option value="receipt" <?= ($type ?? '') === 'receipt' ? 'selected' : '' ?>>Recibo</option>
                    <option value="payment" <?= ($type ?? '') === 'payment' ? 'selected' : '' ?>>Pagamento</option>
                    <option value="plan" <?= ($type ?? '') === 'plan' ? 'selected' : '' ?>>Plano</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option value="">Todos</option>
                    <option value="draft" <?= ($status ?? '') === 'draft' ? 'selected' : '' ?>>Rascunho</option>
                    <option value="sent" <?= ($status ?? '') === 'sent' ? 'selected' : '' ?>>Enviado</option>
                    <option value="paid" <?= ($status ?? '') === 'paid' ? 'selected' : '' ?>>Pago</option>
                    <option value="overdue" <?= ($status ?? '') === 'overdue' ? 'selected' : '' ?>>Vencido</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Período</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="date_from" 
                           value="<?= e($_GET['date_from'] ?? '') ?>">
                    <span class="input-group-text">até</span>
                    <input type="date" class="form-control" name="date_to" 
                           value="<?= e($_GET['date_to'] ?? '') ?>">
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter"></i>
                </button>
                <a href="<?= url('/invoices') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Documents Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            Lista de Documentos
        </h5>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($invoices)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th>Número</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input row-checkbox" 
                                           value="<?= $invoice['id'] ?>">
                                </td>
                                <td>
                                    <strong><?= e($invoice['number'] ?? '#' . str_pad($invoice['id'], 6, '0', STR_PAD_LEFT)) ?></strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar-sm me-2">
                                            <?= strtoupper(substr($invoice['client_name'] ?? 'C', 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-medium"><?= e($invoice['client_name'] ?? 'Cliente') ?></div>
                                            <small class="text-muted"><?= e($invoice['client_email'] ?? '') ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $typeLabels = [
                                        'receipt' => ['label' => 'Recibo', 'class' => 'bg-success'],
                                        'payment' => ['label' => 'Pagamento', 'class' => 'bg-warning'],
                                        'plan' => ['label' => 'Plano', 'class' => 'bg-info']
                                    ];
                                    $type = $invoice['type'] ?? 'receipt';
                                    $typeInfo = $typeLabels[$type] ?? $typeLabels['receipt'];
                                    ?>
                                    <span class="badge <?= $typeInfo['class'] ?>">
                                        <?= $typeInfo['label'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?= formatDate($invoice['created_at'] ?? '') ?>
                                </td>
                                <td>
                                    <strong class="text-success">
                                        <?= formatCurrency($invoice['total'] ?? 0) ?>
                                    </strong>
                                </td>
                                <td>
                                    <?php
                                    $statusLabels = [
                                        'draft' => ['label' => 'Rascunho', 'class' => 'bg-secondary'],
                                        'sent' => ['label' => 'Enviado', 'class' => 'bg-info'],
                                        'paid' => ['label' => 'Pago', 'class' => 'bg-success'],
                                        'overdue' => ['label' => 'Vencido', 'class' => 'bg-danger']
                                    ];
                                    $status = $invoice['status'] ?? 'draft';
                                    $statusInfo = $statusLabels[$status] ?? $statusLabels['draft'];
                                    ?>
                                    <span class="badge <?= $statusInfo['class'] ?>">
                                        <?= $statusInfo['label'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= url("/invoices/{$invoice['id']}") ?>" 
                                           class="btn btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= url("/invoices/{$invoice['id']}/edit") ?>" 
                                           class="btn btn-outline-secondary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-outline-success" title="Download PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" 
                                                onclick="confirmDelete(<?= $invoice['id'] ?>)"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php if (!empty($pagination)): ?>
                    <div class="card-footer">
                        <?= renderPagination($pagination, url('/invoices')) ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                    <h5>Nenhum documento encontrado</h5>
                    <p class="text-muted">Não há documentos que correspondam aos critérios de pesquisa.</p>
                    <button class="global-btn-add-primary" onclick="createNewDocument()">
                        <div class="global-btn-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="global-btn-content">
                            <div class="global-btn-title">Criar Primeiro Documento</div>
                        </div>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div> <!-- End global-main-container -->


<style>
.stat-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.stat-card-body {
    padding: 1.5rem;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    color: #1f2937;
}

.stat-label {
    color: #6b7280;
    font-size: 0.875rem;
    margin: 0.25rem 0 0 0;
    font-weight: 500;
}

.user-avatar-sm {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .page-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .stat-card {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
    }
}
</style>

<script>
function confirmDelete(id) {
    document.getElementById('deleteForm').action = `<?= url('/invoices') ?>/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Select all functionality
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
});
</script>