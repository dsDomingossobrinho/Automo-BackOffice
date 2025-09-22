<!-- 1. TÍTULO DA PÁGINA - ISOLADO -->
<div class="page-title-section">
    <div class="page-title-container">
        <h1 class="main-page-title">
            <i class="fas fa-chart-area page-icon"></i>
            Gestão Financeira
        </h1>
    </div>
</div>

<!-- 2. CONTROLOS PRINCIPAIS -->
<div class="controls-section">
    <div class="controls-container">
        <div class="control-group">
            <select class="control-select" id="yearFilter">
                <option value="<?= date('Y') ?>" selected><?= date('Y') ?></option>
                <option value="<?= date('Y') - 1 ?>"><?= date('Y') - 1 ?></option>
                <option value="<?= date('Y') - 2 ?>"><?= date('Y') - 2 ?></option>
            </select>
            
            <button type="button" class="control-button export-button" onclick="openExportCard()">
                <i class="fas fa-download"></i>
                Exportar Dados
            </button>
        </div>
    </div>
</div>

<!-- 3. ESTATÍSTICAS PRINCIPAIS -->
<div class="stats-section">
    <div class="stats-grid">
        <!-- Total Revenue -->
        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= formatCurrency($totalRevenue ?? 0) ?></div>
                <div class="stat-label">Receita Total</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15.3%</span>
                    <small>vs período anterior</small>
                </div>
            </div>
        </div>
        
        <!-- Monthly Average -->
        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= formatCurrency(($stats['monthly_avg'] ?? 0)) ?></div>
                <div class="stat-label">Média Mensal</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8.2%</span>
                    <small>vs período anterior</small>
                </div>
            </div>
        </div>
        
        <!-- This Month -->
        <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= formatCurrency(($stats['this_month'] ?? 0)) ?></div>
                <div class="stat-label">Este Mês</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12.1%</span>
                    <small>vs mês anterior</small>
                </div>
            </div>
        </div>
        
        <!-- Paying Clients -->
        <div class="stat-card">
            <div class="stat-icon stat-icon-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= number_format($stats['total_clients'] ?? 0) ?></div>
                <div class="stat-label">Clientes Pagantes</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+5.7%</span>
                    <small>novos clientes</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. GRÁFICOS E ANÁLISES -->
<div class="charts-section">
    <div class="charts-grid">
        <!-- Revenue Chart -->
        <div class="chart-card main-chart">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-chart-line"></i>
                    <div class="title-content">
                        <h3>Evolução da Receita</h3>
                        <small>Análise temporal das receitas</small>
                    </div>
                </div>
                <div class="chart-controls">
                    <div class="period-buttons">
                        <button class="period-btn active" data-period="month">Mensal</button>
                        <button class="period-btn" data-period="quarter">Trimestral</button>
                        <button class="period-btn" data-period="year">Anual</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Top Clients -->
        <div class="chart-card side-chart">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-crown"></i>
                    <div class="title-content">
                        <h3>Top Clientes</h3>
                        <small>Maiores contribuidores</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="top-clients-list">
                    <?php if (!empty($topClients)): ?>
                        <?php foreach ($topClients as $index => $client): ?>
                            <div class="client-item">
                                <div class="client-info">
                                    <div class="client-avatar">
                                        <?= strtoupper(substr($client['name'] ?? 'C', 0, 1)) ?>
                                    </div>
                                    <div class="client-details">
                                        <div class="client-name"><?= e($client['name'] ?? 'Cliente') ?></div>
                                        <div class="client-amount"><?= formatCurrency($client['total_spent'] ?? 0) ?></div>
                                    </div>
                                </div>
                                <div class="client-rank">#<?= $index + 1 ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>Sem dados de clientes</h4>
                            <p>Nenhum dado disponível</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 5. TABELA DE TRANSAÇÕES -->
