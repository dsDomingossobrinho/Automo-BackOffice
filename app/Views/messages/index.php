<?php
/**
 * Messages Management - Index View
 */
?>

<div class="page-header-section mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-envelope me-3 text-primary"></i>
                Mensagens Enviadas
            </h1>
            <p class="page-subtitle text-muted">Gerencie todas as mensagens enviadas aos clientes</p>
        </div>
        <div>
            <a href="<?= url('/messages/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Nova Mensagem
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card modern-stat-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($stats['total'] ?? 0) ?></h3>
                <p>Total de Mensagens</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card modern-stat-card">
            <div class="stat-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($stats['sent'] ?? 0) ?></h3>
                <p>Enviadas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card modern-stat-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($stats['pending'] ?? 0) ?></h3>
                <p>Pendentes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card modern-stat-card">
            <div class="stat-icon bg-danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($stats['failed'] ?? 0) ?></h3>
                <p>Falharam</p>
            </div>
        </div>
    </div>
</div>

<!-- Messages Table -->
<div class="card modern-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            Lista de Mensagens
        </h5>
    </div>
    <div class="card-body p-0">
        <?php if (empty($messages)): ?>
            <div class="empty-state text-center py-5">
                <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                <h5>Nenhuma mensagem encontrada</h5>
                <p class="text-muted">Não há mensagens enviadas ou que correspondam aos filtros aplicados.</p>
                <a href="<?= url('/messages/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Enviar Nova Mensagem
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover modern-table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Assunto</th>
                            <th>Status</th>
                            <th>Data de Envio</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar-sm me-3">
                                            <?= strtoupper(substr($message['client_name'] ?? 'C', 0, 1)) ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?= e($message['client_name'] ?? 'Cliente') ?></h6>
                                            <small class="text-muted"><?= e($message['client_contact'] ?? '') ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= strtoupper($message['type'] ?? 'SMS') ?></span>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                        <?= e($message['subject'] ?? $message['content'] ?? 'Sem assunto') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $status = $message['status'] ?? 'pending';
                                    $statusClasses = [
                                        'sent' => 'bg-success',
                                        'pending' => 'bg-warning',
                                        'failed' => 'bg-danger',
                                        'scheduled' => 'bg-info'
                                    ];
                                    $statusLabels = [
                                        'sent' => 'Enviada',
                                        'pending' => 'Pendente',
                                        'failed' => 'Falhada',
                                        'scheduled' => 'Agendada'
                                    ];
                                    ?>
                                    <span class="badge <?= $statusClasses[$status] ?? 'bg-secondary' ?>">
                                        <?= $statusLabels[$status] ?? 'Desconhecido' ?>
                                    </span>
                                </td>
                                <td>
                                    <?= formatDate($message['created_at'] ?? '') ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= url("/messages/{$message['id']}") ?>" 
                                           class="btn btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" 
                                                onclick="confirmDelete(<?= $message['id'] ?>, 'mensagem')"
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
        <?php endif; ?>
    </div>
</div>