<?php
/**
 * Clientes - Estrutura Hierárquica Baseada em Administradores
 * 1. Título da página (isolado)
 * 2. Botão adicionar cliente (destaque)
 * 3. Área de filtros (pesquisar e limpar)
 * 4. Tabela com ações estilizadas (ver/editar/eliminar cards)
 */
?>

<style>
/* CSS inline para clientes - copiado e adaptado de administradores */
.page-title-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e2e8f0;
}

.main-page-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.page-icon {
    color: #3b82f6;
}

.main-page-subtitle {
    color: #6b7280;
    margin: 0;
    font-size: 1rem;
}

.add-client-section {
    margin-bottom: 1.5rem;
}

.add-client-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-add-client {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
}

.btn-add-client:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    color: white;
}

.add-btn-icon {
    font-size: 1.25rem;
}

.add-btn-content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.add-btn-title {
    font-weight: 600;
    font-size: 1rem;
}

.add-btn-subtitle {
    font-size: 0.875rem;
    opacity: 0.9;
}

.add-btn-arrow {
    font-size: 1rem;
}

.quick-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.stat-item {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
}

.stat-number {
    font-weight: 600;
    color: #1e293b;
}

.modern-filters-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e2e8f0;
}

.filters-inline-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.modern-search-group {
    flex: 2;
    min-width: 300px;
    position: relative;
}

.modern-search-input {
    width: 100%;
    height: 44px;
    padding: 0 1rem 0 2.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.modern-search-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.modern-search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    font-size: 0.9rem;
}

.modern-select-group {
    min-width: 160px;
}

.modern-select {
    width: 100%;
    height: 44px;
    padding: 0 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9rem;
    background: #fafbfc;
    transition: all 0.3s ease;
    cursor: pointer;
}

.modern-select:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.modern-buttons-group {
    display: flex;
    gap: 0.5rem;
}

.btn-modern-search {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 0.75rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
}

.btn-modern-search:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-modern-clear {
    background: white;
    color: #64748b;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-modern-clear:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #475569;
    transform: translateY(-1px);
}

.btn-modern-clear.has-filters {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border-color: #ef4444;
}

.btn-modern-clear.has-filters:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
}