<div class="data-table-section">
    <div class="data-table-container">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-receipt"></i>
                <h3>Transações Recentes</h3>
            </div>
            <button type="button" class="table-action-button" onclick="openTransactionDetails()">
                <i class="fas fa-list"></i>
                Ver Todas
            </button>
        </div>
        
        <div class="table-wrapper">
            <?php if (!empty($recentTransactions)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-calendar"></i>Data</th>
                            <th><i class="fas fa-user"></i>Cliente</th>
                            <th><i class="fas fa-file-alt"></i>Descrição</th>
                            <th><i class="fas fa-money-bill"></i>Valor</th>
                            <th><i class="fas fa-check-circle"></i>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentTransactions as $transaction): ?>
                            <tr>
                                <td><?= formatDate($transaction['created_at'] ?? '') ?></td>
                                <td>
                                    <div class="client-cell">
                                        <div class="client-mini-avatar">
                                            <?= strtoupper(substr($transaction['client_name'] ?? 'C', 0, 1)) ?>
                                        </div>
                                        <div class="client-mini-info">
                                            <div class="client-mini-name"><?= e($transaction['client_name'] ?? 'Cliente') ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= e($transaction['description'] ?? 'Pagamento de serviço') ?></td>
                                <td>
                                    <span class="amount-value success"><?= formatCurrency($transaction['amount'] ?? 0) ?></span>
                                </td>
                                <td>
                                    <span class="status-badge success">
                                        <i class="fas fa-check"></i>
                                        Pago
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button type="button" class="action-btn view-btn" onclick="openTransactionView('<?= $transaction['id'] ?? '' ?>')">
                                            <i class="fas fa-eye"></i>
                                            <span>Ver</span>
                                        </button>
                                        <button type="button" class="action-btn download-btn" onclick="downloadReceipt('<?= $transaction['id'] ?? '' ?>')">
                                            <i class="fas fa-download"></i>
                                            <span>Recibo</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h4>Nenhuma transação encontrada</h4>
                    <p>Não há transações recentes para exibir</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- MODAL CARDS -->

<!-- 1. EXPORT CARD -->
<div class="card-overlay" id="exportCardOverlay" style="display: none;">
    <div class="modal-card export-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-download"></i>
                Exportar Dados Financeiros
            </div>
            <button type="button" class="card-close" onclick="closeCard('exportCardOverlay')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <form id="exportFinanceForm" onsubmit="handleExportSubmit(event)">
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="export_format">Formato do Arquivo</label>
                            <select id="export_format" name="format">
                                <option value="csv">CSV (Excel)</option>
                                <option value="pdf">PDF</option>
                                <option value="xlsx">XLSX</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="export_period">Período</label>
                            <select id="export_period" name="period">
                                <option value="current_month">Mês Atual</option>
                                <option value="last_month">Mês Anterior</option>
                                <option value="current_year">Ano Atual</option>
                                <option value="last_year">Ano Anterior</option>
                                <option value="custom">Período Personalizado</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-column">
                        <div class="form-group">
                            <label for="export_data">Dados a Incluir</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="include_transactions" checked>
                                    <span>Transações</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="include_clients" checked>
                                    <span>Dados de Clientes</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="include_summary" checked>
                                    <span>Resumo Estatístico</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group custom-period" style="display: none;">
                            <label for="export_date_from">Data Início</label>
                            <input type="date" id="export_date_from" name="date_from">
                            
                            <label for="export_date_to" style="margin-top: 0.75rem;">Data Fim</label>
                            <input type="date" id="export_date_to" name="date_to">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-footer">
            <button type="button" class="footer-btn cancel-btn" onclick="closeCard('exportCardOverlay')">
                <i class="fas fa-times"></i>
                Cancelar
            </button>
            <button type="submit" form="exportFinanceForm" class="footer-btn submit-btn">
                <i class="fas fa-download"></i>
                Exportar Dados
            </button>
        </div>
    </div>
</div>

<script>
// Global variables
let currentExportSettings = {};

// Card management functions
function openExportCard() {
    document.getElementById('exportCardOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeCard(overlayId) {
    document.getElementById(overlayId).style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Export form handling
document.addEventListener('DOMContentLoaded', function() {
    // Period selection handler
    const periodSelect = document.getElementById('export_period');
    const customPeriodGroup = document.querySelector('.custom-period');
    
    if (periodSelect) {
        periodSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customPeriodGroup.style.display = 'block';
            } else {
                customPeriodGroup.style.display = 'none';
            }
        });
    }
    
    // Year filter functionality
    const yearFilter = document.getElementById('yearFilter');
    if (yearFilter) {
        yearFilter.addEventListener('change', function() {
            window.location.href = window.location.pathname + '?year=' + this.value;
        });
    }
    
    // Period buttons functionality
    const periodButtons = document.querySelectorAll('.period-btn');
    periodButtons.forEach(button => {
        button.addEventListener('click', function() {
            periodButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            console.log('Period changed to:', this.dataset.period);
            // Here you would update the chart data
        });
    });
});

