<!-- 1. TÍTULO DA PÁGINA - ISOLADO -->
<div class="page-title-section">
    <div class="page-title-container">
        <h1 class="main-page-title">
            <i class="fas fa-users page-icon"></i>
            Gestão de Clientes
        </h1>
    </div>
</div>

<!-- 2. BOTÃO ADICIONAR CLIENTE - PROEMINENTE -->
<div class="add-action-section">
    <div class="add-action-container">
        <button type="button" class="primary-add-button" onclick="openCreateCard()">
            <div class="add-button-icon">
                <i class="fas fa-plus"></i>
            </div>
            <div class="add-button-content">
                <span class="add-button-text">Adicionar Cliente</span>
                <small class="add-button-subtitle">Criar novo cliente no sistema</small>
            </div>
        </button>
    </div>
</div>

<!-- 3. ÁREA DE FILTROS -->
<div class="filters-section">
    <div class="filters-container">
        <form method="GET" action="<?= url('/clients') ?>" class="filters-form">
            <div class="filter-group">
                <div class="filter-field">
                    <input type="text" 
                           id="search" 
                           name="search" 
                           class="search-input" 
                           placeholder="Pesquisar clientes..."
                           value="<?= e($_GET['search'] ?? '') ?>">
                    <i class="fas fa-search search-icon"></i>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="filter-button search-button">
                        <i class="fas fa-search"></i>
                        Pesquisar
                    </button>
                    
                    <a href="<?= url('/clients') ?>" class="filter-button clear-button <?= (!empty($_GET['search']) || !empty($_GET['status'])) ? 'active' : '' ?>">
                        <i class="fas fa-times"></i>
                        Limpar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- 4. TABELA DE DADOS -->
