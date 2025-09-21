<?php
/**
 * Clientes - Estrutura Hierárquica Reorganizada
 * 1. Título da página (isolado)
 * 2. Botão adicionar cliente (destaque)
 * 3. Área de filtros (pesquisar e limpar)
 * 4. Tabela com ações estilizadas (ver/editar/eliminar cards)
 */
?>

<style>
/* CSS inline para clientes */
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
    background: white;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e2e8f0;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.stat-divider {
    width: 1px;
    height: 40px;
    background: #e2e8f0;
}

/* =====================================
   ÁREA DE FILTROS MODERNA
   ===================================== */

.modern-filters-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(226, 232, 240, 0.6);
    position: relative;
    overflow: hidden;
}

.modern-filters-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6, #06b6d4);
}

.filters-inline-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: nowrap;
}

/* Campo de Pesquisa Moderno */
.modern-search-group {
    flex: 1;
    min-width: 300px;
}

.search-input-container {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 1rem;
    color: #64748b;
    font-size: 1rem;
    z-index: 2;
}

.modern-search-input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 2.5rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9375rem;
    font-weight: 400;
    background: #fafbfc;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    color: #1e293b;
}

.modern-search-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

.modern-search-input::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

/* Select de Status Moderno */
.modern-select-group {
    min-width: 200px;
}

.modern-status-select {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9375rem;
    font-weight: 500;
    background: #fafbfc;
    color: #1e293b;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.modern-status-select:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

.modern-status-select:hover {
    border-color: #94a3b8;
}

/* Botões Modernos */
.modern-buttons-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modern-search-btn {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.875rem 1.25rem;
    font-size: 0.9375rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    position: relative;
    overflow: hidden;
}

.modern-search-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.modern-search-btn:hover::before {
    left: 100%;
}

.modern-search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
}

.modern-search-btn:active {
    transform: translateY(0);
}

.modern-clear-btn {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.875rem 1.25rem;
    font-size: 0.9375rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
}

.modern-clear-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    text-decoration: none;
    color: white;
}

/* Info dos Resultados */
.results-summary {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(226, 232, 240, 0.6);
}

.results-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
}

.results-info i {
    color: #3b82f6;
}

.results-info strong {
    color: #1e293b;
    font-weight: 700;
}

/* Responsividade */
@media (max-width: 1024px) {
    .filters-inline-row {
        flex-wrap: wrap;
    }

    .modern-search-group {
        min-width: 250px;
    }

    .modern-select-group {
        min-width: 180px;
    }
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

    .modern-search-btn,
    .modern-clear-btn {
        flex: 1;
        justify-content: center;
    }

    .results-summary {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
    }
}

@media (max-width: 480px) {
    .modern-buttons-group {
        flex-direction: column;
        gap: 0.5rem;
    }
}

.client-table-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.table-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.25rem;
}

