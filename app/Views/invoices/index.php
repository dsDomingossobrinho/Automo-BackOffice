<!-- 1. TÍTULO DA PÁGINA - ISOLADO -->
<div class="page-title-section">
    <div class="page-title-container">
        <h1 class="main-page-title">
            <i class="fas fa-file-invoice-dollar page-icon"></i>
            Gestão de Faturas
        </h1>
    </div>
</div>

<!-- 2. BOTÃO ADICIONAR FATURA - PROEMINENTE -->
<div class="add-action-section">
    <div class="add-action-container">
        <button type="button" class="primary-add-button" onclick="openCreateCard()">
            <div class="add-button-icon">
                <i class="fas fa-plus"></i>
            </div>
            <div class="add-button-content">
                <span class="add-button-text">Adicionar Fatura</span>
                <small class="add-button-subtitle">Criar nova fatura no sistema</small>
            </div>
        </button>
    </div>
</div>

<!-- 3. ÁREA DE FILTROS -->
<div class="filters-section">
    <div class="filters-container">
        <form method="GET" action="<?= url('/invoices') ?>" class="filters-form">
            <div class="filter-group">
                <div class="filter-field">
                    <input type="text" 
                           id="search" 
                           name="search" 
                           class="search-input" 
                           placeholder="Pesquisar faturas..."
                           value="<?= e($_GET['search'] ?? '') ?>">
                    <i class="fas fa-search search-icon"></i>
                </div>

                <div class="filter-field">
                    <select name="status" class="filter-select">
                        <option value="">Todos os estados</option>
                        <option value="draft" <?= ($_GET['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Rascunho</option>
                        <option value="sent" <?= ($_GET['status'] ?? '') === 'sent' ? 'selected' : '' ?>>Enviada</option>
                        <option value="paid" <?= ($_GET['status'] ?? '') === 'paid' ? 'selected' : '' ?>>Paga</option>
                        <option value="overdue" <?= ($_GET['status'] ?? '') === 'overdue' ? 'selected' : '' ?>>Vencida</option>
                        <option value="cancelled" <?= ($_GET['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelada</option>
                    </select>
                    <i class="fas fa-chevron-down select-icon"></i>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="filter-button search-button">
                        <i class="fas fa-search"></i>
                        Pesquisar
                    </button>
                    
                    <a href="<?= url('/invoices') ?>" class="filter-button clear-button <?= (!empty($_GET['search']) || !empty($_GET['status'])) ? 'active' : '' ?>">
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
                        <th><i class="fas fa-hashtag"></i>Número</th>
                        <th><i class="fas fa-user"></i>Cliente</th>
                        <th class="mobile-hidden"><i class="fas fa-euro-sign"></i>Valor</th>
                        <th><i class="fas fa-circle"></i>Estado</th>
                        <th class="mobile-hidden"><i class="fas fa-calendar"></i>Data</th>
                        <th class="mobile-hidden"><i class="fas fa-calendar-check"></i>Vencimento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($invoices)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 3rem;">
                                <div style="color: var(--text-muted);">
                                    <i class="fas fa-file-invoice-dollar" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    <h6>Nenhuma fatura encontrada</h6>
                                    <p>Comece adicionando a primeira fatura ao sistema</p>
                                    <button type="button" class="primary-add-button" onclick="openCreateCard()" style="margin-top: 1rem;">
                                        <div class="add-button-icon"><i class="fas fa-plus"></i></div>
                                        <div class="add-button-content">
                                            <span class="add-button-text">Adicionar Fatura</span>
                                        </div>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-primary);">
                                        #<?= e($invoice['number'] ?? 'N/A') ?>
                                    </div>
                                    <small style="color: var(--text-muted);">ID: <?= isset($invoice['id']) ? $invoice['id'] : 'N/A' ?></small>
                                </td>
                                <td>
                                    <div style="font-weight: 500; color: var(--text-primary);">
                                        <?= e($invoice['client_name'] ?? 'N/A') ?>
                                    </div>
                                    <small style="color: var(--text-muted);"><?= e($invoice['client_email'] ?? '') ?></small>
                                </td>
                                <td class="mobile-hidden">
                                    <div style="font-weight: 600; color: var(--primary-color);">
                                        €<?= number_format($invoice['total'] ?? 0, 2, ',', '.') ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge <?= strtolower($invoice['status'] ?? 'draft') ?>">
                                        <i class="fas fa-circle"></i>
                                        <?php
                                        $statusLabels = [
                                            'draft' => 'Rascunho',
                                            'sent' => 'Enviada', 
                                            'paid' => 'Paga',
                                            'overdue' => 'Vencida',
                                            'cancelled' => 'Cancelada'
                                        ];
                                        echo $statusLabels[$invoice['status'] ?? 'draft'] ?? 'Rascunho';
                                        ?>
                                    </span>
                                </td>
                                <td class="mobile-hidden">
                                    <?= date('d/m/Y', strtotime($invoice['date'] ?? 'now')) ?>
                                </td>
                                <td class="mobile-hidden">
                                    <?= date('d/m/Y', strtotime($invoice['due_date'] ?? 'now')) ?>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button type="button" class="action-btn view-btn" onclick="openViewCard(<?= htmlspecialchars(json_encode($invoice)) ?>)">
                                            <i class="fas fa-eye"></i>
                                            <span>Ver</span>
                                        </button>
                                        <button type="button" class="action-btn edit-btn" onclick="openEditCard(<?= htmlspecialchars(json_encode($invoice)) ?>)">
                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>
                                        </button>
                                        <button type="button" class="action-btn delete-btn" onclick="openDeleteCard(<?= isset($invoice['id']) ? $invoice['id'] : 0 ?>, '<?= e($invoice['number'] ?? 'N/A') ?>')">
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

<!-- 1. CREATE INVOICE CARD -->
<div class="card-overlay" id="createCardOverlay" style="display: none;">
    <div class="modal-card create-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-plus-circle"></i>
                Criar Nova Fatura
            </div>
            <button type="button" class="card-close" onclick="closeCard('createCardOverlay')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <form id="createInvoiceForm" onsubmit="handleCreateSubmit(event)">
                <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="create_number">Número da Fatura *</label>
                            <input type="text" id="create_number" name="number" required placeholder="ex: 2024-001">
                        </div>
                        
                        <div class="form-group">
                            <label for="create_client">Cliente *</label>
                            <select id="create_client" name="client_id" required>
                                <option value="">Selecionar cliente...</option>
                                <!-- Clients will be loaded via API or server-side -->
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="create_date">Data da Fatura *</label>
                            <input type="date" id="create_date" name="date" required value="<?= date('Y-m-d') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="create_due_date">Data de Vencimento *</label>
                            <input type="date" id="create_due_date" name="due_date" required>
                        </div>
                    </div>
                    
                    <div class="form-column">
                        <div class="form-group">
                            <label for="create_total">Valor Total *</label>
                            <input type="number" id="create_total" name="total" step="0.01" required placeholder="0,00">
                        </div>
                        
                        <div class="form-group">
                            <label for="create_tax">IVA (%)</label>
                            <input type="number" id="create_tax" name="tax_rate" step="0.01" value="23">
                        </div>
                        
                        <div class="form-group">
                            <label for="create_status">Estado</label>
                            <select id="create_status" name="status">
                                <option value="draft">Rascunho</option>
                                <option value="sent">Enviada</option>
                                <option value="paid">Paga</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="create_notes">Notas</label>
                            <textarea id="create_notes" name="notes" rows="3" placeholder="Notas adicionais..."></textarea>
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
            <button type="submit" form="createInvoiceForm" class="footer-btn submit-btn">
                <i class="fas fa-plus"></i>
                Criar Fatura
            </button>
        </div>
    </div>
</div>

<!-- 2. VIEW INVOICE CARD -->
<div class="card-overlay" id="viewCardOverlay" style="display: none;">
    <div class="modal-card view-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-eye"></i>
                Visualizar Fatura
            </div>
            <button type="button" class="card-close" onclick="closeCard('viewCardOverlay')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="profile-info">
                    <h3 id="view_number">-</h3>
                    <p id="view_client_name">-</p>
                </div>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Valor Total</div>
                    <div class="info-value" id="view_total">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">IVA</div>
                    <div class="info-value" id="view_tax">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Estado</div>
                    <div class="info-value">
                        <span class="status-badge" id="view_status">-</span>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Data da Fatura</div>
                    <div class="info-value" id="view_date">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Data de Vencimento</div>
                    <div class="info-value" id="view_due_date">-</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Cliente Email</div>
                    <div class="info-value" id="view_client_email">-</div>
                </div>
                
                <div class="info-item full-width">
                    <div class="info-label">Notas</div>
                    <div class="info-value" id="view_notes">-</div>
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
                Editar Fatura
            </button>
        </div>
    </div>
</div>

<!-- 3. EDIT INVOICE CARD -->
<div class="card-overlay" id="editCardOverlay" style="display: none;">
    <div class="modal-card edit-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-edit"></i>
                Editar Fatura
            </div>
            <button type="button" class="card-close" onclick="closeCard('editCardOverlay')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <form id="editInvoiceForm" onsubmit="handleEditSubmit(event)">
                <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_invoice_id" name="id">
                
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="edit_number">Número da Fatura *</label>
                            <input type="text" id="edit_number" name="number" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_client">Cliente *</label>
                            <select id="edit_client" name="client_id" required>
                                <option value="">Selecionar cliente...</option>
                                <!-- Clients will be loaded via API -->
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_date">Data da Fatura *</label>
                            <input type="date" id="edit_date" name="date" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_due_date">Data de Vencimento *</label>
                            <input type="date" id="edit_due_date" name="due_date" required>
                        </div>
                    </div>
                    
                    <div class="form-column">
                        <div class="form-group">
                            <label for="edit_total">Valor Total *</label>
                            <input type="number" id="edit_total" name="total" step="0.01" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_tax">IVA (%)</label>
                            <input type="number" id="edit_tax" name="tax_rate" step="0.01">
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_status">Estado</label>
                            <select id="edit_status" name="status">
                                <option value="draft">Rascunho</option>
                                <option value="sent">Enviada</option>
                                <option value="paid">Paga</option>
                                <option value="overdue">Vencida</option>
                                <option value="cancelled">Cancelada</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_notes">Notas</label>
                            <textarea id="edit_notes" name="notes" rows="3"></textarea>
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
            <button type="submit" form="editInvoiceForm" class="footer-btn submit-btn">
                <i class="fas fa-save"></i>
                Guardar Alterações
            </button>
        </div>
    </div>
</div>

<!-- 4. DELETE INVOICE CARD -->
<div class="card-overlay" id="deleteCardOverlay" style="display: none;">
    <div class="modal-card delete-card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-trash"></i>
                Eliminar Fatura
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
                    <p>Está prestes a eliminar a fatura <strong id="delete_invoice_number">-</strong>.</p>
                    
                    <div class="consequences">
                        <h5>Esta acção irá:</h5>
                        <ul>
                            <li>Remover permanentemente a fatura do sistema</li>
                            <li>Eliminar todos os registos de pagamento associados</li>
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
            <button type="button" class="footer-btn danger-btn" onclick="confirmInvoiceDelete()">
                <i class="fas fa-trash"></i>
                Eliminar Fatura
            </button>
        </div>
    </div>
</div>

<script>
// Global variables
let currentViewInvoice = null;
let currentEditInvoice = null;
let currentDeleteInvoiceId = null;

// Card management functions
function openCreateCard() {
    document.getElementById('createCardOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Clear form
    document.getElementById('createInvoiceForm').reset();
    
    // Set default due date (30 days from now)
    const dueDateInput = document.getElementById('create_due_date');
    const dueDate = new Date();
    dueDate.setDate(dueDate.getDate() + 30);
    dueDateInput.value = dueDate.toISOString().split('T')[0];
}

function openViewCard(invoice) {
    currentViewInvoice = invoice;
    
    // Populate view card
    document.getElementById('view_number').textContent = '#' + (invoice.number || 'N/A');
    document.getElementById('view_client_name').textContent = invoice.client_name || 'N/A';
    document.getElementById('view_client_email').textContent = invoice.client_email || 'N/A';
    document.getElementById('view_total').textContent = '€' + parseFloat(invoice.total || 0).toFixed(2);
    document.getElementById('view_tax').textContent = (invoice.tax_rate || '0') + '%';
    document.getElementById('view_notes').textContent = invoice.notes || 'N/A';
    document.getElementById('view_date').textContent = invoice.date ? 
        new Date(invoice.date).toLocaleDateString('pt-PT') : 'N/A';
    document.getElementById('view_due_date').textContent = invoice.due_date ? 
        new Date(invoice.due_date).toLocaleDateString('pt-PT') : 'N/A';
    
    // Status badge
    const statusBadge = document.getElementById('view_status');
    const status = invoice.status || 'draft';
    const statusLabels = {
        'draft': 'Rascunho',
        'sent': 'Enviada',
        'paid': 'Paga',
        'overdue': 'Vencida',
        'cancelled': 'Cancelada'
    };
    statusBadge.textContent = statusLabels[status] || 'Rascunho';
    statusBadge.className = `status-badge ${status.toLowerCase()}`;
    
    document.getElementById('viewCardOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function openEditCard(invoice) {
    currentEditInvoice = invoice;
    
    // Populate edit form
    document.getElementById('edit_invoice_id').value = invoice.id;
    document.getElementById('edit_number').value = invoice.number || '';
    document.getElementById('edit_client').value = invoice.client_id || '';
    document.getElementById('edit_total').value = invoice.total || '';
    document.getElementById('edit_tax').value = invoice.tax_rate || '';
    document.getElementById('edit_status').value = invoice.status || 'draft';
    document.getElementById('edit_notes').value = invoice.notes || '';
    document.getElementById('edit_date').value = invoice.date || '';
    document.getElementById('edit_due_date').value = invoice.due_date || '';
    
    document.getElementById('editCardOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function openDeleteCard(invoiceId, invoiceNumber) {
    currentDeleteInvoiceId = invoiceId;
    document.getElementById('delete_invoice_number').textContent = '#' + invoiceNumber;
    
    document.getElementById('deleteCardOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeCard(overlayId) {
    document.getElementById(overlayId).style.display = 'none';
    document.body.style.overflow = 'auto';
    
    // Clear current data
    if (overlayId === 'viewCardOverlay') {
        currentViewInvoice = null;
    } else if (overlayId === 'editCardOverlay') {
        currentEditInvoice = null;
    } else if (overlayId === 'deleteCardOverlay') {
        currentDeleteInvoiceId = null;
    }
}

function switchToEditCard() {
    if (currentViewInvoice) {
        closeCard('viewCardOverlay');
        setTimeout(() => openEditCard(currentViewInvoice), 100);
    }
}

// Form submission handlers
async function handleCreateSubmit(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    try {
        const response = await fetch('<?= url('/invoices') ?>', {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            closeCard('createCardOverlay');
            location.reload();
        } else {
            alert('Erro ao criar fatura');
        }
    } catch (error) {
        alert('Erro de conexão');
    }
}

async function handleEditSubmit(event) {
    event.preventDefault();
    
    if (!currentEditInvoice) return;
    
    const formData = new FormData(event.target);
    
    try {
        const response = await fetch(`<?= url('/invoices') ?>/${currentEditInvoice.id}`, {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            closeCard('editCardOverlay');
            location.reload();
        } else {
            alert('Erro ao atualizar fatura');
        }
    } catch (error) {
        alert('Erro de conexão');
    }
}

async function confirmInvoiceDelete() {
    if (!currentDeleteInvoiceId) return;
    
    const formData = new FormData();
    formData.append('_method', 'DELETE');
    formData.append('_token', '<?= $csrf_token ?>');
    
    try {
        const response = await fetch(`<?= url('/invoices') ?>/${currentDeleteInvoiceId}`, {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            closeCard('deleteCardOverlay');
            location.reload();
        } else {
            alert('Erro ao eliminar fatura');
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
/* Override specific classes for invoices */
.page-icon:before {
    content: "\f571"; /* fa-file-invoice-dollar */
}

.create-card .card-title i:before {
    content: "\f055"; /* fa-plus-circle */
}

/* Invoice-specific status colors */
.status-badge.draft {
    background: linear-gradient(135deg, rgba(156, 163, 175, 0.1), rgba(156, 163, 175, 0.05));
    color: #374151;
    border: 1px solid rgba(156, 163, 175, 0.2);
}

.status-badge.sent {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05));
    color: #1d4ed8;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.status-badge.paid {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
    color: #15803d;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.status-badge.overdue {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.status-badge.cancelled {
    background: linear-gradient(135deg, rgba(75, 85, 99, 0.1), rgba(75, 85, 99, 0.05));
    color: #374151;
    border: 1px solid rgba(75, 85, 99, 0.2);
}
</style>