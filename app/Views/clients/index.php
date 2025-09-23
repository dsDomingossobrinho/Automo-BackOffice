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

.password-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.password-toggle-btn.compact {
    position: absolute;
    right: 0.5rem;
    width: 2rem;
    height: 2rem;
    font-size: 0.875rem;
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.password-toggle-btn.compact:hover {
    background: #f3f4f6;
    color: #374151;
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

.strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 2px;
    width: 0%;
}

.strength-text-mini {
    font-size: 0.75rem;
    font-weight: 500;
    min-width: 90px;
    text-align: right;
    transition: color 0.2s ease;
    color: #6b7280;
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
    background: none;
    border: none;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #374151;
    font-weight: 500;
}

.optional-toggle:hover {
    background: #f1f5f9;
}

.optional-toggle i {
    transition: transform 0.2s ease;
}

.optional-toggle.expanded i {
    transform: rotate(90deg);
}

.optional-content {
    padding: 0 1rem 1rem 1rem;
    background: white;
}

/* Upload de imagem */
.image-upload-section {
    margin-top: 0.5rem;
}

.upload-options-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.upload-section-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.upload-method-toggle {
    display: flex;
    background: #f3f4f6;
    border-radius: 6px;
    overflow: hidden;
}

.method-btn {
    padding: 0.5rem 0.75rem;
    background: none;
    border: none;
    font-size: 0.75rem;
    font-weight: 500;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.method-btn.active {
    background: #3b82f6;
    color: white;
}

.method-btn:hover:not(.active) {
    background: #e5e7eb;
    color: #374151;
}

.upload-method-content {
    margin-top: 0.75rem;
}

.url-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.url-preview-btn {
    position: absolute;
    right: 0.5rem;
    width: 2rem;
    height: 2rem;
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.url-preview-btn:hover {
    background: #f3f4f6;
    color: #374151;
}

.form-hint.compact {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.file-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #f9fafb;
}

.file-upload-area:hover {
    border-color: #3b82f6;
    background: #f3f4f6;
}

.upload-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.upload-icon {
    font-size: 1.5rem;
    color: #6b7280;
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

.upload-preview {
    display: none;
    position: relative;
}

.upload-preview img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 6px;
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
    transition: opacity 0.2s ease;
    border-radius: 6px;
}

.upload-preview:hover .preview-overlay {
    opacity: 1;
}

.change-file-btn,
.remove-file-btn {
    padding: 0.375rem 0.75rem;
    border: none;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.change-file-btn {
    background: #3b82f6;
    color: white;
}

.remove-file-btn {
    background: #ef4444;
    color: white;
}

.image-preview-section {
    margin-top: 1rem;
    display: none;
}

.global-image-preview {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
}

.global-image-preview img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
}

.preview-info {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.preview-status {
    font-size: 0.75rem;
    font-weight: 500;
}

.clear-preview-btn {
    padding: 0.25rem 0.5rem;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.clear-preview-btn:hover {
    background: #dc2626;
}

/* Media queries para responsividade */
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
    }
}

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

/* Admin Card Base Styles - ESSENCIAL PARA MODAL FUNCIONAR */
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
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* ================================
   CSS DO MODAL DE VISUALIZAÇÃO
   ================================ */

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

/* Responsividade para o grid */
@media (max-width: 768px) {
    .modern-info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
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
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
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
/* =====================================
   ESTILOS DOS BOTÕES - IDÊNTICOS AOS DE ADMIN
   ===================================== */

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

/* Responsividade dos botões */
@media (max-width: 768px) {
    .card-footer {
        padding: 1rem;
    }

    .footer-actions {
        flex-direction: column-reverse;
        gap: 0.75rem;
    }

    .btn-cancel, .btn-create, .btn-edit, .btn-save, .btn-delete-confirm, .safe-cancel {
        width: 100%;
        min-width: auto;
    }
}

/* Estilos para selects pesquisáveis híbridos */
.full-width {
    width: 100%;
}

.searchable-select-container {
    position: relative;
    display: flex;
    align-items: center;
}

.searchable-select-input {
    width: 100%;
    padding-right: 2.5rem;
    cursor: pointer;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.searchable-select-input:focus {
    border-color: var(--gradient-start);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    outline: none;
}

.searchable-select-input.typing {
    cursor: text;
}

.searchable-select-arrow {
    position: absolute;
    right: 0.75rem;
    color: #6b7280;
    pointer-events: none;
    transition: transform 0.3s ease;
}

.searchable-select-arrow.open {
    transform: rotate(180deg);
}

.searchable-select-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e5e7eb;
    border-top: none;
    border-radius: 0 0 8px 8px;
    max-height: 250px;
    overflow-y: auto;
    z-index: 999999;
    display: none;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.searchable-select-dropdown.open {
    display: block !important;
}

.dropdown-option {
    padding: 0.75rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.2s ease;
    font-size: 0.9375rem;
    color: #374151;
}

.dropdown-option:hover {
    background: #f8fafc;
    color: #1f2937;
}

.dropdown-option:last-child {
    border-bottom: none;
    border-radius: 0 0 8px 8px;
}

.dropdown-option.no-results {
    color: #6b7280;
    font-style: italic;
    cursor: default;
    text-align: center;
    padding: 1rem;
}

.dropdown-option.no-results:hover {
    background: white;
    color: #6b7280;
}

.dropdown-item {
    padding: 0.875rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    font-size: 0.9375rem;
}

.dropdown-item:hover {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border-left: 3px solid var(--gradient-start);
}

.dropdown-item:last-child {
    border-bottom: none;
}

.dropdown-item.selected {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
    border-left: 3px solid #1e40af;
    font-weight: 500;
}

.dropdown-loading {
    padding: 1.5rem;
    text-align: center;
    color: #6b7280;
    font-size: 0.875rem;
}

.dropdown-loading i {
    margin-right: 0.5rem;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.dropdown-no-results {
    padding: 1.5rem;
    text-align: center;
    color: #9ca3af;
    font-size: 0.875rem;
    font-style: italic;
}

.select-loading {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e5e7eb;
    border-top: none;
    border-radius: 0 0 8px 8px;
    padding: 0.75rem;
    font-size: 0.875rem;
    color: #6b7280;
    z-index: 10;
}

.select-loading.hidden {
    display: none;
}

.select-loading i {
    margin-right: 0.5rem;
}

/* Responsividade para campos pesquisáveis */
@media (max-width: 768px) {
    .form-row-configs {
        flex-direction: column;
        gap: 1rem;
    }

    .half-width,
    .full-width {
        width: 100%;
    }
}

/* Ajustes para ícones dos campos geográficos */
.form-label compact i.fa-building-user,
.form-label compact i.fa-flag,
.form-label compact i.fa-map-marker-alt {
    color: var(--gradient-start);
    margin-right: 0.5rem;
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
            <button class="primary-action-btn" onclick="openCreateModal()">
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
                                   placeholder="Ex: João Silva Santos" value="<?= e(old('name')) ?>" required>
                        </div>

                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-envelope"></i>Email
                            </label>
                            <input type="email" name="email" class="form-input compact"
                                   placeholder="cliente@empresa.com" value="<?= e(old('email')) ?>">
                        </div>

                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-phone"></i>Contacto
                            </label>
                            <input type="tel" name="contact" class="form-input compact"
                                   placeholder="+244 912 345 678" value="<?= e(old('contact')) ?>">
                        </div>
                    </div>

                    <!-- Linha 2: Senha com validação compacta -->
                    <div class="form-row-password">
                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-lock"></i>Senha (Opcional)
                            </label>
                            <div class="password-input-wrapper">
                                <input type="password" name="password" id="createClientPassword" class="form-input compact password-input"
                                       placeholder="Deixe vazio para auto-gerar" minlength="8">
                                <button type="button" class="password-toggle-btn compact" onclick="togglePasswordVisibility('createClientPassword')">
                                    <i class="fas fa-eye" id="createClientPasswordToggleIcon"></i>
                                </button>
                            </div>

                            <!-- Indicador compacto de força da senha -->
                            <div class="password-strength-compact">
                                <div class="strength-bar-mini">
                                    <div class="strength-fill" id="createClientPasswordStrengthFill"></div>
                                </div>
                                <span class="strength-text-mini" id="createClientPasswordStrengthText">Força da senha</span>
                            </div>

                            <!-- Requisitos compactos (ocultos por padrão) -->
                            <div class="password-requirements-compact" id="createClientPasswordRequirements">
                                <div class="requirements-grid">
                                    <div class="requirement compact" id="req-client-length">
                                        <i class="requirement-icon-mini"></i><span>8+ chars</span>
                                    </div>
                                    <div class="requirement compact" id="req-client-uppercase">
                                        <i class="requirement-icon-mini"></i><span>A-Z</span>
                                    </div>
                                    <div class="requirement compact" id="req-client-lowercase">
                                        <i class="requirement-icon-mini"></i><span>a-z</span>
                                    </div>
                                    <div class="requirement compact" id="req-client-number">
                                        <i class="requirement-icon-mini"></i><span>0-9</span>
                                    </div>
                                    <div class="requirement compact" id="req-client-special">
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
                            <select name="account_type_id" class="form-select compact" required>
                                <option value="">Selecionar...</option>
                                <?php if (!empty($account_types) && is_array($account_types)): ?>
                                    <?php foreach ($account_types as $type): ?>
                                        <?php if (is_array($type) && isset($type['id'])): ?>
                                            <option value="<?= $type['id'] ?>"
                                                    <?= ($type['id'] == old('account_type_id') || (!old('account_type_id') && $type['id'] == 2)) ? 'selected' : '' ?>>
                                                <?= e($type['name'] ?? $type['type'] ?? 'Unknown') ?>
                                            </option>
                                        <?php endif; ?>
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
                                <?php if (!empty($states) && is_array($states)): ?>
                                    <?php foreach ($states as $state): ?>
                                        <?php if (is_array($state) && isset($state['id'])): ?>
                                            <option value="<?= $state['id'] ?>"
                                                    <?= ($state['id'] == old('state_id') || (!old('state_id') && $state['id'] == 1)) ? 'selected' : '' ?>>
                                                <?= e($state['state'] ?? $state['name'] ?? 'Unknown') ?>
                                            </option>
                                        <?php endif; ?>
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

                    <!-- Linha 4: Tipo de Organização -->
                    <div class="form-row-configs">
                        <div class="form-group compact half-width">
                            <label class="form-label compact">
                                <i class="fas fa-building-user"></i>Tipo de Organização *
                            </label>
                            <div class="searchable-select-container">
                                <input type="text"
                                       name="organization_type_display"
                                       class="form-input compact searchable-select-input"
                                       data-endpoint="organization-types"
                                       data-target="organization_type_id"
                                       placeholder="Selecione ou digite para buscar..."
                                       autocomplete="off"
                                       readonly>
                                <i class="fas fa-chevron-down searchable-select-arrow"></i>
                                <input type="hidden" name="organization_type_id" required>
                                <div class="searchable-select-dropdown" id="org-type-dropdown"></div>
                            </div>
                        </div>

                        <div class="form-group compact half-width">
                            <label class="form-label compact">
                                <i class="fas fa-flag"></i>País *
                            </label>
                            <div class="searchable-select-container">
                                <input type="text"
                                       name="country_display"
                                       class="form-input compact searchable-select-input"
                                       data-endpoint="countries"
                                       data-target="country_id"
                                       placeholder="Selecione ou digite para buscar..."
                                       autocomplete="off"
                                       readonly>
                                <i class="fas fa-chevron-down searchable-select-arrow"></i>
                                <input type="hidden" name="country_id" required>
                                <div class="searchable-select-dropdown" id="country-dropdown"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Linha 5: Província -->
                    <div class="form-row-configs">
                        <div class="form-group compact full-width">
                            <label class="form-label compact">
                                <i class="fas fa-map-marker-alt"></i>Província
                            </label>
                            <div class="searchable-select-container">
                                <input type="text"
                                       name="province_display"
                                       class="form-input compact searchable-select-input"
                                       data-endpoint="provinces"
                                       data-target="province_id"
                                       placeholder="Selecione ou digite para buscar..."
                                       autocomplete="off"
                                       readonly>
                                <i class="fas fa-chevron-down searchable-select-arrow"></i>
                                <input type="hidden" name="province_id">
                                <div class="searchable-select-dropdown" id="province-dropdown"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Linha 5: Imagem opcional (colapsível) -->
                    <div class="form-row-optional">
                        <div class="optional-section">
                            <button type="button" class="optional-toggle" onclick="toggleOptionalFields()">
                                <i class="fas fa-chevron-right" id="optionalClientToggleIcon"></i>
                                <span>Configurações Opcionais</span>
                            </button>
                            <div class="optional-content" id="optionalClientFields" style="display: none;">
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
                                    <div class="upload-method-content" id="urlClientMethod">
                                        <div class="form-group compact">
                                            <label class="form-label compact">
                                                <i class="fas fa-link"></i>URL da Imagem
                                            </label>
                                            <div class="url-input-wrapper">
                                                <input type="url" name="img" id="clientImageUrl" class="form-input compact"
                                                       placeholder="https://exemplo.com/imagem.jpg" value="<?= e(old('img')) ?>"
                                                       onchange="previewImageFromUrl(this.value)">
                                                <button type="button" class="url-preview-btn" onclick="previewImageFromUrl(document.getElementById('clientImageUrl').value)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <small class="form-hint compact">Cole a URL direta da imagem</small>
                                        </div>
                                    </div>

                                    <!-- Método Upload -->
                                    <div class="upload-method-content" id="fileClientMethod" style="display: none;">
                                        <div class="form-group compact">
                                            <label class="form-label compact">
                                                <i class="fas fa-upload"></i>Selecionar Arquivo
                                            </label>
                                            <div class="file-upload-area" onclick="document.getElementById('clientImageFile').click()">
                                                <input type="file" id="clientImageFile" name="image_file" accept="image/*"
                                                       style="display: none;" onchange="handleFileUpload(this)">
                                                <div class="upload-placeholder" id="clientUploadPlaceholder">
                                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                    <span class="upload-text">Clique para selecionar arquivo</span>
                                                    <small class="upload-hint">JPG, PNG, GIF até 5MB</small>
                                                </div>
                                                <div class="upload-preview" id="clientUploadPreview" style="display: none;">
                                                    <img id="clientPreviewImage" src="" alt="Preview">
                                                    <div class="preview-overlay">
                                                        <button type="button" class="change-file-btn" onclick="document.getElementById('clientImageFile').click()">
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
                                    <div class="image-preview-section" id="clientImagePreviewSection" style="display: none;">
                                        <label class="form-label compact">
                                            <i class="fas fa-eye"></i>Preview
                                        </label>
                                        <div class="global-image-preview">
                                            <img id="clientGlobalPreviewImage" src="" alt="Preview da imagem">
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

                <!-- Card Informações Empresariais -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon business">
                            <i class="fas fa-building"></i>
                        </div>
                        <h5 class="info-card-title">Informações Empresariais</h5>
                    </div>
                    <div class="info-card-content">
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-industry info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Tipo de Organização</label>
                                    <div class="info-value-modern" id="viewOrganizationType">Não informado</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-globe-africa info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">País</label>
                                    <div class="info-value-modern" id="viewCountry">Não informado</div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-item-modern">
                                <i class="fas fa-map-marker-alt info-icon"></i>
                                <div class="info-content">
                                    <label class="info-label-modern">Província</label>
                                    <div class="info-value-modern" id="viewProvince">Não informado</div>
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
            <form id="editClientForm" class="admin-form" action="javascript:void(0);">
                <?= csrfField() ?>
                <input type="hidden" name="client_id" id="editClientId">

                <!-- Layout compacto otimizado -->
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
                                <i class="fas fa-phone"></i>Contacto
                            </label>
                            <input type="tel" name="contact" id="editContact" class="form-input compact"
                                   placeholder="+244 912 345 678">
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
                                <?php if (!empty($account_types) && is_array($account_types)): ?>
                                    <?php foreach ($account_types as $type): ?>
                                        <?php if (is_array($type) && isset($type['id'])): ?>
                                            <option value="<?= $type['id'] ?>">
                                                <?= e($type['name'] ?? $type['type'] ?? 'Unknown') ?>
                                            </option>
                                        <?php endif; ?>
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
                                <?php if (!empty($states) && is_array($states)): ?>
                                    <?php foreach ($states as $state): ?>
                                        <?php if (is_array($state) && isset($state['id'])): ?>
                                            <option value="<?= $state['id'] ?>">
                                                <?= e($state['state'] ?? $state['name'] ?? 'Unknown') ?>
                                            </option>
                                        <?php endif; ?>
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

                    <!-- Linha 3: Campos Hybrid Searchable Selects -->
                    <div class="form-row-grid">
                        <!-- Tipo de Organização - Hybrid Searchable Select -->
                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-building"></i>Tipo de Organização *
                            </label>
                            <div class="searchable-select-container" id="editOrganizationTypeContainer">
                                <input type="text" class="searchable-select-input"
                                       placeholder="Digite para pesquisar..."
                                       data-endpoint="organization-types"
                                       autocomplete="off">
                                <input type="hidden" name="organization_type_id" id="editOrganizationTypeId" required>
                                <div class="searchable-select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="searchable-select-dropdown">
                                    <div class="dropdown-content">
                                        <!-- Options will be populated dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- País - Hybrid Searchable Select -->
                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-globe"></i>País
                            </label>
                            <div class="searchable-select-container" id="editCountryContainer">
                                <input type="text" class="searchable-select-input"
                                       placeholder="Digite para pesquisar..."
                                       data-endpoint="countries"
                                       autocomplete="off">
                                <input type="hidden" name="country_id" id="editCountryId">
                                <div class="searchable-select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="searchable-select-dropdown">
                                    <div class="dropdown-content">
                                        <!-- Options will be populated dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Província - Hybrid Searchable Select -->
                        <div class="form-group compact">
                            <label class="form-label compact">
                                <i class="fas fa-map-marker-alt"></i>Província
                            </label>
                            <div class="searchable-select-container" id="editProvinceContainer">
                                <input type="text" class="searchable-select-input"
                                       placeholder="Digite para pesquisar..."
                                       data-endpoint="provinces"
                                       autocomplete="off">
                                <input type="hidden" name="province_id" id="editProvinceId">
                                <div class="searchable-select-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="searchable-select-dropdown">
                                    <div class="dropdown-content">
                                        <!-- Options will be populated dynamically -->
                                    </div>
                                </div>
                            </div>
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
                                        <h4 class="upload-title">
                                            <i class="fas fa-image"></i>Imagem do Perfil (Opcional)
                                        </h4>
                                        <div class="upload-method-buttons">
                                            <button type="button" class="upload-method-btn active" data-method="url" onclick="switchEditUploadMethod('url')">
                                                <i class="fas fa-link"></i>URL
                                            </button>
                                            <button type="button" class="upload-method-btn" data-method="file" onclick="switchEditUploadMethod('file')">
                                                <i class="fas fa-upload"></i>Upload
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Método URL -->
                                    <div class="upload-method-content" id="editUrlMethod">
                                        <div class="form-group compact">
                                            <label class="form-label compact">
                                                <i class="fas fa-link"></i>URL da Imagem
                                            </label>
                                            <div class="url-input-group">
                                                <input type="url" name="img" id="editImageUrl" class="form-input compact url-input"
                                                       placeholder="https://exemplo.com/imagem.jpg"
                                                       onchange="previewEditImageFromUrl(this.value)">
                                                <button type="button" class="btn-preview" onclick="previewEditImageFromUrl(document.getElementById('editImageUrl').value)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Método Upload -->
                                    <div class="upload-method-content" id="editFileMethod" style="display: none;">
                                        <div class="form-group compact">
                                            <label class="form-label compact">
                                                <i class="fas fa-upload"></i>Selecionar Arquivo
                                            </label>
                                            <div class="file-upload-wrapper">
                                                <input type="file" name="client_image_file" id="editImageFile"
                                                       class="file-input" accept="image/*" onchange="handleEditFileUpload(this)">
                                                <div class="file-upload-display">
                                                    <div class="file-upload-placeholder">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <span>Clique para selecionar uma imagem</span>
                                                        <small>JPG, PNG, GIF até 5MB</small>
                                                    </div>
                                                    <div class="file-upload-preview" style="display: none;">
                                                        <img id="editPreviewImage" src="" alt="Preview">
                                                        <div class="file-info">
                                                            <span class="file-name" id="editFileName"></span>
                                                            <button type="button" class="remove-file-btn" onclick="removeEditFileUpload()">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preview Section -->
                                    <div class="image-preview-section" id="editImagePreviewSection" style="display: none;">
                                        <div class="preview-header">
                                            <h5><i class="fas fa-eye"></i>Preview da Imagem</h5>
                                            <button type="button" class="btn-clear-preview" onclick="clearEditImagePreview()">
                                                <i class="fas fa-times"></i>Limpar
                                            </button>
                                        </div>
                                        <div class="preview-content">
                                            <div class="preview-status" id="editImageStatus">
                                                ⏳ Carregando imagem...
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
// Simple and robust client management system
let currentClientId = null;
let clientsData = <?= json_encode($clients ?? []) ?>;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {

    // Submissão do formulário de criação
    document.getElementById('createClientForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validar campos obrigatórios
        const requiredFields = ['name', 'account_type_id', 'state_id', 'organization_type_id', 'country_id'];
        const formData = new FormData(this);

        for (const field of requiredFields) {
            const value = formData.get(field);
            if (!value || value.trim() === '') {
                const fieldNames = {
                    'name': 'Nome',
                    'account_type_id': 'Tipo de Conta',
                    'state_id': 'Estado',
                    'organization_type_id': 'Tipo de Organização',
                    'country_id': 'País'
                };
                showAlert(`Campo ${fieldNames[field]} é obrigatório`, 'danger');
                return;
            }
        }

        // Validar formato do email se fornecido
        const email = formData.get('email');
        if (email && email.trim()) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showAlert('Por favor, insira um email válido', 'danger');
                return;
            }
        }

        // Preparar dados para envio
        try {
            showLoading('Criando cliente...');

            const response = await fetch('<?= url('/clients') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            hideLoading();

            if (response.ok && (response.status === 200 || response.status === 302)) {
                // Success - the controller redirects on success
                closeCard();
                showAlert('Cliente criado com sucesso! 🎉', 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                // Handle errors
                let errorMessage = 'Erro ao criar cliente';

                try {
                    const responseText = await response.text();
                    if (responseText.includes('Token de segurança inválido')) {
                        errorMessage = 'Token de segurança inválido. Recarregue a página e tente novamente.';
                    } else if (responseText.includes('Erro ao criar cliente')) {
                        // Extract error message from HTML if possible
                        const match = responseText.match(/Erro ao criar cliente: ([^<]+)/);
                        if (match) {
                            errorMessage = match[1];
                        }
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }

                showAlert(errorMessage, 'danger');
            }
        } catch (error) {
            hideLoading();
            showAlert('Erro de conexão: ' + error.message, 'danger');
        }
    });

    // Submissão do formulário de edição
    const editForm = document.getElementById('editClientForm');
    if (editForm) {
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Chamar a função updateClient
            await updateClient();
        });
    } else {
        console.error('editClientForm not found');
    }
});

// Searchable Select Implementation
class SearchableSelect {
    constructor(container) {
        this.container = container;
        this.input = container.querySelector('.searchable-select-input');
        this.hiddenInput = container.querySelector('input[type="hidden"]');
        this.dropdown = container.querySelector('.searchable-select-dropdown');
        this.arrow = container.querySelector('.searchable-select-arrow');
        this.endpoint = this.input.getAttribute('data-endpoint');
        this.isOpen = false;
        this.searchTimeout = null;
        this.currentData = [];

        this.init();
    }

    init() {
        // Click on input to toggle dropdown
        this.input.addEventListener('click', (e) => {
            e.stopPropagation();
            if (this.isOpen) {
                this.closeDropdown();
            } else {
                this.openDropdown();
            }
        });

        // Input event for search
        this.input.addEventListener('input', (e) => {
            if (!this.input.readOnly) {
                this.handleSearch(e.target.value);
            }
        });

        // Arrow click
        this.arrow.addEventListener('click', (e) => {
            e.stopPropagation();
            if (this.isOpen) {
                this.closeDropdown();
            } else {
                this.openDropdown();
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target)) {
                this.closeDropdown();
            }
        });
    }

    async openDropdown() {

        this.isOpen = true;
        this.input.readOnly = false;
        this.arrow.classList.add('open');
        this.dropdown.classList.add('open');


        // Sempre carregar dados ao abrir, sem search (traz todos os dados)
        await this.loadData('');
        this.renderDropdown();
    }

    closeDropdown() {
        this.isOpen = false;
        this.input.readOnly = true;
        this.arrow.classList.remove('open');
        this.dropdown.classList.remove('open');
    }

    async loadData(search = '') {
        try {

            const response = await fetch(`/api/${this.endpoint}/search?search=${encodeURIComponent(search)}&page=0&size=30`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            });


            if (response.ok) {
                const data = await response.json();
                this.currentData = data.content || [];
            } else {
                console.error('Error loading data:', response.status);
                this.currentData = [];
            }
        } catch (error) {
            console.error('Error loading data:', error);
            this.currentData = [];
        }
    }

    handleSearch(searchTerm) {
        clearTimeout(this.searchTimeout);

        this.searchTimeout = setTimeout(async () => {
            await this.loadData(searchTerm);
            this.renderDropdown();
        }, 300);
    }

    renderDropdown() {
        try {

            if (this.currentData.length === 0) {
                this.dropdown.innerHTML = '<div class="dropdown-option no-results">Nenhum resultado encontrado</div>';
                return;
            }

            const options = this.currentData.map((item, index) => {
                const displayValue = this.getDisplayValue(item);
                return `<div class="dropdown-option" data-id="${item.id}" data-value="${displayValue}">${displayValue}</div>`;
            }).join('');

            this.dropdown.innerHTML = options;


            // Verificar se dropdown está visível
            const rect = this.dropdown.getBoundingClientRect();

            // Verificar estilos finais
            const finalStyles = window.getComputedStyle(this.dropdown);
            console.log('24. Final computed styles:', {
                display: finalStyles.display,
                visibility: finalStyles.visibility,
                opacity: finalStyles.opacity,
                zIndex: finalStyles.zIndex,
                position: finalStyles.position,
                top: finalStyles.top,
                left: finalStyles.left,
                width: finalStyles.width,
                height: finalStyles.height,
                maxHeight: finalStyles.maxHeight,
                overflow: finalStyles.overflow
            });

            // Add click handlers to options
            this.dropdown.querySelectorAll('.dropdown-option').forEach((option, index) => {
                if (!option.classList.contains('no-results')) {
                    option.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.selectOption(e.target);
                    });
                }
            });

        } catch (error) {
        }
    }

    getDisplayValue(item) {
        // Customize display based on endpoint
        switch (this.endpoint) {
            case 'organization-types':
                return item.type || item.description || 'N/A';
            case 'countries':
                return item.country || 'N/A';
            case 'provinces':
                return item.province || item.name || 'N/A';
            default:
                return item.name || item.description || 'N/A';
        }
    }

    selectOption(optionElement) {
        const id = optionElement.getAttribute('data-id');
        const value = optionElement.getAttribute('data-value');

        // Update display input
        this.input.value = value;

        // Update hidden input
        this.hiddenInput.value = id;

        // Close dropdown
        this.closeDropdown();
    }
}

