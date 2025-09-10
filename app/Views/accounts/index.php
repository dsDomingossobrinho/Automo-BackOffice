<?php
/**
 * Administradores - Interface Limpa e Profissional
 */
?>

<style>
.main-container {
    background: #f5f6fa;
    min-height: 100vh;
    padding: 0.75rem;
}

@media (min-width: 768px) {
    .main-container {
        padding: 1.5rem;
    }
}

@media (min-width: 1200px) {
    .main-container {
        padding: 2rem;
    }
}

.page-header {
    background: linear-gradient(135deg, #4285f4, #1e88e5);
    color: white;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(66, 133, 244, 0.2);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

@media (min-width: 768px) {
    .page-header {
        padding: 1.75rem 2.25rem;
        flex-wrap: nowrap;
        margin-bottom: 2rem;
    }
}

.page-header h1 {
    font-size: 1.4rem;
    margin: 0;
    font-weight: 700;
    letter-spacing: -0.5px;
}

@media (min-width: 768px) {
    .page-header h1 {
        font-size: 1.875rem;
    }
}

.search-section {
    background: white;
    border-radius: 16px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    border: 1px solid #e8eaed;
}

@media (min-width: 768px) {
    .search-section {
        padding: 1.75rem 2.25rem;
        margin-bottom: 2rem;
    }
}

.search-section .form-control,
.search-section .form-select {
    border: 2px solid #e8eaed;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 0.925rem;
    transition: all 0.3s ease;
}

.search-section .form-control:focus,
.search-section .form-select:focus {
    border-color: #4285f4;
    box-shadow: 0 0 0 0.2rem rgba(66, 133, 244, 0.15);
}

.table-container {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    overflow-x: auto;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    border: 1px solid #e8eaed;
}

.table {
    min-width: 800px;
    margin-bottom: 0;
}

@media (max-width: 767px) {
    .table {
        font-size: 0.875rem;
    }
    
    .table thead th,
    .table tbody td {
        padding: 1rem 0.75rem;
    }
    
    .btn-action {
        padding: 0.375rem 0.625rem;
        font-size: 0.8rem;
        margin: 0 1px;
    }
}

.table thead th {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border: none;
    padding: 1.25rem 1.5rem;
    font-weight: 700;
    color: #495057;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    border-top: 1px solid #f1f3f4;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background: linear-gradient(135deg, #f8f9ff, #f0f4ff);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background: #f1f3f4;
    border: none;
    padding: 1rem;
    font-weight: 600;
    color: #333;
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid #e9ecef;
}

.table tbody tr:hover {
    background: #f8f9fa;
}

.btn-action {
    border-radius: 10px;
    margin: 0 3px;
    padding: 0.5rem 0.75rem;
    font-size: 0.825rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid transparent;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-action.btn-info {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
}

.btn-action.btn-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
    color: #212529;
}

.btn-action.btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

@media (max-width: 767px) {
    .btn-action {
        padding: 0.375rem 0.625rem;
        font-size: 0.75rem;
        margin: 0 1px;
    }
}

.avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4285f4, #1e88e5);
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin-right: 0.875rem;
    font-size: 0.9rem;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(66, 133, 244, 0.3);
    border: 2px solid white;
}

@media (min-width: 768px) {
    .avatar {
        width: 48px;
        height: 48px;
        margin-right: 1.125rem;
        font-size: 1.1rem;
    }
}

.status-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 25px;
    font-size: 0.775rem;
    font-weight: 600;
    display: inline-block;
    text-align: center;
    min-width: 70px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid transparent;
}

