<!-- Modern Clients Management Page -->
<div class="page-header-section mb-4">
    <div class="d-flex align-items-center justify-content-between">
        <div class="page-title-group">
            <h1 class="page-title">
                <i class="fas fa-users me-3 text-primary"></i>
                Clientes Registados
            </h1>
            <p class="page-subtitle text-muted">Gerencie todos os clientes registados no sistema</p>
        </div>
        <div class="page-actions">
            <button class="btn btn-outline-secondary me-2" data-bs-toggle="tooltip" title="Exportar dados">
                <i class="fas fa-download me-2"></i>Exportar
            </button>
            <a href="<?= url('/clients/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Cliente
            </a>
        </div>
    </div>
</div>

<!-- Search and Filters Section -->
<div class="search-filters-card mb-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="search-group">
                        <label for="searchInput" class="form-label small fw-semibold">Pesquisar Clientes</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   id="searchInput" 
                                   class="form-control border-start-0 ps-0" 
                                   placeholder="Nome, email ou contacto..."
                                   value="<?= e($_GET['search'] ?? '') ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-group">
                        <label for="statusFilter" class="form-label small fw-semibold">Estado</label>
                        <select id="statusFilter" class="form-select">
                            <option value="">Todos os estados</option>
                            <option value="active" <?= ($_GET['status'] ?? '') === 'active' ? 'selected' : '' ?>>Ativos</option>
                            <option value="inactive" <?= ($_GET['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inativos</option>
                            <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pendentes</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-group">
                        <label for="sortFilter" class="form-label small fw-semibold">Ordenar por</label>
                        <select id="sortFilter" class="form-select">
                            <option value="name" <?= ($_GET['sort'] ?? '') === 'name' ? 'selected' : '' ?>>Nome</option>
                            <option value="created" <?= ($_GET['sort'] ?? '') === 'created' ? 'selected' : '' ?>>Data de Registo</option>
                            <option value="updated" <?= ($_GET['sort'] ?? '') === 'updated' ? 'selected' : '' ?>>Última Atualização</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-3 d-flex gap-2">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="applyFilters()">
                    <i class="fas fa-filter me-1"></i>Aplicar Filtros
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearFilters()">
                    <i class="fas fa-times me-1"></i>Limpar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Data Table Section -->
<div class="data-table-card">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0">Lista de Clientes</h5>
                    <span class="badge bg-light text-dark ms-2"><?= count($clients) ?> registos</span>
                </div>
                <div class="table-actions">
                    <button class="btn btn-outline-secondary btn-sm me-2" onclick="toggleSelectAll()">
                        <i class="fas fa-check-square me-1"></i>Selecionar Todos
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h me-1"></i>Ações
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('activate')">
                                <i class="fas fa-check-circle text-success me-2"></i>Ativar Selecionados
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('deactivate')">
                                <i class="fas fa-ban text-warning me-2"></i>Desativar Selecionados
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('delete')">
                                <i class="fas fa-trash text-danger me-2"></i>Remover Selecionados
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="clientsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="40">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th class="sortable" data-sort="name">
                                <i class="fas fa-user me-2 text-muted"></i>Nome
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            </th>
                            <th class="sortable" data-sort="email">
                                <i class="fas fa-envelope me-2 text-muted"></i>Email
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            </th>
                            <th class="sortable" data-sort="phone">
                                <i class="fas fa-phone me-2 text-muted"></i>Contacto
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            </th>
                            <th class="sortable" data-sort="status">
                                <i class="fas fa-circle me-2 text-muted"></i>Estado
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            </th>
                            <th class="sortable" data-sort="created">
                                <i class="fas fa-calendar me-2 text-muted"></i>Registado
                                <i class="fas fa-sort ms-1 text-muted"></i>
                            </th>
                            <th width="120" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($clients)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon mb-3">
                                            <i class="fas fa-users fa-3x text-muted"></i>
                                        </div>
                                        <h6 class="empty-title">Nenhum cliente encontrado</h6>
                                        <p class="empty-text text-muted">Comece adicionando o primeiro cliente ao sistema</p>
                                        <a href="<?= url('/clients/create') ?>" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-2"></i>Adicionar Cliente
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($clients as $client): ?>
                                <tr class="client-row" data-client-id="<?= $client['id'] ?>">
                                    <td>
                                        <input type="checkbox" class="form-check-input client-checkbox" value="<?= $client['id'] ?>">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="client-avatar me-3">
                                                <?= strtoupper(substr($client['name'] ?? 'C', 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="fw-semibold"><?= e($client['name'] ?? 'N/A') ?></div>
                                                <small class="text-muted">ID: <?= $client['id'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="email-cell">
                                            <?= e($client['email'] ?? 'N/A') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="phone-cell">
                                            <i class="fas fa-phone me-2 text-muted"></i>
                                            <?= e($client['phone'] ?? 'N/A') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($client['status'] ?? 'inactive') ?>">
                                            <i class="fas fa-circle me-1"></i>
                                            <?= ucfirst($client['status'] ?? 'Inativo') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="date-cell">
                                            <?= date('d/m/Y', strtotime($client['createdAt'] ?? 'now')) ?>
                                            <small class="d-block text-muted">
                                                <?= date('H:i', strtotime($client['createdAt'] ?? 'now')) ?>
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?= url('/clients/' . $client['id']) ?>" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Ver detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= url('/clients/' . $client['id'] . '/edit') ?>" 
                                                   class="btn btn-outline-secondary btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-sm" 
                                                        onclick="confirmDelete(<?= $client['id'] ?>)"
                                                        data-bs-toggle="tooltip" 
                                                        title="Remover">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <?php if (!empty($clients) && count($clients) > 0): ?>
        <div class="card-footer bg-white border-top">
            <div class="d-flex align-items-center justify-content-between">
                <div class="pagination-info">
                    <small class="text-muted">
                        Mostrando <strong><?= count($clients) ?></strong> de <strong><?= $total_clients ?? count($clients) ?></strong> registos
                    </small>
                </div>
                <nav aria-label="Paginação de clientes">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item <?= ($current_page ?? 1) <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= ($current_page ?? 1) - 1 ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= ($total_pages ?? 1); $i++): ?>
                            <li class="page-item <?= ($current_page ?? 1) === $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($current_page ?? 1) >= ($total_pages ?? 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= ($current_page ?? 1) + 1 ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="modal-icon me-3">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                    </div>
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Remoção</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="mb-1">Tem certeza que deseja remover este cliente?</p>
                <small class="text-muted">Esta ação não pode ser desfeita.</small>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Remover
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            applyFilters();
        }, 300);
    });
    
    // Sort functionality
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.dataset.sort;
            applySorting(sortBy);
        });
    });
    
    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.client-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
});