// Initialize searchable selects when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const searchableSelects = document.querySelectorAll('.searchable-select-container');
    searchableSelects.forEach(container => {
        new SearchableSelect(container);
    });
});

// Main modal functions
function openCreateModal() {
    showModal('createClientCard');
}

function showModal(modalId) {
    // Hide all modals first
    const allModals = document.querySelectorAll('.admin-card');
    allModals.forEach(modal => {
        modal.classList.remove('active');
    });

    // Show overlay
    const overlay = document.getElementById('cardOverlay');
    if (overlay) {
        overlay.classList.add('active');
    }

    // Show target modal
    const targetModal = document.getElementById(modalId);
    if (targetModal) {
        targetModal.classList.add('active');
    }
}

function closeCard() {
    // Hide all modals
    const allModals = document.querySelectorAll('.admin-card');
    allModals.forEach(modal => {
        modal.classList.remove('active');
    });

    // Hide overlay
    const overlay = document.getElementById('cardOverlay');
    if (overlay) {
        overlay.classList.remove('active');
    }
}


// Client CRUD operations
async function openViewCard(id) {
    if (!id) return;
    currentClientId = id;

    try {
        showModal('viewClientCard');

        const response = await fetch(`/clients/${id}`, {
            method: 'GET',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const clientData = await response.json();
        populateViewCard(clientData);
    } catch (error) {
        showAlert('Erro ao carregar dados do cliente. Tente novamente.', 'danger');
        closeCard();
    }
}

// Esta função foi atualizada mais abaixo para usar API
// function openEditCard(id) - vide função async mais abaixo

function openDeleteCard(id) {
    const client = clientsData.find(c => c.id == id);
    if (client) {
        currentClientId = id;
        populateDeleteCard(client);
        showModal('deleteClientCard');
    }
}

function populateViewCard(client) {
    try {
        const user = client.data || client;

        // Header principal com avatar e informações
        const imageElement = document.getElementById('viewClientImage');
        const initialsElement = document.getElementById('viewClientInitials');

        // Configurar avatar
        if (imageElement && initialsElement) {
            if (user.image_url || user.img) {
                imageElement.src = user.image_url || user.img;
                imageElement.style.display = 'block';
                initialsElement.style.display = 'none';
            } else {
                imageElement.style.display = 'none';
                initialsElement.style.display = 'flex';
                initialsElement.textContent = getInitials(user.name || user.email);
            }
        }

        // Nome e email no header
        const nameElement = document.getElementById('viewClientName');
        const emailHeaderElement = document.getElementById('viewClientEmailHeader');
        if (nameElement) nameElement.textContent = user.name || 'Nome não informado';
        if (emailHeaderElement) emailHeaderElement.textContent = user.email || 'Email não informado';

        // Status badge no header
        const isActive = (user.stateName || user.state) === 'ACTIVE' || user.is_active === true || user.is_active === 1;
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
                <i class="fas fa-user"></i>
                <span>Cliente</span>
            `;
        }

        // Card Informações Pessoais
        const fullNameElement = document.getElementById('viewFullName');
        const emailElement = document.getElementById('viewEmail');
        const contactElement = document.getElementById('viewContact');

        if (fullNameElement) fullNameElement.textContent = user.name || 'Não informado';
        if (emailElement) emailElement.textContent = user.email || 'Não informado';
        if (contactElement) contactElement.textContent = user.contacto || user.phone || 'Não informado';

        // Card Informações da Conta
        const clientIdElement = document.getElementById('viewClientId');
        const usernameElement = document.getElementById('viewUsername');
        const accountTypeElement = document.getElementById('viewAccountTypeDetail');

        if (clientIdElement) clientIdElement.textContent = user.id || '-';
        if (usernameElement) usernameElement.textContent = user.username || user.email || '-';
        if (accountTypeElement) accountTypeElement.textContent = user.accountTypeName || 'Cliente';

        // Card Atividade e Histórico
        const createdAtElement = document.getElementById('viewCreatedAt');
        const updatedAtElement = document.getElementById('viewUpdatedAt');
        const lastLoginElement = document.getElementById('viewLastLogin');

        if (createdAtElement) createdAtElement.textContent = formatDate(user.createdAt || user.created_at) || '-';
        if (updatedAtElement) updatedAtElement.textContent = formatDate(user.updatedAt || user.updated_at) || '-';
        if (lastLoginElement) lastLoginElement.textContent = user.lastLogin || user.last_login ? formatDate(user.lastLogin || user.last_login) : 'Nunca acessou';

    } catch (error) {
        showAlert('Erro ao popular dados de visualização', 'danger');
    }
}

// Utility functions for view card
function getInitials(name) {
    if (!name) return 'CL';
    const words = name.split(' ').filter(word => word.length > 0);
    if (words.length === 1) {
        return words[0].substring(0, 2).toUpperCase();
    }
    return (words[0][0] + words[words.length - 1][0]).toUpperCase();
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
        return 'Data inválida';
    }
}

function populateEditCard(client) {
    const form = document.getElementById('editClientForm');
    if (form) {
        const fields = {
            name: form.querySelector('[name="name"]'),
            email: form.querySelector('[name="email"]'),
            contact: form.querySelector('[name="contact"]'),
            img: form.querySelector('[name="img"]'),
            account_type_id: form.querySelector('[name="account_type_id"]'),
            state_id: form.querySelector('[name="state_id"]'),
            status: form.querySelector('[name="status"]'),
            notes: form.querySelector('[name="notes"]')
        };

        if (fields.name) fields.name.value = client.name || '';
        if (fields.email) fields.email.value = client.email || '';
        if (fields.contact) fields.contact.value = client.contact || '';
        if (fields.img) fields.img.value = client.img || '';
        if (fields.account_type_id) fields.account_type_id.value = client.account_type_id || 1;
        if (fields.state_id) fields.state_id.value = client.state_id || 1;
        if (fields.status) fields.status.checked = (client.state || 'active') === 'active';
        if (fields.notes) fields.notes.value = client.notes || '';
    }
}

function populateDeleteCard(client) {
    const nameEl = document.getElementById('deleteClientName');
    const emailEl = document.getElementById('deleteClientEmail');

    if (nameEl) nameEl.textContent = client.name || 'Cliente';
    if (emailEl) emailEl.textContent = client.email || 'Email não informado';
}


// 2. VER CLIENTE - Função removida, usando a nova async function acima

function editFromView() {
    closeCard();
    setTimeout(() => {
        openEditCard(currentClientId);
    }, 300);
}

// 3. EDITAR CLIENTE
async function openEditCard(id) {

    if (!id) {
        console.error('ID não fornecido para openEditCard');
        return;
    }

    currentClientId = id;

    try {
        // Mostrar o modal primeiro com loading
        showModal('editClientCard');

        // Buscar dados do usuário via API
        const response = await fetch(`/clients/${id}`, {
            method: 'GET',
            credentials: 'include', // Incluir cookies de sessão
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });


        if (!response.ok) {
            const errorText = await response.text();
            console.error('Erro na resposta da API:', errorText);
            throw new Error(`Erro ${response.status}: ${response.statusText} - ${errorText}`);
        }

        const userData = await response.json();

        // Popular o modal com os dados do usuário
        await populateEditModal(userData);

    } catch (error) {
        console.error('Erro ao carregar dados do usuário:', error);
        closeCard();
    }
}

// Função para popular o modal de edição com dados do usuário
async function populateEditModal(userData) {

    try {
        // Extrair os dados do usuário da resposta da API
        const user = userData.data || userData;

        // 1. Preencher campos básicos do formulário
        const form = document.getElementById('editClientForm');
        if (!form) {
            console.error('Formulário editClientForm não encontrado');
            return;
        }

        // Campo hidden com ID do usuário
        const userIdField = document.getElementById('editClientId');
        if (userIdField) {
            userIdField.value = user.id;
        } else {
            console.warn('Campo editClientId não encontrado');
        }

        // Campos de texto básicos
        const nameField = form.querySelector('[name="name"]');
        if (nameField) {
            nameField.value = user.name || '';
        }

        const emailField = form.querySelector('[name="email"]');
        if (emailField) {
            emailField.value = user.email || '';
        }

        const contactField = form.querySelector('[name="contact"]');
        if (contactField) {
            // Tentar diferentes nomes de campo de contato
            const contact = user.contacto || user.contact || user.phone || '';
            contactField.value = contact;
            if (!contact) {
                console.warn('Nenhum campo de contato encontrado na API. Campos disponíveis:', Object.keys(user));
            }
        }

        // 2. Preencher Hybrid Searchable Selects

        // Tipo de Organização
        if (user.organizationTypeId) {
            const orgTypeInput = document.querySelector('#editOrganizationTypeContainer .searchable-select-input');
            const orgTypeHidden = document.getElementById('editOrganizationTypeId');

            if (orgTypeInput && orgTypeHidden) {
                // Usar o nome que já vem da API se disponível
                if (user.organizationTypeName) {
                    orgTypeInput.value = user.organizationTypeName;
                    orgTypeHidden.value = user.organizationTypeId;
                } else {
                    // Buscar o nome do tipo de organização se não vier na resposta
                    const orgTypeName = await fetchOrganizationTypeName(user.organizationTypeId);
                    if (orgTypeName) {
                        orgTypeInput.value = orgTypeName;
                        orgTypeHidden.value = user.organizationTypeId;
                    }
                }
            }
        }

        // País
        if (user.countryId) {
            const countryInput = document.querySelector('#editCountryContainer .searchable-select-input');
            const countryHidden = document.getElementById('editCountryId');

            if (countryInput && countryHidden) {
                // Usar o nome que já vem da API se disponível
                if (user.countryName) {
                    countryInput.value = user.countryName;
                    countryHidden.value = user.countryId;
                } else {
                    // Buscar o nome do país se não vier na resposta
                    const countryName = await fetchCountryName(user.countryId);
                    if (countryName) {
                        countryInput.value = countryName;
                        countryHidden.value = user.countryId;
                    }
                }
            }
        }

        // Província
        if (user.provinceId) {
            const provinceInput = document.querySelector('#editProvinceContainer .searchable-select-input');
            const provinceHidden = document.getElementById('editProvinceId');

            if (provinceInput && provinceHidden) {
                // Usar o nome que já vem da API se disponível
                if (user.provinceName) {
                    provinceInput.value = user.provinceName;
                    provinceHidden.value = user.provinceId;
                } else {
                    // Buscar o nome da província se não vier na resposta
                    const provinceName = await fetchProvinceName(user.provinceId);
                    if (provinceName) {
                        provinceInput.value = provinceName;
                        provinceHidden.value = user.provinceId;
                    }
                }
            }
        }

        // 3. Preencher campos de upload de imagem se existir
        if (user.img) {
            const imageUrlField = document.getElementById('editImageUrl');
            if (imageUrlField) {
                imageUrlField.value = user.img;
                // Mostrar preview da imagem
                previewEditImageFromUrl(user.img);
            }
        }

        // 4. Preencher campos de select tradicionais (Tipo de conta e Estado)

        // Tipo de conta - usar o campo authId ou account_type_id
        const accountTypeSelect = form.querySelector('[name="account_type_id"]');
        if (accountTypeSelect) {
            // A API não retorna account_type_id diretamente, mas todos os clientes são USER (ID 2)
            accountTypeSelect.value = 2; // USER account type
        } else {
            console.warn('Campo account_type_id não encontrado');
        }

        // Estado
        const stateSelect = form.querySelector('[name="state_id"]');
        if (stateSelect && user.stateId) {
            stateSelect.value = user.stateId;
        } else {
            console.warn('Campo state_id não encontrado ou stateId não disponível');
        }

        // 6. Adicionar event listener do formulário se ainda não existir
        const editForm = document.getElementById('editClientForm');
        if (editForm && !editForm.hasAttribute('data-listener-added')) {
            editForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Chamar a função updateClient
                await updateClient();
            });
            editForm.setAttribute('data-listener-added', 'true');
        }

        // 7. IMPORTANTE: Inicializar SearchableSelect components DEPOIS de preencher todos os dados
        setTimeout(() => {
            initializeEditSearchableSelects();
        }, 100); // Pequeno delay para garantir que o DOM esteja atualizado

    } catch (error) {
        console.error('Erro ao popular modal de edição:', error);
    }
}

// Funções auxiliares para buscar nomes por ID
async function fetchOrganizationTypeName(id) {
    try {
        const response = await fetch(`/api/data/organization-types?search=&page=0&size=100`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.ok) {
            const data = await response.json();
            const orgType = data.content?.find(item => item.id == id);
            return orgType ? (orgType.type || orgType.description) : null;
        }
    } catch (error) {
        console.error('Erro ao buscar tipo de organização:', error);
    }
    return null;
}

async function fetchCountryName(id) {
    try {
        const response = await fetch(`/api/data/countries?search=&page=0&size=100`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.ok) {
            const data = await response.json();
            const country = data.content?.find(item => item.id == id);
            return country ? `${country.country} (${country.indicative || 'N/A'})` : null;
        }
    } catch (error) {
        console.error('Erro ao buscar país:', error);
    }
    return null;
}

async function fetchProvinceName(id) {
    try {
        const response = await fetch(`/api/data/provinces?search=&page=0&size=100`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.ok) {
            const data = await response.json();
            const province = data.content?.find(item => item.id == id);
            return province ? (province.provinceName || province.name) : null;
        }
    } catch (error) {
        console.error('Erro ao buscar província:', error);
    }
    return null;
}

// Função para inicializar os SearchableSelect components do modal de edição
function initializeEditSearchableSelects() {

    try {

    // Organizações
    const editOrgContainer = document.getElementById('editOrganizationTypeContainer');
    if (editOrgContainer) {
        // Limpar instância anterior se existir
        if (editOrgContainer._searchableSelectInstance) {
            editOrgContainer._searchableSelectInstance.destroy?.();
        }
        editOrgContainer._searchableSelectInstance = new SearchableSelect(editOrgContainer);
    } else {
        console.warn('editOrganizationTypeContainer não encontrado');
    }

    // Países
    const editCountryContainer = document.getElementById('editCountryContainer');
    if (editCountryContainer) {
        // Limpar instância anterior se existir
        if (editCountryContainer._searchableSelectInstance) {
            editCountryContainer._searchableSelectInstance.destroy?.();
        }
        editCountryContainer._searchableSelectInstance = new SearchableSelect(editCountryContainer);
    } else {
        console.warn('editCountryContainer não encontrado');
    }

    // Províncias
    const editProvinceContainer = document.getElementById('editProvinceContainer');
    if (editProvinceContainer) {
        // Limpar instância anterior se existir
        if (editProvinceContainer._searchableSelectInstance) {
            editProvinceContainer._searchableSelectInstance.destroy?.();
        }
        editProvinceContainer._searchableSelectInstance = new SearchableSelect(editProvinceContainer);
    } else {
        console.warn('editProvinceContainer não encontrado');
    }

    } catch (error) {
        console.error('Erro ao inicializar SearchableSelect components:', error);
    }
}

async function updateClient() {

    if (!currentClientId) {
        console.error('No currentClientId set');
        return;
    }

    try {
        const form = document.getElementById('editClientForm');
        const formData = new FormData(form);

        // Log form data for debugging
        for (let [key, value] of formData.entries()) {
        }

        // Construir payload usando os nomes de campo que o PHP espera para validação
        const payload = {
            name: formData.get('name'),
            account_type_id: formData.get('account_type_id') || '1',
            state_id: formData.get('state_id') || '1'
        };


        // Adicionar campos opcionais apenas se não estiverem vazios
        const contact = formData.get('contact');
        if (contact && contact.trim()) {
            payload.contact = contact;
        }

        const email = formData.get('email');
        if (email && email.trim()) {
            payload.email = email;
        }

        const img = formData.get('img');
        if (img && img.trim()) {
            payload.img = img;
        }

        const organizationTypeId = formData.get('organization_type_id');
        if (organizationTypeId) {
            payload.organization_type_id = organizationTypeId;
        }

        const countryId = formData.get('country_id');
        if (countryId) {
            payload.country_id = countryId;
        }

        const provinceId = formData.get('province_id');
        if (provinceId) {
            payload.province_id = provinceId;
        }

        // Usar endpoint PUT /clients/{id} conforme documentação
        const url = `/clients/${currentClientId}`;

        const response = await fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });


        if (response.ok) {
            const result = await response.json();
            showAlert('Cliente atualizado com sucesso!', 'success');
            closeCard();
            // Recarregar página para mostrar dados atualizados
            window.location.reload();
        } else {
            const errorText = await response.text();
            console.error('Update failed:', response.status, errorText);

            let errorMessage = 'Erro ao atualizar cliente';
            try {
                const error = JSON.parse(errorText);
                errorMessage = error.message || errorMessage;
            } catch (e) {
                // Not JSON, use default message
            }

            showAlert(errorMessage, 'danger');
        }
    } catch (error) {
        console.error('Erro ao atualizar cliente:', error);
        showAlert('Erro ao atualizar cliente. Tente novamente.', 'danger');
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

        showModal('deleteClientCard');
    }
}

async function confirmDelete() {
    if (!currentClientId) {
        showAlert('ID do cliente não encontrado', 'danger');
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

// Função para alternar campos opcionais - compatível com admin
function toggleOptionalFields() {
    const optionalFields = document.getElementById('optionalClientFields');
    const toggleIcon = document.getElementById('optionalClientToggleIcon');
    const toggleBtn = document.querySelector('.optional-toggle');

    if (optionalFields && (optionalFields.style.display === 'none' || !optionalFields.style.display)) {
        optionalFields.style.display = 'block';
        if (toggleIcon) toggleIcon.style.transform = 'rotate(90deg)';
        if (toggleBtn) toggleBtn.classList.add('expanded');
    } else if (optionalFields) {
        optionalFields.style.display = 'none';
        if (toggleIcon) toggleIcon.style.transform = 'rotate(0deg)';
        if (toggleBtn) toggleBtn.classList.remove('expanded');
    }
}

// Função para alternar campos opcionais na edição
function toggleOptionalFieldsEdit() {
    const optionalFields = document.getElementById('optionalFieldsEdit');
    const toggleIcon = document.getElementById('optionalToggleIconEdit');
    const toggleBtn = document.querySelector('#editClientCard .optional-toggle');

    if (optionalFields && (optionalFields.style.display === 'none' || !optionalFields.style.display)) {
        optionalFields.style.display = 'block';
        if (toggleIcon) toggleIcon.style.transform = 'rotate(90deg)';
        if (toggleBtn) toggleBtn.classList.add('expanded');
    } else if (optionalFields) {
        optionalFields.style.display = 'none';
        if (toggleIcon) toggleIcon.style.transform = 'rotate(0deg)';
        if (toggleBtn) toggleBtn.classList.remove('expanded');
    }
}

// ===========================================
// SISTEMA DE UPLOAD DUPLO DE IMAGEM - CLIENTES
// ===========================================

// Alternar entre métodos de upload
function switchUploadMethod(method) {
    const urlMethod = document.getElementById('urlClientMethod');
    const fileMethod = document.getElementById('fileClientMethod');
    const urlBtn = document.querySelector('[data-method="url"]');
    const fileBtn = document.querySelector('[data-method="file"]');

    // Verificar se os elementos existem antes de manipular
    if (!urlMethod || !fileMethod || !urlBtn || !fileBtn) {
        return;
    }

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
        const fileInput = document.getElementById('clientImageFile');
        if (fileInput) fileInput.value = '';
        if (typeof hideFilePreviewClient === 'function') hideFilePreviewClient();
    } else {
        fileMethod.style.display = 'block';
        fileBtn.classList.add('active');
        // Clear URL input when switching to file
        const urlInput = document.getElementById('clientImageUrl');
        if (urlInput) urlInput.value = '';
        if (typeof hideGlobalPreviewClient === 'function') hideGlobalPreviewClient();
    }
}

// Preview de imagem via URL
function previewImageFromUrl(url) {
    if (!url || url.trim() === '') {
        hideGlobalPreviewClient();
        return;
    }

    // Validar se é uma URL válida de imagem
    const imageExtensions = /\.(jpg|jpeg|png|gif|webp|svg|bmp)(\?.*)?$/i;
    if (!imageExtensions.test(url)) {
        showImageErrorClient('URL deve apontar para uma imagem válida (JPG, PNG, GIF, etc.)');
        return;
    }

    const globalPreview = document.getElementById('clientGlobalPreviewImage');
    const previewSection = document.getElementById('clientImagePreviewSection');
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
        hideGlobalPreviewClient();
        showImageErrorClient('Não foi possível carregar a imagem da URL fornecida');
    };
    img.src = url;
}

// Manipular upload de arquivo
function handleFileUpload(input) {
    const file = input.files[0];
    if (!file) return;

    // Validar tipo de arquivo
    if (!file.type.startsWith('image/')) {
        showImageErrorClient('Por favor, selecione apenas arquivos de imagem');
        input.value = '';
        return;
    }

    // Validar tamanho (5MB max)
    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        showImageErrorClient('Arquivo muito grande. Tamanho máximo: 5MB');
        input.value = '';
        return;
    }

    // Mostrar preview do arquivo
    const reader = new FileReader();
    reader.onload = function(e) {
        showFilePreviewClient(e.target.result, file.name);
        showGlobalPreviewClient(e.target.result, 'upload');
    };
    reader.readAsDataURL(file);
}

// Mostrar preview do arquivo na área de upload
function showFilePreviewClient(src, filename) {
    const placeholder = document.getElementById('clientUploadPlaceholder');
    const preview = document.getElementById('clientUploadPreview');
    const previewImage = document.getElementById('clientPreviewImage');

    placeholder.style.display = 'none';
    preview.style.display = 'block';
    previewImage.src = src;
}

// Ocultar preview do arquivo
function hideFilePreviewClient() {
    const placeholder = document.getElementById('clientUploadPlaceholder');
    const preview = document.getElementById('clientUploadPreview');

    placeholder.style.display = 'flex';
    preview.style.display = 'none';
}

// Mostrar preview global
function showGlobalPreviewClient(src, type) {
    const globalPreview = document.getElementById('clientGlobalPreviewImage');
    const previewSection = document.getElementById('clientImagePreviewSection');
    const statusText = previewSection.querySelector('.preview-status');

    globalPreview.src = src;
    statusText.textContent = type === 'upload' ? '✅ Arquivo carregado' : '✅ Imagem URL carregada';
    statusText.style.color = '#10b981';
    previewSection.style.display = 'block';
}

// Ocultar preview global
function hideGlobalPreviewClient() {
    const previewSection = document.getElementById('clientImagePreviewSection');
    if (previewSection) {
        previewSection.style.display = 'none';
    }
}

// Limpar preview
function clearImagePreview() {
    hideGlobalPreviewClient();
    hideFilePreviewClient();

    // Limpar inputs
    const urlInput = document.getElementById('clientImageUrl');
    const fileInput = document.getElementById('clientImageFile');

    if (urlInput) urlInput.value = '';
    if (fileInput) fileInput.value = '';
}

// Remover upload de arquivo
function removeFileUpload() {
    const fileInput = document.getElementById('clientImageFile');
    if (fileInput) fileInput.value = '';
    hideFilePreviewClient();
    hideGlobalPreviewClient();
}

// Mostrar erro de imagem
function showImageErrorClient(message) {
    showAlert(message, 'danger');
}

// ===========================================
// EDIT MODAL - UPLOAD FUNCTIONS
// ===========================================

// Alternar entre métodos de upload no modal de edição
function switchEditUploadMethod(method) {
    const urlMethod = document.getElementById('editUrlMethod');
    const fileMethod = document.getElementById('editFileMethod');
    const urlBtn = document.querySelector('#editClientCard [data-method="url"]');
    const fileBtn = document.querySelector('#editClientCard [data-method="file"]');

    // Verificar se os elementos existem antes de manipular
    if (!urlMethod || !fileMethod || !urlBtn || !fileBtn) {
        return;
    }

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
        hideEditFilePreview();
    } else {
        fileMethod.style.display = 'block';
        fileBtn.classList.add('active');
        // Clear URL input when switching to file
        const urlInput = document.getElementById('editImageUrl');
        if (urlInput) urlInput.value = '';
        hideEditGlobalPreview();
    }
}

// Preview de imagem via URL - Edit Modal
function previewEditImageFromUrl(url) {
    if (!url || url.trim() === '') {
        hideEditGlobalPreview();
        return;
    }

    const previewSection = document.getElementById('editImagePreviewSection');
    const statusText = document.getElementById('editImageStatus');

    if (!previewSection || !statusText) return;

    statusText.textContent = '⏳ Carregando imagem...';
    statusText.style.color = '#f59e0b';
    previewSection.style.display = 'block';

    // Carregar imagem
    const img = new Image();
    img.onload = function() {
        showEditGlobalPreview(this.src, 'url');
    };
    img.onerror = function() {
        statusText.textContent = '❌ Erro ao carregar imagem';
        statusText.style.color = '#ef4444';
    };
    img.src = url;
}

// Handle file upload - Edit Modal
function handleEditFileUpload(input) {
    const file = input.files[0];
    if (!file) {
        hideEditFilePreview();
        hideEditGlobalPreview();
        return;
    }

    // Validar tipo de arquivo
    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        showImageErrorClient('Por favor, selecione apenas arquivos de imagem (JPG, PNG, GIF, WebP).');
        input.value = '';
        return;
    }

    // Validar tamanho (5MB)
    const maxSize = 5 * 1024 * 1024;
    if (file.size > maxSize) {
        showImageErrorClient('Arquivo muito grande. Tamanho máximo permitido é 5MB.');
        input.value = '';
        return;
    }

    // Mostrar preview
    const reader = new FileReader();
    reader.onload = function(e) {
        showEditFilePreview(e.target.result, file.name);
        showEditGlobalPreview(e.target.result, 'upload');
    };
    reader.readAsDataURL(file);
}

// Mostrar preview do arquivo - Edit Modal
function showEditFilePreview(src, filename) {
    const placeholder = document.querySelector('#editClientCard .file-upload-placeholder');
    const preview = document.querySelector('#editClientCard .file-upload-preview');
    const previewImage = document.getElementById('editPreviewImage');
    const fileName = document.getElementById('editFileName');

    if (placeholder) placeholder.style.display = 'none';
    if (preview) preview.style.display = 'block';
    if (previewImage) previewImage.src = src;
    if (fileName) fileName.textContent = filename;
}

// Esconder preview do arquivo - Edit Modal
function hideEditFilePreview() {
    const placeholder = document.querySelector('#editClientCard .file-upload-placeholder');
    const preview = document.querySelector('#editClientCard .file-upload-preview');

    if (placeholder) placeholder.style.display = 'flex';
    if (preview) preview.style.display = 'none';
}

// Mostrar preview global - Edit Modal
function showEditGlobalPreview(src, type) {
    const previewSection = document.getElementById('editImagePreviewSection');
    const statusText = document.getElementById('editImageStatus');

    if (!previewSection || !statusText) return;

    statusText.textContent = type === 'upload' ? '✅ Arquivo carregado' : '✅ Imagem URL carregada';
    statusText.style.color = '#10b981';
    previewSection.style.display = 'block';
}

// Esconder preview global - Edit Modal
function hideEditGlobalPreview() {
    const previewSection = document.getElementById('editImagePreviewSection');
    if (previewSection) {
        previewSection.style.display = 'none';
    }
}

// Limpar preview de imagem - Edit Modal
function clearEditImagePreview() {
    hideEditGlobalPreview();
    hideEditFilePreview();

    // Limpar inputs
    const urlInput = document.getElementById('editImageUrl');
    const fileInput = document.getElementById('editImageFile');

    if (urlInput) urlInput.value = '';
    if (fileInput) fileInput.value = '';
}

// Remover upload de arquivo - Edit Modal
function removeEditFileUpload() {
    const fileInput = document.getElementById('editImageFile');
    if (fileInput) fileInput.value = '';
    hideEditFilePreview();
    hideEditGlobalPreview();
}

// Validação de senha para clientes
function togglePasswordVisibility(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + 'ToggleIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Função para checar força da senha
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
    let score = 1;

    if (validCount >= 5) {
        strength = 'strong';
        score = 4;
    } else if (validCount >= 4) {
        strength = 'good';
        score = 3;
    } else if (validCount >= 2) {
        strength = 'fair';
        score = 2;
    }

    return {
        requirements,
        validCount,
        strength,
        score
    };
}

// Função para atualizar indicador de força da senha
function updatePasswordStrength(inputId) {
    const passwordInput = document.getElementById(inputId);
    const strengthFill = document.getElementById(inputId + 'StrengthFill');
    const strengthText = document.getElementById(inputId + 'StrengthText');
    const requirementsContainer = document.getElementById(inputId + 'Requirements');

    if (!passwordInput || !strengthFill || !strengthText) return;

    const password = passwordInput.value;

    if (!password) {
        strengthFill.style.width = '0%';
        strengthFill.className = 'strength-fill';
        strengthText.textContent = 'Força da senha';
        strengthText.className = 'strength-text-mini';
        if (requirementsContainer) {
            requirementsContainer.classList.remove('show');
        }
        return;
    }

    const result = checkPasswordStrength(password);

    // Atualizar barra de força
    strengthFill.className = `strength-fill ${result.strength}`;

    // Calcular largura da barra baseada no score
    const widths = { weak: '25%', fair: '50%', good: '75%', strong: '100%' };
    strengthFill.style.width = widths[result.strength];

    // Atualizar cores da barra
    const colors = {
        weak: '#ef4444',
        fair: '#f59e0b',
        good: '#3b82f6',
        strong: '#10b981'
    };
    strengthFill.style.background = colors[result.strength];

    // Atualizar texto de força (versão compacta)
    const compactTexts = {
        weak: 'Fraca',
        fair: 'Razoável',
        good: 'Boa',
        strong: 'Forte'
    };

    strengthText.textContent = compactTexts[result.strength];
    strengthText.className = `strength-text-mini ${result.strength}`;

    // Atualizar requisitos se existir o container
    if (requirementsContainer) {
        const requirements = [
            { id: 'req-client-length', valid: result.requirements.length },
            { id: 'req-client-uppercase', valid: result.requirements.uppercase },
            { id: 'req-client-lowercase', valid: result.requirements.lowercase },
            { id: 'req-client-number', valid: result.requirements.number },
            { id: 'req-client-special', valid: result.requirements.special }
        ];

        requirements.forEach(req => {
            const element = document.getElementById(req.id);
            if (element) {
                element.className = `requirement compact ${req.valid ? 'valid' : 'invalid'}`;
            }
        });
    }
}

// Função para configurar validação de senha
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
            const requirementsContainer = document.getElementById(inputId + 'Requirements');
            if (requirementsContainer && this.value) {
                requirementsContainer.classList.add('show');
            }
        };

        passwordInput.blurHandler = function() {
            const requirementsContainer = document.getElementById(inputId + 'Requirements');
            if (requirementsContainer) {
                setTimeout(() => {
                    requirementsContainer.classList.remove('show');
                }, 200);
            }
        };

        passwordInput.addEventListener('input', passwordInput.strengthHandler);
        passwordInput.addEventListener('focus', passwordInput.focusHandler);
        passwordInput.addEventListener('blur', passwordInput.blurHandler);
    }
}

// Função para abrir card de edição a partir da visualização
function openEditCardFromView() {
    if (currentClientId) {
        closeCard();
        setTimeout(() => openEditCard(currentClientId), 300);
    }
}

// Função duplicada removida - usando implementação atualizada acima

// Função getInitials duplicada removida - usando implementação acima

// Função removida - não é mais usada na implementação atual

// Função para carregar dados no card de edição
async function editClient() {
    if (!currentClientId) return;

    const form = document.getElementById('editClientForm');
    if (!form) return;

    try {
        const formData = new FormData(form);

        const response = await fetch(`<?= url('/clients') ?>/${currentClientId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.ok) {
            showAlert('Cliente atualizado com sucesso!', 'success');
            closeCard();
            window.location.reload();
        } else {
            showAlert('Erro ao atualizar cliente', 'danger');
        }
    } catch (error) {
        console.error('Erro:', error);
        showAlert('Erro ao atualizar cliente', 'danger');
    }
}

async function deleteClient() {
    if (!currentClientId) return;

    try {
        const response = await fetch(`<?= url('/clients') ?>/${currentClientId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        });

        if (response.ok) {
            showAlert('Cliente eliminado com sucesso!', 'success');
            closeCard();
            window.location.reload();
        } else {
            showAlert('Erro ao eliminar cliente', 'danger');
        }
    } catch (error) {
        console.error('Erro:', error);
        showAlert('Erro ao eliminar cliente', 'danger');
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCard();
    }
});

// Close modal by clicking overlay
document.addEventListener('click', function(e) {
    if (e.target.id === 'cardOverlay') {
        closeCard();
    }
});

// Helper functions (copiadas do admin)
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

    const loadingContent = document.createElement('div');
    loadingContent.style.cssText = `
        background: white;
        padding: 2rem 3rem;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        text-align: center;
        max-width: 400px;
        width: 90%;
    `;

    loadingContent.innerHTML = `
        <div style="
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem auto;
        "></div>
        <p style="margin: 0; color: #374151; font-weight: 500; font-size: 1rem;">${message}</p>
    `;

    if (!document.getElementById('spinnerCSS')) {
        const style = document.createElement('style');
        style.id = 'spinnerCSS';
        style.textContent = `
            @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        `;
        document.head.appendChild(style);
    }

    loadingOverlay.appendChild(loadingContent);
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
        display: flex;
        align-items: center;
        gap: 0.75rem;
    `;

    const icon = type === 'success' ? '✅' : '⚠️';
    alert.innerHTML = `
        <span style="font-size: 1.25rem;">${icon}</span>
        <span style="flex: 1; white-space: pre-line;">${message}</span>
        <button onclick="this.parentElement.remove()" style="
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.125rem;
            padding: 0.25rem;
            border-radius: 4px;
            opacity: 0.8;
            transition: opacity 0.2s;
        " onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">✕</button>
    `;

    if (!document.getElementById('alertCSS')) {
        const style = document.createElement('style');
        style.id = 'alertCSS';
        style.textContent = `
            @keyframes slideInAlert {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(alert);

    // Auto remove after 8 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.style.animation = 'slideInAlert 0.3s ease reverse';
            setTimeout(() => alert.remove(), 300);
        }
    }, 8000);
}

// =============================================================================
// SEARCHABLE INPUTS - Busca dinâmica com API
// =============================================================================

document.addEventListener('DOMContentLoaded', function() {
    initSearchableInputs();
});

function initSearchableInputs() {
    const searchableInputs = document.querySelectorAll('.searchable-input');

    searchableInputs.forEach(input => {
        const endpoint = input.dataset.endpoint;
        const targetField = input.dataset.target;
        const resultsContainer = input.parentElement.querySelector('.search-results');

        // Carregar dados iniciais quando o input recebe foco
        input.addEventListener('focus', function() {
            loadInitialData(endpoint, resultsContainer, input, targetField);
        });

        // Busca em tempo real enquanto o usuário digita
        input.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                searchData(endpoint, searchTerm, resultsContainer, input, targetField);
            } else if (searchTerm.length === 0) {
                loadInitialData(endpoint, resultsContainer, input, targetField);
            }
        }, 300));

        // Esconder resultados quando perder o foco (com delay para permitir clique)
        input.addEventListener('blur', function() {
            setTimeout(() => {
                hideResults(resultsContainer);
            }, 200);
        });
    });
}

async function loadInitialData(endpoint, resultsContainer, input, targetField) {
    const apiEndpoint = getApiEndpoint(endpoint);
    await fetchData(apiEndpoint, '', resultsContainer, input, targetField, 30);
}

async function searchData(endpoint, searchTerm, resultsContainer, input, targetField) {
    const apiEndpoint = getApiEndpoint(endpoint);
    await fetchData(apiEndpoint, searchTerm, resultsContainer, input, targetField, 30);
}

function getApiEndpoint(endpoint) {
    switch (endpoint) {
        case 'organization-types':
            return '/organization-types/paginated';
        case 'countries':
            return '/countries/paginated';
        case 'provinces':
            return '/provinces/paginated';
        default:
            return '/organization-types/paginated';
    }
}

async function fetchData(apiEndpoint, searchTerm, resultsContainer, input, targetField, size = 30) {
    try {
        showSearchLoading(resultsContainer);

        const params = new URLSearchParams({
            search: searchTerm,
            page: 0,
            size: size
        });

        const response = await fetch(`<?= $_ENV['API_BASE_URL'] ?? 'http://172.17.0.1:8080' ?>${apiEndpoint}?${params}`, {
            headers: {
                'Authorization': 'Bearer <?= $_SESSION['jwt_token'] ?? '' ?>',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        const data = await response.json();
        displayResults(data.content || [], resultsContainer, input, targetField, apiEndpoint);

    } catch (error) {
        console.error(`Erro ao buscar dados:`, error);
        displayFallbackData(apiEndpoint, resultsContainer, input, targetField);
    }
}

function displayResults(data, resultsContainer, input, targetField, apiEndpoint) {
    resultsContainer.innerHTML = '';

    if (data.length === 0) {
        resultsContainer.innerHTML = '<div class="search-no-results">Nenhum resultado encontrado</div>';
        showResults(resultsContainer);
        return;
    }

    data.forEach(item => {
        const resultItem = document.createElement('div');
        resultItem.className = 'search-result-item';

        // Formatação baseada no tipo de dados
        let displayText = '';
        if (apiEndpoint.includes('organization-types')) {
            displayText = item.type || item.description || 'Tipo não definido';
        } else if (apiEndpoint.includes('countries')) {
            displayText = `${item.country} (${item.indicative || 'N/A'})`;
        } else if (apiEndpoint.includes('provinces')) {
            displayText = item.provinceName || item.name || 'Província não definida';
        } else {
            displayText = item.name || item.description || item.type || 'Item não definido';
        }

        resultItem.textContent = displayText;
        resultItem.dataset.id = item.id;
        resultItem.dataset.value = displayText;

        // Clique para selecionar
        resultItem.addEventListener('click', function() {
            selectItem(this, input, targetField, resultsContainer);
        });

        resultsContainer.appendChild(resultItem);
    });

    showResults(resultsContainer);
}

function displayFallbackData(apiEndpoint, resultsContainer, input, targetField) {
    let fallbackData = [];

    if (apiEndpoint.includes('organization-types')) {
        fallbackData = [
            { id: 1, type: 'Individual' },
            { id: 2, type: 'Enterprise' }
        ];
    } else if (apiEndpoint.includes('countries')) {
        fallbackData = [
            { id: 25, country: 'Brasil', indicative: '+55' },
            { id: 1, country: 'Portugal', indicative: '+351' },
            { id: 2, country: 'Angola', indicative: '+244' }
        ];
    }

    displayResults(fallbackData, resultsContainer, input, targetField, apiEndpoint);
}

function selectItem(resultItem, input, targetField, resultsContainer) {
    const id = resultItem.dataset.id;
    const displayValue = resultItem.dataset.value;

    // Atualizar input visível
    input.value = displayValue;

    // Atualizar campo hidden
    const hiddenField = document.querySelector(`[name="${targetField}"]`);
    if (hiddenField) {
        hiddenField.value = id;
    }

    // Esconder resultados
    hideResults(resultsContainer);
}

function showSearchLoading(resultsContainer) {
    resultsContainer.innerHTML = '<div class="search-loading"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>';
    showResults(resultsContainer);
}

function showResults(resultsContainer) {
    resultsContainer.style.display = 'block';
}

function hideResults(resultsContainer) {
    resultsContainer.style.display = 'none';
}

// Utility: debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

</script>