@media (max-width: 768px) {
    .modern-filters-section {
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .filters-inline-row {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }

    .modern-search-group,
    .modern-select-group {
        min-width: auto;
    }

    .modern-buttons-group {
        flex-direction: row;
        justify-content: space-between;
    }
}

.table-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.table-header {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
    padding: 1.5rem;
}

.table-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.table-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.table-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.results-info {
    background: #f1f5f9;
    color: #64748b;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
}

.table-responsive {
    overflow-x: auto;
}

.clients-table {
    width: 100%;
    border-collapse: collapse;
}

.clients-table th {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.clients-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.9rem;
    vertical-align: middle;
}

.clients-table tr:hover {
    background: #f9fafb;
}

.client-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.client-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.client-details {
    min-width: 0;
}

.client-name {
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
    font-size: 0.9rem;
}

.client-email {
    color: #6b7280;
    font-size: 0.8rem;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge.active {
    background: #dcfce7;
    color: #166534;
}

.status-badge.inactive {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.eliminated {
    background: #fee2e2;
    color: #991b1b;
}

.status-badge i {
    font-size: 0.625rem;
}

.client-action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-table-action {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.875rem;
}

.btn-view {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
}

.btn-view:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-edit {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.btn-edit:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.btn-delete {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.btn-delete:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

@media (max-width: 768px) {
    .filters-row {
        grid-template-columns: 1fr;
    }

    .add-client-container {
        flex-direction: column;
        align-items: stretch;
    }

    .quick-stats {
        justify-content: center;
    }

    .table-header-content {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .client-action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }

    .btn-table-action {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
}

/* =====================================
   MODALS DE CLIENTES
   ===================================== */

.client-card-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.75);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    backdrop-filter: blur(8px);
    animation: fadeIn 0.3s ease;
}

.client-card {
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 800px;
    max-height: 85vh;
    overflow: hidden;
    position: relative;
    animation: slideInScale 0.3s ease;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
}

.card-header {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    color: white;
    padding: 2rem;
    position: relative;
}

.card-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.card-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
}

.card-title-group {
    flex: 1;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.card-subtitle {
    opacity: 0.9;
    margin: 0;
    font-size: 0.9rem;
}

.card-close-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.card-close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.card-body {
    padding: 2rem;
    max-height: 60vh;
    overflow-y: auto;
}

.card-footer {
    background: #f8fafc;
    padding: 1.5rem 2rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInScale {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Form Styles */
.form-row-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-input,
.form-select,
.form-textarea {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
    min-height: 100px;
    resize: vertical;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
    background: white;
    color: #6b7280;
    border: 2px solid #d1d5db;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-secondary:hover {
    background: #f9fafb;
    border-color: #9ca3af;
    color: #374151;
}

/* Responsividade para modals */
@media (max-width: 768px) {
    .card-overlay {
        padding: 1rem;
    }

    .client-card {
        max-height: 95vh;
        border-radius: 12px;
    }

    .card-header {
        padding: 1.5rem;
    }

    .card-header-content {
        gap: 1rem;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .card-title {
        font-size: 1.25rem;
    }

    .card-body {
        padding: 1.5rem;
        max-height: 70vh;
    }

    .form-row-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .card-footer {
        padding: 1rem 1.5rem;
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}
</style>

<!-- SEÇÃO SUPERIOR MODERNIZADA -->
<div class="page-title-section">
    <h1 class="main-page-title">
        <i class="fas fa-users page-icon"></i>
        Gestão de Clientes
    </h1>
    <p class="main-page-subtitle">Gerencie todos os clientes do sistema com funcionalidades completas</p>
</div>

<!-- BOTÃO ADICIONAR CLIENTE PROEMINENTE -->
<div class="add-client-section">
    <div class="add-client-container">
        <button type="button" class="btn-add-client" onclick="openCreateCard()">
            <i class="fas fa-plus add-btn-icon"></i>
            <div class="add-btn-content">
                <div class="add-btn-title">Adicionar Cliente</div>
                <div class="add-btn-subtitle">Criar novo cliente no sistema</div>
            </div>
            <i class="fas fa-arrow-right add-btn-arrow"></i>
        </button>

        <!-- ESTATÍSTICAS RÁPIDAS -->
        <div class="quick-stats">
            <div class="stat-item">
                <span class="stat-number" id="totalClients">0</span>
                <span>Total</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" id="activeClients">0</span>
                <span>Ativos</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" id="inactiveClients">0</span>
                <span>Inativos</span>
            </div>
        </div>
    </div>
</div>

<!-- ÁREA DE FILTROS MODERNIZADA -->
<div class="modern-filters-section">
    <form method="GET" action="<?= url('/clients') ?>" class="filters-form">
        <div class="filters-inline-row">
            <!-- Campo de Busca -->
            <div class="modern-search-group">
                <i class="fas fa-search modern-search-icon"></i>
                <input type="text"
                       name="search"
                       class="modern-search-input"
                       placeholder="Pesquisar por nome, email, contacto..."
                       value="<?= e($_GET['search'] ?? '') ?>">
            </div>

            <!-- Filtro de Estado -->
            <div class="modern-select-group">
                <select name="state" class="modern-select">
                    <option value="">Todos os Estados</option>
                    <option value="1" <?= ($_GET['state'] ?? '') === '1' ? 'selected' : '' ?>>Ativo</option>
                    <option value="2" <?= ($_GET['state'] ?? '') === '2' ? 'selected' : '' ?>>Inativo</option>
                    <option value="4" <?= ($_GET['state'] ?? '') === '4' ? 'selected' : '' ?>>Eliminado</option>
                </select>
            </div>

            <!-- Botões de Ação -->
            <div class="modern-buttons-group">
                <button type="submit" class="btn-modern-search">
                    <i class="fas fa-search"></i>
                    Pesquisar
                </button>

                <a href="<?= url('/clients') ?>"
                   class="btn-modern-clear <?= (!empty($_GET['search']) || !empty($_GET['state'])) ? 'has-filters' : '' ?>">
                    <i class="fas fa-times"></i>
                    Limpar
                </a>
            </div>
        </div>
    </form>
</div>

<!-- TABELA DE CLIENTES -->
<div class="table-section">
    <div class="table-header">
        <div class="table-header-content">
            <h3 class="table-title">
                <i class="fas fa-list"></i>
                Lista de Clientes
            </h3>
            <div class="table-actions">
                <div class="results-info">
                    <span id="resultsCount">Carregando...</span>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="clients-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Estado</th>
                    <th>Tipo de Conta</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="clientsTableBody">
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #6b7280;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; margin-bottom: 0.5rem;"></i><br>
                        Carregando clientes...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- MODALS DE CLIENTES -->
<div id="clientCardOverlay" class="client-card-overlay" onclick="closeCard()">

    <!-- 1. CARD CRIAR CLIENTE -->
    <div id="createClientCard" class="client-card" onclick="event.stopPropagation()">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Adicionar Cliente</h3>
                    <p class="card-subtitle">Criar novo cliente no sistema</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="card-body">
            <form id="createClientForm">
                <div class="form-row-grid">
                    <div class="form-group">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" name="name" class="form-input" placeholder="Nome do cliente" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" placeholder="email@exemplo.com">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contacto *</label>
                        <input type="text" name="contact" class="form-input" placeholder="+244 900 000 000" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipo de Conta *</label>
                        <select name="accountTypeId" class="form-select" required>
                            <option value="">Selecionar tipo...</option>
                            <option value="1">Individual</option>
                            <option value="2">Corporativo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <select name="stateId" class="form-select">
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Palavra-passe</label>
                        <input type="password" name="password" class="form-input" placeholder="Senha (opcional)">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">URL da Imagem</label>
                        <input type="url" name="img" class="form-input" placeholder="https://exemplo.com/imagem.jpg">
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer">
            <button type="button" class="btn-secondary" onclick="closeCard()">
                <i class="fas fa-times"></i>
                Cancelar
            </button>
            <button type="button" class="btn-primary" onclick="createClient()">
                <i class="fas fa-save"></i>
                Salvar Cliente
            </button>
        </div>
    </div>

    <!-- 2. CARD VER CLIENTE -->
    <div id="viewClientCard" class="client-card" onclick="event.stopPropagation()">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Detalhes do Cliente</h3>
                    <p class="card-subtitle">Visualizar informações do cliente</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="card-body">
            <div id="viewClientContent">
                <!-- Conteúdo será preenchido dinamicamente -->
            </div>
        </div>

        <div class="card-footer">
            <button type="button" class="btn-secondary" onclick="closeCard()">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </button>
        </div>
    </div>

    <!-- 3. CARD EDITAR CLIENTE -->
    <div id="editClientCard" class="client-card" onclick="event.stopPropagation()">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Editar Cliente</h3>
                    <p class="card-subtitle">Atualizar informações do cliente</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="card-body">
            <form id="editClientForm">
                <div class="form-row-grid">
                    <div class="form-group">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" name="name" id="editClientName" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="editClientEmail" class="form-input">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contacto *</label>
                        <input type="text" name="contact" id="editClientContact" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipo de Conta *</label>
                        <select name="accountTypeId" id="editClientAccountType" class="form-select" required>
                            <option value="">Selecionar tipo...</option>
                            <option value="1">Individual</option>
                            <option value="2">Corporativo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <select name="stateId" id="editClientState" class="form-select">
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nova Palavra-passe</label>
                        <input type="password" name="password" id="editClientPassword" class="form-input" placeholder="Deixe em branco para manter atual">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">URL da Imagem</label>
                        <input type="url" name="img" id="editClientImg" class="form-input">
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer">
            <button type="button" class="btn-secondary" onclick="closeCard()">
                <i class="fas fa-times"></i>
                Cancelar
            </button>
            <button type="button" class="btn-primary" onclick="updateClient()">
                <i class="fas fa-save"></i>
                Atualizar Cliente
            </button>
        </div>
    </div>

    <!-- 4. CARD ELIMINAR CLIENTE -->
    <div id="deleteClientCard" class="client-card" onclick="event.stopPropagation()">
        <div class="card-header danger-header">
            <div class="card-header-content">
                <div class="card-icon delete-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Confirmar Eliminação</h3>
                    <p class="card-subtitle">Esta ação é irreversível</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="card-body delete-body-compact">
            <!-- Warning Icon -->
            <div class="delete-warning-compact">
                <div class="warning-icon-compact">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h4 class="delete-title">Eliminar Cliente?</h4>
            </div>

            <!-- Client Info Compact -->
            <div class="client-info-compact">
                <div class="client-avatar-compact">
                    <span id="deleteClientInitials">CL</span>
                </div>
                <div class="client-text-compact">
                    <h5 id="deleteClientName">Nome do Cliente</h5>
                    <span id="deleteClientEmail">email@exemplo.com</span>
                </div>
            </div>

            <!-- Warning Message -->
            <div class="warning-message-compact">
                <p><strong>Atenção:</strong> Esta ação é permanente e não pode ser desfeita.</p>
            </div>
        </div>

        <div class="card-footer delete-footer">
            <div class="footer-actions danger-actions">
                <button type="button" class="btn-safe-cancel" onclick="closeCard()">
                    <i class="fas fa-arrow-left"></i>
                    Cancelar
                </button>
                <button type="button" class="btn-danger-confirm" onclick="confirmDelete()">
                    <i class="fas fa-trash-alt"></i>
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ===========================================
// VARIABLES GLOBAIS
// ===========================================
let currentClientId = null;
let clientsData = [];

// Mock data enquanto não temos backend
const mockClients = [
    {
        id: 1,
        name: "João Silva",
        email: "joao.silva@email.com",
        contact: "+244 900 123 456",
        img: null,
        accountTypeId: 1,
        stateId: 1,
        state: "ACTIVE",
        createdAt: "2024-01-15T10:30:00Z",
        updatedAt: "2024-01-15T10:30:00Z"
    },
    {
        id: 2,
        name: "Maria Santos",
        email: "maria.santos@empresa.com",
        contact: "+244 900 789 012",
        img: null,
        accountTypeId: 2,
        stateId: 1,
        state: "ACTIVE",
        createdAt: "2024-01-10T14:20:00Z",
        updatedAt: "2024-01-10T14:20:00Z"
    },
    {
        id: 3,
        name: "Pedro Costa",
        email: "pedro.costa@gmail.com",
        contact: "+244 900 345 678",
        img: null,
        accountTypeId: 1,
        stateId: 2,
        state: "INACTIVE",
        createdAt: "2024-01-05T09:15:00Z",
        updatedAt: "2024-01-05T09:15:00Z"
    }
];

// ===========================================
// INICIALIZAÇÃO
// ===========================================
document.addEventListener('DOMContentLoaded', function() {
    loadClients();
    loadStatistics();
});

// ===========================================
// FUNÇÕES DE CARREGAMENTO DE DADOS
// ===========================================

async function loadClients() {
    try {
        // TODO: Substituir por chamada real à API GET /users/paginated
        // const response = await fetch('<?= url('/clients/api') ?>', {
        //     method: 'GET',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-Requested-With': 'XMLHttpRequest'
        //     }
        // });

        // Por enquanto usar mock data
        clientsData = mockClients;
        renderClientsTable(clientsData);
        updateResultsCount(clientsData.length);
    } catch (error) {
        console.error('Erro ao carregar clientes:', error);
        renderEmptyTable('Erro ao carregar clientes');
    }
}

async function loadStatistics() {
    try {
        // TODO: Substituir por chamada real à API GET /users/statistics
        // const stats = await fetch('<?= url('/clients/statistics') ?>');

        // Por enquanto calcular dos mock data
        const stats = {
            totalClients: mockClients.length,
            activeClients: mockClients.filter(c => c.stateId === 1).length,
            inactiveClients: mockClients.filter(c => c.stateId === 2).length
        };

        document.getElementById('totalClients').textContent = stats.totalClients;
        document.getElementById('activeClients').textContent = stats.activeClients;
        document.getElementById('inactiveClients').textContent = stats.inactiveClients;
    } catch (error) {
        console.error('Erro ao carregar estatísticas:', error);
    }
}

// ===========================================
// FUNÇÕES DE RENDERIZAÇÃO
// ===========================================

function renderClientsTable(clients) {
    const tbody = document.getElementById('clientsTableBody');

    if (!clients || clients.length === 0) {
        renderEmptyTable('Nenhum cliente encontrado');
        return;
    }

    tbody.innerHTML = clients.map(client => `
        <tr>
            <td>
                <div class="client-info">
                    <div class="client-avatar">
                        ${client.img ?
                            `<img src="${client.img}" alt="${client.name}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">` :
                            getInitials(client.name)
                        }
                    </div>
                    <div class="client-details">
                        <div class="client-name">${client.name || 'Nome não informado'}</div>
                        <div class="client-email">${client.email || 'Email não informado'}</div>
                    </div>
                </div>
            </td>
            <td>${client.contact || 'Não informado'}</td>
            <td>
                <span class="status-badge ${getStatusClass(client.stateId)}">
                    <i class="fas fa-circle"></i>
                    ${getStatusText(client.stateId)}
                </span>
            </td>
            <td>${getAccountTypeText(client.accountTypeId)}</td>
            <td>${formatDate(client.createdAt)}</td>
            <td>
                <div class="client-action-buttons">
                    <button class="btn-table-action btn-view" onclick="openViewCard(${client.id})" title="Visualizar">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-table-action btn-edit" onclick="openEditCard(${client.id})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-table-action btn-delete" onclick="openDeleteCard(${client.id}, '${client.name}')" title="Eliminar">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function renderEmptyTable(message) {
    const tbody = document.getElementById('clientsTableBody');
    tbody.innerHTML = `
        <tr>
            <td colspan="6" style="text-align: center; padding: 2rem; color: #6b7280;">
                <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.5;"></i><br>
                ${message}
            </td>
        </tr>
    `;
}

function updateResultsCount(count) {
    document.getElementById('resultsCount').textContent = `${count} resultado${count !== 1 ? 's' : ''} encontrado${count !== 1 ? 's' : ''}`;
}

// ===========================================
// FUNÇÕES AUXILIARES
// ===========================================

function getInitials(name) {
    if (!name) return 'CL';
    return name.split(' ')
        .map(word => word.charAt(0))
        .join('')
        .substring(0, 2)
        .toUpperCase();
}

function getStatusClass(stateId) {
    switch (stateId) {
        case 1: return 'active';
        case 2: return 'inactive';
        case 4: return 'eliminated';
        default: return 'inactive';
    }
}

function getStatusText(stateId) {
    switch (stateId) {
        case 1: return 'Ativo';
        case 2: return 'Inativo';
        case 4: return 'Eliminado';
        default: return 'Desconhecido';
    }
}

function getAccountTypeText(accountTypeId) {
    switch (accountTypeId) {
        case 1: return 'Individual';
        case 2: return 'Corporativo';
        default: return 'Não informado';
    }
}

function formatDate(dateString) {
    if (!dateString) return 'Não informado';
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('pt-PT', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    } catch (error) {
        return 'Data inválida';
    }
}

function getClientById(id) {
    return clientsData.find(client => client.id == id);
}

// ===========================================
// FUNÇÕES DE MODAL
// ===========================================

function showCard(cardId) {
    // Esconder todos os cards
    document.querySelectorAll('.client-card').forEach(card => {
        card.style.display = 'none';
    });

    // Mostrar o card específico
    document.getElementById(cardId).style.display = 'block';
    document.getElementById('clientCardOverlay').style.display = 'flex';

    // Prevenir scroll do body
    document.body.style.overflow = 'hidden';
}

function closeCard() {
    document.getElementById('clientCardOverlay').style.display = 'none';
    document.body.style.overflow = 'auto';

    // Limpar formulários
    document.getElementById('createClientForm').reset();
    document.getElementById('editClientForm').reset();

    currentClientId = null;
}

// ===========================================
// MODAL FUNCTIONS
// ===========================================

// 1. CRIAR CLIENTE
function openCreateCard() {
    showCard('createClientCard');
}

async function createClient() {
    try {
        const form = document.getElementById('createClientForm');
        const formData = new FormData(form);

        const clientData = {
            name: formData.get('name'),
            email: formData.get('email') || null,
            contact: formData.get('contact'),
            img: formData.get('img') || null,
            password: formData.get('password') || null,
            accountTypeId: parseInt(formData.get('accountTypeId')),
            stateId: parseInt(formData.get('stateId'))
        };

        // TODO: Substituir por chamada real à API POST /users
        // const response = await fetch('<?= url('/clients') ?>', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-Requested-With': 'XMLHttpRequest'
        //     },
        //     body: JSON.stringify(clientData)
        // });

        // Mock implementation
        const newClient = {
            id: Date.now(),
            ...clientData,
            state: clientData.stateId === 1 ? 'ACTIVE' : 'INACTIVE',
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString()
        };

        mockClients.unshift(newClient);
        clientsData = mockClients;

        closeCard();
        loadClients();
        loadStatistics();

        // Mostrar sucesso
        showNotification('Cliente criado com sucesso!', 'success');
    } catch (error) {
        console.error('Erro ao criar cliente:', error);
        showNotification('Erro ao criar cliente', 'error');
    }
}

// 2. VER CLIENTE
function openViewCard(id) {
    const client = getClientById(id);
    if (client) {
        currentClientId = id;

        const content = document.getElementById('viewClientContent');
        content.innerHTML = `
            <div class="modern-profile-header">
                <div class="profile-banner">
                    <div class="profile-avatar-container">
                        <div class="profile-avatar-large">
                            ${client.img ?
                                `<img src="${client.img}" alt="${client.name}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">` :
                                `<span>${getInitials(client.name)}</span>`
                            }
                        </div>
                        <div class="avatar-status-indicator ${getStatusClass(client.stateId)}">
                            <i class="fas fa-circle"></i>
                        </div>
                    </div>
                    <div class="profile-main-info">
                        <h4 class="profile-name">${client.name}</h4>
                        <p class="profile-email">${client.email || 'Email não informado'}</p>
                        <div class="profile-badges">
                            <div class="status-badge ${getStatusClass(client.stateId)}">
                                <i class="fas fa-circle"></i>
                                <span>${getStatusText(client.stateId)}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modern-info-grid">
                <div class="info-card">
                    <div class="info-header">
                        <i class="fas fa-user"></i>
                        <h5>Informações Pessoais</h5>
                    </div>
                    <div class="info-content">
                        <div class="info-item">
                            <span class="info-label">Nome Completo:</span>
                            <span class="info-value">${client.name}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value">${client.email || 'Não informado'}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Contacto:</span>
                            <span class="info-value">${client.contact}</span>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-header">
                        <i class="fas fa-cog"></i>
                        <h5>Informações da Conta</h5>
                    </div>
                    <div class="info-content">
                        <div class="info-item">
                            <span class="info-label">Tipo de Conta:</span>
                            <span class="info-value">${getAccountTypeText(client.accountTypeId)}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Estado:</span>
                            <span class="status-badge ${getStatusClass(client.stateId)}">
                                <i class="fas fa-circle"></i>
                                ${getStatusText(client.stateId)}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Data de Criação:</span>
                            <span class="info-value">${formatDate(client.createdAt)}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Última Atualização:</span>
                            <span class="info-value">${formatDate(client.updatedAt)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;

        showCard('viewClientCard');
    }
}

// 3. EDITAR CLIENTE
function openEditCard(id) {
    const client = getClientById(id);
    if (client) {
        currentClientId = id;

        // Preencher formulário de edição
        document.getElementById('editClientName').value = client.name || '';
        document.getElementById('editClientEmail').value = client.email || '';
        document.getElementById('editClientContact').value = client.contact || '';
        document.getElementById('editClientAccountType').value = client.accountTypeId || '';
        document.getElementById('editClientState').value = client.stateId || '';
        document.getElementById('editClientImg').value = client.img || '';

        showCard('editClientCard');
    }
}

async function updateClient() {
    if (!currentClientId) return;

    try {
        const form = document.getElementById('editClientForm');
        const formData = new FormData(form);

        const clientData = {
            name: formData.get('name'),
            email: formData.get('email') || null,
            contact: formData.get('contact'),
            img: formData.get('img') || null,
            accountTypeId: parseInt(formData.get('accountTypeId')),
            stateId: parseInt(formData.get('stateId'))
        };

        // Adicionar password apenas se foi fornecida
        const password = formData.get('password');
        if (password && password.trim()) {
            clientData.password = password;
        }

        // TODO: Substituir por chamada real à API PUT /users/{id}
        // const response = await fetch(`<?= url('/clients') ?>/${currentClientId}`, {
        //     method: 'PUT',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-Requested-With': 'XMLHttpRequest'
        //     },
        //     body: JSON.stringify(clientData)
        // });

        // Mock implementation
        const clientIndex = mockClients.findIndex(c => c.id == currentClientId);
        if (clientIndex !== -1) {
            mockClients[clientIndex] = {
                ...mockClients[clientIndex],
                ...clientData,
                state: clientData.stateId === 1 ? 'ACTIVE' : 'INACTIVE',
                updatedAt: new Date().toISOString()
            };
        }

        clientsData = mockClients;

        closeCard();
        loadClients();
        loadStatistics();

        showNotification('Cliente atualizado com sucesso!', 'success');
    } catch (error) {
        console.error('Erro ao atualizar cliente:', error);
        showNotification('Erro ao atualizar cliente', 'error');
    }
}

// 4. ELIMINAR CLIENTE
function openDeleteCard(id, name) {
    const client = getClientById(id);
    if (client) {
        currentClientId = id;

        // Preencher informações do cliente
        document.getElementById('deleteClientName').textContent = client.name || 'Cliente';
        document.getElementById('deleteClientEmail').textContent = client.email || 'Email não informado';
        document.getElementById('deleteClientInitials').textContent = getInitials(client.name || client.email);

        showCard('deleteClientCard');
    }
}

async function confirmDelete() {
    if (!currentClientId) {
        alert('ID do cliente não encontrado');
        return;
    }

    try {
        // Desabilitar botão para evitar cliques múltiplos
        const deleteBtn = document.querySelector('.btn-danger-confirm');
        const originalText = deleteBtn.innerHTML;
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Eliminando...';

        // TODO: Substituir por chamada real à API DELETE /users/{id}
        // const response = await fetch(`<?= url('/clients') ?>/${currentClientId}`, {
        //     method: 'DELETE',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-Requested-With': 'XMLHttpRequest'
        //     }
        // });

        // Mock implementation
        const clientIndex = mockClients.findIndex(c => c.id == currentClientId);
        if (clientIndex !== -1) {
            mockClients.splice(clientIndex, 1);
        }

        // Sucesso - mostrar feedback e remover da lista
        deleteBtn.innerHTML = '<i class="fas fa-check"></i> Eliminado!';
        deleteBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';

        // Remover o cliente da lista no frontend imediatamente
        removeClientFromList(currentClientId);

        setTimeout(() => {
            closeCard();
            loadClients();
            loadStatistics();
        }, 1500);
    } catch (error) {
        console.error('Erro ao eliminar cliente:', error);
        showNotification('Erro ao eliminar cliente', 'error');

        // Restaurar botão
        const deleteBtn = document.querySelector('.btn-danger-confirm');
        deleteBtn.disabled = false;
        deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Eliminar';
    }
}

function removeClientFromList(clientId) {
    // Remover do array mockClients
    const index = mockClients.findIndex(client => client.id == clientId);
    if (index !== -1) {
        mockClients.splice(index, 1);
    }

    // Remover visualmente da tabela
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const deleteBtn = row.querySelector('button[onclick*="openDeleteCard"]');
        if (deleteBtn && deleteBtn.getAttribute('onclick').includes(`openDeleteCard(${clientId}`)) {
            // Animar saída
            row.style.transition = 'all 0.3s ease';
            row.style.transform = 'translateX(-100%)';
            row.style.opacity = '0';

            setTimeout(() => {
                row.remove();

                // Verificar se a tabela está vazia
                const remainingRows = document.querySelectorAll('tbody tr');
                if (remainingRows.length === 0) {
                    renderEmptyTable('Nenhum cliente encontrado');
                }
            }, 300);
        }
    });
}

// ===========================================
// FUNÇÕES DE NOTIFICAÇÃO
// ===========================================

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;

    // Adicionar CSS inline para a notificação
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' :
                     type === 'error' ? 'linear-gradient(135deg, #dc2626, #b91c1c)' :
                     'linear-gradient(135deg, #3b82f6, #1e40af)'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
    `;

    document.body.appendChild(notification);

    // Remover após 5 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 5000);
}

// ===========================================
// EVENT LISTENERS
// ===========================================

// Fechar modal com Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCard();
    }
});

// Pesquisa em tempo real
document.querySelector('input[name="search"]').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();

    if (searchTerm.length === 0) {
        renderClientsTable(mockClients);
        updateResultsCount(mockClients.length);
        return;
    }

    const filteredClients = mockClients.filter(client =>
        client.name.toLowerCase().includes(searchTerm) ||
        (client.email && client.email.toLowerCase().includes(searchTerm)) ||
        (client.contact && client.contact.toLowerCase().includes(searchTerm))
    );

    renderClientsTable(filteredClients);
    updateResultsCount(filteredClients.length);
});

// Filtro por estado
document.querySelector('select[name="state"]').addEventListener('change', function(e) {
    const stateId = e.target.value;

    let filteredClients = mockClients;

    if (stateId) {
        filteredClients = mockClients.filter(client => client.stateId == stateId);
    }

    renderClientsTable(filteredClients);
    updateResultsCount(filteredClients.length);
});
</script>

<!-- Incluir estilos para o modal de view (copiado dos administradores) -->
<style>
/* Modern Profile Header */
.modern-profile-header {
    margin: -2rem -2rem 2rem -2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px 20px 0 0;
    color: white;
}

.profile-banner {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.profile-avatar-container {
    position: relative;
}

.profile-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.75rem;
    border: 4px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.avatar-status-indicator {
    position: absolute;
    bottom: 4px;
    right: 4px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-status-indicator.active {
    background: #10b981;
}

.avatar-status-indicator.inactive {
    background: #f59e0b;
}

.avatar-status-indicator i {
    font-size: 0.5rem;
    color: white;
}

.profile-main-info {
    flex: 1;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    color: white;
}

.profile-email {
    font-size: 1rem;
    margin: 0 0 1rem 0;
    opacity: 0.9;
}

.profile-badges {
    display: flex;
    gap: 0.5rem;
}

/* Modern Info Grid */
.modern-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.info-card {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.info-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e2e8f0;
}

.info-header i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.info-header h5 {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.info-content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #f1f5f9;
}

.info-label {
    font-weight: 500;
    color: #64748b;
    font-size: 0.875rem;
}

.info-value {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.875rem;
    text-align: right;
}

/* Estilos do delete modal compacto (copiado dos administradores) */
.danger-header {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: white;
}

.danger-header .card-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.danger-header .card-title {
    color: white;
}

.danger-header .card-subtitle {
    color: rgba(255, 255, 255, 0.9);
}

.delete-body-compact {
    padding: 1.5rem;
}

.delete-warning-compact {
    text-align: center;
    margin-bottom: 1.25rem;
}

.warning-icon-compact {
    margin-bottom: 0.75rem;
}

.warning-icon-compact i {
    font-size: 2.5rem;
    color: #dc2626;
}

.delete-title {
    color: #991b1b;
    font-weight: 700;
    font-size: 1.25rem;
    margin: 0;
}

.client-info-compact {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 1px solid #e2e8f0;
}

.client-avatar-compact {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.client-text-compact h5 {
    color: #1e293b;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    font-size: 1rem;
}

.client-text-compact span {
    color: #64748b;
    font-size: 0.875rem;
}

.warning-message-compact {
    text-align: center;
    padding: 0.75rem;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-radius: 8px;
    border: 1px solid #fca5a5;
}

.warning-message-compact p {
    color: #7f1d1d;
    font-size: 0.875rem;
    margin: 0;
    line-height: 1.4;
}

.delete-footer {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.btn-safe-cancel {
    background: white;
    color: #6b7280;
    border: 2px solid #d1d5db;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    cursor: pointer;
    min-width: 120px;
    justify-content: center;
}

.btn-safe-cancel:hover {
    background: #f9fafb;
    border-color: #9ca3af;
    color: #374151;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-danger-confirm {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    border: 2px solid #dc2626;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    cursor: pointer;
    min-width: 120px;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.btn-danger-confirm:hover {
    background: linear-gradient(135deg, #b91c1c, #991b1b);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
}

.btn-danger-confirm:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
}

@media (max-width: 768px) {
    .client-card-overlay .card {
        width: 95%;
        max-width: 400px;
        max-height: 80vh;
        margin: 10vh auto;
    }

    .delete-warning-compact {
        margin-bottom: 1rem;
    }

    .client-info-compact {
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        gap: 0.5rem;
    }

    .client-avatar-compact {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .modern-info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .profile-banner {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .profile-badges {
        justify-content: center;
    }

    .profile-avatar-large {
        width: 70px;
        height: 70px;
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .client-card-overlay .card {
        width: 98%;
        max-height: 75vh;
        margin: 12.5vh auto;
    }

    .delete-body-compact {
        padding: 0.75rem;
    }

    .warning-icon-compact i {
        font-size: 2.25rem;
    }

    .delete-title {
        font-size: 1.125rem;
    }

    .client-info-compact {
        padding: 0.5rem;
        gap: 0.5rem;
    }

    .client-avatar-compact {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }

    .warning-message-compact {
        padding: 0.5rem;
    }

    .btn-safe-cancel,
    .btn-danger-confirm {
        width: 100%;
        min-width: auto;
        padding: 0.625rem;
        font-size: 0.875rem;
    }
}

/* Notificações */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>