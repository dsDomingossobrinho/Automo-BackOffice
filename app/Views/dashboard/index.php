<div class="page-container">
    <?php if (isset($api_error) && $api_error): ?>
    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <div>
            <strong>Atenção:</strong> Não foi possível conectar com o sistema backend. 
            Os dados exibidos podem não estar atualizados.
        </div>
    </div>
    <?php endif; ?>

    <!-- Modern Dashboard Header -->
    <div class="dashboard-welcome-card mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center">
                <div class="dashboard-avatar me-3">
                    <img src="<?= asset('images/automo-logo.png') ?>" alt="Automo" class="avatar-img">
                </div>
                <div>
                    <h1 class="dashboard-title mb-1">Bem-vindo ao Automo BackOffice</h1>
                    <p class="dashboard-subtitle mb-0">
                        Sistema de gestão automotiva • 
                        <span class="text-primary"><?= date('d/m/Y') ?></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <div class="d-flex align-items-center justify-content-lg-end gap-2">
                <button class="btn btn-outline-primary btn-sm d-flex align-items-center">
                    <i class="fas fa-sync me-1"></i>
                    Atualizar
                </button>
                <button class="btn btn-primary btn-sm d-flex align-items-center">
                    <i class="fas fa-download me-1"></i>
                    Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modern Statistics Grid -->
<div class="row mb-4 g-4">
    <!-- Total Clients -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card h-100">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon stat-icon-primary me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-label">Total de Clientes</div>
                        <div class="stat-value"><?= number_format($stats['total_clients']) ?></div>
                    </div>
                </div>
                <div class="stat-footer mt-3">
                    <div class="stat-trend trend-up">
                        <i class="fas fa-arrow-up"></i>
                        <span>+<?= $stats['new_clients_month'] ?></span>
                        <small>este mês</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Active Clients -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card h-100">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon stat-icon-success me-3">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-label">Clientes Ativos</div>
                        <div class="stat-value"><?= number_format($stats['active_clients']) ?></div>
                    </div>
                </div>
                <div class="stat-footer mt-3">
                    <div class="stat-trend trend-neutral">
                        <i class="fas fa-percentage"></i>
                        <span><?= $stats['total_clients'] > 0 ? round(($stats['active_clients'] / $stats['total_clients']) * 100, 1) : 0 ?>%</span>
                        <small>do total</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Messages -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card h-100">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon stat-icon-info me-3">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-label">Mensagens Enviadas</div>
                        <div class="stat-value"><?= number_format($stats['total_messages']) ?></div>
                    </div>
                </div>
                <div class="stat-footer mt-3">
                    <div class="stat-trend trend-info">
                        <i class="fas fa-clock"></i>
                        <span><?= $stats['messages_today'] ?></span>
                        <small>hoje</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Revenue -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card h-100">
            <div class="stat-card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon stat-icon-warning me-3">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-label">Receita Total</div>
                        <div class="stat-value"><?= number_format($stats['total_revenue'], 0, ',', '.') ?><small class="text-muted ms-1">AOA</small></div>
                    </div>
                </div>
                <div class="stat-footer mt-3">
                    <div class="stat-trend trend-warning">
                        <i class="fas fa-calendar"></i>
                        <span><?= number_format($stats['monthly_revenue'], 0, ',', '.') ?></span>
                        <small>este mês</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Analytics -->
<div class="row mb-4 g-4">
    <!-- Revenue Chart -->
    <div class="col-lg-8">
        <div class="analytics-card h-100">
            <div class="card-header-modern">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="chart-icon me-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Evolução da Receita</h5>
                            <small class="text-muted">Receita mensal dos últimos 6 meses</small>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Exportar</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Imprimir</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body-modern">
                <div class="chart-container">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="col-lg-4">
        <div class="analytics-card h-100">
            <div class="card-header-modern">
                <div class="d-flex align-items-center">
                    <div class="chart-icon me-3">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Distribuição</h5>
                        <small class="text-muted">Mensagens por tipo</small>
                    </div>
                </div>
            </div>
            <div class="card-body-modern">
                <div class="chart-container">
                    <canvas id="distributionChart" height="220"></canvas>
                </div>
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <div class="chart-legend-dot bg-primary me-2"></div>
                            <small>Enviadas</small>
                        </div>
                        <strong><?= number_format($chart_data['message_stats']['data'][0] ?? 0) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <div class="chart-legend-dot bg-success me-2"></div>
                            <small>Entregues</small>
                        </div>
                        <strong><?= number_format($chart_data['message_stats']['data'][1] ?? 0) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="chart-legend-dot bg-warning me-2"></div>
                            <small>Respondidas</small>
                        </div>
                        <strong><?= number_format($chart_data['message_stats']['data'][2] ?? 0) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activities and Quick Actions -->