// Form submission handlers
async function handleExportSubmit(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    try {
        // Show loading state
        const submitBtn = document.querySelector('#exportFinanceForm + .card-footer .submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
        submitBtn.disabled = true;
        
        // Simulate export process
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        closeCard('exportCardOverlay');
        
        // Show success message
        alert('Exportação concluída com sucesso!');
        
    } catch (error) {
        alert('Erro durante a exportação');
    }
}

// Transaction actions
function openTransactionView(transactionId) {
    console.log('Opening transaction view:', transactionId);
    // Implementation for viewing transaction details
}

function downloadReceipt(transactionId) {
    console.log('Downloading receipt for transaction:', transactionId);
    // Implementation for downloading receipt
}

function openTransactionDetails() {
    console.log('Opening all transactions');
    // Implementation for showing all transactions
}

// Close cards when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('card-overlay')) {
        const overlayId = event.target.id;
        closeCard(overlayId);
    }
});

// Close cards with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const openCards = ['exportCardOverlay'];
        openCards.forEach(cardId => {
            const card = document.getElementById(cardId);
            if (card.style.display === 'flex') {
                closeCard(cardId);
            }
        });
    }
});
</script>

<link rel="stylesheet" href="<?= asset('css/global-design-system.css') ?>">

<style>
/* Finances specific overrides */
.page-icon:before {
    content: "\f1fe"; /* fa-chart-area */
}

/* Controls Section */
.controls-section {
    margin-bottom: 2rem;
}

.controls-container {
    display: flex;
    justify-content: center;
}

.control-group {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.control-select {
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background: var(--card-background);
    color: var(--text-primary);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.control-select:hover,
.control-select:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
}

.export-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.export-button:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-hover);
}

/* Stats Section - Override for financial stats */
.stat-icon-success { background: var(--gradient-success); }
.stat-icon-primary { background: var(--gradient-primary); }
.stat-icon-warning { background: var(--gradient-warning); }
.stat-icon-info { background: var(--gradient-info); }

/* Chart Controls */
.chart-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.period-buttons {
    display: flex;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
}

.period-btn {
    padding: 0.5rem 1rem;
    border: none;
    background: var(--card-background);
    color: var(--text-muted);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.period-btn:not(:last-child) {
    border-right: 1px solid var(--border-color);
}

.period-btn:hover {
    background: rgba(var(--primary-rgb), 0.05);
    color: var(--primary-color);
}

.period-btn.active {
    background: var(--primary-color);
    color: white;
}

/* Top Clients List */
.top-clients-list {
    max-height: 400px;
    overflow-y: auto;
}

.client-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    transition: background-color 0.2s ease;
}

.client-item:last-child {
    border-bottom: none;
}

.client-item:hover {
    background: rgba(var(--primary-rgb), 0.02);
}

.client-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
}

.client-avatar {
    width: 40px;
    height: 40px;
    background: var(--gradient-primary);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.client-details {
    flex: 1;
}

.client-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.client-amount {
    font-size: 0.75rem;
    color: var(--color-success);
    font-weight: 600;
}

.client-rank {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    min-width: 2rem;
    text-align: right;
}

/* Table specific styles */
.client-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.client-mini-avatar {
    width: 32px;
    height: 32px;
    background: var(--gradient-primary);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.client-mini-name {
    font-weight: 500;
    color: var(--text-primary);
}

.amount-value {
    font-weight: 600;
    font-size: 0.875rem;
}

.amount-value.success {
    color: var(--color-success);
}

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.status-badge.success {
    background: rgba(var(--success-rgb), 0.1);
    color: var(--color-success);
}

/* Export card specific styles */
.export-card {
    max-width: 600px;
}

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.checkbox-item input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: var(--primary-color);
}

.checkbox-item span {
    font-size: 0.875rem;
    color: var(--text-primary);
}

/* Table Actions */
.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.table-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.table-title i {
    width: 40px;
    height: 40px;
    background: var(--gradient-primary);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.table-title h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.table-action-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.table-action-button:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .charts-grid {
        grid-template-columns: 1fr;
    }
    
    .period-buttons {
        flex-wrap: wrap;
    }
}

@media (max-width: 768px) {
    .controls-container {
        justify-content: stretch;
    }
    
    .control-group {
        flex-direction: column;
        align-items: stretch;
    }
    
    .export-button {
        justify-content: center;
    }
    
    .table-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .client-item {
        padding: 0.75rem;
    }
    
    .client-avatar {
        width: 36px;
        height: 36px;
        font-size: 0.8125rem;
    }
    
    .client-mini-avatar {
        width: 28px;
        height: 28px;
        font-size: 0.7rem;
    }
}
</style>