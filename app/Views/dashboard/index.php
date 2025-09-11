<!-- 1. TÍTULO DA PÁGINA - ISOLADO -->
<div class="page-title-section">
    <div class="page-title-container">
        <h1 class="main-page-title">
            <i class="fas fa-tachometer-alt page-icon"></i>
            Dashboard
        </h1>
    </div>
</div>

<?php if (isset($api_error) && $api_error): ?>
<div class="alert-section">
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <strong>Atenção:</strong> Não foi possível conectar com o sistema backend. 
            Os dados exibidos podem não estar atualizados.
        </div>
    </div>
</div>
<?php endif; ?>

<!-- 2. ESTATÍSTICAS PRINCIPAIS -->
<div class="stats-section">
    <div class="stats-grid">
        <!-- Total Clients -->
        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= number_format($stats['total_clients']) ?></div>
                <div class="stat-label">Total de Clientes</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+<?= $stats['new_clients_month'] ?></span>
                    <small>este mês</small>
                </div>
            </div>
        </div>
        
        <!-- Active Clients -->
        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= number_format($stats['active_clients']) ?></div>
                <div class="stat-label">Clientes Ativos</div>
                <div class="stat-trend trend-neutral">
                    <i class="fas fa-percentage"></i>
                    <span><?= $stats['total_clients'] > 0 ? round(($stats['active_clients'] / $stats['total_clients']) * 100, 1) : 0 ?>%</span>
                    <small>do total</small>
                </div>
            </div>
        </div>
        
        <!-- Messages -->
        <div class="stat-card">
            <div class="stat-icon stat-icon-info">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= number_format($stats['total_messages']) ?></div>
                <div class="stat-label">Mensagens Enviadas</div>
                <div class="stat-trend trend-info">
                    <i class="fas fa-clock"></i>
                    <span><?= $stats['messages_today'] ?></span>
                    <small>hoje</small>
                </div>
            </div>
        </div>
        
        <!-- Revenue -->
        <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= number_format($stats['total_revenue'], 0, ',', '.') ?><small class="currency">AOA</small></div>
                <div class="stat-label">Receita Total</div>
                <div class="stat-trend trend-warning">
                    <i class="fas fa-calendar"></i>
                    <span><?= number_format($stats['monthly_revenue'], 0, ',', '.') ?></span>
                    <small>este mês</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. GRÁFICOS E ANÁLISES -->
<div class="charts-section">
    <div class="charts-grid">
        <!-- Revenue Chart -->
        <div class="chart-card main-chart">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-chart-line"></i>
                    <div class="title-content">
                        <h3>Evolução da Receita</h3>
                        <small>Receita mensal dos últimos 6 meses</small>
                    </div>
                </div>
                <div class="card-actions">
                    <button class="action-button">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="action-button">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Distribution Chart -->
        <div class="chart-card side-chart">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    <div class="title-content">
                        <h3>Distribuição</h3>
                        <small>Mensagens por tipo</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="distributionChart"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-dot bg-primary"></div>
                        <div class="legend-content">
                            <span>Enviadas</span>
                            <strong><?= number_format($chart_data['message_stats']['data'][0] ?? 0) ?></strong>
                        </div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot bg-success"></div>
                        <div class="legend-content">
                            <span>Entregues</span>
                            <strong><?= number_format($chart_data['message_stats']['data'][1] ?? 0) ?></strong>
                        </div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot bg-warning"></div>
                        <div class="legend-content">
                            <span>Respondidas</span>
                            <strong><?= number_format($chart_data['message_stats']['data'][2] ?? 0) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. ATIVIDADES E AÇÕES RÁPIDAS -->
