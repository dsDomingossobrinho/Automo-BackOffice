<?php
/**
 * Finances - Total Revenue View
 */
?>

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-chart-area me-3 text-success"></i>
                Total Facturado
            </h1>
            <p class="page-subtitle text-muted">Visão geral das receitas totais do sistema</p>
        </div>
        <div class="page-actions">
            <select class="form-select me-2" id="yearFilter">
                <option value="<?= date('Y') ?>" selected><?= date('Y') ?></option>
                <option value="<?= date('Y') - 1 ?>"><?= date('Y') - 1 ?></option>
                <option value="<?= date('Y') - 2 ?>"><?= date('Y') - 2 ?></option>
            </select>
            <button class="btn btn-outline-primary">
                <i class="fas fa-download me-2"></i>
                Exportar
            </button>
        </div>
    </div>
</div>

<!-- Revenue Overview Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-gradient-success me-3">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div>
                        <h3 class="stat-value"><?= formatCurrency($totalRevenue ?? 0) ?></h3>
                        <p class="stat-label">Receita Total</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +15.3%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-gradient-primary me-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h3 class="stat-value"><?= formatCurrency(($stats['monthly_avg'] ?? 0)) ?></h3>
                        <p class="stat-label">Média Mensal</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +8.2%
                        </span>
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
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h3 class="stat-value"><?= formatCurrency(($stats['this_month'] ?? 0)) ?></h3>
                        <p class="stat-label">Este Mês</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +12.1%
                        </span>
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
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="stat-value"><?= number_format($stats['total_clients'] ?? 0) ?></h3>
                        <p class="stat-label">Clientes Pagantes</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +5.7%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="row mb-4">
    <div class="col-xl-8">
        <div class="chart-card">
            <div class="chart-header">
                <h4 class="chart-title">Evolução da Receita</h4>
                <div class="chart-actions">
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary active" data-period="month">Mensal</button>
                        <button type="button" class="btn btn-outline-primary" data-period="quarter">Trimestral</button>
                        <button type="button" class="btn btn-outline-primary" data-period="year">Anual</button>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4">
        <div class="chart-card">
            <div class="chart-header">
                <h4 class="chart-title">Top Clientes</h4>
            </div>
            <div class="top-clients-list">
                <?php if (!empty($topClients)): ?>
                    <?php foreach ($topClients as $index => $client): ?>
                        <div class="client-item">
                            <div class="client-info">
                                <div class="client-avatar">
                                    <?= strtoupper(substr($client['name'] ?? 'C', 0, 1)) ?>
                                </div>
                                <div class="client-details">
                                    <h6><?= e($client['name'] ?? 'Cliente') ?></h6>
                                    <p><?= formatCurrency($client['total_spent'] ?? 0) ?></p>
                                </div>
                            </div>
                            <div class="client-rank">
                                #<?= $index + 1 ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-users fa-2x mb-3"></i>
                        <p>Nenhum dado de cliente disponível</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Transações Recentes</h4>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recentTransactions)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentTransactions as $transaction): ?>
                                    <tr>
                                        <td><?= formatDate($transaction['created_at'] ?? '') ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar-sm me-2">
                                                    <?= strtoupper(substr($transaction['client_name'] ?? 'C', 0, 1)) ?>
                                                </div>
                                                <?= e($transaction['client_name'] ?? 'Cliente') ?>
                                            </div>
                                        </td>
                                        <td><?= e($transaction['description'] ?? 'Pagamento de serviço') ?></td>
                                        <td class="fw-bold text-success"><?= formatCurrency($transaction['amount'] ?? 0) ?></td>
                                        <td>
                                            <span class="badge bg-success">Pago</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="Ver detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-secondary" title="Baixar recibo">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-receipt fa-3x mb-3"></i>
                        <h5>Nenhuma transação encontrada</h5>
                        <p>Não há transações recentes para exibir.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

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

.bg-gradient-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
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
    margin: 0.25rem 0 0.5rem 0;
    font-weight: 500;
}

.stat-change {
    font-size: 0.8125rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
}

.stat-change.positive {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.chart-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
    height: 100%;
}

.chart-header {
    padding: 1.5rem 1.5rem 0;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: between;
    align-items: center;
}

.chart-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.chart-container {
    padding: 0 1.5rem 1.5rem;
    height: 300px;
}

.client-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.client-item:last-child {
    border-bottom: none;
}

.client-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.client-avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.client-details h6 {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
}

.client-details p {
    margin: 0;
    font-size: 0.75rem;
    color: #059669;
    font-weight: 600;
}

.client-rank {
    font-size: 0.875rem;
    font-weight: 600;
    color: #6b7280;
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
    
    .chart-card {
        margin-bottom: 1rem;
    }
    
    .chart-container {
        height: 250px;
    }
}
</style>

<script>
// Placeholder for chart initialization
document.addEventListener('DOMContentLoaded', function() {
    console.log('Finance dashboard loaded');
    
    // Year filter functionality
    const yearFilter = document.getElementById('yearFilter');
    if (yearFilter) {
        yearFilter.addEventListener('change', function() {
            // Reload page with new year parameter
            window.location.href = window.location.pathname + '?year=' + this.value;
        });
    }
    
    // Period buttons functionality
    const periodButtons = document.querySelectorAll('[data-period]');
    periodButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            periodButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Here you would typically update the chart data
            console.log('Period changed to:', this.dataset.period);
        });
    });
});
</script>