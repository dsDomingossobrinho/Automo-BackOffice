<?php
/**
 * Administradores - Estrutura Hierárquica Reorganizada
 * 1. Título da página (isolado)
 * 2. Botão adicionar administrador (destaque)
 * 3. Área de filtros (pesquisar e limpar)
 * 4. Tabela com ações estilizadas (ver/editar/eliminar cards)
 */
?>

<style>
/* CSS inline para administradores */
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

.add-admin-section {
    margin-bottom: 1.5rem;
}

.add-admin-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-add-administrator {
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

.btn-add-administrator:hover {
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

.admin-table-section {
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

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th,
.admin-table td {
    text-align: left;
    padding: 0.75rem;
    border-bottom: 1px solid #f3f4f6;
}

.admin-table th {
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

.admin-row:hover {
    background: #f8fafc;
}

.admin-user-info {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.admin-avatar {
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

.admin-details {
    display: flex;
    flex-direction: column;
}

.admin-name {
    font-weight: 600;
    color: #1f2937;
}

.admin-username {
    font-size: 0.875rem;
    color: #6b7280;
}

.admin-email {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.email-icon {
    color: #6b7280;
    font-size: 0.875rem;
}

.admin-role-badge {
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

.admin-status-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    width: fit-content;
}

.admin-status-badge.active {
    background: #d1fae5;
    color: #065f46;
}

.admin-status-badge.inactive {
    background: #f3f4f6;
    color: #374151;
}

.status-indicator {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

.admin-last-login {
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

.admin-action-buttons {
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

.btn-create-first-admin {
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

.btn-create-first-admin:hover {
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
    
    .add-admin-container {
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
    
    .admin-action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .action-btn {
        justify-content: center;
    }
}

/* =====================================
   CARDS MODAIS PARA ADMINISTRADORES
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
    background: linear-gradient(135deg, #3b82f6, #1e40af);
}

input:checked + .toggle-slider:before {
    transform: translateX(24px);
}

.toggle-label {
    font-size: 0.9375rem;
    color: #374151;
    font-weight: 500;
}

/* =====================================
   VALIDAÇÃO DE SENHA FORTE
   ===================================== */

.password-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.password-input {
    padding-right: 3rem !important;
}

.password-toggle-btn {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.3s ease;
    z-index: 2;
}

.password-toggle-btn:hover {
    color: #3b82f6;
    background: #f3f4f6;
}

.password-strength-container {
    margin: 0.75rem 0 0.5rem 0;
}

.password-strength-bar {
    width: 100%;
    height: 6px;
    background: #e5e7eb;
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.strength-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 3px;
}

.strength-fill.weak {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    width: 25%;
}

.strength-fill.fair {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    width: 50%;
}

.strength-fill.good {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    width: 75%;
}

.strength-fill.strong {
    background: linear-gradient(135deg, #10b981, #059669);
    width: 100%;
}

.strength-text {
    font-size: 0.8125rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.strength-text.weak {
    color: #ef4444;
}

.strength-text.fair {
    color: #f59e0b;
}

.strength-text.good {
    color: #3b82f6;
}

.strength-text.strong {
    color: #10b981;
}

.password-requirements {
    margin-top: 0.75rem;
    padding: 1rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    display: none;
}

.password-requirements.show {
    display: block;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.requirement {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
    font-size: 0.8125rem;
    transition: all 0.3s ease;
}

.requirement:last-child {
    margin-bottom: 0;
}

.requirement-icon {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    transition: all 0.3s ease;
}

.requirement.valid .requirement-icon {
    background: #10b981;
    color: white;
}

.requirement.valid .requirement-icon:before {
    content: "\f00c"; /* checkmark */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
}

.requirement.invalid .requirement-icon {
    background: #ef4444;
    color: white;
}

.requirement.invalid .requirement-icon:before {
    content: "\f00d"; /* times */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
}

.requirement.valid {
    color: #10b981;
}

.requirement.invalid {
    color: #6b7280;
}

.requirement span {
    transition: all 0.3s ease;
}

/* =====================================
   PAGINAÇÃO MODERNIZADA
   ===================================== */

.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 0;
    margin-top: 1rem;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 0 0 16px 16px;
}

.pagination-info {
    display: flex;
    align-items: center;
}

.pagination-text {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

.pagination-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.pagination-numbers {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin: 0 0.75rem;
}

.pagination-btn {
    min-width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    background: white;
    color: #64748b;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0 0.75rem;
}

.pagination-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-color: #3b82f6;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
}

.pagination-btn.active {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-color: #3b82f6;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
}

.pagination-btn:disabled {
    background: #f1f5f9;
    color: #cbd5e1;
    border-color: #e2e8f0;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.pagination-ellipsis {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    color: #94a3b8;
    font-weight: 500;
    font-size: 0.875rem;
}

/* Responsividade da Paginação */
@media (max-width: 768px) {
    .pagination-container {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
    }

    .pagination-info {
        order: 2;
    }

    .pagination-controls {
        order: 1;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-numbers {
        margin: 0 0.5rem;
    }

    .pagination-btn {
        min-width: 36px;
        height: 36px;
        font-size: 0.8125rem;
    }

    .pagination-text {
        font-size: 0.8125rem;
        text-align: center;
    }
}

/* =====================================
   LAYOUT COMPACTO PARA MODAL DE CRIAÇÃO
   ===================================== */

.compact-form-layout {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-height: 60vh;
    overflow-y: auto;
    padding-right: 0.5rem;
}

.form-row-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1rem;
    align-items: end;
}

.form-row-password {
    width: 100%;
}

.form-row-configs {
    display: flex;
    gap: 1rem;
    align-items: end;
}

.form-row-optional {
    border-top: 1px solid #e2e8f0;
    padding-top: 1rem;
}

.form-group.compact {
    margin-bottom: 0.75rem;
}

.form-group.compact.half-width {
    flex: 1;
}

.form-label.compact {
    font-size: 0.8125rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.375rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.form-input.compact,
.form-select.compact {
    height: 2.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: white;
    transition: all 0.2s ease;
    width: 100%;
}

.form-input.compact:focus,
.form-select.compact:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.password-toggle-btn.compact {
    right: 0.5rem;
    width: 2rem;
    height: 2rem;
    font-size: 0.875rem;
}

/* Força da senha compacta */
.password-strength-compact {
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.strength-bar-mini {
    flex: 1;
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    overflow: hidden;
}

.strength-text-mini {
    font-size: 0.75rem;
    font-weight: 500;
    min-width: 90px;
    text-align: right;
    transition: color 0.2s ease;
}

.strength-text-mini.weak {
    color: #ef4444;
}

.strength-text-mini.fair {
    color: #f59e0b;
}

.strength-text-mini.good {
    color: #3b82f6;
}

.strength-text-mini.strong {
    color: #10b981;
}

/* Requisitos compactos */
.password-requirements-compact {
    margin-top: 0.5rem;
    padding: 0.75rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    display: none;
}

.password-requirements-compact.show {
    display: block;
    animation: slideDown 0.2s ease;
}

.requirements-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.5rem;
}

.requirement.compact {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    margin-bottom: 0;
}

.requirement-icon-mini {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #ef4444;
    display: block;
    position: relative;
}

.requirement.compact.valid .requirement-icon-mini {
    background: #10b981;
}

.requirement.compact.valid .requirement-icon-mini::after {
    content: "✓";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 8px;
    font-weight: bold;
}

.requirement.compact.invalid .requirement-icon-mini::after {
    content: "×";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 8px;
    font-weight: bold;
}

.requirement.compact.valid {
    color: #10b981;
}

.requirement.compact.invalid {
    color: #6b7280;
}

/* Seção opcional colapsível */
.optional-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
}

.optional-toggle {
    width: 100%;
    background: transparent;
    border: none;
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    transition: all 0.2s ease;
}

.optional-toggle:hover {
    background: #f3f4f6;
}

.optional-toggle i {
    transition: transform 0.2s ease;
}

.optional-toggle.expanded i {
    transform: rotate(90deg);
}

.optional-content {
    padding: 0 1rem 1rem 1rem;
    border-top: 1px solid #e2e8f0;
    animation: slideDown 0.2s ease;
}

/* Sistema de Upload de Imagem */
.image-upload-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.upload-options-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.upload-section-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}

.upload-method-toggle {
    display: flex;
    background: #f3f4f6;
    border-radius: 8px;
    padding: 0.25rem;
    gap: 0.25rem;
}

.method-btn {
    background: transparent;
    border: none;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 500;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.method-btn:hover {
    color: #374151;
    background: #e5e7eb;
}

.method-btn.active {
    background: white;
    color: #3b82f6;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.upload-method-content {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* URL Input */
.url-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.url-preview-btn {
    position: absolute;
    right: 0.5rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #6b7280;
    transition: all 0.2s ease;
}

.url-preview-btn:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* File Upload Area */
.file-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fafafa;
    position: relative;
    overflow: hidden;
}

.file-upload-area:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}

.file-upload-area.dragover {
    border-color: #3b82f6;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(30, 64, 175, 0.05));
}

.upload-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.upload-icon {
    font-size: 2rem;
    color: #9ca3af;
    margin-bottom: 0.5rem;
}

.upload-text {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
}

.upload-hint {
    font-size: 0.75rem;
    color: #6b7280;
}

/* Upload Preview */
.upload-preview {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-preview img {
    max-width: 100%;
    max-height: 120px;
    border-radius: 6px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.preview-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 6px;
}

.upload-preview:hover .preview-overlay {
    opacity: 1;
}

.change-file-btn,
.remove-file-btn {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 4px;
    padding: 0.375rem 0.5rem;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.change-file-btn {
    color: #3b82f6;
}

.change-file-btn:hover {
    background: #3b82f6;
    color: white;
}

.remove-file-btn {
    color: #ef4444;
}

.remove-file-btn:hover {
    background: #ef4444;
    color: white;
}

/* Preview Global */
.image-preview-section {
    border-top: 1px solid #e2e8f0;
    padding-top: 1rem;
    margin-top: 1rem;
}

.global-image-preview {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}

.global-image-preview img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.preview-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.preview-status {
    font-size: 0.8125rem;
    font-weight: 500;
    color: #10b981;
}

.clear-preview-btn {
    background: transparent;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.clear-preview-btn:hover {
    background: #ef4444;
    color: white;
    border-color: #ef4444;
}

.form-hint.compact {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* Responsividade */
@media (max-width: 480px) {
    .upload-options-header {
        flex-direction: column;
        gap: 0.75rem;
        align-items: stretch;
    }

    .upload-method-toggle {
        justify-content: center;
    }

    .global-image-preview {
        flex-direction: column;
        text-align: center;
    }

    .file-upload-area {
        padding: 1rem;
    }

    .upload-icon {
        font-size: 1.5rem;
    }
}

/* Responsividade */
@media (max-width: 768px) {
    .form-row-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .form-row-configs {
        flex-direction: column;
        gap: 0.75rem;
    }

    .form-group.compact.half-width {
        width: 100%;
    }

    .requirements-grid {
        grid-template-columns: 1fr 1fr;
    }

    .compact-form-layout {
        max-height: 70vh;
    }
}

@media (max-width: 480px) {
    .requirements-grid {
        grid-template-columns: 1fr;
        gap: 0.25rem;
    }

    .password-strength-compact {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }

    .strength-text-mini {
        text-align: left;
        min-width: auto;
    }
}

/* Layout específico para modal de edição */
.form-row-full {
    width: 100%;
}

.form-textarea.compact {
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: white;
    transition: all 0.2s ease;
    resize: vertical;
    min-height: 2.5rem;
}

.form-textarea.compact:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

/* Toggle switch compacto */
.status-toggle-compact {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.toggle-switch-mini {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
}

.toggle-switch-mini input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider-mini {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.3s;
    border-radius: 24px;
}

.toggle-slider-mini:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.toggle-switch-mini input:checked + .toggle-slider-mini {
    background-color: #3b82f6;
}

.toggle-switch-mini input:checked + .toggle-slider-mini:before {
    transform: translateX(20px);
}

.toggle-label-mini {
    font-size: 0.8125rem;
    font-weight: 500;
    color: #374151;
}

/* =====================================
   MODAL DE VISUALIZAÇÃO MODERNIZADO
   ===================================== */

/* Header do perfil moderno */
.modern-profile-header {
    margin: -1.5rem -1.5rem 1.5rem -1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    border-radius: 0 0 20px 20px;
    position: relative;
    overflow: hidden;
}

.modern-profile-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    z-index: 1;
}

.profile-banner {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.profile-avatar-container {
    position: relative;
}

.profile-avatar-large {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #ffffff, #f8fafc);
    color: #667eea;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.5rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
}

.profile-avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 17px;
}

.avatar-status-indicator {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 20px;
    height: 20px;
    background: #10b981;
    border: 3px solid white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.avatar-status-indicator i {
    font-size: 8px;
    color: white;
}

.avatar-status-indicator.inactive {
    background: #6b7280;
}

.avatar-status-indicator.pending {
    background: #f59e0b;
}

.profile-main-info {
    flex: 1;
    color: white;
}

.profile-name {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.profile-email {
    font-size: 0.9375rem;
    margin: 0 0 1rem 0;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 400;
}

.profile-badges {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.status-badge,
.account-type-badge {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 500;
    color: white;
}

.status-badge.active {
    background: rgba(16, 185, 129, 0.2);
    border-color: rgba(16, 185, 129, 0.3);
}

.status-badge.inactive {
    background: rgba(107, 114, 128, 0.2);
    border-color: rgba(107, 114, 128, 0.3);
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.2);
    border-color: rgba(245, 158, 11, 0.3);
}

/* Grid moderno de informações */
.modern-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.info-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.info-card.activity-card {
    grid-column: 1 / -1;
}

.info-card-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-bottom: 1px solid #e2e8f0;
}

.info-card-icon {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.info-card-icon.personal {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
}

.info-card-icon.account {
    background: linear-gradient(135deg, #10b981, #059669);
}

.info-card-icon.activity {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.info-card-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.info-card-content {
    padding: 1rem;
}

.info-row {
    margin-bottom: 0.75rem;
}

.info-row:last-child {
    margin-bottom: 0;
}

.info-item-modern {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.info-icon {
    width: 20px;
    height: 20px;
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 0.125rem;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
    min-width: 0;
}

.info-label-modern {
    display: block;
    font-size: 0.75rem;
    font-weight: 500;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    margin-bottom: 0.25rem;
}

.info-value-modern {
    font-size: 0.9375rem;
    font-weight: 500;
    color: #1f2937;
    line-height: 1.4;
    word-break: break-word;
}

.info-value-modern.email-link {
    color: #3b82f6;
    cursor: pointer;
    transition: color 0.2s ease;
}

.info-value-modern.email-link:hover {
    color: #1e40af;
    text-decoration: underline;
}

.info-value-modern.username-value {
    font-family: 'Courier New', monospace;
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
}

/* Responsividade */
@media (max-width: 768px) {
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

    .profile-name {
        font-size: 1.25rem;
    }

    .modern-profile-header {
        margin: -1.5rem -1rem 1.5rem -1rem;
        padding: 1.5rem 1rem;
    }

    .info-card-content {
        padding: 1rem;
    }

    .info-item-modern {
        gap: 0.5rem;
    }
}

@media (max-width: 480px) {
    .info-card-header {
        padding: 0.75rem 1rem;
    }

    .info-card-icon {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
    }

    .info-card-title {
        font-size: 0.875rem;
    }

    .status-badge,
    .account-type-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
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

.recent-stat .stat-icon-circle {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
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

/* =====================================
   ANIMAÇÕES E MICRO-INTERAÇÕES
   ===================================== */

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes glow {
    0%, 100% {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    50% {
        box-shadow: 0 8px 30px rgba(79, 70, 229, 0.3);
    }
}

/* Aplicar animações */
.dashboard-title {
    animation: slideInLeft 0.8s ease;
}

.dashboard-subtitle {
    animation: slideInLeft 0.8s ease 0.2s both;
}

.primary-action-btn {
    animation: fadeInUp 0.8s ease 0.4s both;
}

.stat-card-modern:nth-child(1) {
    animation: fadeInUp 0.8s ease 0.6s both;
}

.stat-card-modern:nth-child(2) {
    animation: fadeInUp 0.8s ease 0.7s both;
}

.stat-card-modern:nth-child(3) {
    animation: fadeInUp 0.8s ease 0.8s both;
}

.stat-card-modern:nth-child(4) {
    animation: fadeInUp 0.8s ease 0.9s both;
}

/* Hover effects especiais */
.stat-card-modern:hover .stat-icon-circle {
    animation: pulse 2s infinite;
}

.primary-action-btn:focus {
    animation: glow 2s infinite;
    outline: none;
}

/* Efeito de partículas no hover dos cards */
.stat-card-modern::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.1) 50%, transparent 60%);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
    border-radius: 20px;
}

.stat-card-modern:hover::after {
    transform: translateX(100%);
}

/* Melhor feedback visual para números */
.stat-value {
    transition: all 0.3s ease;
}

.stat-card-modern:hover .stat-value {
    transform: scale(1.05);
    color: #4f46e5;
}

/* View Card Specific */
.admin-profile-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.profile-avatar-large {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    flex-shrink: 0;
}

.profile-info {
    flex: 1;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.profile-role {
    color: #6b7280;
    margin: 0 0 1rem 0;
    font-size: 1rem;
}

.profile-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9375rem;
    font-weight: 500;
}

.profile-status .status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
}

.info-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.info-column {
    display: flex;
    flex-direction: column;
}

.info-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
}

.info-section.full-width {
    grid-column: 1 / -1;
}

.info-section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 1.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e2e8f0;
}

.info-section-title i {
    color: #3b82f6;
    font-size: 0.875rem;
}

.info-item {
    margin-bottom: 1rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    font-size: 0.8125rem;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 0.25rem;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-value {
    font-size: 0.9375rem;
    color: #1f2937;
    font-weight: 500;
}

.email-value {
    font-family: 'Courier New', monospace;
    color: #3b82f6;
}

.username-value {
    font-family: 'Courier New', monospace;
    background: #e5e7eb;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    display: inline-block;
}

.notes-content {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1rem;
    color: #6b7280;
    font-style: italic;
    min-height: 60px;
}

/* Delete Card Specific */
.delete-confirmation {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 2rem;
}

.warning-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border: 3px solid #f59e0b;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #d97706;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.confirmation-content {
    max-width: 500px;
}

.confirmation-title {
    font-size: 1.375rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 1rem 0;
}

.confirmation-text {
    color: #6b7280;
    font-size: 1rem;
    line-height: 1.6;
    margin: 0 0 1.5rem 0;
}

.highlight-name {
    color: #ef4444;
    font-weight: 600;
}

.consequences-list {
    text-align: left;
}

.consequences-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.75rem 0;
}

.consequences {
    list-style: none;
    padding: 0;
    margin: 0;
}

.consequences li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
    font-size: 0.9375rem;
    color: #6b7280;
}

.consequences li i {
    color: #ef4444;
    font-size: 0.875rem;
    width: 16px;
    text-align: center;
}

.consequences li i.fa-info-circle {
    color: #3b82f6;
}

/* Card Footer */
.card-footer {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 1.5rem 2rem;
}

.footer-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.footer-actions.danger-actions {
    justify-content: center;
    gap: 2rem;
}

.btn-cancel, .btn-create, .btn-edit, .btn-save, .btn-delete-confirm, .safe-cancel {
    padding: 0.875rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9375rem;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 140px;
    justify-content: center;
}

.btn-cancel, .safe-cancel {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-cancel:hover, .safe-cancel:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-create {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
}

.btn-edit, .btn-save {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.btn-edit:hover, .btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);
}

.btn-delete-confirm {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.btn-delete-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
}

/* Responsive Cards */
@media (max-width: 768px) {
    .card-overlay {
        padding: 1rem;
    }
    
    .admin-card {
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
        max-height: 65vh;
    }
    
    .form-columns, .info-columns {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .admin-profile-header {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
        padding: 1.5rem;
    }
    
    .profile-avatar-large {
        width: 70px;
        height: 70px;
        font-size: 1.75rem;
    }
    
    .footer-actions {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .footer-actions.danger-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-cancel, .btn-create, .btn-edit, .btn-save, .btn-delete-confirm, .safe-cancel {
        width: 100%;
        min-width: auto;
    }
    
    .warning-icon {
        width: 80px;
        height: 80px;
        font-size: 2.5rem;
    }
}

@media (max-width: 480px) {
    .card-overlay {
        padding: 0.5rem;
    }
    
    .admin-card {
        max-height: 98vh;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .card-footer {
        padding: 1rem;
    }
    
    .form-section, .info-section {
        padding: 1rem;
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
                    <i class="fas fa-users-cog"></i>
                </div>
                <span>Administradores</span>
            </h1>
            <p class="dashboard-subtitle">Gerencie os administradores do sistema com segurança e eficiência</p>
        </div>

        <!-- Botão de Ação Principal -->
        <div class="dashboard-action">
            <button class="primary-action-btn" onclick="openCreateCard()">
                <div class="action-btn-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <span>Adicionar Admin</span>
                <div class="action-btn-glow"></div>
            </button>
        </div>
    </div>

    <!-- 2. CARDS DE ESTATÍSTICAS -->
    <?php if (($stats['stats_error'] ?? null) === 'access_denied'): ?>
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
                        <h3 class="stat-value"><?= $stats['total_admins'] ?? 0 ?></h3>
                        <p class="stat-description">Total de Administradores</p>
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
                        <h3 class="stat-value"><?= $stats['active_admins'] ?? 0 ?></h3>
                        <p class="stat-description">Administradores Ativos</p>
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
                        <h3 class="stat-value"><?= $stats['inactive_admins'] ?? 0 ?></h3>
                        <p class="stat-description">Administradores Inativos</p>
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
                        <h3 class="stat-value"><?= $stats['eliminated_admins'] ?? 0 ?></h3>
                        <p class="stat-description">Administradores Eliminados</p>
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
        <form method="GET" action="<?= url('/accounts') ?>" class="modern-filters-form">
            <div class="filters-inline-row">
                <!-- Campo de Pesquisa -->
                <div class="modern-search-group">
                    <div class="search-input-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text"
                               name="search"
                               class="modern-search-input"
                               value="<?= e($search ?? '') ?>"
                               placeholder="Pesquisar administradores..."
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
                        <a href="<?= url('/accounts') ?>" class="modern-clear-btn">
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
                    <span>Exibindo <strong><?= count($accounts ?? []) ?></strong> de <strong><?= $pagination['total_elements'] ?? 0 ?></strong> administradores</span>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- 4. TABELA DE ADMINISTRADORES -->
<div class="admin-table-section">
    <div class="table-header">
        <div class="table-header-content">
            <h3 class="table-title">
                <i class="fas fa-table"></i>
                Lista de Administradores
            </h3>
            <div class="table-actions">
                <button class="btn-export-data" onclick="exportData('accounts')">
                    <i class="fas fa-download"></i>
                    <span>Exportar Dados</span>
                </button>
            </div>
        </div>
    </div>
    <div class="table-content">
        <?php if (empty($accounts)): ?>
            <div class="empty-state-container">
                <div class="empty-state-icon">
                    <i class="fas fa-users-slash"></i>
                </div>
                <div class="empty-state-content">
                    <h4 class="empty-state-title">Nenhum administrador encontrado</h4>
                    <p class="empty-state-text">Não há administradores cadastrados ou que correspondam aos filtros aplicados.</p>
                    <button class="btn-create-first-admin" onclick="openCreateCard()">
                        <i class="fas fa-user-plus"></i>
                        <span>Criar Primeiro Administrador</span>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead class="admin-table-header">
                        <tr>
                            <th class="col-select">
                                <div class="table-checkbox-wrapper">
                                    <input class="table-checkbox" type="checkbox" id="selectAll">
                                    <label for="selectAll" class="checkbox-label"></label>
                                </div>
                            </th>
                            <th class="col-user">
                                <div class="th-content">
                                    <i class="fas fa-user"></i>
                                    <span>Administrador</span>
                                </div>
                            </th>
                            <th class="col-email">
                                <div class="th-content">
                                    <i class="fas fa-envelope"></i>
                                    <span>Email</span>
                                </div>
                            </th>
                            <th class="col-role">
                                <div class="th-content">
                                    <i class="fas fa-user-tag"></i>
                                    <span>Função</span>
                                </div>
                            </th>
                            <th class="col-status">
                                <div class="th-content">
                                    <i class="fas fa-toggle-on"></i>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="col-login">
                                <div class="th-content">
                                    <i class="fas fa-clock"></i>
                                    <span>Último Acesso</span>
                                </div>
                            </th>
                            <th class="col-actions">
                                <div class="th-content">
                                    <i class="fas fa-cogs"></i>
                                    <span>Ações</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="admin-table-body">
                        <?php foreach ($accounts as $account): ?>
                            <tr class="admin-row">
                                <td class="col-select">
                                    <div class="table-checkbox-wrapper">
                                        <input class="table-checkbox row-checkbox" 
                                               type="checkbox" 
                                               id="row_<?= $account['id'] ?>"
                                               value="<?= $account['id'] ?>">
                                        <label for="row_<?= $account['id'] ?>" class="checkbox-label"></label>
                                    </div>
                                </td>
                                
                                <td class="col-user">
                                    <div class="admin-user-info">
                                        <div class="admin-avatar">
                                            <?= strtoupper(substr($account['name'] ?? $account['email'], 0, 1)) ?>
                                        </div>
                                        <div class="admin-details">
                                            <div class="admin-name"><?= e($account['name'] ?? 'Sem nome') ?></div>
                                            <div class="admin-username">@<?= e($account['username'] ?? 'usuario') ?></div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="col-email">
                                    <div class="admin-email">
                                        <i class="fas fa-envelope email-icon"></i>
                                        <span class="email-text"><?= e($account['email']) ?></span>
                                    </div>
                                </td>
                                
                                <td class="col-role">
                                    <div class="admin-role-badge">
                                        <i class="fas fa-user-shield"></i>
                                        <span><?= e($account['role_name'] ?? 'Administrador') ?></span>
                                    </div>
                                </td>
                                
                                <td class="col-status">
                                    <?php 
                                    $isActive = ($account['state'] ?? 'INACTIVE') === 'ACTIVE';
                                    ?>
                                    <div class="admin-status-badge <?= $isActive ? 'active' : 'inactive' ?>">
                                        <div class="status-indicator"></div>
                                        <span class="status-text">
                                            <?= $isActive ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="col-login">
                                    <div class="admin-last-login">
                                        <?php if (isset($account['updatedAt']) && $account['updatedAt']): ?>
                                            <i class="fas fa-clock login-icon"></i>
                                            <span class="login-date"><?= date('d/m/Y', strtotime($account['updatedAt'])) ?></span>
                                            <small class="login-time"><?= date('H:i', strtotime($account['updatedAt'])) ?></small>
                                        <?php else: ?>
                                            <span class="no-login">
                                                <i class="fas fa-minus-circle"></i>
                                                Nunca acessou
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                                <td class="col-actions">
                                    <div class="admin-action-buttons">
                                        <button class="action-btn view-btn" 
                                                onclick="openViewCard(<?= $account['id'] ?>)"
                                                title="Visualizar administrador">
                                            <i class="fas fa-eye"></i>
                                            <span>Ver</span>
                                        </button>
                                        
                                        <button class="action-btn edit-btn" 
                                                onclick="openEditCard(<?= $account['id'] ?>)"
                                                title="Editar administrador">
                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>
                                        </button>
                                        
                                        <button class="action-btn delete-btn" 
                                                onclick="openDeleteCard(<?= $account['id'] ?>, '<?= e($account['name'] ?? $account['email']) ?>')"
                                                title="Eliminar administrador">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Eliminar</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação Modernizada -->
            <?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
                <div class="pagination-container">
                    <div class="pagination-info">
                        <span class="pagination-text">
                            Exibindo <?= (($pagination['current_page'] - 1) * $pagination['size']) + 1 ?>
                            a <?= min($pagination['current_page'] * $pagination['size'], $pagination['total_elements']) ?>
                            de <?= $pagination['total_elements'] ?> administradores
                        </span>
                    </div>

                    <div class="pagination-controls">
                        <!-- Botão Primeira Página -->
                        <button class="pagination-btn"
                                onclick="changePage(1)"
                                <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?>
                                title="Primeira página">
                            <i class="fas fa-angle-double-left"></i>
                        </button>

                        <!-- Botão Página Anterior -->
                        <button class="pagination-btn"
                                onclick="changePage(<?= $pagination['current_page'] - 1 ?>)"
                                <?= !$pagination['has_previous'] ? 'disabled' : '' ?>
                                title="Página anterior">
                            <i class="fas fa-angle-left"></i>
                        </button>

                        <!-- Números das Páginas -->
                        <div class="pagination-numbers">
                            <?php
                            $start = max(1, $pagination['current_page'] - 2);
                            $end = min($pagination['total_pages'], $pagination['current_page'] + 2);

                            // Mostrar "..." se necessário no início
                            if ($start > 1): ?>
                                <button class="pagination-btn" onclick="changePage(1)">1</button>
                                <?php if ($start > 2): ?>
                                    <span class="pagination-ellipsis">...</span>
                                <?php endif;
                            endif;

                            // Mostrar páginas ao redor da atual
                            for ($i = $start; $i <= $end; $i++): ?>
                                <button class="pagination-btn <?= $i == $pagination['current_page'] ? 'active' : '' ?>"
                                        onclick="changePage(<?= $i ?>)">
                                    <?= $i ?>
                                </button>
                            <?php endfor;

                            // Mostrar "..." se necessário no final
                            if ($end < $pagination['total_pages']):
                                if ($end < $pagination['total_pages'] - 1): ?>
                                    <span class="pagination-ellipsis">...</span>
                                <?php endif; ?>
                                <button class="pagination-btn" onclick="changePage(<?= $pagination['total_pages'] ?>)">
                                    <?= $pagination['total_pages'] ?>
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Botão Próxima Página -->
                        <button class="pagination-btn"
                                onclick="changePage(<?= $pagination['current_page'] + 1 ?>)"
                                <?= !$pagination['has_next'] ? 'disabled' : '' ?>
                                title="Próxima página">
                            <i class="fas fa-angle-right"></i>
                        </button>

                        <!-- Botão Última Página -->
                        <button class="pagination-btn"
                                onclick="changePage(<?= $pagination['total_pages'] ?>)"
                                <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : '' ?>
                                title="Última página">
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- SISTEMA DE CARDS MODAIS PARA ADMINISTRADORES -->

<!-- Overlay para todos os cards -->
<div id="cardOverlay" class="card-overlay">
    
    <!-- 1. CARD CRIAR ADMINISTRADOR -->
    <div id="createAdminCard" class="admin-card create-card">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon create-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Criar Novo Administrador</h3>
                    <p class="card-subtitle">Preencha as informações do novo administrador</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <form id="createAdminForm" class="admin-form">
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
                                <i class="fas fa-envelope"></i>Email *
                            </label>
                            <input type="email" name="email" class="form-input compact"
                                   placeholder="admin@empresa.com" required>
                        </div>

                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-phone"></i>Contacto
                            </label>
                            <input type="tel" name="contact" class="form-input compact"
                                   placeholder="+244 912 345 678">
                        </div>
                    </div>

                    <!-- Linha 2: Senha com validação compacta -->
                    <div class="form-row-password">
                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-lock"></i>Senha *
                            </label>
                            <div class="password-input-wrapper">
                                <input type="password" name="password" id="createPassword" class="form-input compact password-input"
                                       placeholder="Digite uma senha segura" required minlength="8">
                                <button type="button" class="password-toggle-btn compact" onclick="togglePasswordVisibility('createPassword')">
                                    <i class="fas fa-eye" id="createPasswordToggleIcon"></i>
                                </button>
                            </div>

                            <!-- Indicador compacto de força da senha -->
                            <div class="password-strength-compact">
                                <div class="strength-bar-mini">
                                    <div class="strength-fill" id="createPasswordStrengthFill"></div>
                                </div>
                                <span class="strength-text-mini" id="createPasswordStrengthText">Força da senha</span>
                            </div>

                            <!-- Requisitos compactos (ocultos por padrão) -->
                            <div class="password-requirements-compact" id="createPasswordRequirements">
                                <div class="requirements-grid">
                                    <div class="requirement compact" id="req-length">
                                        <i class="requirement-icon-mini"></i><span>8+ chars</span>
                                    </div>
                                    <div class="requirement compact" id="req-uppercase">
                                        <i class="requirement-icon-mini"></i><span>A-Z</span>
                                    </div>
                                    <div class="requirement compact" id="req-lowercase">
                                        <i class="requirement-icon-mini"></i><span>a-z</span>
                                    </div>
                                    <div class="requirement compact" id="req-number">
                                        <i class="requirement-icon-mini"></i><span>0-9</span>
                                    </div>
                                    <div class="requirement compact" id="req-special">
                                        <i class="requirement-icon-mini"></i><span>!@#</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Linha 3: Configurações em linha horizontal -->
                    <div class="form-row-configs">
                        <div class="form-group compact half-width">
                            <label class="form-label compact">
                                <i class="fas fa-building"></i>Tipo de Conta *
                            </label>
                            <select name="accountTypeId" class="form-select compact" required>
                                <option value="">Selecionar...</option>
                                <?php if (!empty($accountTypes)): ?>
                                    <?php foreach ($accountTypes as $type): ?>
                                        <option value="<?= $type['id'] ?>"
                                                <?= $type['id'] == 1 ? 'selected' : '' ?>>
                                            <?= e($type['type']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1" selected>INDIVIDUAL</option>
                                    <option value="2">CORPORATE</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group compact half-width">
                            <label class="form-label compact">
                                <i class="fas fa-toggle-on"></i>Estado *
                            </label>
                            <select name="stateId" class="form-select compact" required>
                                <option value="">Selecionar...</option>
                                <?php if (!empty($states)): ?>
                                    <?php foreach ($states as $state): ?>
                                        <option value="<?= $state['id'] ?>"
                                                <?= $state['id'] == 1 ? 'selected' : '' ?>>
                                            <?= e($state['state']) ?>
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

                    <!-- Linha 4: Imagem opcional (colapsível) -->
                    <div class="form-row-optional">
                        <div class="optional-section">
                            <button type="button" class="optional-toggle" onclick="toggleOptionalFields()">
                                <i class="fas fa-chevron-right" id="optionalToggleIcon"></i>
                                <span>Configurações Opcionais</span>
                            </button>
                            <div class="optional-content" id="optionalFields" style="display: none;">
                                <div class="image-upload-section">
                                    <div class="upload-options-header">
                                        <h5 class="upload-section-title">
                                            <i class="fas fa-image"></i>
                                            Imagem do Perfil
                                        </h5>
                                        <div class="upload-method-toggle">
                                            <button type="button" class="method-btn active" data-method="url" onclick="switchUploadMethod('url')">
                                                <i class="fas fa-link"></i>URL
                                            </button>
                                            <button type="button" class="method-btn" data-method="file" onclick="switchUploadMethod('file')">
                                                <i class="fas fa-upload"></i>Upload
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Método URL -->
                                    <div class="upload-method-content" id="urlMethod">
                                        <div class="form-group compact">
                                            <label class="form-label compact">
                                                <i class="fas fa-link"></i>URL da Imagem
                                            </label>
                                            <div class="url-input-wrapper">
                                                <input type="url" name="img" id="imageUrl" class="form-input compact"
                                                       placeholder="https://exemplo.com/imagem.jpg"
                                                       onchange="previewImageFromUrl(this.value)">
                                                <button type="button" class="url-preview-btn" onclick="previewImageFromUrl(document.getElementById('imageUrl').value)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <small class="form-hint compact">Cole a URL direta da imagem</small>
                                        </div>
                                    </div>

                                    <!-- Método Upload -->
                                    <div class="upload-method-content" id="fileMethod" style="display: none;">
                                        <div class="form-group compact">
                                            <label class="form-label compact">
                                                <i class="fas fa-upload"></i>Selecionar Arquivo
                                            </label>
                                            <div class="file-upload-area" onclick="document.getElementById('imageFile').click()">
                                                <input type="file" id="imageFile" name="imageFile" accept="image/*"
                                                       style="display: none;" onchange="handleFileUpload(this)">
                                                <div class="upload-placeholder" id="uploadPlaceholder">
                                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                    <span class="upload-text">Clique para selecionar arquivo</span>
                                                    <small class="upload-hint">JPG, PNG, GIF até 5MB</small>
                                                </div>
                                                <div class="upload-preview" id="uploadPreview" style="display: none;">
                                                    <img id="previewImage" src="" alt="Preview">
                                                    <div class="preview-overlay">
                                                        <button type="button" class="change-file-btn" onclick="document.getElementById('imageFile').click()">
                                                            <i class="fas fa-edit"></i>Alterar
                                                        </button>
                                                        <button type="button" class="remove-file-btn" onclick="removeFileUpload()">
                                                            <i class="fas fa-trash"></i>Remover
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preview Global -->
                                    <div class="image-preview-section" id="imagePreviewSection" style="display: none;">
                                        <label class="form-label compact">
                                            <i class="fas fa-eye"></i>Preview
                                        </label>
                                        <div class="global-image-preview">
                                            <img id="globalPreviewImage" src="" alt="Preview da imagem">
                                            <div class="preview-info">
                                                <span class="preview-status">✅ Imagem carregada</span>
                                                <button type="button" class="clear-preview-btn" onclick="clearImagePreview()">
                                                    <i class="fas fa-times"></i>Limpar
                                                </button>
                                            </div>
                                        </div>
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
                <button type="submit" form="createAdminForm" class="btn-create">
                    <i class="fas fa-user-plus"></i>
                    Criar Administrador
                </button>
            </div>
        </div>
    </div>
    
    <!-- 2. CARD VISUALIZAR ADMINISTRADOR -->
    <div id="viewAdminCard" class="admin-card view-card">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon view-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Detalhes do Administrador</h3>
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
                        <div class="profile-avatar-large" id="viewAdminAvatar">
                            <img id="viewAdminImage" src="" alt="Avatar" style="display: none;">
                            <span id="viewAdminInitials">JS</span>
                        </div>
                        <div class="avatar-status-indicator" id="viewAvatarStatus">
                            <i class="fas fa-circle"></i>
                        </div>
                    </div>
                    <div class="profile-main-info">
                        <h4 class="profile-name" id="viewAdminName">Nome do Administrador</h4>
                        <p class="profile-email" id="viewAdminEmailHeader">email@exemplo.com</p>
                        <div class="profile-badges">
                            <div class="status-badge" id="viewStatusBadge">
                                <i class="fas fa-circle"></i>
                                <span id="viewStatusText">Ativo</span>
                            </div>
                            <div class="account-type-badge" id="viewAccountTypeBadge">
                                <i class="fas fa-user-shield"></i>
                                <span id="viewAccountTypeText">Administrador</span>
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
                                    <div class="info-value-modern" id="viewAdminId">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-user-circle info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Nome de Usuário</label>
                                    <div class="info-value-modern username-value" id="viewUsername">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-building info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Tipo de Conta</label>
                                    <div class="info-value-modern" id="viewAccountTypeDetail">-</div>
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
                    Editar Administrador
                </button>
            </div>
        </div>
    </div>
    
    <!-- 3. CARD EDITAR ADMINISTRADOR -->
    <div id="editAdminCard" class="admin-card edit-card">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon edit-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Editar Administrador</h3>
                    <p class="card-subtitle">Atualize as informações e configurações da conta</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <form id="editAdminForm" class="admin-form">
                <?= csrfField() ?>
                <?= methodField('PUT') ?>
                <input type="hidden" name="admin_id" id="editAdminId">
                
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
                                <i class="fas fa-envelope"></i>Email *
                            </label>
                            <input type="email" name="email" id="editEmail" class="form-input compact"
                                   placeholder="admin@empresa.com" required>
                        </div>

                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-phone"></i>Contacto
                            </label>
                            <input type="tel" name="contact" id="editContact" class="form-input compact"
                                   placeholder="+244 912 345 678">
                        </div>
                    </div>

                    <!-- Linha 2: Senha com validação compacta -->
                    <div class="form-row-password">
                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-lock"></i>Nova Senha (opcional)
                            </label>
                            <div class="password-input-wrapper">
                                <input type="password" name="password" id="editPassword" class="form-input compact password-input"
                                       placeholder="Digite uma nova senha (deixe vazio para manter atual)" minlength="8">
                                <button type="button" class="password-toggle-btn compact" onclick="togglePasswordVisibility('editPassword')">
                                    <i class="fas fa-eye" id="editPasswordToggleIcon"></i>
                                </button>
                            </div>

                            <!-- Indicador compacto de força da senha -->
                            <div class="password-strength-compact">
                                <div class="strength-bar-mini">
                                    <div class="strength-fill" id="editPasswordStrengthFill"></div>
                                </div>
                                <span class="strength-text-mini" id="editPasswordStrengthText">Força da senha</span>
                            </div>

                            <!-- Requisitos compactos (ocultos por padrão) -->
                            <div class="password-requirements-compact" id="editPasswordRequirements">
                                <div class="requirements-grid">
                                    <div class="requirement compact" id="edit-req-length">
                                        <i class="requirement-icon-mini"></i><span>8+ chars</span>
                                    </div>
                                    <div class="requirement compact" id="edit-req-uppercase">
                                        <i class="requirement-icon-mini"></i><span>A-Z</span>
                                    </div>
                                    <div class="requirement compact" id="edit-req-lowercase">
                                        <i class="requirement-icon-mini"></i><span>a-z</span>
                                    </div>
                                    <div class="requirement compact" id="edit-req-number">
                                        <i class="requirement-icon-mini"></i><span>0-9</span>
                                    </div>
                                    <div class="requirement compact" id="edit-req-special">
                                        <i class="requirement-icon-mini"></i><span>!@#</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Linha 3: Configurações em linha horizontal -->
                    <div class="form-row-configs">
                        <div class="form-group compact half-width">
                            <label class="form-label compact">
                                <i class="fas fa-building"></i>Tipo de Conta *
                            </label>
                            <select name="accountTypeId" id="editAccountTypeId" class="form-select compact" required>
                                <option value="">Selecionar...</option>
                                <?php if (!empty($accountTypes)): ?>
                                    <?php foreach ($accountTypes as $type): ?>
                                        <option value="<?= $type['id'] ?>">
                                            <?= e($type['type']) ?>
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
                            <select name="stateId" id="editStateId" class="form-select compact" required>
                                <option value="">Selecionar...</option>
                                <?php if (!empty($states)): ?>
                                    <?php foreach ($states as $state): ?>
                                        <option value="<?= $state['id'] ?>">
                                            <?= e($state['state']) ?>
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

                    <!-- Linha 4: Imagem opcional (colapsível) -->
                    <div class="form-row-optional">
                        <div class="optional-section">
                            <button type="button" class="optional-toggle" onclick="toggleOptionalFieldsEdit()">
                                <i class="fas fa-chevron-right" id="optionalToggleIconEdit"></i>
                                <span>Configurações de Imagem</span>
                            </button>
                            <div class="optional-content" id="optionalFieldsEdit" style="display: none;">
                                <div class="image-upload-section">
                                    <div class="upload-options-header">
                                        <h5 class="upload-section-title">
                                            <i class="fas fa-image"></i>
                                            Imagem do Perfil
                                        </h5>
                                        <div class="upload-method-toggle">
                                            <button type="button" class="method-btn active" data-method="url" onclick="switchUploadMethodEdit('url')">
                                                <i class="fas fa-link"></i>URL
                                            </button>
                                            <button type="button" class="method-btn" data-method="file" onclick="switchUploadMethodEdit('file')">
                                                <i class="fas fa-upload"></i>Upload
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Método URL -->
                                    <div class="upload-method-content" id="urlMethodEdit">
                                        <div class="form-group compact">
                                            <label class="form-label compact">
                                                <i class="fas fa-link"></i>URL da Imagem
                                            </label>
                                            <div class="url-input-wrapper">
                                                <input type="url" name="img" id="editImageUrl" class="form-input compact"
                                                       placeholder="https://exemplo.com/imagem.jpg"
                                                       onchange="previewImageFromUrlEdit(this.value)">
                                                <button type="button" class="url-preview-btn" onclick="previewImageFromUrlEdit(document.getElementById('editImageUrl').value)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <small class="form-hint compact">Cole a URL direta da imagem</small>
                                        </div>
                                    </div>

                                    <!-- Método Upload -->
                                    <div class="upload-method-content" id="fileMethodEdit" style="display: none;">
                                        <div class="form-group compact">
                                            <label class="form-label compact">
                                                <i class="fas fa-upload"></i>Selecionar Arquivo
                                            </label>
                                            <div class="file-upload-area" onclick="document.getElementById('editImageFile').click()">
                                                <input type="file" id="editImageFile" name="imageFile" accept="image/*"
                                                       style="display: none;" onchange="handleFileUploadEdit(this)">
                                                <div class="upload-placeholder" id="uploadPlaceholderEdit">
                                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                    <span class="upload-text">Clique para selecionar arquivo</span>
                                                    <small class="upload-hint">JPG, PNG, GIF até 5MB</small>
                                                </div>
                                                <div class="upload-preview" id="uploadPreviewEdit" style="display: none;">
                                                    <img id="previewImageEdit" src="" alt="Preview">
                                                    <div class="preview-overlay">
                                                        <button type="button" class="change-file-btn" onclick="document.getElementById('editImageFile').click()">
                                                            <i class="fas fa-edit"></i>Alterar
                                                        </button>
                                                        <button type="button" class="remove-file-btn" onclick="removeFileUploadEdit()">
                                                            <i class="fas fa-trash"></i>Remover
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preview Global -->
                                    <div class="image-preview-section" id="imagePreviewSectionEdit" style="display: none;">
                                        <label class="form-label compact">
                                            <i class="fas fa-eye"></i>Preview
                                        </label>
                                        <div class="global-image-preview">
                                            <img id="globalPreviewImageEdit" src="" alt="Preview da imagem">
                                            <div class="preview-info">
                                                <span class="preview-status">✅ Imagem carregada</span>
                                                <button type="button" class="clear-preview-btn" onclick="clearImagePreviewEdit()">
                                                    <i class="fas fa-times"></i>Limpar
                                                </button>
                                            </div>
                                        </div>
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
                <button type="submit" form="editAdminForm" class="btn-save">
                    <i class="fas fa-save"></i>
                    Salvar Alterações
                </button>
            </div>
        </div>
    </div>
    
    <!-- 4. CARD ELIMINAR ADMINISTRADOR -->
    <div id="deleteAdminCard" class="admin-card delete-card">
        <div class="card-header">
            <div class="card-header-content">
                <div class="card-icon delete-icon">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <div class="card-title-group">
                    <h3 class="card-title">Eliminar Administrador</h3>
                    <p class="card-subtitle">Esta ação não pode ser desfeita</p>
                </div>
            </div>
            <button class="card-close-btn" onclick="closeCard()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <div class="delete-confirmation">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                
                <div class="confirmation-content">
                    <h4 class="confirmation-title">Tem certeza que deseja eliminar este administrador?</h4>
                    <p class="confirmation-text">
                        Está prestes a eliminar permanentemente a conta do administrador 
                        <strong id="deleteAdminName" class="highlight-name">Nome do Administrador</strong>.
                    </p>
                    
                    <div class="consequences-list">
                        <h5 class="consequences-title">O que acontecerá:</h5>
                        <ul class="consequences">
                            <li><i class="fas fa-times-circle"></i> A conta será removida permanentemente</li>
                            <li><i class="fas fa-times-circle"></i> O administrador perderá acesso ao sistema</li>
                            <li><i class="fas fa-times-circle"></i> Todas as sessões ativas serão encerradas</li>
                            <li><i class="fas fa-info-circle"></i> Histórico de ações será mantido para auditoria</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <div class="footer-actions danger-actions">
                <button type="button" class="btn-cancel safe-cancel" onclick="closeCard()">
                    <i class="fas fa-shield-alt"></i>
                    Manter Seguro
                </button>
                <button type="button" class="btn-delete-confirm" onclick="confirmDelete()">
                    <i class="fas fa-trash-alt"></i>
                    Sim, Eliminar Definitivamente
                </button>
            </div>
        </div>
    </div>
    
</div>

<script>
// ===========================================
// SISTEMA DE CARDS MODAIS PARA ADMINISTRADORES
// ===========================================

// Variável global para armazenar dados do admin atual
let currentAdminData = null;
let currentAdminId = null;

// Dados mockados para demonstração (substituir pela API real)
const mockAdmins = <?= json_encode($accounts ?? []) ?>;

// ===========================================
// FUNÇÕES PRINCIPAIS DOS CARDS
// ===========================================

// 1. CRIAR ADMINISTRADOR
function openCreateCard() {
    showCard('createAdminCard');
    resetCreateForm();
}

function resetCreateForm() {
    const form = document.getElementById('createAdminForm');
    if (form) {
        form.reset();
        // Selecionar valores padrão
        const accountTypeSelect = form.querySelector('select[name="accountTypeId"]');
        if (accountTypeSelect) {
            accountTypeSelect.value = '1'; // INDIVIDUAL - Back Office
        }

        const stateSelect = form.querySelector('select[name="stateId"]');
        if (stateSelect) {
            stateSelect.value = '1'; // ACTIVE
        }

        // Resetar indicador de senha
        resetPasswordStrength('createPassword');
    }
}

function resetPasswordStrength(inputId) {
    const strengthFill = document.getElementById(inputId + 'StrengthFill');
    const strengthText = document.getElementById(inputId + 'StrengthText');
    const requirementsContainer = document.getElementById(inputId + 'Requirements');

    if (strengthFill) strengthFill.className = 'strength-fill';
    if (strengthText) {
        strengthText.textContent = 'Digite uma senha';
        strengthText.className = 'strength-text';
    }
    if (requirementsContainer) requirementsContainer.classList.remove('show');
}

function setupPasswordValidation(inputId) {
    const passwordInput = document.getElementById(inputId);
    if (passwordInput) {
        // Remover listeners existentes
        passwordInput.removeEventListener('input', passwordInput.strengthHandler);
        passwordInput.removeEventListener('focus', passwordInput.focusHandler);
        passwordInput.removeEventListener('blur', passwordInput.blurHandler);

        // Adicionar novos listeners
        passwordInput.strengthHandler = function() {
            updatePasswordStrength(inputId);
        };

        passwordInput.focusHandler = function() {
            if (this.value.length > 0) {
                document.getElementById(inputId + 'Requirements').classList.add('show');
            }
        };

        passwordInput.blurHandler = function() {
            if (this.value.length === 0) {
                document.getElementById(inputId + 'Requirements').classList.remove('show');
            }
        };

        passwordInput.addEventListener('input', passwordInput.strengthHandler);
        passwordInput.addEventListener('focus', passwordInput.focusHandler);
        passwordInput.addEventListener('blur', passwordInput.blurHandler);
    }
}

// 2. VISUALIZAR ADMINISTRADOR
function openViewCard(id) {
    const admin = getAdminById(id);
    if (admin) {
        currentAdminData = admin;
        currentAdminId = id;
        populateViewCard(admin);
        showCard('viewAdminCard');
    }
}

function populateViewCard(admin) {
    try {
        // Header principal com avatar e informações
        const avatarElement = document.getElementById('viewAdminAvatar');
        const imageElement = document.getElementById('viewAdminImage');
        const initialsElement = document.getElementById('viewAdminInitials');

        // Configurar avatar
        if (imageElement && initialsElement) {
            if (admin.image_url) {
                imageElement.src = admin.image_url;
                imageElement.style.display = 'block';
                initialsElement.style.display = 'none';
            } else {
                imageElement.style.display = 'none';
                initialsElement.style.display = 'flex';
                initialsElement.textContent = getInitials(admin.name || admin.email);
            }
        }

        // Nome e email no header
        const nameElement = document.getElementById('viewAdminName');
        const emailHeaderElement = document.getElementById('viewAdminEmailHeader');

        if (nameElement) nameElement.textContent = admin.name || 'Nome não informado';
        if (emailHeaderElement) emailHeaderElement.textContent = admin.email || 'Email não informado';

        // Status badge no header
        const isActive = (admin.state || admin.is_active) === 'ACTIVE' || admin.is_active === true || admin.is_active === 1;
        const statusBadge = document.getElementById('viewStatusBadge');
        const statusText = document.getElementById('viewStatusText');
        const avatarStatus = document.getElementById('viewAvatarStatus');

        if (statusBadge && statusText && avatarStatus) {
            if (isActive) {
                statusBadge.className = 'status-badge active';
                statusText.textContent = 'Ativo';
                avatarStatus.className = 'avatar-status-indicator active';
            } else {
                statusBadge.className = 'status-badge inactive';
                statusText.textContent = 'Inativo';
                avatarStatus.className = 'avatar-status-indicator inactive';
            }
        }

        // Account type badge no header
        const accountTypeBadge = document.getElementById('viewAccountTypeBadge');
        if (accountTypeBadge) {
            accountTypeBadge.innerHTML = `
                <i class="fas fa-shield-alt"></i>
                <span>${admin.role_name || 'Administrador'}</span>
            `;
        }

        // Informações pessoais nos cards
        const fullNameElement = document.getElementById('viewFullName');
        const emailElement = document.getElementById('viewEmail');
        const contactElement = document.getElementById('viewContact');

        if (fullNameElement) fullNameElement.textContent = admin.name || 'Não informado';
        if (emailElement) emailElement.textContent = admin.email || 'Não informado';
        if (contactElement) contactElement.textContent = admin.contact || 'Não informado';

        // Informações da conta
        const usernameElement = document.getElementById('viewUsername');
        const createdAtElement = document.getElementById('viewCreatedAt');
        const updatedAtElement = document.getElementById('viewUpdatedAt');
        const lastLoginElement = document.getElementById('viewLastLogin');

        if (usernameElement) usernameElement.textContent = admin.username || 'Não informado';
        if (createdAtElement) createdAtElement.textContent = formatDate(admin.createdAt) || 'Não disponível';
        if (updatedAtElement) updatedAtElement.textContent = formatDate(admin.updatedAt) || 'Não disponível';
        if (lastLoginElement) lastLoginElement.textContent = admin.last_login ? formatDate(admin.last_login) : 'Nunca acessou';

        // ID do administrador
        const idElement = document.getElementById('viewAdminId');
        if (idElement) {
            idElement.textContent = admin.id || 'N/A';
        }

        // Account type detail
        const accountTypeDetailElement = document.getElementById('viewAccountTypeDetail');
        if (accountTypeDetailElement) {
            accountTypeDetailElement.textContent = admin.role_name || 'Administrador';
        }

    } catch (error) {
        console.error('Error in populateViewCard:', error);
    }
}

// 3. EDITAR ADMINISTRADOR
function openEditCard(id) {
    const admin = getAdminById(id);
    if (admin) {
        currentAdminData = admin;
        currentAdminId = id;
        populateEditCard(admin);
        showCard('editAdminCard');
    }
}

function openEditCardFromView() {
    if (currentAdminId) {
        closeCard();
        setTimeout(() => openEditCard(currentAdminId), 300);
    }
}

function populateEditCard(admin) {
    // Preencher ID do admin
    document.getElementById('editAdminId').value = admin.id;

    // Usar a nova função de carregamento de dados
    loadEditAdminData(admin);

    // Resetar campos opcionais de imagem
    hideGlobalPreviewEdit();
    const optionalFields = document.getElementById('optionalFieldsEdit');
    if (optionalFields) {
        optionalFields.style.display = 'none';
        const toggleIcon = document.getElementById('optionalToggleIconEdit');
        if (toggleIcon) {
            toggleIcon.style.transform = 'rotate(0deg)';
        }
    }

    // Garantir que o método URL está ativo por padrão
    switchUploadMethodEdit('url');
}

// 4. ELIMINAR ADMINISTRADOR
function openDeleteCard(id, name) {
    currentAdminId = id;
    document.getElementById('deleteAdminName').textContent = name || 'Administrador';
    showCard('deleteAdminCard');
}

// ===========================================
// FUNÇÕES DE CONTROLE DOS CARDS
// ===========================================

function showCard(cardId) {
    const overlay = document.getElementById('cardOverlay');
    const cards = document.querySelectorAll('.admin-card');

    // Ocultar todos os cards
    cards.forEach(card => card.classList.remove('active'));

    // Mostrar o card específico
    document.getElementById(cardId).classList.add('active');
    overlay.classList.add('active');

    // Prevenir scroll do body
    document.body.style.overflow = 'hidden';

    // Focus no primeiro input do card
    setTimeout(() => {
        const firstInput = document.querySelector(`#${cardId} input, #${cardId} select, #${cardId} textarea`);
        if (firstInput) firstInput.focus();
    }, 100);

    // Configurar validador de senha se for o card de criar
    if (cardId === 'createAdminCard') {
        setupPasswordValidation('createPassword');
    }
}

function closeCard() {
    const overlay = document.getElementById('cardOverlay');
    const cards = document.querySelectorAll('.admin-card');
    
    // Ocultar todos os cards
    cards.forEach(card => card.classList.remove('active'));
    overlay.classList.remove('active');
    
    // Restaurar scroll do body
    document.body.style.overflow = 'auto';
    
    // Limpar dados temporários
    currentAdminData = null;
    currentAdminId = null;
}

// ===========================================
// FUNÇÕES DE SUBMISSÃO DOS FORMULÁRIOS
// ===========================================

function confirmDelete() {
    if (currentAdminId) {
        performDelete(currentAdminId);
    }
}

async function performDelete(id) {
    try {
        showLoading('Eliminando administrador...');
        
        const response = await fetch(`<?= url('/accounts') ?>/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });
        
        hideLoading();
        closeCard();
        
        if (response.ok) {
            showAlert('Administrador eliminado com sucesso!', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            const errorData = await response.json().catch(() => ({}));
            showAlert(errorData.message || 'Erro ao eliminar administrador', 'danger');
        }
    } catch (error) {
        hideLoading();
        closeCard();
        showAlert('Erro de conexão: ' + error.message, 'danger');
    }
}

// ===========================================
// FUNÇÕES AUXILIARES
// ===========================================

function getAdminById(id) {
    return mockAdmins.find(admin => admin.id == id) || null;
}

function getInitials(name) {
    if (!name) return 'AD';
    const words = name.trim().split(' ');
    if (words.length >= 2) {
        return (words[0][0] + words[1][0]).toUpperCase();
    }
    return name.substring(0, 2).toUpperCase();
}

function formatDate(dateString) {
    if (!dateString) return null;
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
        return dateString;
    }
}

function showLoading(message = 'Processando...') {
    // Remove existing loading
    hideLoading();

    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'loadingOverlay';
    loadingOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease;
    `;

    loadingOverlay.innerHTML = `
        <div style="
            background: white;
            border-radius: 16px;
            padding: 2rem 3rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 1rem;
            max-width: 400px;
        ">
            <div style="
                width: 24px;
                height: 24px;
                border: 3px solid #e5e7eb;
                border-top: 3px solid #3b82f6;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            "></div>
            <span style="
                color: #1f2937;
                font-weight: 500;
                font-size: 1rem;
            ">${message}</span>
        </div>
    `;

    // Add CSS animations if not exists
    if (!document.getElementById('loadingAnimations')) {
        const style = document.createElement('style');
        style.id = 'loadingAnimations';
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(loadingOverlay);
}

function hideLoading() {
    const existingLoading = document.getElementById('loadingOverlay');
    if (existingLoading) {
        existingLoading.remove();
    }
}

function showAlert(message, type) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.admin-alert');
    existingAlerts.forEach(alert => alert.remove());

    const alert = document.createElement('div');
    alert.className = `admin-alert alert-${type}`;
    alert.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        min-width: 320px;
        max-width: 500px;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        background: ${type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #ef4444, #dc2626)'};
        color: white;
        font-weight: 500;
        animation: slideInAlert 0.3s ease;
    `;

    alert.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}" style="font-size: 1.25rem;"></i>
            <div style="flex: 1; line-height: 1.4;">${message}</div>
            <button type="button" onclick="this.parentElement.parentElement.remove()"
                    style="background: none; border: none; color: white; font-size: 1.25rem; cursor: pointer; padding: 0; margin-left: 0.5rem;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    // Add CSS animation
    if (!document.getElementById('alertAnimations')) {
        const style = document.createElement('style');
        style.id = 'alertAnimations';
        style.textContent = `
            @keyframes slideInAlert {
                from {
                    opacity: 0;
                    transform: translateX(100%);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(alert);

    // Auto-remove after 6 seconds for errors, 4 seconds for success
    const timeout = type === 'success' ? 4000 : 6000;
    setTimeout(() => {
        if (alert && alert.parentElement) {
            alert.style.animation = 'slideInAlert 0.3s ease reverse';
            setTimeout(() => alert.remove(), 300);
        }
    }, timeout);
}

// ===========================================
// VALIDAÇÃO DE SENHA FORTE
// ===========================================

function togglePasswordVisibility(inputId) {
    const passwordInput = document.getElementById(inputId);
    const toggleIcon = document.getElementById(inputId + 'ToggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        toggleIcon.className = 'fas fa-eye';
    }
}

function checkPasswordStrength(password) {
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password),
        special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
    };

    const validCount = Object.values(requirements).filter(Boolean).length;

    let strength = 'weak';
    let score = 0;

    if (validCount >= 5) {
        strength = 'strong';
        score = 4;
    } else if (validCount >= 4) {
        strength = 'good';
        score = 3;
    } else if (validCount >= 2) {
        strength = 'fair';
        score = 2;
    } else if (validCount >= 1) {
        strength = 'weak';
        score = 1;
    }

    return {
        strength,
        score,
        requirements,
        validCount
    };
}

function updatePasswordStrength(inputId) {
    const passwordInput = document.getElementById(inputId);
    const password = passwordInput.value;
    const strengthFill = document.getElementById(inputId + 'StrengthFill');
    const strengthText = document.getElementById(inputId + 'StrengthText');
    const requirementsContainer = document.getElementById(inputId + 'Requirements');

    if (password.length === 0) {
        strengthFill.className = 'strength-fill';

        // Detectar se é layout compacto
        const isCompact = strengthText.classList.contains('strength-text-mini');
        strengthText.textContent = isCompact ? 'Força da senha' : 'Digite uma senha';
        strengthText.className = isCompact ? 'strength-text-mini' : 'strength-text';

        requirementsContainer.classList.remove('show');
        return;
    }

    const result = checkPasswordStrength(password);

    // Atualizar barra de força
    strengthFill.className = `strength-fill ${result.strength}`;

    // Atualizar texto de força baseado no layout
    const isCompact = strengthText.classList.contains('strength-text-mini');

    if (isCompact) {
        // Textos compactos
        const compactTexts = {
            weak: 'Fraca',
            fair: 'Razoável',
            good: 'Boa',
            strong: 'Forte'
        };
        strengthText.textContent = compactTexts[result.strength];
        strengthText.className = `strength-text-mini ${result.strength}`;
    } else {
        // Textos completos
        const strengthTexts = {
            weak: '🔴 Fraca - Adicione mais caracteres',
            fair: '🟡 Razoável - Quase lá!',
            good: '🔵 Boa - Senha segura',
            strong: '🟢 Forte - Excelente segurança!'
        };
        strengthText.textContent = strengthTexts[result.strength];
        strengthText.className = `strength-text ${result.strength}`;
    }

    // Mostrar requisitos
    requirementsContainer.classList.add('show');

    // Atualizar requisitos individuais
    const reqElements = {
        'req-length': result.requirements.length,
        'req-uppercase': result.requirements.uppercase,
        'req-lowercase': result.requirements.lowercase,
        'req-number': result.requirements.number,
        'req-special': result.requirements.special
    };

    for (const [reqId, isValid] of Object.entries(reqElements)) {
        const reqElement = document.getElementById(reqId);
        if (reqElement) {
            const baseClass = reqElement.classList.contains('compact') ? 'requirement compact' : 'requirement';
            reqElement.className = `${baseClass} ${isValid ? 'valid' : 'invalid'}`;
        }
    }
}

// Função para alternar campos opcionais
function toggleOptionalFields() {
    const optionalFields = document.getElementById('optionalFields');
    const toggleIcon = document.getElementById('optionalToggleIcon');
    const toggleBtn = document.querySelector('.optional-toggle');

    if (optionalFields.style.display === 'none') {
        optionalFields.style.display = 'block';
        toggleIcon.style.transform = 'rotate(90deg)';
        toggleBtn.classList.add('expanded');
    } else {
        optionalFields.style.display = 'none';
        toggleIcon.style.transform = 'rotate(0deg)';
        toggleBtn.classList.remove('expanded');
    }
}

// ===========================================
// SISTEMA DE UPLOAD DUPLO DE IMAGEM
// ===========================================

// Alternar entre métodos de upload
function switchUploadMethod(method) {
    const urlMethod = document.getElementById('urlMethod');
    const fileMethod = document.getElementById('fileMethod');
    const urlBtn = document.querySelector('[data-method="url"]');
    const fileBtn = document.querySelector('[data-method="file"]');

    // Reset active states
    urlBtn.classList.remove('active');
    fileBtn.classList.remove('active');

    // Hide both methods
    urlMethod.style.display = 'none';
    fileMethod.style.display = 'none';

    // Show selected method
    if (method === 'url') {
        urlMethod.style.display = 'block';
        urlBtn.classList.add('active');
        // Clear file input when switching to URL
        const fileInput = document.getElementById('imageFile');
        if (fileInput) fileInput.value = '';
        hideFilePreview();
    } else {
        fileMethod.style.display = 'block';
        fileBtn.classList.add('active');
        // Clear URL input when switching to file
        const urlInput = document.getElementById('imageUrl');
        if (urlInput) urlInput.value = '';
        hideGlobalPreview();
    }
}

// Preview de imagem via URL
function previewImageFromUrl(url) {
    if (!url || url.trim() === '') {
        hideGlobalPreview();
        return;
    }

    // Validar se é uma URL válida de imagem
    const imageExtensions = /\.(jpg|jpeg|png|gif|webp|svg|bmp)(\?.*)?$/i;
    if (!imageExtensions.test(url)) {
        showImageError('URL deve apontar para uma imagem válida (JPG, PNG, GIF, etc.)');
        return;
    }

    const globalPreview = document.getElementById('globalPreviewImage');
    const previewSection = document.getElementById('imagePreviewSection');
    const statusText = document.querySelector('.preview-status');

    // Mostrar loading
    statusText.textContent = '⏳ Carregando imagem...';
    statusText.style.color = '#f59e0b';
    previewSection.style.display = 'block';

    // Carregar imagem
    const img = new Image();
    img.onload = function() {
        globalPreview.src = url;
        statusText.textContent = '✅ Imagem URL carregada';
        statusText.style.color = '#10b981';
    };
    img.onerror = function() {
        hideGlobalPreview();
        showImageError('Não foi possível carregar a imagem da URL fornecida');
    };
    img.src = url;
}

// Manipular upload de arquivo
function handleFileUpload(input) {
    const file = input.files[0];
    if (!file) return;

    // Validar tipo de arquivo
    if (!file.type.startsWith('image/')) {
        showImageError('Por favor, selecione apenas arquivos de imagem');
        input.value = '';
        return;
    }

    // Validar tamanho (5MB max)
    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        showImageError('Arquivo muito grande. Tamanho máximo: 5MB');
        input.value = '';
        return;
    }

    // Mostrar preview do arquivo
    const reader = new FileReader();
    reader.onload = function(e) {
        showFilePreview(e.target.result, file.name);
        showGlobalPreview(e.target.result, 'upload');
    };
    reader.readAsDataURL(file);
}

// Mostrar preview do arquivo na área de upload
function showFilePreview(src, filename) {
    const placeholder = document.getElementById('uploadPlaceholder');
    const preview = document.getElementById('uploadPreview');
    const previewImg = document.getElementById('previewImage');

    placeholder.style.display = 'none';
    preview.style.display = 'flex';
    previewImg.src = src;
    previewImg.alt = filename;
}

// Ocultar preview do arquivo
function hideFilePreview() {
    const placeholder = document.getElementById('uploadPlaceholder');
    const preview = document.getElementById('uploadPreview');

    placeholder.style.display = 'flex';
    preview.style.display = 'none';
}

// Remover arquivo selecionado
function removeFileUpload() {
    const fileInput = document.getElementById('imageFile');
    fileInput.value = '';
    hideFilePreview();
    hideGlobalPreview();
}

// Mostrar preview global
function showGlobalPreview(src, type) {
    const globalPreview = document.getElementById('globalPreviewImage');
    const previewSection = document.getElementById('imagePreviewSection');
    const statusText = document.querySelector('.preview-status');

    globalPreview.src = src;
    previewSection.style.display = 'block';

    if (type === 'upload') {
        statusText.textContent = '✅ Arquivo carregado';
    } else {
        statusText.textContent = '✅ Imagem URL carregada';
    }
    statusText.style.color = '#10b981';
}

// Ocultar preview global
function hideGlobalPreview() {
    const previewSection = document.getElementById('imagePreviewSection');
    previewSection.style.display = 'none';
}

// Limpar preview global
function clearImagePreview() {
    // Determinar qual método está ativo
    const urlMethod = document.getElementById('urlMethod');
    const fileMethod = document.getElementById('fileMethod');

    if (urlMethod.style.display !== 'none') {
        // Método URL ativo
        const urlInput = document.getElementById('imageUrl');
        urlInput.value = '';
    } else {
        // Método arquivo ativo
        removeFileUpload();
    }

    hideGlobalPreview();
}

// Mostrar erro de imagem
function showImageError(message) {
    // Criar ou atualizar notificação de erro
    let errorDiv = document.getElementById('imageError');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.id = 'imageError';
        errorDiv.style.cssText = `
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        `;
        errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle"></i><span></span>`;

        // Inserir após o campo ativo
        const activeMethod = document.querySelector('.upload-method-content[style*="block"]') ||
                           document.getElementById('urlMethod');
        activeMethod.appendChild(errorDiv);
    }

    errorDiv.querySelector('span').textContent = message;
    errorDiv.style.display = 'flex';

    // Auto-remover após 5 segundos
    setTimeout(() => {
        if (errorDiv.parentNode) {
            errorDiv.parentNode.removeChild(errorDiv);
        }
    }, 5000);
}

// Configurar drag & drop na área de upload
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.querySelector('.file-upload-area');
    if (uploadArea) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const fileInput = document.getElementById('imageFile');
                fileInput.files = files;
                handleFileUpload(fileInput);
            }
        });
    }
});

// ===========================================
// SISTEMA DE UPLOAD DUPLO DE IMAGEM - MODAL EDIÇÃO
// ===========================================

// Função para alternar campos opcionais do modal de edição
function toggleOptionalFieldsEdit() {
    const optionalFields = document.getElementById('optionalFieldsEdit');
    const toggleIcon = document.getElementById('optionalToggleIconEdit');
    const toggleBtn = optionalFields.parentNode.querySelector('.optional-toggle');

    if (optionalFields.style.display === 'none') {
        optionalFields.style.display = 'block';
        toggleIcon.style.transform = 'rotate(90deg)';
        toggleBtn.classList.add('expanded');
    } else {
        optionalFields.style.display = 'none';
        toggleIcon.style.transform = 'rotate(0deg)';
        toggleBtn.classList.remove('expanded');
    }
}

// Alternar entre métodos de upload - Modal Edição
function switchUploadMethodEdit(method) {
    const urlMethod = document.getElementById('urlMethodEdit');
    const fileMethod = document.getElementById('fileMethodEdit');
    const urlBtn = document.querySelector('#optionalFieldsEdit [data-method="url"]');
    const fileBtn = document.querySelector('#optionalFieldsEdit [data-method="file"]');

    // Reset active states
    urlBtn.classList.remove('active');
    fileBtn.classList.remove('active');

    // Hide both methods
    urlMethod.style.display = 'none';
    fileMethod.style.display = 'none';

    // Show selected method
    if (method === 'url') {
        urlMethod.style.display = 'block';
        urlBtn.classList.add('active');
        // Clear file input when switching to URL
        const fileInput = document.getElementById('editImageFile');
        if (fileInput) fileInput.value = '';
        hideFilePreviewEdit();
    } else {
        fileMethod.style.display = 'block';
        fileBtn.classList.add('active');
        // Clear URL input when switching to file
        const urlInput = document.getElementById('editImageUrl');
        if (urlInput) urlInput.value = '';
        hideGlobalPreviewEdit();
    }
}

// Preview de imagem via URL - Modal Edição
function previewImageFromUrlEdit(url) {
    if (!url || url.trim() === '') {
        hideGlobalPreviewEdit();
        return;
    }

    // Validar se é uma URL válida de imagem
    const imageExtensions = /\.(jpg|jpeg|png|gif|webp|svg|bmp)(\?.*)?$/i;
    if (!imageExtensions.test(url)) {
        showImageErrorEdit('URL deve apontar para uma imagem válida (JPG, PNG, GIF, etc.)');
        return;
    }

    const globalPreview = document.getElementById('globalPreviewImageEdit');
    const previewSection = document.getElementById('imagePreviewSectionEdit');
    const statusText = previewSection.querySelector('.preview-status');

    // Mostrar loading
    statusText.textContent = '⏳ Carregando imagem...';
    statusText.style.color = '#f59e0b';
    previewSection.style.display = 'block';

    // Carregar imagem
    const img = new Image();
    img.onload = function() {
        globalPreview.src = url;
        statusText.textContent = '✅ Imagem URL carregada';
        statusText.style.color = '#10b981';
    };
    img.onerror = function() {
        hideGlobalPreviewEdit();
        showImageErrorEdit('Não foi possível carregar a imagem da URL fornecida');
    };
    img.src = url;
}

// Manipular upload de arquivo - Modal Edição
function handleFileUploadEdit(input) {
    const file = input.files[0];
    if (!file) return;

    // Validar tipo de arquivo
    if (!file.type.startsWith('image/')) {
        showImageErrorEdit('Por favor, selecione apenas arquivos de imagem');
        input.value = '';
        return;
    }

    // Validar tamanho (5MB max)
    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        showImageErrorEdit('Arquivo muito grande. Tamanho máximo: 5MB');
        input.value = '';
        return;
    }

    // Mostrar preview do arquivo
    const reader = new FileReader();
    reader.onload = function(e) {
        showFilePreviewEdit(e.target.result, file.name);
        showGlobalPreviewEdit(e.target.result, 'upload');
    };
    reader.readAsDataURL(file);
}

// Mostrar preview do arquivo na área de upload - Modal Edição
function showFilePreviewEdit(src, filename) {
    const placeholder = document.getElementById('uploadPlaceholderEdit');
    const preview = document.getElementById('uploadPreviewEdit');
    const previewImg = document.getElementById('previewImageEdit');

    placeholder.style.display = 'none';
    preview.style.display = 'flex';
    previewImg.src = src;
    previewImg.alt = filename;
}

// Ocultar preview do arquivo - Modal Edição
function hideFilePreviewEdit() {
    const placeholder = document.getElementById('uploadPlaceholderEdit');
    const preview = document.getElementById('uploadPreviewEdit');

    placeholder.style.display = 'flex';
    preview.style.display = 'none';
}

// Remover arquivo selecionado - Modal Edição
function removeFileUploadEdit() {
    const fileInput = document.getElementById('editImageFile');
    fileInput.value = '';
    hideFilePreviewEdit();
    hideGlobalPreviewEdit();
}

// Mostrar preview global - Modal Edição
function showGlobalPreviewEdit(src, type) {
    const globalPreview = document.getElementById('globalPreviewImageEdit');
    const previewSection = document.getElementById('imagePreviewSectionEdit');
    const statusText = previewSection.querySelector('.preview-status');

    globalPreview.src = src;
    previewSection.style.display = 'block';

    if (type === 'upload') {
        statusText.textContent = '✅ Arquivo carregado';
    } else {
        statusText.textContent = '✅ Imagem URL carregada';
    }
    statusText.style.color = '#10b981';
}

// Ocultar preview global - Modal Edição
function hideGlobalPreviewEdit() {
    const previewSection = document.getElementById('imagePreviewSectionEdit');
    previewSection.style.display = 'none';
}

// Limpar preview global - Modal Edição
function clearImagePreviewEdit() {
    // Determinar qual método está ativo
    const urlMethod = document.getElementById('urlMethodEdit');
    const fileMethod = document.getElementById('fileMethodEdit');

    if (urlMethod.style.display !== 'none') {
        // Método URL ativo
        const urlInput = document.getElementById('editImageUrl');
        urlInput.value = '';
    } else {
        // Método arquivo ativo
        removeFileUploadEdit();
    }

    hideGlobalPreviewEdit();
}

// Mostrar erro de imagem - Modal Edição
function showImageErrorEdit(message) {
    // Criar ou atualizar notificação de erro
    let errorDiv = document.getElementById('imageErrorEdit');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.id = 'imageErrorEdit';
        errorDiv.style.cssText = `
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        `;
        errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle"></i><span></span>`;

        // Inserir após o campo ativo
        const activeMethod = document.querySelector('#optionalFieldsEdit .upload-method-content[style*="block"]') ||
                           document.getElementById('urlMethodEdit');
        activeMethod.appendChild(errorDiv);
    }

    errorDiv.querySelector('span').textContent = message;
    errorDiv.style.display = 'flex';

    // Auto-remover após 5 segundos
    setTimeout(() => {
        if (errorDiv.parentNode) {
            errorDiv.parentNode.removeChild(errorDiv);
        }
    }, 5000);
}

// Configurar dados existentes no modal de edição
function loadEditAdminData(adminData) {
    // Carregar dados básicos conforme endpoint PUT /admins/{id}
    if (adminData.name) document.getElementById('editName').value = adminData.name;
    if (adminData.email) document.getElementById('editEmail').value = adminData.email;
    if (adminData.contact) document.getElementById('editContact').value = adminData.contact;

    // Campos específicos do endpoint
    if (adminData.accountTypeId || adminData.account_type_id) {
        const accountTypeId = adminData.accountTypeId || adminData.account_type_id;
        const accountTypeSelect = document.getElementById('editAccountTypeId');
        if (accountTypeSelect) accountTypeSelect.value = accountTypeId;
    }

    if (adminData.stateId || adminData.state_id) {
        const stateId = adminData.stateId || adminData.state_id;
        const stateSelect = document.getElementById('editStateId');
        if (stateSelect) stateSelect.value = stateId;
    }

    // Campo de senha opcional - deixar vazio (usuário preenche apenas se quiser alterar)
    const passwordInput = document.getElementById('editPassword');
    if (passwordInput) {
        passwordInput.value = '';
    }

    // Resetar indicador de senha
    resetPasswordStrength('editPassword');

    // Carregar imagem existente se houver
    if (adminData.img && adminData.img.trim() !== '') {
        const imageUrl = adminData.img;
        const urlInput = document.getElementById('editImageUrl');
        if (urlInput) {
            urlInput.value = imageUrl;
            previewImageFromUrlEdit(imageUrl);
        }
    }
}

// Adicionar evento de validação de senha para o modal de edição
document.addEventListener('DOMContentLoaded', function() {
    const editPasswordInput = document.getElementById('editPassword');
    if (editPasswordInput) {
        editPasswordInput.addEventListener('input', function() {
            updatePasswordStrengthEdit(this.value);
        });
    }
});

// Função específica para validação de senha no modal de edição
function updatePasswordStrengthEdit(password) {
    // Campo opcional - se vazio, não mostrar validação
    if (password.length === 0) {
        const strengthFill = document.getElementById('editPasswordStrengthFill');
        const strengthText = document.getElementById('editPasswordStrengthText');
        const requirementsContainer = document.getElementById('editPasswordRequirements');

        if (strengthFill) strengthFill.className = 'strength-fill';
        if (strengthText) {
            strengthText.textContent = 'Força da senha';
            strengthText.className = 'strength-text-mini';
        }
        if (requirementsContainer) requirementsContainer.classList.remove('show');
        return;
    }

    // Usar função existente adaptada
    const result = checkPasswordStrength(password);

    // Atualizar barra de força
    const strengthFill = document.getElementById('editPasswordStrengthFill');
    if (strengthFill) strengthFill.className = `strength-fill ${result.strength}`;

    // Atualizar texto de força (versão compacta)
    const strengthText = document.getElementById('editPasswordStrengthText');
    if (strengthText) {
        const compactTexts = {
            weak: 'Fraca',
            fair: 'Razoável',
            good: 'Boa',
            strong: 'Forte'
        };
        strengthText.textContent = compactTexts[result.strength];
        strengthText.className = `strength-text-mini ${result.strength}`;
    }

    // Mostrar requisitos
    const requirementsContainer = document.getElementById('editPasswordRequirements');
    if (requirementsContainer) requirementsContainer.classList.add('show');

    // Atualizar requisitos individuais
    const reqElements = {
        'edit-req-length': result.requirements.length,
        'edit-req-uppercase': result.requirements.uppercase,
        'edit-req-lowercase': result.requirements.lowercase,
        'edit-req-number': result.requirements.number,
        'edit-req-special': result.requirements.special
    };

    for (const [reqId, isValid] of Object.entries(reqElements)) {
        const reqElement = document.getElementById(reqId);
        if (reqElement) {
            reqElement.className = `requirement compact ${isValid ? 'valid' : 'invalid'}`;
        }
    }
}

// ===========================================
// FUNÇÕES DE PAGINAÇÃO
// ===========================================

function changePage(page) {
    if (page < 1) return;

    // Obter parâmetros atuais da URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentSearch = urlParams.get('search') || '';
    const currentStatus = urlParams.get('status') || '';

    // Construir nova URL com a página solicitada
    const newUrl = new URL(window.location.href);
    newUrl.searchParams.set('page', page);

    if (currentSearch) {
        newUrl.searchParams.set('search', currentSearch);
    }

    if (currentStatus) {
        newUrl.searchParams.set('status', currentStatus);
    }

    // Navegar para a nova URL
    window.location.href = newUrl.toString();
}

function goToPage(page) {
    changePage(page);
}

// ===========================================
// OUTRAS FUNÇÕES DA PÁGINA
// ==========================================="

function exportData(type) {
    const params = new URLSearchParams(window.location.search);
    params.set('export', type);
    window.location.href = `<?= url('/accounts') ?>?${params.toString()}`;
}

// ===========================================
// INICIALIZAÇÃO E EVENT LISTENERS
// ===========================================

document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidade de seleção em massa
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
    
    // Atualizar o "selecionar tudo" quando checkboxes individuais mudarem
    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = checkedCount === rowCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < rowCheckboxes.length;
            }
        });
    });
    
    // Pesquisa em tempo real com debounce
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                // Resetar para página 1 quando fazendo nova busca
                const currentUrl = new URL(window.location.href);
                const searchValue = this.value.trim();

                if (searchValue !== '') {
                    currentUrl.searchParams.set('search', searchValue);
                    currentUrl.searchParams.set('page', '1'); // Reset para página 1
                } else {
                    currentUrl.searchParams.delete('search');
                    currentUrl.searchParams.set('page', '1');
                }

                window.location.href = currentUrl.toString();
            }, 800);
        });
    }

    // Filtro de status
    const statusFilter = document.querySelector('select[name="status"]');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const currentUrl = new URL(window.location.href);
            const statusValue = this.value;

            if (statusValue !== '') {
                currentUrl.searchParams.set('status', statusValue);
            } else {
                currentUrl.searchParams.delete('status');
            }

            // Reset para página 1 quando mudando filtro
            currentUrl.searchParams.set('page', '1');
            window.location.href = currentUrl.toString();
        });
    }
    
    // Fechar cards com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCard();
        }
    });
    
    // Fechar card clicando no overlay
    document.getElementById('cardOverlay').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCard();
        }
    });
    
    // Submissão do formulário de criação
    document.getElementById('createAdminForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validar campos obrigatórios
        const requiredFields = ['name', 'email', 'password', 'accountTypeId', 'stateId'];
        const formData = new FormData(this);

        for (const field of requiredFields) {
            const value = formData.get(field);
            if (!value || value.trim() === '') {
                showAlert(`Campo ${field === 'name' ? 'Nome' : field === 'email' ? 'Email' : field === 'password' ? 'Senha' : field === 'accountTypeId' ? 'Tipo de Conta' : 'Estado'} é obrigatório`, 'danger');
                return;
            }
        }

        // Validar formato do email
        const email = formData.get('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showAlert('Por favor, insira um email válido', 'danger');
            return;
        }

        // Validar força da senha
        const password = formData.get('password');
        const passwordStrength = checkPasswordStrength(password);

        if (passwordStrength.score < 3) {
            showAlert('A senha não atende aos requisitos mínimos de segurança. Verifique os indicadores abaixo do campo senha.', 'danger');
            return;
        }

        // Preparar dados para envio (formato JSON conforme especificado)
        const adminData = {
            email: formData.get('email').trim(),
            name: formData.get('name').trim(),
            password: formData.get('password'),
            accountTypeId: parseInt(formData.get('accountTypeId')),
            stateId: parseInt(formData.get('stateId'))
        };

        // Adicionar campos opcionais apenas se preenchidos
        const img = formData.get('img');
        if (img && img.trim() !== '') {
            adminData.img = img.trim();
        }

        const contact = formData.get('contact');
        if (contact && contact.trim() !== '') {
            adminData.contact = contact.trim();
        }

        try {
            showLoading('Criando administrador...');

            const response = await fetch('<?= url('/accounts') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(adminData)
            });

            hideLoading();

            const responseData = await response.json().catch(() => ({}));

            if (response.ok || response.status === 201) {
                closeCard();
                showAlert('Administrador criado com sucesso! 🎉', 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                // Tratar erros de validação do backend
                let errorMessage = 'Erro ao criar administrador';

                if (response.status === 500) {
                    // Erro interno do servidor
                    errorMessage = `⚠️ Erro interno do servidor (Backend): O sistema backend precisa ser corrigido.
                                   Detalhes técnicos: ${responseData.message || 'Erro na validação da entidade Admin'}`;
                } else if (responseData.errors && typeof responseData.errors === 'object') {
                    // Se existem erros de campo específicos
                    const errorMessages = [];
                    for (const [field, messages] of Object.entries(responseData.errors)) {
                        if (Array.isArray(messages)) {
                            errorMessages.push(...messages);
                        } else {
                            errorMessages.push(messages);
                        }
                    }
                    errorMessage = errorMessages.join(', ');
                } else if (responseData.message) {
                    errorMessage = responseData.message;
                }

                showAlert(errorMessage, 'danger');
            }
        } catch (error) {
            hideLoading();
            showAlert('Erro de conexão: ' + error.message, 'danger');
        }
    });
    
    // Submissão do formulário de edição
    document.getElementById('editAdminForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validar senha apenas se foi preenchida (campo opcional)
        const passwordInput = document.getElementById('editPassword');
        if (passwordInput.value && passwordInput.value.trim() !== '') {
            // Se senha foi preenchida, validar força
            const passwordStrength = checkPasswordStrength(passwordInput.value);
            if (passwordStrength.validCount < 4) {
                showAlert('Se alterar a senha, ela deve atender a pelo menos 4 dos 5 requisitos de segurança', 'warning');
                passwordInput.focus();
                return;
            }
        }

        const formData = new FormData(this);
        const id = formData.get('admin_id');

        // Se senha estiver vazia, remover do FormData para não enviar
        if (!passwordInput.value || passwordInput.value.trim() === '') {
            formData.delete('password');
        }

        try {
            showLoading('Salvando alterações...');

            const response = await fetch(`<?= url('/accounts') ?>/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            hideLoading();

            if (response.ok) {
                closeCard();
                showAlert('Administrador atualizado com sucesso!', 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                const errorData = await response.json().catch(() => ({}));
                if (errorData.fieldErrors && errorData.fieldErrors.password) {
                    showAlert('Erro na senha: ' + errorData.fieldErrors.password, 'danger');
                } else {
                    showAlert(errorData.message || 'Erro ao atualizar administrador', 'danger');
                }
            }
        } catch (error) {
            hideLoading();
            showAlert('Erro de conexão: ' + error.message, 'danger');
        }
    });
});
</script>