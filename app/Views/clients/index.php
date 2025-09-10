<div class="global-main-container">
    <!-- Enhanced Page Header -->
    <div class="global-page-header">
        <div class="global-header-content">
            <div class="global-header-left">
                <h2><i class="fas fa-users me-2"></i>Gestão de Clientes</h2>
                <p>Gerencie e monitore todos os clientes registados no sistema automotivo</p>
            </div>
            <div class="global-header-actions">
                <div class="global-stats-card">
                    <div class="global-stats-icon"><i class="fas fa-users"></i></div>
                    <div class="global-stats-content">
                        <div class="global-stats-number"><?= count($clients ?? []) ?></div>
                        <div class="global-stats-label">Cliente<?= count($clients ?? []) !== 1 ? 's' : '' ?></div>
                    </div>
                </div>
                <div class="global-quick-actions">
                    <div class="global-action-group">
                        <a href="<?= url('/clients/create') ?>" class="global-btn-add-primary">
                            <div class="global-btn-icon"><i class="fas fa-plus"></i></div>
                            <div class="global-btn-content">
                                <div class="global-btn-title">Novo Cliente</div>
                                <div class="global-btn-subtitle">Registar novo cliente</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Search Section -->
    <div class="global-search-section">
        <div class="global-search-header">
            <h5 class="global-search-title">
                <i class="fas fa-filter me-2"></i>Filtros de Pesquisa
            </h5>
            <p class="global-search-subtitle">Use os filtros abaixo para encontrar clientes específicos</p>
        </div>
        
        <form method="GET" action="<?= url('/clients') ?>" class="global-search-form">
            <div class="global-search-row">
                <div class="global-form-group">
                    <label for="search" class="global-form-label">
                        <i class="fas fa-search me-1"></i>Pesquisar
                    </label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           class="global-form-control" 
                           placeholder="Nome, email ou contacto..."
                           value="<?= e($_GET['search'] ?? '') ?>">
                </div>
                <div class="global-form-group">
                    <label for="status" class="global-form-label">
                        <i class="fas fa-toggle-on me-1"></i>Estado
                    </label>
                    <select id="status" name="status" class="global-form-control">
                        <option value="">Todos os estados</option>
                        <option value="active" <?= ($_GET['status'] ?? '') === 'active' ? 'selected' : '' ?>>Ativos</option>
                        <option value="inactive" <?= ($_GET['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inativos</option>
                        <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pendentes</option>
                    </select>
                    </div>
                </div>
                <div class="global-form-group">
                    <label for="sort" class="global-form-label">
                        <i class="fas fa-sort me-1"></i>Ordenar por
                    </label>
                    <select id="sort" name="sort" class="global-form-control">
                        <option value="name" <?= ($_GET['sort'] ?? '') === 'name' ? 'selected' : '' ?>>Nome</option>
                        <option value="created" <?= ($_GET['sort'] ?? '') === 'created' ? 'selected' : '' ?>>Data de Registo</option>
                        <option value="updated" <?= ($_GET['sort'] ?? '') === 'updated' ? 'selected' : '' ?>>Última Atualização</option>
                    </select>
                </div>
            </div>
            
            <div class="global-search-actions">
                <div class="global-search-actions-main">
                    <button type="submit" class="global-btn-search">
                        <i class="fas fa-search me-1"></i>Pesquisar
                    </button>
                </div>
                <div class="global-clear-filter-container <?= (!empty($_GET['search']) || !empty($_GET['status'])) ? 'active' : 'inactive' ?>">
                    <a href="<?= url('/clients') ?>" class="global-btn-clear-filters">
                        <i class="fas fa-times"></i>
                        <span>Limpar Filtros</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Enhanced Data Table -->
    <div class="global-data-table-container">
        <div class="global-table-header">
            <h5 class="global-table-title">
                <i class="fas fa-table me-2"></i>Lista de Clientes
            </h5>
        </div>
        <div class="global-table-responsive">
            <table class="global-table" id="clientsTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-user me-1"></i>Nome</th>
                        <th><i class="fas fa-envelope me-1"></i>Email</th>
                        <th class="d-none d-md-table-cell"><i class="fas fa-phone me-1"></i>Contacto</th>
                        <th><i class="fas fa-circle me-1"></i>Estado</th>
                        <th class="d-none d-lg-table-cell"><i class="fas fa-calendar me-1"></i>Registado</th>
                        <th>Ações</th>
                    </tr>
                            <th width="120" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($clients)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 3rem;">
                                    <div style="color: var(--text-muted);">
                                        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                        <h6>Nenhum cliente encontrado</h6>
                                        <p>Comece adicionando o primeiro cliente ao sistema</p>
                                        <a href="<?= url('/clients/create') ?>" class="global-btn-add-primary" style="margin-top: 1rem; display: inline-flex;">
                                            <div class="global-btn-icon"><i class="fas fa-plus"></i></div>
                                            <div class="global-btn-content">
                                                <div class="global-btn-title">Adicionar Cliente</div>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: var(--text-primary);">
                                            <?= e($client['name'] ?? 'N/A') ?>
                                        </div>
                                        <small style="color: var(--text-muted);">ID: <?= $client['id'] ?></small>
                                    </td>
                                    <td><?= e($client['email'] ?? 'N/A') ?></td>
                                    <td class="d-none d-md-table-cell"><?= e($client['phone'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="global-status-badge <?= strtolower($client['status'] ?? 'inactive') ?>">
                                            <i class="fas fa-circle me-1"></i>
                                            <?= ucfirst($client['status'] ?? 'Inativo') ?>
                                        </span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <?= date('d/m/Y', strtotime($client['createdAt'] ?? 'now')) ?>
                                    </td>
                                    <td>
                                        <div class="global-action-buttons-container">
                                            <div class="global-action-buttons-group">
                                                <a href="<?= url('/clients/' . $client['id']) ?>" class="global-btn-action-table">
                                                    <i class="fas fa-eye"></i>
                                                    <span class="btn-text">Ver</span>
                                                </a>
                                                <a href="<?= url('/clients/' . $client['id'] . '/edit') ?>" class="global-btn-action-table">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="btn-text">Editar</span>
                                                </a>
                                                <button type="button" class="global-btn-action-table" onclick="confirmDelete(<?= $client['id'] ?>)">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="btn-text">Remover</span>
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
    </div>

</div> <!-- End global-main-container -->

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