<div class="data-table-section">
    <div class="data-table-container">
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i>Nome</th>
                        <th><i class="fas fa-envelope"></i>Email</th>
                        <th class="mobile-hidden"><i class="fas fa-phone"></i>Contacto</th>
                        <th><i class="fas fa-circle"></i>Estado</th>
                        <th class="mobile-hidden"><i class="fas fa-calendar"></i>Registado</th>
                        <th>Ações</th>
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
                                    <button type="button" class="primary-add-button" onclick="openCreateCard()" style="margin-top: 1rem;">
                                        <div class="add-button-icon"><i class="fas fa-plus"></i></div>
                                        <div class="add-button-content">
                                            <span class="add-button-text">Adicionar Cliente</span>
                                        </div>
                                    </button>
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
                                    <small style="color: var(--text-muted);">ID: <?= isset($client['id']) ? $client['id'] : 'N/A' ?></small>
                                </td>
                                <td><?= e($client['email'] ?? 'N/A') ?></td>
                                <td class="mobile-hidden"><?= e($client['phone'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="status-badge <?= strtolower($client['status'] ?? 'inactive') ?>">
                                        <i class="fas fa-circle"></i>
                                        <?= ucfirst($client['status'] ?? 'Inativo') ?>
                                    </span>
                                </td>
                                <td class="mobile-hidden">
                                    <?= date('d/m/Y', strtotime($client['createdAt'] ?? 'now')) ?>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button type="button" class="action-btn view-btn" onclick="openViewCard(<?= htmlspecialchars(json_encode($client)) ?>)">
                                            <i class="fas fa-eye"></i>
                                            <span>Ver</span>
                                        </button>
                                        <button type="button" class="action-btn edit-btn" onclick="openEditCard(<?= htmlspecialchars(json_encode($client)) ?>)">
                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>
                                        </button>
                                        <button type="button" class="action-btn delete-btn" onclick="openDeleteCard(<?= isset($client['id']) ? $client['id'] : 0 ?>, '<?= e($client['name'] ?? 'N/A') ?>')">
                                            <i class="fas fa-trash"></i>
                                            <span>Eliminar</span>
                                        </button>
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

<!-- MODAL CARDS -->

<!-- 1. CREATE CLIENT CARD -->
<div class="card-overlay" id="createCardOverlay" style="display: none;">
    <div class="modal-card create-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-user-plus"></i>
                Criar Novo Cliente
            </div>
            <button type="button" class="card-close" onclick="closeCard('createCardOverlay')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <form id="createClientForm" onsubmit="handleCreateSubmit(event)">
                <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="create_name">Nome Completo *</label>
                            <input type="text" id="create_name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="create_email">Email *</label>
                            <input type="email" id="create_email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="create_phone">Contacto</label>
                            <input type="tel" id="create_phone" name="phone">
                        </div>
                    </div>
                    
                    <div class="form-column">
                        <div class="form-group">
                            <label for="create_company">Empresa</label>
                            <input type="text" id="create_company" name="company">
                        </div>
                        
                        <div class="form-group">
                            <label for="create_address">Morada</label>
                            <textarea id="create_address" name="address" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="create_status">Estado</label>
                            <select id="create_status" name="status">
                                <option value="active">Ativo</option>
                                <option value="inactive">Inativo</option>
                                <option value="pending">Pendente</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-footer">
            <button type="button" class="footer-btn cancel-btn" onclick="closeCard('createCardOverlay')">
                <i class="fas fa-times"></i>
                Cancelar
            </button>
            <button type="submit" form="createClientForm" class="footer-btn submit-btn">
                <i class="fas fa-plus"></i>
                Criar Cliente
            </button>
        </div>
    </div>
</div>

<!-- 2. VIEW CLIENT CARD -->
<div class="card-overlay" id="viewCardOverlay" style="display: none;">
    <div class="modal-card view-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-eye"></i>
                Visualizar Cliente
            </div>
            <button type="button" class="card-close" onclick="closeCard('viewCardOverlay')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <h3 id="view_name">-</h3>
                    <p id="view_email">-</p>
                </div>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Contacto</div>
                    <div class="info-value" id="view_phone">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Empresa</div>
                    <div class="info-value" id="view_company">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Estado</div>
                    <div class="info-value">
                        <span class="status-badge" id="view_status">-</span>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Data de Registo</div>
                    <div class="info-value" id="view_created">-</div>
                </div>
                
                <div class="info-item full-width">
                    <div class="info-label">Morada</div>
                    <div class="info-value" id="view_address">-</div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="button" class="footer-btn cancel-btn" onclick="closeCard('viewCardOverlay')">
                <i class="fas fa-times"></i>
                Fechar
            </button>
            <button type="button" class="footer-btn edit-btn" onclick="switchToEditCard()">
                <i class="fas fa-edit"></i>
                Editar Cliente
            </button>
        </div>
    </div>
</div>

<!-- 3. EDIT CLIENT CARD -->
<div class="card-overlay" id="editCardOverlay" style="display: none;">
    <div class="modal-card edit-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-edit"></i>
                Editar Cliente
            </div>
            <button type="button" class="card-close" onclick="closeCard('editCardOverlay')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <form id="editClientForm" onsubmit="handleEditSubmit(event)">
                <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_client_id" name="id">
                
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="edit_name">Nome Completo *</label>
                            <input type="text" id="edit_name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_email">Email *</label>
                            <input type="email" id="edit_email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_phone">Contacto</label>
                            <input type="tel" id="edit_phone" name="phone">
                        </div>
                    </div>
                    
                    <div class="form-column">
                        <div class="form-group">
                            <label for="edit_company">Empresa</label>
                            <input type="text" id="edit_company" name="company">
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_address">Morada</label>
                            <textarea id="edit_address" name="address" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_status">Estado</label>
                            <select id="edit_status" name="status">
                                <option value="active">Ativo</option>
                                <option value="inactive">Inativo</option>
                                <option value="pending">Pendente</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-footer">
            <button type="button" class="footer-btn cancel-btn" onclick="closeCard('editCardOverlay')">
                <i class="fas fa-times"></i>
                Cancelar
            </button>
            <button type="submit" form="editClientForm" class="footer-btn submit-btn">
                <i class="fas fa-save"></i>
                Guardar Alterações
            </button>
        </div>
    </div>
</div>

<!-- 4. DELETE CLIENT CARD -->
<div class="card-overlay" id="deleteCardOverlay" style="display: none;">
    <div class="modal-card delete-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-trash"></i>
                Eliminar Cliente
            </div>
            <button type="button" class="card-close" onclick="closeCard('deleteCardOverlay')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <div class="delete-warning">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="warning-content">
                    <h4>Tem a certeza?</h4>
                    <p>Está prestes a eliminar o cliente <strong id="delete_client_name">-</strong>.</p>
                    
                    <div class="consequences">
                        <h5>Esta acção irá:</h5>
                        <ul>
                            <li>Remover permanentemente o cliente do sistema</li>
                            <li>Eliminar todo o histórico associado</li>
                            <li>Esta operação não pode ser desfeita</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="button" class="footer-btn cancel-btn" onclick="closeCard('deleteCardOverlay')">
                <i class="fas fa-times"></i>
                Cancelar
            </button>
            <button type="button" class="footer-btn danger-btn" onclick="confirmClientDelete()">
                <i class="fas fa-trash"></i>
                Eliminar Cliente
            </button>
        </div>
    </div>
</div>

<script>
// Global variables
let currentViewClient = null;
let currentEditClient = null;
let currentDeleteClientId = null;

// Card management functions
function openCreateCard() {
    document.getElementById('createCardOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Clear form
    document.getElementById('createClientForm').reset();
}

function openViewCard(client) {
    currentViewClient = client;
    
    // Populate view card
    document.getElementById('view_name').textContent = client.name || 'N/A';
    document.getElementById('view_email').textContent = client.email || 'N/A';
    document.getElementById('view_phone').textContent = client.phone || 'N/A';
    document.getElementById('view_company').textContent = client.company || 'N/A';
    document.getElementById('view_address').textContent = client.address || 'N/A';
    document.getElementById('view_created').textContent = client.createdAt ? 
        new Date(client.createdAt).toLocaleDateString('pt-PT') : 'N/A';
    
    // Status badge
    const statusBadge = document.getElementById('view_status');
    const status = client.status || 'inactive';
    statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
    statusBadge.className = `status-badge ${status.toLowerCase()}`;
    
    document.getElementById('viewCardOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function openEditCard(client) {
    currentEditClient = client;
    
    // Populate edit form
    document.getElementById('edit_client_id').value = client.id;
    document.getElementById('edit_name').value = client.name || '';
    document.getElementById('edit_email').value = client.email || '';
    document.getElementById('edit_phone').value = client.phone || '';
    document.getElementById('edit_company').value = client.company || '';
    document.getElementById('edit_address').value = client.address || '';
    document.getElementById('edit_status').value = client.status || 'active';
    
    document.getElementById('editCardOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function openDeleteCard(clientId, clientName) {
    currentDeleteClientId = clientId;
    document.getElementById('delete_client_name').textContent = clientName;
    
    document.getElementById('deleteCardOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeCard(overlayId) {
    document.getElementById(overlayId).style.display = 'none';
    document.body.style.overflow = 'auto';
    
    // Clear current data
    if (overlayId === 'viewCardOverlay') {
        currentViewClient = null;
    } else if (overlayId === 'editCardOverlay') {
        currentEditClient = null;
    } else if (overlayId === 'deleteCardOverlay') {
        currentDeleteClientId = null;
    }
}

function switchToEditCard() {
    if (currentViewClient) {
        closeCard('viewCardOverlay');
        setTimeout(() => openEditCard(currentViewClient), 100);
    }
}

// Form submission handlers
async function handleCreateSubmit(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    try {
        const response = await fetch('<?= url('/clients') ?>', {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            closeCard('createCardOverlay');
            location.reload();
        } else {
            alert('Erro ao criar cliente');
        }
    } catch (error) {
        alert('Erro de conexão');
    }
}

async function handleEditSubmit(event) {
    event.preventDefault();
    
    if (!currentEditClient) return;
    
    const formData = new FormData(event.target);
    
    try {
        const response = await fetch(`<?= url('/clients') ?>/${currentEditClient.id}`, {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            closeCard('editCardOverlay');
            location.reload();
        } else {
            alert('Erro ao atualizar cliente');
        }
    } catch (error) {
        alert('Erro de conexão');
    }
}

async function confirmClientDelete() {
    if (!currentDeleteClientId) return;
    
    const formData = new FormData();
    formData.append('_method', 'DELETE');
    formData.append('_token', '<?= $csrf_token ?>');
    
    try {
        const response = await fetch(`<?= url('/clients') ?>/${currentDeleteClientId}`, {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            closeCard('deleteCardOverlay');
            location.reload();
        } else {
            alert('Erro ao eliminar cliente');
        }
    } catch (error) {
        alert('Erro de conexão');
    }
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
        const openCards = ['createCardOverlay', 'viewCardOverlay', 'editCardOverlay', 'deleteCardOverlay'];
        openCards.forEach(cardId => {
            const card = document.getElementById(cardId);
            if (card.style.display === 'flex') {
                closeCard(cardId);
            }
        });
    }
});
</script>


<style>
/* Override specific classes for clients */
.page-icon:before {
    content: "\f0c0"; /* fa-users */
}

.create-card .card-title i:before {
    content: "\f234"; /* fa-user-plus */
}

/* Client-specific status colors */
.status-badge.active {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
    color: #15803d;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.status-badge.inactive {
    background: linear-gradient(135deg, rgba(156, 163, 175, 0.1), rgba(156, 163, 175, 0.05));
    color: #374151;
    border: 1px solid rgba(156, 163, 175, 0.2);
}

.status-badge.pending {
    background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(251, 191, 36, 0.05));
    color: #92400e;
    border: 1px solid rgba(251, 191, 36, 0.2);
}
</style>