// Filter functions
function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const sort = document.getElementById('sortFilter').value;
    
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (status) params.append('status', status);
    if (sort) params.append('sort', sort);
    
    window.location.href = '<?= url('/clients') ?>?' + params.toString();
}

function clearFilters() {
    window.location.href = '<?= url('/clients') ?>';
}

function applySorting(sortBy) {
    const params = new URLSearchParams(window.location.search);
    params.set('sort', sortBy);
    window.location.href = '<?= url('/clients') ?>?' + params.toString();
}

// Selection functions
function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    selectAllCheckbox.click();
}

// Bulk actions
function bulkAction(action) {
    const selectedIds = getSelectedClientIds();
    
    if (selectedIds.length === 0) {
        alert('Selecione pelo menos um cliente.');
        return;
    }
    
    if (confirm(`Tem certeza que deseja ${action} ${selectedIds.length} cliente(s)?`)) {
        // Implement bulk action logic here
        console.log(`Bulk ${action} for clients:`, selectedIds);
    }
}

function getSelectedClientIds() {
    const checkboxes = document.querySelectorAll('.client-checkbox:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

// Delete functions
let clientToDelete = null;

function confirmDelete(clientId) {
    clientToDelete = clientId;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (clientToDelete) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `<?= url('/clients') ?>/${clientToDelete}`;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '<?= $csrf_token ?>';
        
        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
});
</script>

<style>
/* Modern CRUD Page Styles */
.page-header-section {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
    border-radius: 16px;
    padding: 2rem;
    border: 1px solid rgba(59, 130, 246, 0.1);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    margin-bottom: 0;
}

.search-filters-card .card {
    border-radius: 12px;
}

.search-group .input-group-text {
    background-color: #f8fafc;
    border-color: #e2e8f0;
}

.search-group .form-control {
    border-color: #e2e8f0;
}

.search-group .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
}

.data-table-card .card {
    border-radius: 12px;
}

.table th {
    font-weight: 600;
    color: #475569;
    background-color: #f8fafc !important;
    border-bottom: 2px solid #e2e8f0;
    padding: 1rem 0.75rem;
    font-size: 0.875rem;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-color: #f1f5f9;
}

.sortable {
    cursor: pointer;
    user-select: none;
    transition: color 0.2s ease;
}

.sortable:hover {
    color: #3b82f6;
}

.client-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
}

.status-active {
    background-color: rgba(16, 185, 129, 0.1);
    color: #047857;
}

.status-inactive {
    background-color: rgba(156, 163, 175, 0.2);
    color: #374151;
}

.status-pending {
    background-color: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.action-buttons .btn {
    border-radius: 8px;
    transition: all 0.2s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-1px);
}

.empty-state {
    padding: 3rem 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.pagination .page-link {
    border-radius: 8px;
    margin: 0 2px;
    border: 1px solid #e2e8f0;
    color: #475569;
}

.pagination .page-item.active .page-link {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.modal-icon {
    width: 48px;
    height: 48px;
    background: rgba(245, 158, 11, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header-section {
        padding: 1.5rem;
        text-align: center;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .page-actions {
        margin-top: 1rem;
    }
    
    .table-responsive {
        border-radius: 8px;
    }
    
    .action-buttons .btn-group {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
}
</style>