<div class="activities-section">
    <div class="activities-grid">
        <!-- Recent Activities -->
        <div class="activities-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-clock"></i>
                    <div class="title-content">
                        <h3>Atividades Recentes</h3>
                        <small>Últimas ações no sistema</small>
                    </div>
                </div>
                <a href="#" class="view-all-button">
                    <i class="fas fa-history"></i>
                    Ver Todas
                </a>
            </div>
            <div class="card-body">
                <?php if (empty($recent_activity)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h4>Nenhuma atividade recente</h4>
                        <p>As ações do sistema aparecerão aqui</p>
                    </div>
                <?php else: ?>
                    <div class="activity-timeline">
                        <?php foreach (array_slice($recent_activity, 0, 5) as $index => $activity): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker <?= 'timeline-marker-' . $activity['color'] ?>">
                                    <i class="fas fa-<?= $activity['icon'] ?>"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title"><?= e($activity['message']) ?></div>
                                    <div class="timeline-time">
                                        <i class="fas fa-clock"></i>
                                        <?= date('d/m/Y H:i', strtotime($activity['timestamp'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-bolt"></i>
                    <div class="title-content">
                        <h3>Ações Rápidas</h3>
                        <small>Operações frequentes</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="quick-actions-grid">
                    <button type="button" class="quick-action-item" onclick="window.location.href='<?= url('/clients') ?>'">
                        <div class="quick-action-icon bg-primary">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="quick-action-content">
                            <span class="quick-action-title">Novo Cliente</span>
                            <small class="quick-action-subtitle">Registar cliente</small>
                        </div>
                        <i class="fas fa-arrow-right quick-action-arrow"></i>
                    </button>
                    
                    <button type="button" class="quick-action-item" onclick="window.location.href='<?= url('/messages') ?>'">
                        <div class="quick-action-icon bg-info">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="quick-action-content">
                            <span class="quick-action-title">Enviar Mensagem</span>
                            <small class="quick-action-subtitle">Nova campanha SMS</small>
                        </div>
                        <i class="fas fa-arrow-right quick-action-arrow"></i>
                    </button>
                    
                    <button type="button" class="quick-action-item" onclick="window.location.href='<?= url('/invoices') ?>'">
                        <div class="quick-action-icon bg-success">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="quick-action-content">
                            <span class="quick-action-title">Nova Fatura</span>
                            <small class="quick-action-subtitle">Gerar documento</small>
                        </div>
                        <i class="fas fa-arrow-right quick-action-arrow"></i>
                    </button>
                    
                    <button type="button" class="quick-action-item" onclick="window.location.href='<?= url('/accounts') ?>'">
                        <div class="quick-action-icon bg-warning">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="quick-action-content">
                            <span class="quick-action-title">Nova Conta</span>
                            <small class="quick-action-subtitle">Criar utilizador</small>
                        </div>
                        <i class="fas fa-arrow-right quick-action-arrow"></i>
                    </button>
                </div>
                
                <!-- System Summary -->
                <div class="system-summary">
                    <h4 class="summary-title">Resumo do Sistema</h4>
                    <div class="summary-grid">
                        <div class="summary-item">
                            <div class="summary-value"><?= $stats['total_users'] ?></div>
                            <div class="summary-label">Utilizadores</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-value"><?= $stats['total_clients'] > 0 ? round(($stats['active_clients'] / $stats['total_clients']) * 100, 1) : 0 ?>%</div>
                            <div class="summary-label">Taxa de Atividade</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-value"><?= number_format($stats['monthly_revenue'] / 1000, 1) ?>K</div>
                            <div class="summary-label">AOA Mensal</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js Configuration
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
    Chart.defaults.font.size = 12;
    Chart.defaults.color = '#6b7280';
    
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_data['monthly_revenue']['labels']) ?>,
            datasets: [{
                label: 'Receita (AOA)',
                data: <?= json_encode($chart_data['monthly_revenue']['data']) ?>,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#f1f5f9',
                    bodyColor: '#f1f5f9',
                    borderColor: '#3b82f6',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return 'Receita: ' + new Intl.NumberFormat('pt-AO').format(context.parsed.y) + ' AOA';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)'
                    },
                    border: { display: false },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('pt-AO', {
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value) + ' AOA';
                        }
                    }
                }
            }
        }
    });
    
    // Distribution Chart
    const distributionCtx = document.getElementById('distributionChart').getContext('2d');
    new Chart(distributionCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($chart_data['message_stats']['labels']) ?>,
            datasets: [{
                data: <?= json_encode($chart_data['message_stats']['data']) ?>,
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#f1f5f9',
                    bodyColor: '#f1f5f9',
                    cornerRadius: 8
                }
            }
        }
    });
});
</script>

<link rel="stylesheet" href="/css/global-design-system.css">

<style>
/* Dashboard specific overrides */
.page-icon:before {
    content: "\f3fd"; /* fa-tachometer-alt */
}

/* Alert Section */
.alert-section {
    margin-bottom: 2rem;
}