<div class="row g-4">
    <!-- Recent Activities -->
    <div class="col-lg-8">
        <div class="activity-card">
            <div class="card-header-modern">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="activity-icon me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Atividades Recentes</h5>
                            <small class="text-muted">Últimas ações no sistema</small>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-history me-1"></i>Ver Todas
                    </a>
                </div>
            </div>
            <div class="card-body-modern">
                <?php if (empty($recent_activity)): ?>
                    <div class="empty-state py-5 text-center">
                        <div class="empty-icon mb-3">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h6 class="empty-title">Nenhuma atividade recente</h6>
                        <p class="empty-text text-muted">As ações do sistema aparecerão aqui</p>
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
                                        <i class="fas fa-clock me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($activity['timestamp'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="quick-actions-card">
            <div class="card-header-modern">
                <div class="d-flex align-items-center">
                    <div class="action-icon me-3">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Ações Rápidas</h5>
                        <small class="text-muted">Operações frequentes</small>
                    </div>
                </div>
            </div>
            <div class="card-body-modern">
                <div class="quick-actions-grid">
                    <a href="<?= url('/clients/create') ?>" class="quick-action-item">
                        <div class="quick-action-icon bg-primary">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="quick-action-content">
                            <div class="quick-action-title">Novo Cliente</div>
                            <small class="quick-action-subtitle">Registar cliente</small>
                        </div>
                        <i class="fas fa-arrow-right quick-action-arrow"></i>
                    </a>
                    
                    <a href="<?= url('/messages/create') ?>" class="quick-action-item">
                        <div class="quick-action-icon bg-info">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="quick-action-content">
                            <div class="quick-action-title">Enviar Mensagem</div>
                            <small class="quick-action-subtitle">Nova campanha SMS</small>
                        </div>
                        <i class="fas fa-arrow-right quick-action-arrow"></i>
                    </a>
                    
                    <a href="<?= url('/invoices/create') ?>" class="quick-action-item">
                        <div class="quick-action-icon bg-success">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="quick-action-content">
                            <div class="quick-action-title">Nova Fatura</div>
                            <small class="quick-action-subtitle">Gerar documento</small>
                        </div>
                        <i class="fas fa-arrow-right quick-action-arrow"></i>
                    </a>
                    
                    <a href="<?= url('/accounts/create') ?>" class="quick-action-item">
                        <div class="quick-action-icon bg-warning">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="quick-action-content">
                            <div class="quick-action-title">Nova Conta</div>
                            <small class="quick-action-subtitle">Criar utilizador</small>
                        </div>
                        <i class="fas fa-arrow-right quick-action-arrow"></i>
                    </a>
                </div>
                
                <!-- System Summary -->
                <div class="system-summary mt-4">
                    <h6 class="summary-title">Resumo do Sistema</h6>
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

<style>
/* Modern Dashboard Styles */
:root {
    --dashboard-bg: #f8fafc;
    --card-bg: #ffffff;
    --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    --card-shadow-hover: 0 10px 25px rgba(0, 0, 0, 0.15);
    --border-color: #e5e7eb;
    --text-primary: #111827;
    --text-secondary: #6b7280;
    --border-radius: 12px;
    --border-radius-lg: 16px;
}

body {
    background-color: var(--dashboard-bg);
}

/* Welcome Card */
.dashboard-welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: var(--border-radius-lg);
    padding: 2rem;
    color: white;
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
}

.dashboard-avatar {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--border-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.avatar-img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    filter: brightness(0) invert(1);
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Statistics Cards */
.stat-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--card-shadow-hover);
}

.stat-card-body {
    padding: 2rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-icon-primary { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.stat-icon-success { background: linear-gradient(135deg, #10b981, #047857); }
.stat-icon-info { background: linear-gradient(135deg, #06b6d4, #0891b2); }
.stat-icon-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }

.stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
}

.stat-footer {
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.trend-up { color: #059669; }
.trend-neutral { color: var(--text-secondary); }
.trend-info { color: #0891b2; }
.trend-warning { color: #d97706; }

/* Analytics Cards */
.analytics-card,
.activity-card,
.quick-actions-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    border: 1px solid var(--border-color);
}

.card-header-modern {
    padding: 1.5rem 2rem 1rem;
    border-bottom: 1px solid var(--border-color);
}

.card-body-modern {
    padding: 1.5rem 2rem 2rem;
}

.chart-icon,
.activity-icon,
.action-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.chart-container {
    position: relative;
    height: 300px;
}

.chart-legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

/* Activity Timeline */
.empty-state .empty-icon {
    width: 80px;
    height: 80px;
    background: rgba(107, 114, 128, 0.1);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--text-secondary);
}

.activity-timeline {
    max-height: 400px;
    overflow-y: auto;
}

.timeline-item {
    display: flex;
    align-items: start;
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

.timeline-marker-primary { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.timeline-marker-success { background: linear-gradient(135deg, #10b981, #047857); }
.timeline-marker-info { background: linear-gradient(135deg, #06b6d4, #0891b2); }
.timeline-marker-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }

.timeline-title {
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.timeline-time {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

/* Quick Actions */
.quick-actions-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.quick-action-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    border: 1px solid rgba(59, 130, 246, 0.1);
}

.quick-action-item:hover {
    background: rgba(59, 130, 246, 0.1);
    transform: translateY(-2px);
    color: inherit;
    text-decoration: none;
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
}

.quick-action-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.quick-action-subtitle {
    color: var(--text-secondary);
}

.quick-action-arrow {
    margin-left: auto;
    color: var(--text-secondary);
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
    background: rgba(59, 130, 246, 0.05);
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
    color: var(--text-secondary);
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 1.75rem;
    }
    
    .dashboard-subtitle {
        font-size: 1rem;
    }
    
    .stat-card-body {
        padding: 1.5rem;
    }
    
    .card-header-modern,
    .card-body-modern {
        padding: 1rem;
    }
    
    .summary-grid {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
}
</style>

</div> <!-- End page-container -->