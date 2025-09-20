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

.filters-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e2e8f0;
}

.filters-header {
    margin-bottom: 1.5rem;
}

.filters-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filters-subtitle {
    color: #6b7280;
    margin: 0;
    font-size: 0.875rem;
}

.filters-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-label {
    font-weight: 500;
    color: #374151;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.search-input-wrapper {
    position: relative;
}

.filter-input, .filter-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.search-input {
    padding-right: 3rem;
}

.search-input-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
}

.filters-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.filters-actions-main {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn-search-filter {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-search-filter:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-clear-filters {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-clear-filters:hover {
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
}

.clear-filters-wrapper.inactive {
    display: none;
}

.filters-results-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
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
    padding: 1.5rem;
}

.table-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-title {
    font-size: 1.25rem;
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
    padding: 1rem;
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
    gap: 0.75rem;
}

.admin-avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
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
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.375rem;
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
    max-width: 900px;
    width: 100%;
    max-height: 90vh;
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
    padding: 2rem;
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
    gap: 1.5rem;
}

.card-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
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
    font-size: 1.5rem;
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
    padding: 2rem;
    max-height: 60vh;
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

<!-- 1. TÍTULO DA PÁGINA - ISOLADO -->
<div class="page-title-section">
    <div class="page-title-container">
        <h1 class="main-page-title">
            <i class="fas fa-users-cog page-icon"></i>
            Administradores
        </h1>
        <p class="main-page-subtitle">Gerencie os administradores do sistema com segurança e eficiência</p>
    </div>
</div>

<!-- 2. BOTÃO ADICIONAR ADMINISTRADOR - DESTAQUE -->
<div class="add-admin-section">
    <div class="add-admin-container">
        <button class="btn-add-administrator" onclick="openCreateCard()">
            <div class="add-btn-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="add-btn-content">
                <span class="add-btn-title">Novo Administrador</span>
                <span class="add-btn-subtitle">Criar nova conta de administrador</span>
            </div>
            <div class="add-btn-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </button>
        
        <!-- Estatísticas em formato compacto -->
        <div class="quick-stats">
            <div class="stat-item">
                <span class="stat-number"><?= count($accounts ?? []) ?></span>
                <span class="stat-label">Total</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number"><?= count(array_filter($accounts ?? [], fn($acc) => ($acc['state'] ?? 'INACTIVE') === 'ACTIVE')) ?></span>
                <span class="stat-label">Ativos</span>
            </div>
        </div>
    </div>
</div>

<!-- 3. ÁREA DE FILTROS -->
<div class="filters-section">
    <div class="filters-container">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fas fa-search"></i>
                Pesquisar & Filtrar
            </h3>
            <p class="filters-subtitle">Use os filtros abaixo para encontrar administradores específicos</p>
        </div>
        
        <form method="GET" action="<?= url('/accounts') ?>" class="filters-form">
            <div class="filters-row">
                <!-- Campo de Pesquisa -->
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-search"></i>
                        Pesquisar Administradores
                    </label>
                    <div class="search-input-wrapper">
                        <input type="text" 
                               name="search" 
                               class="filter-input search-input" 
                               value="<?= e($search ?? '') ?>"
                               placeholder="Digite nome, email ou usuário..."
                               autocomplete="off">
                        <div class="search-input-icon">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>

                <!-- Filtro de Status -->
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-toggle-on"></i>
                        Filtrar por Status
                    </label>
                    <select name="status" class="filter-select">
                        <option value="">🔍 Todos os Status</option>
                        <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>
                            ✅ Somente Ativos
                        </option>
                        <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>
                            ⏸️ Somente Inativos
                        </option>
                    </select>
                </div>
            </div>
            
            <!-- Ações dos Filtros -->
            <div class="filters-actions">
                <div class="filters-actions-main">
                    <button type="submit" class="btn-search-filter">
                        <i class="fas fa-search"></i>
                        <span>Aplicar Filtros</span>
                    </button>
                    
                    <!-- Botão Limpar Filtros (condicional) -->
                    <div class="clear-filters-wrapper <?= (!empty($search) || !empty($status)) ? 'active' : 'inactive' ?>">
                        <a href="<?= url('/accounts') ?>" class="btn-clear-filters">
                            <i class="fas fa-eraser"></i>
                            <span>Limpar Filtros</span>
                        </a>
                    </div>
                </div>
                
                <!-- Info dos resultados -->
                <div class="filters-results-info">
                    <i class="fas fa-info-circle"></i>
                    <small>Encontrados <?= count($accounts ?? []) ?> administrador<?= count($accounts ?? []) !== 1 ? 'es' : '' ?></small>
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

            <!-- Paginação -->
            <?php if (!empty($pagination)): ?>
                <div class="table-pagination">
                    <div class="pagination-wrapper">
                        <?= renderPagination($pagination, url('/accounts')) ?>
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
                
                <!-- Campos organizados em duas colunas -->
                <div class="form-columns">
                    <!-- Coluna Esquerda -->
                    <div class="form-column left-column">
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-user"></i>
                                Informações Pessoais
                            </h4>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-signature"></i>
                                    Nome Completo *
                                </label>
                                <input type="text" name="name" class="form-input"
                                       placeholder="Ex: João Silva Santos" required>
                                <small class="form-hint">Nome que será exibido no sistema</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    Endereço de Email *
                                </label>
                                <input type="email" name="email" class="form-input"
                                       placeholder="admin@empresa.com" required>
                                <small class="form-hint">Email será usado para login</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-lock"></i>
                                    Senha *
                                </label>
                                <div class="password-input-wrapper">
                                    <input type="password" name="password" id="createPassword" class="form-input password-input"
                                           placeholder="Digite uma senha segura" required minlength="8">
                                    <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('createPassword')">
                                        <i class="fas fa-eye" id="createPasswordToggleIcon"></i>
                                    </button>
                                </div>

                                <!-- Indicador de Força da Senha -->
                                <div class="password-strength-container">
                                    <div class="password-strength-bar">
                                        <div class="strength-fill" id="createPasswordStrengthFill"></div>
                                    </div>
                                    <span class="strength-text" id="createPasswordStrengthText">Digite uma senha</span>
                                </div>

                                <!-- Requisitos da Senha -->
                                <div class="password-requirements" id="createPasswordRequirements">
                                    <div class="requirement" id="req-length">
                                        <i class="fas fa-times requirement-icon"></i>
                                        <span>Mínimo 8 caracteres</span>
                                    </div>
                                    <div class="requirement" id="req-uppercase">
                                        <i class="fas fa-times requirement-icon"></i>
                                        <span>Pelo menos 1 letra maiúscula</span>
                                    </div>
                                    <div class="requirement" id="req-lowercase">
                                        <i class="fas fa-times requirement-icon"></i>
                                        <span>Pelo menos 1 letra minúscula</span>
                                    </div>
                                    <div class="requirement" id="req-number">
                                        <i class="fas fa-times requirement-icon"></i>
                                        <span>Pelo menos 1 número</span>
                                    </div>
                                    <div class="requirement" id="req-special">
                                        <i class="fas fa-times requirement-icon"></i>
                                        <span>Pelo menos 1 símbolo (!@#$%^&*)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-phone"></i>
                                    Contacto Telefónico
                                </label>
                                <input type="tel" name="contact" class="form-input"
                                       placeholder="+244 912 345 678">
                                <small class="form-hint">Formato: +244 912 345 678</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Coluna Direita -->
                    <div class="form-column right-column">
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-cogs"></i>
                                Configurações da Conta
                            </h4>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-image"></i>
                                    Imagem do Perfil
                                </label>
                                <input type="url" name="img" class="form-input"
                                       placeholder="https://exemplo.com/imagem.jpg">
                                <small class="form-hint">URL da imagem ou deixe vazio para usar avatar padrão</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-building"></i>
                                    Tipo de Conta *
                                </label>
                                <select name="accountTypeId" class="form-select" required>
                                    <option value="">Selecionar tipo...</option>
                                    <?php if (!empty($accountTypes)): ?>
                                        <?php foreach ($accountTypes as $type): ?>
                                            <option value="<?= $type['id'] ?>"
                                                    <?= $type['id'] == 1 ? 'selected' : '' ?>>
                                                <?= e($type['type']) ?> - <?= e($type['description']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1" selected>INDIVIDUAL - Back Office Individual</option>
                                        <option value="2">CORPORATE - Corporate Account</option>
                                    <?php endif; ?>
                                </select>
                                <small class="form-hint">Define o tipo da conta de administrador</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-toggle-on"></i>
                                    Estado da Conta *
                                </label>
                                <select name="stateId" class="form-select" required>
                                    <option value="">Selecionar estado...</option>
                                    <?php if (!empty($states)): ?>
                                        <?php foreach ($states as $state): ?>
                                            <option value="<?= $state['id'] ?>"
                                                    <?= $state['id'] == 1 ? 'selected' : '' ?>>
                                                <?= e($state['state']) ?> - <?= e($state['description']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1" selected>ACTIVE - Ativo</option>
                                        <option value="2">INACTIVE - Inativo</option>
                                        <option value="3">PENDING - Pendente</option>
                                        <option value="4">ELIMINATED - Eliminado</option>
                                    <?php endif; ?>
                                </select>
                                <small class="form-hint">Estado inicial da conta do administrador</small>
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
            <!-- Profile Header -->
            <div class="admin-profile-header">
                <div class="profile-avatar-large">
                    <span id="viewAdminInitials">JS</span>
                </div>
                <div class="profile-info">
                    <h4 class="profile-name" id="viewAdminName">Nome do Administrador</h4>
                    <p class="profile-role" id="viewAdminRole">Administrador</p>
                    <div class="profile-status" id="viewAdminStatus">
                        <div class="status-indicator"></div>
                        <span>Status</span>
                    </div>
                </div>
            </div>
            
            <!-- Info Columns -->
            <div class="info-columns">
                <!-- Coluna Esquerda -->
                <div class="info-column">
                    <div class="info-section">
                        <h5 class="info-section-title">
                            <i class="fas fa-user"></i>
                            Informações Pessoais
                        </h5>
                        
                        <div class="info-item">
                            <label class="info-label">Nome Completo</label>
                            <div class="info-value" id="viewFullName">-</div>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Endereço de Email</label>
                            <div class="info-value email-value" id="viewEmail">-</div>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Contacto Telefónico</label>
                            <div class="info-value" id="viewContact">Não informado</div>
                        </div>
                    </div>
                </div>
                
                <!-- Coluna Direita -->
                <div class="info-column">
                    <div class="info-section">
                        <h5 class="info-section-title">
                            <i class="fas fa-cogs"></i>
                            Informações da Conta
                        </h5>
                        
                        <div class="info-item">
                            <label class="info-label">Nome de Usuário</label>
                            <div class="info-value username-value" id="viewUsername">-</div>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Data de Criação</label>
                            <div class="info-value" id="viewCreatedAt">-</div>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Última Atualização</label>
                            <div class="info-value" id="viewUpdatedAt">-</div>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Último Acesso</label>
                            <div class="info-value" id="viewLastLogin">Nunca acessou</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Notas -->
            <div class="info-section full-width">
                <h5 class="info-section-title">
                    <i class="fas fa-sticky-note"></i>
                    Notas Adicionais
                </h5>
                <div class="notes-content" id="viewNotes">Nenhuma nota disponível.</div>
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
                    <p class="card-subtitle">Atualize as informações do administrador</p>
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
                
                <!-- Campos organizados em duas colunas -->
                <div class="form-columns">
                    <!-- Coluna Esquerda -->
                    <div class="form-column left-column">
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-user"></i>
                                Informações Pessoais
                            </h4>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-signature"></i>
                                    Nome Completo *
                                </label>
                                <input type="text" name="name" id="editName" class="form-input" 
                                       placeholder="Ex: João Silva Santos" required>
                                <small class="form-hint">Nome que será exibido no sistema</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    Endereço de Email *
                                </label>
                                <input type="email" name="email" id="editEmail" class="form-input" 
                                       placeholder="admin@empresa.com" required>
                                <small class="form-hint">Email será usado para login</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-phone"></i>
                                    Contacto Telefónico
                                </label>
                                <input type="tel" name="contact" id="editContact" class="form-input" 
                                       placeholder="+351 912 345 678">
                                <small class="form-hint">Formato: +351 912 345 678</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Coluna Direita -->
                    <div class="form-column right-column">
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-cogs"></i>
                                Configurações da Conta
                            </h4>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user-circle"></i>
                                    Nome de Usuário *
                                </label>
                                <input type="text" name="username" id="editUsername" class="form-input" 
                                       placeholder="joao.silva" required>
                                <small class="form-hint">Usado para identificação interna</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user-shield"></i>
                                    Função/Papel
                                </label>
                                <select name="role_id" id="editRole" class="form-select">
                                    <option value="">Selecionar função...</option>
                                    <option value="1">Super Administrador</option>
                                    <option value="2">Administrador</option>
                                    <option value="3">Gestor</option>
                                    <option value="4">Operador</option>
                                </select>
                                <small class="form-hint">Define as permissões do usuário</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-toggle-on"></i>
                                    Status da Conta
                                </label>
                                <div class="status-toggle">
                                    <input type="hidden" name="state" value="INACTIVE">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="is_active" id="editIsActive" value="1">
                                        <span class="toggle-slider"></span>
                                    </label>
                                    <span class="toggle-label">Conta Ativa</span>
                                </div>
                                <small class="form-hint">Administradores ativos podem fazer login</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-sticky-note"></i>
                                    Notas Adicionais
                                </label>
                                <textarea name="notes" id="editNotes" class="form-textarea" rows="3" 
                                          placeholder="Informações adicionais sobre este administrador..."></textarea>
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
    // Avatar e informações principais
    document.getElementById('viewAdminInitials').textContent = getInitials(admin.name || admin.email);
    document.getElementById('viewAdminName').textContent = admin.name || 'Nome não informado';
    document.getElementById('viewAdminRole').textContent = admin.role_name || 'Administrador';
    
    // Status
    const statusElement = document.getElementById('viewAdminStatus');
    const isActive = (admin.state || admin.is_active) === 'ACTIVE' || admin.is_active === true || admin.is_active === 1;
    statusElement.className = `profile-status ${isActive ? 'active' : 'inactive'}`;
    statusElement.innerHTML = `
        <div class="status-indicator"></div>
        <span>${isActive ? 'Ativo' : 'Inativo'}</span>
    `;
    
    // Informações pessoais
    document.getElementById('viewFullName').textContent = admin.name || 'Não informado';
    document.getElementById('viewEmail').textContent = admin.email || 'Não informado';
    document.getElementById('viewContact').textContent = admin.contact || 'Não informado';
    
    // Informações da conta
    document.getElementById('viewUsername').textContent = admin.username || 'Não informado';
    document.getElementById('viewCreatedAt').textContent = formatDate(admin.createdAt) || 'Não disponível';
    document.getElementById('viewUpdatedAt').textContent = formatDate(admin.updatedAt) || 'Não disponível';
    document.getElementById('viewLastLogin').textContent = admin.last_login ? formatDate(admin.last_login) : 'Nunca acessou';
    
    // Notas
    document.getElementById('viewNotes').textContent = admin.notes || 'Nenhuma nota disponível.';
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
    document.getElementById('editAdminId').value = admin.id;
    document.getElementById('editName').value = admin.name || '';
    document.getElementById('editEmail').value = admin.email || '';
    document.getElementById('editContact').value = admin.contact || '';
    document.getElementById('editUsername').value = admin.username || '';
    document.getElementById('editRole').value = admin.role_id || '2';
    
    const isActive = (admin.state || admin.is_active) === 'ACTIVE' || admin.is_active === true || admin.is_active === 1;
    document.getElementById('editIsActive').checked = isActive;
    
    document.getElementById('editNotes').value = admin.notes || '';
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
        strengthText.textContent = 'Digite uma senha';
        strengthText.className = 'strength-text';
        requirementsContainer.classList.remove('show');
        return;
    }

    const result = checkPasswordStrength(password);

    // Atualizar barra de força
    strengthFill.className = `strength-fill ${result.strength}`;

    // Atualizar texto de força
    const strengthTexts = {
        weak: '🔴 Fraca - Adicione mais caracteres',
        fair: '🟡 Razoável - Quase lá!',
        good: '🔵 Boa - Senha segura',
        strong: '🟢 Forte - Excelente segurança!'
    };

    strengthText.textContent = strengthTexts[result.strength];
    strengthText.className = `strength-text ${result.strength}`;

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
            reqElement.className = `requirement ${isValid ? 'valid' : 'invalid'}`;
        }
    }
}

// ===========================================
// OUTRAS FUNÇÕES DA PÁGINA
// ===========================================

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
                this.form.submit();
            }, 800);
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
        
        const formData = new FormData(this);
        const id = formData.get('admin_id');
        
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
                showAlert(errorData.message || 'Erro ao atualizar administrador', 'danger');
            }
        } catch (error) {
            hideLoading();
            showAlert('Erro de conexão: ' + error.message, 'danger');
        }
    });
});
</script>