.status-badge.bg-success {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
    color: white;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

.status-badge.bg-secondary {
    background: linear-gradient(135deg, #6c757d, #495057) !important;
    color: white;
    box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
}

@media (min-width: 768px) {
    .status-badge {
        padding: 0.5rem 1.125rem;
        font-size: 0.825rem;
        min-width: 85px;
    }
}

.card-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    z-index: 1050;
    display: none;
    overflow-y: auto;
    padding: 1rem;
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.action-card {
    position: relative;
    margin: 2rem auto;
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 650px;
    transform: none;
    animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #e8eaed;
}

@media (min-width: 768px) {
    .action-card {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin: 0;
        width: 90%;
        max-width: 700px;
        max-height: 85vh;
        overflow-y: auto;
    }
    
    .card-overlay {
        padding: 0;
        overflow: hidden;
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@media (min-width: 768px) {
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translate(-50%, -40px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
    }
}

.card-header {
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid #e8eaed;
    border-radius: 20px 20px 0 0;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.card-header h4 {
    font-weight: 700;
    font-size: 1.1rem;
    margin: 0;
    color: #495057;
}

.card-body {
    padding: 1.75rem;
    background: #fafbfc;
}

.card-footer {
    padding: 1.25rem 1.75rem;
    border-top: 1px solid #e8eaed;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 0 0 20px 20px;
}

@media (min-width: 768px) {
    .card-header {
        padding: 1.75rem 2.25rem;
    }
    
    .card-header h4 {
        font-size: 1.25rem;
    }
    
    .card-body {
        padding: 2.25rem;
    }
    
    .card-footer {
        padding: 1.75rem 2.25rem;
    }
}

.card-body .form-control,
.card-body .form-select {
    border: 2px solid #e8eaed;
    border-radius: 12px;
    padding: 0.875rem 1.125rem;
    font-size: 0.925rem;
    transition: all 0.3s ease;
    background: white;
}

.card-body .form-control:focus,
.card-body .form-select:focus {
    border-color: #4285f4;
    box-shadow: 0 0 0 0.25rem rgba(66, 133, 244, 0.15);
    transform: translateY(-1px);
}

.card-body .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.625rem;
    font-size: 0.9rem;
}

.card-body .form-text {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.375rem;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #4285f4, #1e88e5);
    border: none;
    color: white;
    padding: 0.75rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.925rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(66, 133, 244, 0.3);
}

.btn-secondary-custom {
    background: linear-gradient(135deg, #6c757d, #495057);
    border: none;
    color: white;
    padding: 0.75rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.925rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
}

@media (min-width: 768px) {
    .btn-primary-custom,
    .btn-secondary-custom {
        padding: 0.875rem 2.125rem;
        font-size: 1rem;
    }
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, #1976d2, #1565c0);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(66, 133, 244, 0.4);
}

.btn-secondary-custom:hover {
    background: linear-gradient(135deg, #495057, #343a40);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(108, 117, 125, 0.4);
}

.btn-primary-custom:focus,
.btn-secondary-custom:focus {
    box-shadow: 0 0 0 0.25rem rgba(66, 133, 244, 0.25);
    transform: translateY(-1px);
}

.btn-primary-custom:active,
.btn-secondary-custom:active {
    transform: translateY(0);
    box-shadow: 0 1px 4px rgba(0,0,0,0.2);
}

.search-input {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.8rem 1rem;
    font-size: 1rem;
}

.search-input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Administradores</h2>
                <p class="text-muted mb-0">Gerencie os administradores do sistema</p>
            </div>
            <button class="btn btn-primary-custom" onclick="openCreateCard()">
                <i class="fas fa-plus me-2"></i>Adicionar Administrador
            </button>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <form method="GET" action="<?= url('/accounts') ?>" class="row align-items-end">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Pesquisar Administradores</label>
                <input type="text" 
                       name="search" 
                       class="form-control search-input" 
                       value="<?= e($search ?? '') ?>"
                       placeholder="Digite nome, email ou username...">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select search-input">
                    <option value="">Todos os Status</option>
                    <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>Ativos</option>
                    <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>Inativos</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-search me-1"></i>Buscar
                    </button>
                    <?php if (!empty($search) || !empty($status)): ?>
                        <a href="<?= url('/accounts') ?>" class="btn btn-secondary-custom">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <?php if (empty($accounts)): ?>
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-muted mb-3">Nenhum administrador encontrado</h4>
                <p class="text-muted mb-4">Não há administradores cadastrados ou que correspondam aos filtros.</p>
                <button class="btn btn-primary-custom" onclick="openCreateCard()">
                    <i class="fas fa-plus me-2"></i>Criar Primeiro Administrador
                </button>
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Administrador</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th width="120">Status</th>
                        <th width="150">Criado em</th>
                        <th width="160">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $index => $account): ?>
                        <tr>
                            <td class="text-muted fw-bold">
                                <?= (($pagination['current_page'] - 1) * ($pagination['size'] ?? 15)) + $index + 1 ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <?= strtoupper(substr($account['name'] ?? $account['email'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-semibold"><?= e($account['name'] ?? 'Sem nome') ?></div>
                                        <small class="text-muted">ID: <?= $account['id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><?= e($account['email']) ?></div>
                            </td>
                            <td>
                                <code class="bg-light px-2 py-1 rounded"><?= e($account['username'] ?? 'N/A') ?></code>
                            </td>
                            <td>
                                <?php 
                                $isActive = ($account['state'] ?? '') === 'ACTIVE';
                                if ($isActive): ?>
                                    <span class="status-badge bg-success text-white">
                                        <i class="fas fa-check-circle me-1"></i>Ativo
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge bg-secondary text-white">
                                        <i class="fas fa-pause-circle me-1"></i>Inativo
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($account['createdAt'])): ?>
                                    <div class="small"><?= formatDate($account['createdAt'], 'd/m/Y') ?></div>
                                    <div class="text-muted small"><?= formatDate($account['createdAt'], 'H:i') ?></div>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary btn-action" 
                                            onclick="viewAdmin(<?= $account['id'] ?>)" 
                                            title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning btn-action" 
                                            onclick="editAdmin(<?= $account['id'] ?>)" 
                                            title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-action" 
                                            onclick="deleteAdmin(<?= $account['id'] ?>, '<?= e($account['name'] ?? $account['email']) ?>')" 
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if (($pagination['total_pages'] ?? 1) > 1): ?>
                <div class="p-3 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Mostrando <?= (($pagination['current_page'] - 1) * ($pagination['size'] ?? 15)) + 1 ?> a 
                            <?= min($pagination['current_page'] * ($pagination['size'] ?? 15), $pagination['total_elements'] ?? 0) ?> 
                            de <?= number_format($pagination['total_elements'] ?? 0) ?> registros
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <?php if ($pagination['current_page'] > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= url('/accounts') ?>?page=<?= $pagination['current_page'] - 1 ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?><?= !empty($status) ? '&status='.$status : '' ?>">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php 
                                $start = max(1, $pagination['current_page'] - 2);
                                $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
                                
                                for ($i = $start; $i <= $end; $i++): ?>
                                    <li class="page-item <?= $i === $pagination['current_page'] ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= url('/accounts') ?>?page=<?= $i ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?><?= !empty($status) ? '&status='.$status : '' ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= url('/accounts') ?>?page=<?= $pagination['current_page'] + 1 ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?><?= !empty($status) ? '&status='.$status : '' ?>">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Card Overlay -->
<div class="card-overlay" id="cardOverlay" onclick="closeCard()">
    <div class="action-card" onclick="event.stopPropagation()">
        <div id="cardContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<script>
// Global variables
let currentAdminId = null;

// Open create card
function openCreateCard() {
    const content = `
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-plus text-primary me-2"></i>Criar Administrador</h4>
        </div>
        <div class="card-body">
            <form id="createForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nome Completo *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email *</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Senha *</label>
                        <input type="password" class="form-control" name="password" minlength="8" required>
                        <div class="form-text">Mínimo 8 caracteres</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contacto *</label>
                        <input type="tel" class="form-control" name="contact" placeholder="+244 9xx xxx xxx" pattern="\+?[0-9\s\-\(\)]+" required>
                        <div class="form-text">Ex: +244 923 456 789</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tipo de Conta *</label>
                        <select class="form-select" name="accountTypeId" required>
                            <option value="">Selecione o tipo</option>
                            <option value="1">ADMIN - Back Office</option>
                            <option value="2">USER - Corporate</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Estado</label>
                        <select class="form-select" name="stateId">
                            <option value="1" selected>ACTIVE - Ativo</option>
                            <option value="2">INACTIVE - Inativo</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <button class="btn btn-secondary-custom" onclick="closeCard()">Cancelar</button>
            <button class="btn btn-primary-custom" onclick="submitCreate()">
                <i class="fas fa-save me-2"></i>Criar Administrador
            </button>
        </div>
    `;
    
    document.getElementById('cardContent').innerHTML = content;
    document.getElementById('cardOverlay').style.display = 'block';
}

// View admin card
async function viewAdmin(id) {
    console.log('Loading admin view for ID:', id);
    
    if (!id) {
        showAlert('ID do administrador é obrigatório', 'danger');
        return;
    }
    
    const content = `
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-eye text-info me-2"></i>Visualizar Administrador</h4>
        </div>
        <div class="card-body text-center">
            <div class="spinner-border text-primary mb-3"></div>
            <p>Carregando informações...</p>
        </div>
    `;
    
    document.getElementById('cardContent').innerHTML = content;
    document.getElementById('cardOverlay').style.display = 'block';
    
    try {
        const response = await fetch(`<?= url('/accounts') ?>/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        
        console.log('View response status:', response.status);
        
        if (response.ok) {
            let result;
            try {
                result = await response.json();
                console.log('View response data:', result);
            } catch (jsonError) {
                console.error('JSON parse error:', jsonError);
                showAlert('Resposta inválida do servidor', 'danger');
                return;
            }
            
            const admin = result.data || result;
            
            if (!admin || !admin.id) {
                showAlert('Dados do administrador não encontrados', 'danger');
                return;
            }
            
            const viewContent = `
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-eye text-info me-2"></i>Visualizar Administrador</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avatar mb-3" style="width: 80px; height: 80px; font-size: 24px;">
                                ${(admin.name || admin.email || 'N').charAt(0).toUpperCase()}
                            </div>
                            <h5>${admin.name || 'Sem nome'}</h5>
                            <span class="status-badge bg-${admin.stateId === 1 ? 'success' : 'secondary'} text-white">
                                ${admin.stateId === 1 ? 'Ativo' : 'Inativo'}
                            </span>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr><td><strong>ID:</strong></td><td>${admin.id}</td></tr>
                                <tr><td><strong>Nome:</strong></td><td>${admin.name || '-'}</td></tr>
                                <tr><td><strong>Email:</strong></td><td>${admin.email}</td></tr>
                                <tr><td><strong>Username:</strong></td><td><code>${admin.username || 'N/A'}</code></td></tr>
                                <tr><td><strong>Contacto:</strong></td><td>${admin.contact || '-'}</td></tr>
                                <tr><td><strong>Auth ID:</strong></td><td>${admin.authId || '-'}</td></tr>
                                <tr><td><strong>Estado:</strong></td><td><span class="badge bg-${admin.stateId === 1 ? 'success' : 'secondary'}">${admin.state || (admin.stateId === 1 ? 'ATIVO' : 'INATIVO')}</span></td></tr>
                                <tr><td><strong>Criado:</strong></td><td>${admin.createdAt ? new Date(admin.createdAt).toLocaleString('pt-BR') : '-'}</td></tr>
                                <tr><td><strong>Atualizado:</strong></td><td>${admin.updatedAt ? new Date(admin.updatedAt).toLocaleString('pt-BR') : '-'}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-secondary-custom" onclick="closeCard()">Fechar</button>
                </div>
            `;
            
            document.getElementById('cardContent').innerHTML = viewContent;
        } else {
            showAlert('Erro ao carregar administrador: ' + response.status, 'danger');
            closeCard();
        }
    } catch (error) {
        console.error('View error:', error);
        showAlert('Erro ao carregar dados: ' + error.message, 'danger');
        closeCard();
    }
}

// Edit admin card
async function editAdmin(id) {
    console.log('Loading admin edit for ID:', id);
    
    if (!id) {
        showAlert('ID do administrador é obrigatório', 'danger');
        return;
    }
    
    currentAdminId = id;
    
    const content = `
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-edit text-warning me-2"></i>Editar Administrador</h4>
        </div>
        <div class="card-body text-center">
            <div class="spinner-border text-primary mb-3"></div>
            <p>Carregando informações...</p>
        </div>
    `;
    
    document.getElementById('cardContent').innerHTML = content;
    document.getElementById('cardOverlay').style.display = 'block';
    
    try {
        const response = await fetch(`<?= url('/accounts') ?>/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        
        console.log('Edit load response status:', response.status);
        
        if (response.ok) {
            let result;
            try {
                result = await response.json();
                console.log('Edit load response data:', result);
            } catch (jsonError) {
                console.error('JSON parse error:', jsonError);
                showAlert('Resposta inválida do servidor', 'danger');
                return;
            }
            
            const admin = result.data || result;
            
            if (!admin || !admin.id) {
                showAlert('Dados do administrador não encontrados', 'danger');
                closeCard();
                return;
            }
            
            const editContent = `
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-edit text-warning me-2"></i>Editar Administrador</h4>
                </div>
                <div class="card-body">
                    <form id="editForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nome Completo *</label>
                                <input type="text" class="form-control" name="name" value="${admin.name || ''}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email *</label>
                                <input type="email" class="form-control" name="email" value="${admin.email || ''}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Contacto</label>
                                <input type="tel" class="form-control" name="contact" value="${admin.contact || ''}" placeholder="+244 9xx xxx xxx" pattern="\+?[0-9\s\-\(\)]+">
                                <div class="form-text">Ex: +244 923 456 789</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nova Senha</label>
                                <input type="password" class="form-control" name="password" minlength="8">
                                <div class="form-text">Deixe em branco para não alterar</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tipo de Conta</label>
                                <select class="form-select" name="accountTypeId">
                                    <option value="1">ADMIN - Back Office</option>
                                    <option value="2">USER - Corporate</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Estado</label>
                                <select class="form-select" name="stateId">
                                    <option value="1">ACTIVE - Ativo</option>
                                    <option value="2">INACTIVE - Inativo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <button class="btn btn-secondary-custom" onclick="closeCard()">Cancelar</button>
                    <button class="btn btn-primary-custom" onclick="submitEdit()">
                        <i class="fas fa-save me-2"></i>Salvar Alterações
                    </button>
                </div>
            `;
            
            document.getElementById('cardContent').innerHTML = editContent;
            
            // Set current values
            const accountTypeSelect = document.querySelector('select[name="accountTypeId"]');
            const stateSelect = document.querySelector('select[name="stateId"]');
            
            if (accountTypeSelect) {
                accountTypeSelect.value = admin.accountTypeId || 1;
            }
            if (stateSelect) {
                stateSelect.value = admin.stateId || 1;
            }
        } else {
            showAlert('Erro ao carregar administrador: ' + response.status, 'danger');
            closeCard();
        }
    } catch (error) {
        console.error('Edit load error:', error);
        showAlert('Erro ao carregar dados: ' + error.message, 'danger');
        closeCard();
    }
}

// Delete admin card
function deleteAdmin(id, name) {
    currentAdminId = id;
    
    const content = `
        <div class="card-header">
            <h4 class="mb-0 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminação</h4>
        </div>
        <div class="card-body text-center">
            <div class="mb-4">
                <i class="fas fa-user-times text-danger" style="font-size: 3rem;"></i>
            </div>
            <h5 class="mb-3">Eliminar Administrador?</h5>
            <p class="text-muted">Tem certeza que deseja eliminar <strong>${name}</strong>?</p>
            <div class="alert alert-danger">
                <i class="fas fa-info-circle me-2"></i>
                Esta ação não pode ser desfeita.
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center gap-3">
            <button class="btn btn-secondary-custom" onclick="closeCard()">Cancelar</button>
            <button class="btn btn-danger" onclick="confirmDelete()" style="padding: 0.8rem 2rem; border-radius: 8px; font-weight: 500;">
                <i class="fas fa-trash me-2"></i>Eliminar
            </button>
        </div>
    `;
    
    document.getElementById('cardContent').innerHTML = content;
    document.getElementById('cardOverlay').style.display = 'block';
}

// Submit functions
async function submitCreate() {
    const form = document.getElementById('createForm');
    if (!form) {
        showAlert('Formulário não encontrado', 'danger');
        return;
    }
    
    const formData = new FormData(form);
    
    // Convert FormData to JSON object
    const data = Object.fromEntries(formData.entries());
    
    // Validate required fields
    const requiredFields = ['name', 'email', 'password', 'contact', 'accountTypeId'];
    for (const field of requiredFields) {
        if (!data[field] || data[field].trim() === '') {
            showAlert(`Campo ${field} é obrigatório`, 'danger');
            return;
        }
    }
    
    console.log('Sending create data:', data);
    
    try {
        const response = await fetch('<?= url('/accounts') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= $_SESSION[CSRF_TOKEN_NAME] ?? '' ?>'
            },
            body: JSON.stringify(data)
        });
        
        console.log('Create response status:', response.status);
        
        let result;
        try {
            result = await response.json();
            console.log('Create response data:', result);
        } catch (jsonError) {
            console.error('JSON parse error:', jsonError);
            showAlert('Resposta inválida do servidor', 'danger');
            return;
        }
        
        if (response.ok && (result.success || result.data)) {
            showAlert('Administrador criado com sucesso!', 'success');
            closeCard();
            setTimeout(() => window.location.reload(), 1500);
        } else {
            const message = result.message || result.error || 'Erro ao criar administrador';
            showAlert(message, 'danger');
        }
    } catch (error) {
        console.error('Create error:', error);
        showAlert('Erro de conexão: ' + error.message, 'danger');
    }
}

async function submitEdit() {
    const form = document.getElementById('editForm');
    if (!form) {
        showAlert('Formulário não encontrado', 'danger');
        return;
    }
    
    if (!currentAdminId) {
        showAlert('ID do administrador não encontrado', 'danger');
        return;
    }
    
    const formData = new FormData(form);
    
    // Convert FormData to JSON object
    const data = Object.fromEntries(formData.entries());
    
    // Validate required fields (password is optional for edit)
    const requiredFields = ['name', 'email'];
    for (const field of requiredFields) {
        if (!data[field] || data[field].trim() === '') {
            showAlert(`Campo ${field} é obrigatório`, 'danger');
            return;
        }
    }
    
    // Remove empty password to avoid updating it
    if (!data.password || data.password.trim() === '') {
        delete data.password;
    }
    
    console.log('Sending edit data:', data, 'for ID:', currentAdminId);
    
    try {
        const response = await fetch(`<?= url('/accounts') ?>/${currentAdminId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= $_SESSION[CSRF_TOKEN_NAME] ?? '' ?>'
            },
            body: JSON.stringify(data)
        });
        
        console.log('Edit response status:', response.status);
        
        let result;
        try {
            result = await response.json();
            console.log('Edit response data:', result);
        } catch (jsonError) {
            console.error('JSON parse error:', jsonError);
            showAlert('Resposta inválida do servidor', 'danger');
            return;
        }
        
        if (response.ok && (result.success || result.data)) {
            showAlert('Administrador atualizado com sucesso!', 'success');
            closeCard();
            setTimeout(() => window.location.reload(), 1500);
        } else {
            const message = result.message || result.error || 'Erro ao atualizar administrador';
            showAlert(message, 'danger');
        }
    } catch (error) {
        console.error('Edit error:', error);
        showAlert('Erro de conexão: ' + error.message, 'danger');
    }
}

async function confirmDelete() {
    console.log('Confirming delete for ID:', currentAdminId);
    
    if (!currentAdminId) {
        showAlert('ID do administrador não encontrado', 'danger');
        closeCard();
        return;
    }
    
    try {
        const response = await fetch(`<?= url('/accounts') ?>/${currentAdminId}`, {
            method: 'DELETE',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= $_SESSION[CSRF_TOKEN_NAME] ?? '' ?>'
            }
        });
        
        console.log('Delete response status:', response.status);
        
        closeCard();
        
        if (response.ok) {
            let result;
            try {
                result = await response.json();
                console.log('Delete response data:', result);
            } catch (jsonError) {
                // Delete might not return JSON, that's OK
                console.log('Delete completed without JSON response');
            }
            
            showAlert('Administrador eliminado com sucesso!', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            let errorMessage = 'Erro ao eliminar administrador';
            try {
                const errorResult = await response.json();
                errorMessage = errorResult.message || errorResult.error || errorMessage;
            } catch (jsonError) {
                errorMessage += ' (Status: ' + response.status + ')';
            }
            showAlert(errorMessage, 'danger');
        }
    } catch (error) {
        console.error('Delete error:', error);
        showAlert('Erro de conexão: ' + error.message, 'danger');
        closeCard();
    }
}

// Utility functions
function closeCard() {
    document.getElementById('cardOverlay').style.display = 'none';
    currentAdminId = null;
}

function showAlert(message, type) {
    console.log('Showing alert:', message, 'Type:', type);
    
    // Remove any existing alerts first
    const existingAlerts = document.querySelectorAll('.alert.position-fixed');
    existingAlerts.forEach(alert => alert.remove());
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 320px; max-width: 500px; box-shadow: 0 4px 16px rgba(0,0,0,0.15);';
    alert.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
            <div class="flex-grow-1">${message}</div>
            <button type="button" class="btn-close ms-2" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    document.body.appendChild(alert);
    
    // Auto-remove after 6 seconds
    setTimeout(() => {
        if (alert && alert.parentElement) {
            alert.remove();
        }
    }, 6000);
    
    return alert;
}

// Real-time search and UI enhancements
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => this.form.submit(), 600);
        });
    }
    
    // Add loading state to buttons
    document.addEventListener('click', function(e) {
        if (e.target.matches('.btn-primary-custom, .btn-secondary-custom')) {
            const btn = e.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processando...';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 2000);
        }
    });
    
    // Enhance card overlay close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCard();
        }
    });
});
</script>