.table-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-export-data {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-export-data:hover {
    background: #e5e7eb;
}

.client-table {
    width: 100%;
    border-collapse: collapse;
}

.client-table th,
.client-table td {
    text-align: left;
    padding: 0.75rem;
    border-bottom: 1px solid #f3f4f6;
}

.client-table th {
    background: #f8fafc;
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
}

.th-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.client-row:hover {
    background: #f8fafc;
}

.client-user-info {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.client-avatar {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.8125rem;
}

.client-details {
    display: flex;
    flex-direction: column;
}

.client-name {
    font-weight: 600;
    color: #1f2937;
}

.client-username {
    font-size: 0.875rem;
    color: #6b7280;
}

.client-email {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.email-icon {
    color: #6b7280;
    font-size: 0.875rem;
}

.client-role-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #dbeafe;
    color: #1e40af;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    width: fit-content;
}

.client-status-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    width: fit-content;
}

.client-status-badge.active {
    background: #d1fae5;
    color: #065f46;
}

.client-status-badge.inactive {
    background: #f3f4f6;
    color: #374151;
}

.status-indicator {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

.client-last-login {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-direction: column;
    align-items: flex-start;
}

.login-icon {
    color: #6b7280;
    font-size: 0.875rem;
}

.login-date {
    font-weight: 500;
}

.login-time {
    color: #6b7280;
}

.no-login {
    color: #9ca3af;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.client-action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    border: none;
    border-radius: 6px;
    padding: 0.4375rem 0.625rem;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.view-btn {
    background: #dbeafe;
    color: #1e40af;
}

.view-btn:hover {
    background: #bfdbfe;
}

.edit-btn {
    background: #fef3c7;
    color: #92400e;
}

.edit-btn:hover {
    background: #fde68a;
}

.delete-btn {
    background: #fecaca;
    color: #b91c1c;
}

.delete-btn:hover {
    background: #fca5a5;
}

.empty-state-container {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-state-icon {
    font-size: 3rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state-title {
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.empty-state-text {
    color: #6b7280;
    margin-bottom: 1.5rem;
}

.btn-create-first-client {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-create-first-client:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.table-checkbox-wrapper {
    display: flex;
    align-items: center;
}

.table-checkbox {
    margin: 0;
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

    .action-btn {
        justify-content: center;
    }
}

/* =====================================
   CARDS MODAIS PARA CLIENTES
   ===================================== */

/* Overlay */
.card-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    animation: fadeIn 0.3s ease;
}

.card-overlay.active {
    display: flex;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Card Base */
.admin-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    max-width: 800px;
    width: 100%;
    max-height: 85vh;
    overflow: hidden;
    display: none;
    animation: slideInScale 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.admin-card.active {
    display: block;
}

@keyframes slideInScale {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(40px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Card Header */
.card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-bottom: 1px solid #e2e8f0;
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
}

.card-header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.create-icon { background: linear-gradient(135deg, #10b981, #059669); }
.view-icon { background: linear-gradient(135deg, #3b82f6, #1e40af); }
.edit-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
.delete-icon { background: linear-gradient(135deg, #ef4444, #dc2626); }

.card-title-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.card-subtitle {
    color: #6b7280;
    margin: 0;
    font-size: 0.9375rem;
}

.card-close-btn {
    background: #f3f4f6;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6b7280;
}

.card-close-btn:hover {
    background: #e5e7eb;
    transform: scale(1.05);
}

/* Card Body */
.card-body {
    padding: 1.5rem;
    max-height: 55vh;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #d1d5db transparent;
}

.card-body::-webkit-scrollbar {
    width: 6px;
}

.card-body::-webkit-scrollbar-track {
    background: transparent;
}

.card-body::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 3px;
}

.card-body::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

/* Form Layout */
.form-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
}

.form-column {
    display: flex;
    flex-direction: column;
}

.form-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 1.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e2e8f0;
}

.section-title i {
    color: #3b82f6;
    font-size: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 0.9375rem;
}

.form-label i {
    color: #6b7280;
    font-size: 0.875rem;
    width: 16px;
    text-align: center;
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-hint {
    font-size: 0.8125rem;
    color: #6b7280;
    margin-top: 0.375rem;
    display: block;
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

/* Toggle Switch */
.status-toggle {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 52px;
    height: 28px;
    cursor: pointer;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #d1d5db;
    transition: 0.3s;
    border-radius: 28px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

input:checked + .toggle-slider {
    background-color: #3b82f6;
}

input:checked + .toggle-slider:before {
    transform: translateX(24px);
}

.toggle-label {
    font-weight: 500;
    color: #374151;
}

/* Card Footer */
.card-footer {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 1.5rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

/* Botões do Footer */
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
    font-size: 0.9375rem;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
    background: white;
    color: #6b7280;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9375rem;
}

.btn-secondary:hover {
    background: #f9fafb;
    border-color: #9ca3af;
    color: #374151;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
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
    font-size: 0.9375rem;
}

.btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Delete Card Specific Styles */
.delete-warning {
    text-align: center;
    padding: 2rem 1rem;
}

.warning-icon {
    font-size: 4rem;
    color: #ef4444;
    margin-bottom: 1rem;
}

.delete-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.delete-message {
    color: #6b7280;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.client-info-display {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.client-info-display .client-avatar {
    width: 48px;
    height: 48px;
    font-size: 1.125rem;
}

/* View Card Specific Styles */
.info-section {
    margin-bottom: 2rem;
}

.info-section:last-child {
    margin-bottom: 0;
}

.info-section h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.info-section h4 i {
    color: #3b82f6;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-label {
    font-size: 0.8125rem;
    font-weight: 500;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-value {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1f2937;
}

/* Responsividade dos Modais */
@media (max-width: 768px) {
    .card-overlay {
        padding: 1rem;
    }

    .admin-card {
        max-height: 90vh;
    }

    .form-columns {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .card-footer {
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn-primary,
    .btn-secondary,
    .btn-danger {
        width: 100%;
        justify-content: center;
    }
}

/* =====================================
   DASHBOARD HEADER MODERNIZADO
   ===================================== */

.admin-dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin: -2rem -2rem 2rem -2rem;
    padding: 2rem 2rem 1.5rem 2rem;
    border-radius: 0 0 20px 20px;
    position: relative;
    overflow: hidden;
}

.admin-dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.dashboard-title-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 2;
}

.title-content {
    flex: 1;
}

.dashboard-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.75rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.5rem 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.title-icon-wrapper {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.title-icon-wrapper i {
    font-size: 1.25rem;
    color: white;
}

.dashboard-subtitle {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-weight: 400;
    line-height: 1.5;
}

/* Botão de Ação Principal */
.dashboard-action {
    position: relative;
}

.primary-action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.95);
    color: #4f46e5;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.primary-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    background: white;
}

.action-btn-icon {
    width: 24px;
    height: 24px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
}

.action-btn-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: radial-gradient(circle, rgba(79, 70, 229, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    transition: all 0.3s ease;
    transform: translate(-50%, -50%);
    z-index: -1;
}

.primary-action-btn:hover .action-btn-glow {
    width: 200px;
    height: 200px;
}

/* Cards de Estatísticas */
.stats-dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    position: relative;
    z-index: 2;
    margin-bottom: 1rem;
}

.stat-card-modern {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 1rem;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
    cursor: pointer;
}

.stat-card-modern:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.stat-card-content {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    position: relative;
    z-index: 2;
}

.stat-icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
    position: relative;
}

.total-stat .stat-icon-circle {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
}

.active-stat .stat-icon-circle {
    background: linear-gradient(135deg, #10b981, #059669);
}

.inactive-stat .stat-icon-circle {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.eliminated-stat .stat-icon-circle {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.stat-details {
    flex: 1;
    min-width: 0;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
    line-height: 1;
}

.stat-description {
    font-size: 0.8125rem;
    color: #6b7280;
    margin: 0 0 0.375rem 0;
    font-weight: 500;
    line-height: 1.4;
}

.stat-trend {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
}

.stat-trend.positive {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.stat-trend.neutral {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
}

.stat-trend i {
    font-size: 0.75rem;
}

.stat-card-bg {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    opacity: 0.05;
    background-size: cover;
    background-position: center;
    border-radius: 20px;
}

/* Estilos para mensagem de erro 403 */
.stats-error-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 1rem;
}

.stats-error-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(239, 68, 68, 0.2);
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 20px rgba(239, 68, 68, 0.1);
}

.error-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.error-content {
    flex: 1;
}

.error-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #dc2626;
    margin: 0 0 0.25rem 0;
}

.error-message {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
    line-height: 1.5;
}

/* Responsividade do Dashboard */
@media (max-width: 1024px) {
    .stats-dashboard {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .admin-dashboard-header {
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        padding: 2rem 1.5rem;
        border-radius: 0 0 20px 20px;
    }

    .dashboard-title-section {
        flex-direction: column;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .dashboard-title {
        font-size: 1.875rem;
        gap: 0.75rem;
    }

    .title-icon-wrapper {
        width: 50px;
        height: 50px;
    }

    .title-icon-wrapper i {
        font-size: 1.5rem;
    }

    .dashboard-subtitle {
        font-size: 1rem;
    }

    .primary-action-btn {
        padding: 0.875rem 1.5rem;
        font-size: 0.9375rem;
        width: 100%;
        justify-content: center;
    }

    .stats-dashboard {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .stat-card-modern {
        padding: 1.5rem;
    }

    .stat-card-content {
        gap: 1rem;
    }

    .stat-icon-circle {
        width: 56px;
        height: 56px;
        font-size: 1.25rem;
    }

    .stat-value {
        font-size: 1.875rem;
    }
}

@media (max-width: 480px) {
    .admin-dashboard-header {
        margin: -1rem -1rem 1.5rem -1rem;
        padding: 1.5rem 1rem;
    }

    .dashboard-title {
        font-size: 1.5rem;
    }

    .stat-card-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .stat-icon-circle {
        align-self: center;
    }
}
</style>

<!-- SEÇÃO SUPERIOR MODERNIZADA -->
<div class="admin-dashboard-header">
    <!-- 1. CABEÇALHO PRINCIPAL -->
    <div class="dashboard-title-section">
        <div class="title-content">
            <h1 class="dashboard-title">
                <div class="title-icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
                <span>Clientes</span>
            </h1>
            <p class="dashboard-subtitle">Gerencie os clientes do sistema com segurança e eficiência</p>
        </div>

        <!-- Botão de Ação Principal -->
        <div class="dashboard-action">
            <button class="primary-action-btn" onclick="openClientCreateModal()">
                <div class="action-btn-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <span>Adicionar Cliente</span>
                <div class="action-btn-glow"></div>
            </button>
        </div>
    </div>

    <!-- 2. CARDS DE ESTATÍSTICAS -->
    <?php if (($statistics['stats_error'] ?? null) === 'access_denied'): ?>
        <!-- Mensagem de Acesso Negado -->
        <div class="stats-error-container">
            <div class="stats-error-card">
                <div class="error-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="error-content">
                    <h3 class="error-title">Acesso Negado</h3>
                    <p class="error-message">Apenas administradores podem acessar estatísticas detalhadas.</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="stats-dashboard">
            <div class="stat-card-modern total-stat">
                <div class="stat-card-content">
                    <div class="stat-icon-circle">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-details">
                        <h3 class="stat-value"><?= $statistics['totalUsers'] ?? 0 ?></h3>
                        <p class="stat-description">Total de Clientes</p>
                        <span class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            Sistema ativo
                        </span>
                    </div>
                </div>
                <div class="stat-card-bg"></div>
            </div>

            <div class="stat-card-modern active-stat">
                <div class="stat-card-content">
                    <div class="stat-icon-circle">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-details">
                        <h3 class="stat-value"><?= $statistics['activeUsers'] ?? 0 ?></h3>
                        <p class="stat-description">Clientes Ativos</p>
                        <span class="stat-trend positive">
                            <i class="fas fa-check-circle"></i>
                            Online
                        </span>
                    </div>
                </div>
                <div class="stat-card-bg"></div>
            </div>

            <div class="stat-card-modern inactive-stat">
                <div class="stat-card-content">
                    <div class="stat-icon-circle">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <div class="stat-details">
                        <h3 class="stat-value"><?= $statistics['inactiveUsers'] ?? 0 ?></h3>
                        <p class="stat-description">Clientes Inativos</p>
                        <span class="stat-trend neutral">
                            <i class="fas fa-pause-circle"></i>
                            Pausados
                        </span>
                    </div>
                </div>
                <div class="stat-card-bg"></div>
            </div>

            <div class="stat-card-modern eliminated-stat">
                <div class="stat-card-content">
                    <div class="stat-icon-circle">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <div class="stat-details">
                        <h3 class="stat-value"><?= $statistics['eliminatedUsers'] ?? 0 ?></h3>
                        <p class="stat-description">Clientes Eliminados</p>
                        <span class="stat-trend neutral">
                            <i class="fas fa-trash-alt"></i>
                            Removidos
                        </span>
                    </div>
                </div>
                <div class="stat-card-bg"></div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- 3. ÁREA DE FILTROS MODERNA -->
<div class="modern-filters-section">
    <div class="filters-container">
        <form method="GET" action="<?= url('/clients') ?>" class="modern-filters-form">
            <div class="filters-inline-row">
                <!-- Campo de Pesquisa -->
                <div class="modern-search-group">
                    <div class="search-input-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text"
                               name="search"
                               class="modern-search-input"
                               value="<?= e($search ?? '') ?>"
                               placeholder="Pesquisar clientes..."
                               autocomplete="off">
                    </div>
                </div>

                <!-- Filtro de Status -->
                <div class="modern-select-group">
                    <select name="status" class="modern-status-select">
                        <option value="">🌐 Todos os Status</option>
                        <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>
                            ✅ Somente Ativos
                        </option>
                        <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>
                            ⏸️ Somente Inativos
                        </option>
                    </select>
                </div>

                <!-- Botões de Ação -->
                <div class="modern-buttons-group">
                    <button type="submit" class="modern-search-btn">
                        <i class="fas fa-search"></i>
                        <span>Pesquisar</span>
                    </button>

                    <!-- Botão Limpar (condicional) -->
                    <?php if (!empty($search) || !empty($status)): ?>
                        <a href="<?= url('/clients') ?>" class="modern-clear-btn">
                            <i class="fas fa-times-circle"></i>
                            <span>Limpar</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Info dos Resultados -->
            <div class="results-summary">
                <div class="results-info">
                    <i class="fas fa-info-circle"></i>
                    <span>Exibindo <strong><?= count($clients ?? []) ?></strong> de <strong><?= $pagination['total_elements'] ?? 0 ?></strong> clientes</span>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- 4. TABELA DE CLIENTES -->
<div class="client-table-section">
    <div class="table-header">
        <div class="table-header-content">
            <h3 class="table-title">
                <i class="fas fa-table"></i>
                Lista de Clientes
            </h3>
            <div class="table-actions">
                <button class="btn-export-data" onclick="exportData('clients')">
                    <i class="fas fa-download"></i>
                    <span>Exportar Dados</span>
                </button>
            </div>
        </div>
    </div>
    <div class="table-content">

        <?php if (!isset($clients) || !is_array($clients) || count($clients) === 0): ?>
            <div class="empty-state-container">
                <div class="empty-state-icon">
                    <i class="fas fa-users-slash"></i>
                </div>
                <div class="empty-state-content">
                    <h4 class="empty-state-title">Nenhum cliente encontrado</h4>
                    <p class="empty-state-text">Não há clientes cadastrados ou que correspondam aos filtros aplicados.</p>
                    <button class="btn-create-first-client" onclick="openClientCreateModal()">
                        <i class="fas fa-user-plus"></i>
                        <span>Criar Primeiro Cliente</span>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <table class="client-table">
                <thead>
                    <tr>
                        <th>
                            <div class="th-content">
                                <div class="table-checkbox-wrapper">
                                    <input type="checkbox" class="table-checkbox" id="selectAll">
                                </div>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-user"></i>
                                Cliente
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-envelope"></i>
                                Email
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-shield-alt"></i>
                                Tipo de Conta
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-toggle-on"></i>
                                Status
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-clock"></i>
                                Último Login
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-cogs"></i>
                                Ações
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr class="client-row">
                            <td>
                                <div class="table-checkbox-wrapper">
                                    <input type="checkbox" class="table-checkbox" value="<?= $client['id'] ?? '' ?>">
                                </div>
                            </td>
                            <td>
                                <div class="client-user-info">
                                    <div class="client-avatar">
                                        <?php if (!empty($client['img'])): ?>
                                            <img src="<?= e($client['img']) ?>" alt="<?= e($client['name']) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                        <?php else: ?>
                                            <?= strtoupper(substr($client['name'] ?? 'C', 0, 1)) ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="client-details">
                                        <div class="client-name"><?= e($client['name'] ?? 'Nome não informado') ?></div>
                                        <div class="client-username">@<?= e($client['authUsername'] ?? strtolower(str_replace(' ', '', $client['name'] ?? 'cliente'))) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="client-email">
                                    <i class="fas fa-envelope email-icon"></i>
                                    <?= e($client['email'] ?? 'Email não informado') ?>
                                </div>
                            </td>
                            <td>
                                <div class="client-role-badge">
                                    <i class="fas fa-building"></i>
                                    <?= ($client['organizationTypeId'] ?? 1) == 2 ? 'Corporativo' : 'Individual' ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                $status = strtolower($client['stateName'] ?? 'active');
                                $statusClass = $status === 'active' ? 'active' : 'inactive';
                                $statusText = $status === 'active' ? 'Ativo' : 'Inativo';
                                ?>
                                <div class="client-status-badge <?= $statusClass ?>">
                                    <div class="status-indicator"></div>
                                    <?= $statusText ?>
                                </div>
                            </td>
                            <td>
                                <div class="client-last-login">
                                    <?php if (!empty($client['last_login'])): ?>
                                        <div class="login-date">
                                            <i class="fas fa-calendar-alt login-icon"></i>
                                            <?= date('d/m/Y', strtotime($client['last_login'])) ?>
                                        </div>
                                        <div class="login-time">
                                            <?= date('H:i', strtotime($client['last_login'])) ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-login">
                                            <i class="fas fa-user-clock"></i>
                                            Nunca logou
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="client-action-buttons">
                                    <button class="action-btn view-btn" onclick="openViewCard(<?= $client['id'] ?? 0 ?>)" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn edit-btn" onclick="openEditCard(<?= $client['id'] ?? 0 ?>)" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn delete-btn" onclick="openDeleteCard(<?= $client['id'] ?? 0 ?>)" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Paginação -->
            <?php if (($pagination['total_pages'] ?? 1) > 1): ?>
                <div class="pagination-container">
                    <div class="pagination-info">
                        <span>Página <?= $pagination['current_page'] ?? 1 ?> de <?= $pagination['total_pages'] ?? 1 ?></span>
                    </div>
                    <div class="pagination-controls">
                        <?php if (($pagination['current_page'] ?? 1) > 1): ?>
                            <a href="?page=<?= ($pagination['current_page'] ?? 1) - 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($status) ? '&status=' . urlencode($status) : '' ?>" class="pagination-btn">
                                <i class="fas fa-chevron-left"></i>
                                Anterior
                            </a>
                        <?php endif; ?>

                        <?php if (($pagination['current_page'] ?? 1) < ($pagination['total_pages'] ?? 1)): ?>
                            <a href="?page=<?= ($pagination['current_page'] ?? 1) + 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($status) ? '&status=' . urlencode($status) : '' ?>" class="pagination-btn">
                                Próxima
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- MODAIS DE CLIENTES -->
<div id="cardOverlay" class="card-overlay">

    <!-- 1. CARD CRIAR CLIENTE -->
    <div id="createClientCard" class="admin-card create-card">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon create-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Criar Novo Cliente</h3>
                    <p class="card-subtitle">Preencha as informações do novo cliente</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="card-body">
            <form id="createClientForm" class="admin-form">
                <?= csrfField() ?>

                <!-- Layout compacto otimizado -->
                <div class="compact-form-layout">
                    <!-- Linha 1: Informações principais em grid -->
                    <div class="form-row-grid">
                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-signature"></i>Nome Completo *
                            </label>
                            <input type="text" name="name" class="form-input compact"
                                   placeholder="Ex: João Silva Santos" required>
                        </div>

                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-envelope"></i>Email
                            </label>
                            <input type="email" name="email" class="form-input compact"
                                   placeholder="cliente@empresa.com">
                        </div>

                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-phone"></i>Contacto *
                            </label>
                            <input type="tel" name="contact" class="form-input compact"
                                   placeholder="+244 912 345 678" required>
                        </div>
                    </div>

                    <!-- Linha 2: Configurações em linha horizontal -->
                    <div class="form-row-configs">
                        <div class="form-group compact half-width">
                            <label class="form-label compact">
                                <i class="fas fa-layer-group"></i>Tipo de Conta *
                            </label>
                            <select name="account_type_id" class="form-select compact" required>
                                <option value="">Selecionar...</option>
                                <?php if (!empty($account_types)): ?>
                                    <?php foreach ($account_types as $type): ?>
                                        <option value="<?= $type['id'] ?>"
                                                <?= $type['id'] == 2 ? 'selected' : '' ?>>
                                            <?= e($type['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">INDIVIDUAL</option>
                                    <option value="2" selected>CORPORATE</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group compact half-width">
                            <label class="form-label compact">
                                <i class="fas fa-toggle-on"></i>Estado *
                            </label>
                            <select name="state_id" class="form-select compact" required>
                                <option value="">Selecionar...</option>
                                <?php if (!empty($states)): ?>
                                    <?php foreach ($states as $state): ?>
                                        <option value="<?= $state['id'] ?>"
                                                <?= $state['id'] == 1 ? 'selected' : '' ?>>
                                            <?= e($state['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1" selected>ACTIVE</option>
                                    <option value="2">INACTIVE</option>
                                    <option value="3">PENDING</option>
                                    <option value="4">ELIMINATED</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Linha 3: Configurações Opcionais (colapsível) -->
                    <div class="form-row-optional">
                        <div class="optional-section">
                            <button type="button" class="optional-toggle" onclick="toggleOptionalFields()">
                                <i class="fas fa-chevron-right" id="optionalToggleIcon"></i>
                                <span>Configurações Opcionais</span>
                            </button>
                            <div class="optional-content" id="optionalFields" style="display: none;">
                                <div class="form-row-grid">
                                    <div class="form-group compact">
                                        <label class="form-label compact">
                                            <i class="fas fa-image"></i>URL da Imagem
                                        </label>
                                        <input type="url" name="img" class="form-input compact"
                                               placeholder="https://exemplo.com/imagem.jpg">
                                    </div>
                                    <div class="form-group compact">
                                        <label class="form-label compact">
                                            <i class="fas fa-key"></i>Senha
                                        </label>
                                        <input type="password" name="password" class="form-input compact"
                                               placeholder="Senha inicial (opcional)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer">
            <div class="footer-actions">
                <button type="button" class="btn-cancel" onclick="closeCard()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button type="submit" form="createClientForm" class="btn-create">
                    <i class="fas fa-user-plus"></i>
                    Criar Cliente
                </button>
            </div>
        </div>
    </div>

    <!-- 2. CARD VISUALIZAR CLIENTE -->
    <div id="viewClientCard" class="admin-card view-card">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon view-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Detalhes do Cliente</h3>
                    <p class="card-subtitle">Informações completas da conta</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="card-body">
            <!-- Modern Profile Header -->
            <div class="modern-profile-header">
                <div class="profile-banner">
                    <div class="profile-avatar-container">
                        <div class="profile-avatar-large" id="viewClientAvatar">
                            <img id="viewClientImage" src="" alt="Avatar" style="display: none;">
                            <span id="viewClientInitials">CL</span>
                        </div>
                        <div class="avatar-status-indicator" id="viewAvatarStatus">
                            <i class="fas fa-circle"></i>
                        </div>
                    </div>
                    <div class="profile-main-info">
                        <h4 class="profile-name" id="viewClientName">Nome do Cliente</h4>
                        <p class="profile-email" id="viewClientEmailHeader">email@exemplo.com</p>
                        <div class="profile-badges">
                            <div class="status-badge" id="viewStatusBadge">
                                <i class="fas fa-circle"></i>
                                <span id="viewStatusText">Ativo</span>
                            </div>
                            <div class="account-type-badge" id="viewAccountTypeBadge">
                                <i class="fas fa-user"></i>
                                <span id="viewAccountTypeText">Cliente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Info Grid -->
            <div class="modern-info-grid">
                <!-- Card Informações Pessoais -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon personal">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5 class="info-card-title">Informações Pessoais</h5>
                    </div>
                    <div class="info-card-content">
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-id-card info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Nome Completo</label>
                                    <div class="info-value-modern" id="viewFullName">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-envelope info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Email</label>
                                    <div class="info-value-modern email-link" id="viewEmail">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-phone info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Contacto</label>
                                    <div class="info-value-modern" id="viewContact">Não informado</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Informações da Conta -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon account">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h5 class="info-card-title">Informações da Conta</h5>
                    </div>
                    <div class="info-card-content">
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-fingerprint info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">ID do Sistema</label>
                                    <div class="info-value-modern" id="viewClientId">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-layer-group info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Tipo de Conta</label>
                                    <div class="info-value-modern" id="viewAccountTypeDetail">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-toggle-on info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Estado da Conta</label>
                                    <div class="info-value-modern" id="viewStateDetail">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Atividade -->
                <div class="info-card activity-card">
                    <div class="info-card-header">
                        <div class="info-card-icon activity">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5 class="info-card-title">Atividade e Histórico</h5>
                    </div>
                    <div class="info-card-content">
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-calendar-plus info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Criado em</label>
                                    <div class="info-value-modern" id="viewCreatedAt">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-calendar-check info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Última Atualização</label>
                                    <div class="info-value-modern" id="viewUpdatedAt">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-sign-in-alt info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Último Acesso</label>
                                    <div class="info-value-modern" id="viewLastLogin">Nunca acessou</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="footer-actions">
                <button type="button" class="btn-cancel" onclick="closeCard()">
                    <i class="fas fa-arrow-left"></i>
                    Voltar
                </button>
                <button type="button" class="btn-edit" onclick="openEditCardFromView()">
                    <i class="fas fa-edit"></i>
                    Editar Cliente
                </button>
            </div>
        </div>
    </div>

    <!-- 3. CARD EDITAR CLIENTE -->
    <div id="editClientCard" class="admin-card edit-card">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon edit-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Editar Cliente</h3>
                    <p class="card-subtitle">Atualize as informações e configurações da conta</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="card-body">
            <form id="editClientForm" class="admin-form">
                <?= csrfField() ?>
                <?= methodField('PUT') ?>
                <input type="hidden" name="client_id" id="editClientId">

                <!-- Layout compacto otimizado para edição -->
                <div class="compact-form-layout">
                    <!-- Linha 1: Informações principais em grid -->
                    <div class="form-row-grid">
                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-signature"></i>Nome Completo *
                            </label>
                            <input type="text" name="name" id="editName" class="form-input compact"
                                   placeholder="Ex: João Silva Santos" required>
                        </div>

                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-envelope"></i>Email
                            </label>
                            <input type="email" name="email" id="editEmail" class="form-input compact"
                                   placeholder="cliente@empresa.com">
                        </div>

                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-phone"></i>Contacto *
                            </label>
                            <input type="tel" name="contact" id="editContact" class="form-input compact"
                                   placeholder="+244 912 345 678" required>
                        </div>
                    </div>

                    <!-- Linha 2: Configurações em linha horizontal -->
                    <div class="form-row-configs">
                        <div class="form-group compact half-width">
                            <label class="form-label compact">
                                <i class="fas fa-layer-group"></i>Tipo de Conta *
                            </label>
                            <select name="account_type_id" id="editAccountTypeId" class="form-select compact" required>
                                <option value="">Selecionar...</option>
                                <?php if (!empty($account_types)): ?>
                                    <?php foreach ($account_types as $type): ?>
                                        <option value="<?= $type['id'] ?>">
                                            <?= e($type['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">INDIVIDUAL</option>
                                    <option value="2">CORPORATE</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group compact half-width">
                            <label class="form-label compact">
                                <i class="fas fa-toggle-on"></i>Estado *
                            </label>
                            <select name="state_id" id="editStateId" class="form-select compact" required>
                                <option value="">Selecionar...</option>
                                <?php if (!empty($states)): ?>
                                    <?php foreach ($states as $state): ?>
                                        <option value="<?= $state['id'] ?>">
                                            <?= e($state['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">ACTIVE</option>
                                    <option value="2">INACTIVE</option>
                                    <option value="3">PENDING</option>
                                    <option value="4">ELIMINATED</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Linha 3: Configurações Opcionais (colapsível) -->
                    <div class="form-row-optional">
                        <div class="optional-section">
                            <button type="button" class="optional-toggle" onclick="toggleOptionalFieldsEdit()">
                                <i class="fas fa-chevron-right" id="optionalToggleIconEdit"></i>
                                <span>Configurações de Imagem e Senha</span>
                            </button>
                            <div class="optional-content" id="optionalFieldsEdit" style="display: none;">
                                <div class="form-row-grid">
                                    <div class="form-group compact">
                                        <label class="form-label compact">
                                            <i class="fas fa-image"></i>URL da Imagem
                                        </label>
                                        <input type="url" name="img" id="editImageUrl" class="form-input compact"
                                               placeholder="https://exemplo.com/imagem.jpg">
                                    </div>
                                    <div class="form-group compact">
                                        <label class="form-label compact">
                                            <i class="fas fa-key"></i>Nova Senha (opcional)
                                        </label>
                                        <input type="password" name="password" class="form-input compact"
                                               placeholder="Deixe vazio para manter atual">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer">
            <div class="footer-actions">
                <button type="button" class="btn-cancel" onclick="closeCard()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button type="submit" form="editClientForm" class="btn-save">
                    <i class="fas fa-save"></i>
                    Salvar Alterações
                </button>
            </div>
        </div>
    </div>

    <!-- 4. CARD ELIMINAR CLIENTE -->
    <div id="deleteClientCard" class="admin-card delete-card">
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
            <div class="admin-info-compact">
                <div class="admin-avatar-compact">
                    <span id="deleteClientInitials">CL</span>
                </div>
                <div class="admin-text-compact">
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
let clientsData = <?= json_encode($clients ?? []) ?>;

// ===========================================
// INICIALIZAÇÃO
// ===========================================
document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();
    initializeSelectAll();
});

// ===========================================
// EVENT LISTENERS
// ===========================================
function initializeEventListeners() {
    // Fechar modal com Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCard();
        }
    });

    // Prevenir submit do formulário com Enter
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA' && e.target.type !== 'submit') {
            e.preventDefault();
        }
    });
}

function initializeSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.client-table .table-checkbox:not(#selectAll)');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
}

// ===========================================
// FUNÇÕES DE MODAL
// ===========================================
function showCard(cardId) {
    // Esconder todos os cards
    document.querySelectorAll('.admin-card').forEach(card => {
        card.classList.remove('active');
    });

    // Mostrar overlay e card específico
    document.getElementById('cardOverlay').classList.add('active');
    document.getElementById(cardId).classList.add('active');

    // Prevenir scroll do body
    document.body.style.overflow = 'hidden';
}

function closeCard() {
    document.getElementById('cardOverlay').classList.remove('active');
    document.querySelectorAll('.admin-card').forEach(card => {
        card.classList.remove('active');
    });

    document.body.style.overflow = 'auto';

    // Limpar formulários
    const forms = document.querySelectorAll('#createClientForm, #editClientForm');
    forms.forEach(form => form.reset());

    currentClientId = null;
}

// ===========================================
// MODAL FUNCTIONS
// ===========================================

// 1. CRIAR CLIENTE
function openClientCreateModal() {
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
            status: formData.get('status') ? 'active' : 'inactive',
            notes: formData.get('notes') || null
        };

        // TODO: Implementar chamada real à API
        const response = await fetch('<?= url('/clients') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(clientData)
        });

        if (response.ok) {
            const result = await response.json();
            showNotification('Cliente criado com sucesso!', 'success');
            closeCard();
            // Recarregar página ou atualizar dados
            window.location.reload();
        } else {
            const error = await response.json();
            showNotification(error.message || 'Erro ao criar cliente', 'error');
        }
    } catch (error) {
        console.error('Erro ao criar cliente:', error);
        showNotification('Erro ao criar cliente', 'error');
    }
}

// 2. VER CLIENTE
function openViewCard(id) {
    const client = clientsData.find(c => c.id == id);
    if (client) {
        currentClientId = id;

        // Usar a nova função para popular o card moderno
        populateViewCard(client);

        // Manter compatibilidade - content não é mais usado
        const content = document.getElementById('viewClientContent');
        if (content) content.innerHTML = `
            <div class="info-section">
                <h4><i class="fas fa-user"></i> Informações Pessoais</h4>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nome Completo</span>
                        <span class="info-value">${client.name || 'Não informado'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">${client.email || 'Não informado'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Contacto</span>
                        <span class="info-value">${client.contact || 'Não informado'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tipo de Conta</span>
                        <span class="info-value">${(client.account_type_id || 1) == 2 ? 'Corporativo' : 'Individual'}</span>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h4><i class="fas fa-cog"></i> Status da Conta</h4>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Status Atual</span>
                        <span class="info-value">
                            <span class="client-status-badge ${(client.state || 'active') === 'active' ? 'active' : 'inactive'}">
                                <div class="status-indicator"></div>
                                ${(client.state || 'active') === 'active' ? 'Ativo' : 'Inativo'}
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Data de Criação</span>
                        <span class="info-value">${client.created_at ? new Date(client.created_at).toLocaleDateString('pt-PT') : 'Não informado'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Último Login</span>
                        <span class="info-value">${client.last_login ? new Date(client.last_login).toLocaleDateString('pt-PT') : 'Nunca logou'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">ID do Cliente</span>
                        <span class="info-value">#${client.id}</span>
                    </div>
                </div>
            </div>
        `;

        showCard('viewClientCard');
    }
}

function editFromView() {
    closeCard();
    setTimeout(() => {
        openEditCard(currentClientId);
    }, 300);
}

// 3. EDITAR CLIENTE
function openEditCard(id) {
    const client = clientsData.find(c => c.id == id);
    if (client) {
        currentClientId = id;

        // Preencher ID do cliente
        document.getElementById('editClientId').value = client.id;

        // Usar a nova função para carregar dados
        loadEditClientData(client);

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
            status: formData.get('status') ? 'active' : 'inactive',
            notes: formData.get('notes') || null
        };

        // Adicionar password apenas se foi fornecida
        const password = formData.get('password');
        if (password && password.trim()) {
            clientData.password = password;
        }

        // TODO: Implementar chamada real à API
        const response = await fetch(`<?= url('/clients') ?>/${currentClientId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(clientData)
        });

        if (response.ok) {
            const result = await response.json();
            showNotification('Cliente atualizado com sucesso!', 'success');
            closeCard();
            // Recarregar página ou atualizar dados
            window.location.reload();
        } else {
            const error = await response.json();
            showNotification(error.message || 'Erro ao atualizar cliente', 'error');
        }
    } catch (error) {
        console.error('Erro ao atualizar cliente:', error);
        showNotification('Erro ao atualizar cliente', 'error');
    }
}

// 4. ELIMINAR CLIENTE
function openDeleteCard(id) {
    const client = clientsData.find(c => c.id == id);
    if (client) {
        currentClientId = id;

        // Preencher informações do cliente
        document.getElementById('deleteClientName').textContent = client.name || 'Nome não informado';
        document.getElementById('deleteClientEmail').textContent = client.email || 'Email não informado';

        // Gerar iniciais para o avatar
        const initials = client.name ? client.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'CL';
        document.getElementById('deleteClientInitials').textContent = initials;

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
        const deleteBtn = document.querySelector('.btn-danger');
        const originalText = deleteBtn.innerHTML;
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Eliminando...';

        // TODO: Implementar chamada real à API
        const response = await fetch(`<?= url('/clients') ?>/${currentClientId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        });

        if (response.ok) {
            deleteBtn.innerHTML = '<i class="fas fa-check"></i> Eliminado!';
            deleteBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';

            setTimeout(() => {
                showNotification('Cliente eliminado com sucesso!', 'success');
                closeCard();
                // Recarregar página ou atualizar dados
                window.location.reload();
            }, 1500);
        } else {
            const error = await response.json();
            showNotification(error.message || 'Erro ao eliminar cliente', 'error');

            // Restaurar botão
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Erro ao eliminar cliente:', error);
        showNotification('Erro ao eliminar cliente', 'error');

        // Restaurar botão
        const deleteBtn = document.querySelector('.btn-danger');
        deleteBtn.disabled = false;
        deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Confirmar Eliminação';
    }
}

// ===========================================
// FUNÇÕES AUXILIARES
// ===========================================
function exportData(type) {
    // TODO: Implementar exportação de dados
    showNotification('Funcionalidade de exportação em desenvolvimento', 'info');
}

function showNotification(message, type = 'info') {
    // Criar elemento de notificação
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;

    // Estilos inline para a notificação
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
        font-weight: 500;
    `;

    // Adicionar CSS de animação ao documento se não existir
    if (!document.getElementById('notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            .notification-content {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(notification);

    // Remover após 5 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            if (notification.parentNode) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

// Função para resetar formulários
function resetForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
    }
}

// ===========================================
// FUNÇÕES PARA NOVOS CARDS
// ===========================================

// Função para alternar campos opcionais
function toggleOptionalFields(cardType) {
    const toggle = event.target.closest('.optional-toggle');
    const content = document.getElementById(`optionalFields${cardType.charAt(0).toUpperCase() + cardType.slice(1)}`);
    const icon = toggle.querySelector('i');

    if (content.style.display === 'none' || !content.style.display) {
        content.style.display = 'block';
        icon.style.transform = 'rotate(90deg)';
        toggle.classList.add('expanded');
    } else {
        content.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
        toggle.classList.remove('expanded');
    }
}

// Função para abrir card de edição a partir da visualização
function openEditCardFromView() {
    if (currentClientId) {
        closeCard();
        setTimeout(() => openEditCard(currentClientId), 300);
    }
}

// Função para popular o card de visualização
function populateViewCard(client) {
    try {
        // Header principal com avatar e informações
        const avatarElement = document.getElementById('viewClientAvatar');
        const imageElement = document.getElementById('viewClientImage');
        const initialsElement = document.getElementById('viewClientInitials');

        // Configurar avatar
        if (imageElement && initialsElement) {
            if (client.img) {
                imageElement.src = client.img;
                imageElement.style.display = 'block';
                initialsElement.style.display = 'none';
            } else {
                imageElement.style.display = 'none';
                initialsElement.style.display = 'flex';
                initialsElement.textContent = getInitials(client.name || client.email);
            }
        }

        // Informações do header
        document.getElementById('viewClientName').textContent = client.name || 'Nome não informado';
        document.getElementById('viewClientEmailHeader').textContent = client.email || 'Email não informado';

        // Status badge
        const statusBadge = document.getElementById('viewStatusBadge');
        const statusText = document.getElementById('viewStatusText');
        if (statusBadge && statusText) {
            statusText.textContent = client.state?.name || 'Desconhecido';
            statusBadge.className = `status-badge ${getStatusClass(client.state?.name)}`;
        }

        // Account type badge
        const accountTypeBadge = document.getElementById('viewAccountTypeBadge');
        const accountTypeText = document.getElementById('viewAccountTypeText');
        if (accountTypeBadge && accountTypeText) {
            accountTypeText.textContent = client.accountType?.name || 'Desconhecido';
        }

        // Informações detalhadas
        document.getElementById('viewFullName').textContent = client.name || '-';
        document.getElementById('viewEmail').textContent = client.email || '-';
        document.getElementById('viewContact').textContent = client.contact || '-';
        document.getElementById('viewAccountType').textContent = client.accountType?.name || '-';
        document.getElementById('viewState').textContent = client.state?.name || '-';
        document.getElementById('viewCreatedAt').textContent = client.createdAt ?
            new Date(client.createdAt).toLocaleDateString('pt-PT') : '-';

    } catch (error) {
        console.error('Erro ao popular card de visualização:', error);
    }
}

// Função para obter iniciais do nome
function getInitials(name) {
    if (!name) return 'CL';
    return name.split(' ')
        .map(n => n[0])
        .join('')
        .substring(0, 2)
        .toUpperCase();
}

// Função para obter classe CSS do status
function getStatusClass(status) {
    if (!status) return 'status-unknown';

    switch (status.toLowerCase()) {
        case 'active':
        case 'ativo':
            return 'status-active';
        case 'inactive':
        case 'inativo':
            return 'status-inactive';
        case 'pending':
        case 'pendente':
            return 'status-pending';
        case 'eliminated':
        case 'eliminado':
            return 'status-eliminated';
        default:
            return 'status-unknown';
    }
}

// Função para carregar dados no card de edição
function loadEditClientData(client) {
    document.getElementById('editName').value = client.name || '';
    document.getElementById('editEmail').value = client.email || '';
    document.getElementById('editContact').value = client.contact || '';
    document.getElementById('editAccountType').value = client.accountTypeId || '';
    document.getElementById('editState').value = client.stateId || '';
    document.getElementById('editImg').value = client.img || '';
}
</script>