.alert {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));
    border: 1px solid rgba(245, 158, 11, 0.2);
    border-radius: var(--border-radius);
    gap: 0.75rem;
    color: #92400e;
}

.alert i {
    font-size: 1.125rem;
    flex-shrink: 0;
}

.alert strong {
    font-weight: 600;
}

/* Stats Section */
.stats-section {
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--card-background);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-icon-primary { background: var(--gradient-primary); }
.stat-icon-success { background: var(--gradient-success); }
.stat-icon-info { background: var(--gradient-info); }
.stat-icon-warning { background: var(--gradient-warning); }

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-value .currency {
    font-size: 1rem;
    font-weight: 500;
    color: var(--text-muted);
    margin-left: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-muted);
    font-weight: 500;
    margin-bottom: 0.75rem;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.trend-up { color: var(--color-success); }
.trend-neutral { color: var(--text-muted); }
.trend-info { color: var(--color-info); }
.trend-warning { color: var(--color-warning); }

/* Charts Section */
.charts-section {
    margin-bottom: 2rem;
}

.charts-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}

.chart-card {
    background: var(--card-background);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.chart-card .card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-title i {
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

.title-content h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.25rem 0;
}

.title-content small {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.card-actions {
    display: flex;
    gap: 0.5rem;
}

.action-button {
    width: 36px;
    height: 36px;
    border: none;
    background: var(--border-color);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    cursor: pointer;
    transition: all 0.2s ease;
}

.action-button:hover {
    background: var(--primary-color);
    color: white;
}

.chart-card .card-body {
    padding: 1.5rem;
}

.chart-container {
    position: relative;
    height: 300px;
}

.side-chart .chart-container {
    height: 220px;
}

.chart-legend {
    margin-top: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.legend-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
}

.legend-item .legend-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
}

.legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.legend-dot.bg-primary { background: var(--primary-color); }
.legend-dot.bg-success { background: var(--color-success); }
.legend-dot.bg-warning { background: var(--color-warning); }

.legend-item span {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.legend-item strong {
    font-weight: 600;
    color: var(--text-primary);
}

/* Activities Section */
.activities-section {
    margin-bottom: 2rem;
}

.activities-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}

.activities-card,
.quick-actions-card {
    background: var(--card-background);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.activities-card .card-header,
.quick-actions-card .card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.view-all-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.view-all-button:hover {
    background: var(--primary-dark);
    color: white;
    text-decoration: none;
}

.activities-card .card-body,
.quick-actions-card .card-body {
    padding: 1.5rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: rgba(var(--primary-rgb), 0.1);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.empty-state h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--text-muted);
    margin: 0;
}

/* Activity Timeline */
.activity-timeline {
    max-height: 400px;
    overflow-y: auto;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 0;
    position: relative;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 24px;
    top: 60px;
    bottom: 0;
    width: 2px;
    background: var(--border-color);
}

.timeline-marker {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.timeline-marker-primary { background: var(--gradient-primary); }
.timeline-marker-success { background: var(--gradient-success); }
.timeline-marker-info { background: var(--gradient-info); }
.timeline-marker-warning { background: var(--gradient-warning); }

.timeline-content {
    flex: 1;
}

.timeline-title {
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.timeline-time {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Quick Actions */
.quick-actions-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.quick-action-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(var(--primary-rgb), 0.05);
    border: 1px solid rgba(var(--primary-rgb), 0.1);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.quick-action-item:hover {
    background: rgba(var(--primary-rgb), 0.1);
    transform: translateY(-2px);
    color: inherit;
}

.quick-action-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.125rem;
    flex-shrink: 0;
}

.quick-action-icon.bg-primary { background: var(--gradient-primary); }
.quick-action-icon.bg-info { background: var(--gradient-info); }
.quick-action-icon.bg-success { background: var(--gradient-success); }
.quick-action-icon.bg-warning { background: var(--gradient-warning); }

.quick-action-content {
    flex: 1;
}

.quick-action-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.quick-action-subtitle {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.quick-action-arrow {
    color: var(--text-muted);
    font-size: 0.875rem;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
}

.quick-action-item:hover .quick-action-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* System Summary */
.system-summary {
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.summary-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    text-align: center;
}

.summary-item {
    padding: 0.75rem;
    background: rgba(var(--primary-rgb), 0.05);
    border-radius: 8px;
}

.summary-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.summary-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .charts-grid,
    .activities-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .summary-grid {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
}
</style>