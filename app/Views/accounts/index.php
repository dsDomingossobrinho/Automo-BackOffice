<?php
/**
 * Administradores - Interface Limpa e Profissional
 */
?>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    --surface-color: #ffffff;
    --background-color: #f8fafc;
    --border-color: #e2e8f0;
    --text-primary: #2d3748;
    --text-secondary: #4a5568;
    --text-muted: #718096;
    --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --radius-sm: 6px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --radius-xl: 16px;
}

.main-container {
    background: var(--background-color);
    min-height: 100vh;
    padding: 1rem;
    position: relative;
}

.main-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 200px;
    background: var(--primary-gradient);
    opacity: 0.03;
    z-index: 0;
}

.main-container > * {
    position: relative;
    z-index: 1;
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
    background: var(--surface-color);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
}

.page-header .header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.page-header .header-left h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
    letter-spacing: -0.025em;
}

.page-header .header-left p {
    color: var(--text-muted);
    margin: 0;
    font-size: 0.95rem;
}

.page-header .header-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

/* Enhanced Header Actions Area */
.header-actions {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
    justify-content: space-between;
}

@media (max-width: 991px) {
    .header-actions {
        justify-content: center;
    }
}

/* Statistics Card */
.stats-card {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    background: rgba(102, 126, 234, 0.08);
    border: 1px solid rgba(102, 126, 234, 0.2);
    border-radius: var(--radius-lg);
    padding: 1rem 1.25rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
    min-width: 200px;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--primary-gradient);
}

.stats-card:hover {
    background: rgba(102, 126, 234, 0.12);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.stats-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.stats-content {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.stats-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
}

.stats-label {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Quick Actions Area */
.quick-actions {
    display: flex;
    align-items: center;
}

.action-group {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Primary Add Button */
.btn-add-primary {
    background: var(--primary-gradient);
    border: none;
    border-radius: var(--radius-lg);
    color: white;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
    min-height: 60px;
}

.btn-add-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.btn-add-primary:hover::before {
    left: 100%;
}

.btn-add-primary:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.btn-add-primary .btn-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.btn-add-primary .btn-content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 0.125rem;
}

.btn-add-primary .btn-title {
    font-size: 0.95rem;
    font-weight: 600;
    line-height: 1.2;
}

.btn-add-primary .btn-subtitle {
    font-size: 0.75rem;
    opacity: 0.8;
    font-weight: 400;
}

/* Secondary Actions */
.secondary-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-action-secondary {
    background: rgba(113, 128, 150, 0.1);
    border: 1px solid rgba(113, 128, 150, 0.2);
    border-radius: var(--radius-md);
    color: var(--text-secondary);
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    font-weight: 500;
    position: relative;
    overflow: hidden;
}

.btn-action-secondary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(113, 128, 150, 0.1), transparent);
    transition: left 0.5s;
}

.btn-action-secondary:hover::before {
    left: 100%;
}

.btn-action-secondary:hover {
    background: rgba(113, 128, 150, 0.15);
    border-color: rgba(113, 128, 150, 0.3);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-action-secondary i {
    font-size: 0.8rem;
    width: 14px;
    text-align: center;
}

.btn-action-secondary .action-text {
    font-size: 0.8rem;
}

/* Enhanced Header Actions Responsiveness */
@media (max-width: 1200px) {
    .header-actions {
        gap: 1.5rem;
    }
    
    .stats-card {
        padding: 0.875rem 1rem;
    }
    
    .stats-icon {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
    
    .stats-number {
        font-size: 1.375rem;
    }
    
    .btn-add-primary {
        padding: 0.875rem 1.25rem;
        min-height: 56px;
    }
    
    .btn-add-primary .btn-icon {
        width: 28px;
        height: 28px;
        font-size: 0.8rem;
    }
    
    .btn-add-primary .btn-title {
        font-size: 0.9rem;
    }
    
    .btn-action-secondary {
        padding: 0.625rem 0.875rem;
    }
}

@media (max-width: 991px) {
    .page-header {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .page-header .header-content {
        gap: 1.5rem;
    }
    
    .page-header .header-left h2 {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }
    
    .page-header .header-left p {
        font-size: 0.875rem;
    }
    
    .header-actions {
        gap: 1.25rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .stats-card {
        order: 1;
        flex: 1;
        min-width: 200px;
        justify-content: center;
        margin-bottom: 0.75rem;
    }
    
    .quick-actions {
        order: 2;
        width: 100%;
        justify-content: center;
    }
    
    .action-group {
        flex-direction: column;
        gap: 0.75rem;
        width: 100%;
        max-width: 280px;
    }
    
    .btn-add-primary {
        width: 100%;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .secondary-actions {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 767px) {
    .page-header {
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }
    
    .page-header .header-content {
        flex-direction: column;
        align-items: stretch;
        gap: 1.5rem;
    }
    
    .page-header .header-left {
        text-align: center;
    }
    
    .page-header .header-left h2 {
        font-size: 1.375rem;
    }
    
    .page-header .header-right {
        width: 100%;
        justify-content: center;
    }
    
    .header-actions {
        flex-direction: column;
        gap: 1rem;
        width: 100%;
        align-items: center;
    }
    
    .stats-card {
        order: 1;
        width: 100%;
        max-width: 280px;
        padding: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .stats-icon {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
    }
    
    .stats-number {
        font-size: 1.25rem;
    }
    
    .stats-label {
        font-size: 0.75rem;
    }
    
    .quick-actions {
        order: 2;
        width: 100%;
    }
    
    .action-group {
        width: 100%;
        max-width: 280px;
        margin: 0 auto;
    }
    
    .btn-add-primary {
        padding: 1rem;
        min-height: 56px;
        gap: 0.75rem;
    }
    
    .btn-add-primary .btn-icon {
        width: 24px;
        height: 24px;
        font-size: 0.75rem;
    }
    
    .btn-add-primary .btn-title {
        font-size: 0.875rem;
    }
    
    .btn-add-primary .btn-subtitle {
        font-size: 0.7rem;
    }
    
    .secondary-actions {
        gap: 0.375rem;
    }
    
    .btn-action-secondary {
        padding: 0.625rem 0.75rem;
        font-size: 0.8rem;
        flex: 1;
    }
    
    .btn-action-secondary .action-text {
        font-size: 0.75rem;
    }
}

@media (max-width: 575px) {
    .page-header {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .page-header .header-left h2 {
        font-size: 1.25rem;
    }
    
    .page-header .header-left p {
        font-size: 0.8rem;
        display: none; /* Hide description on very small screens */
    }
    
    .header-actions {
        gap: 0.875rem;
    }
    
    .stats-card {
        padding: 0.875rem;
        gap: 0.75rem;
        max-width: 240px;
        min-width: 180px;
        margin: 0 auto;
    }
    
    .stats-icon {
        width: 28px;
        height: 28px;
        font-size: 0.8rem;
    }
    
    .stats-number {
        font-size: 1.125rem;
    }
    
    .stats-label {
        font-size: 0.7rem;
    }
    
    .action-group {
        max-width: 240px;
        gap: 0.625rem;
    }
    
    .btn-add-primary {
        padding: 0.875rem 1rem;
        min-height: 52px;
        gap: 0.625rem;
    }
    
    .btn-add-primary .btn-content {
        align-items: center;
        text-align: center;
    }
    
    .btn-add-primary .btn-title {
        font-size: 0.8rem;
    }
    
    .btn-add-primary .btn-subtitle {
        font-size: 0.65rem;
    }
    
    .secondary-actions {
        gap: 0.25rem;
    }
    
    .btn-action-secondary {
        padding: 0.5rem 0.625rem;
        font-size: 0.75rem;
    }
    
    .btn-action-secondary .action-text {
        display: none; /* Show only icons on very small screens */
    }
    
    .btn-action-secondary i {
        margin: 0;
    }
}

@media (min-width: 768px) {
    .page-header {
        padding: 2.5rem;
        margin-bottom: 2.5rem;
    }
    
    .page-header .header-content {
        flex-wrap: nowrap;
    }
    
    .page-header .header-left h2 {
        font-size: 2rem;
    }
}

.search-section {
    background: var(--surface-color);
    border-radius: var(--radius-xl);
    padding: 1.75rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.search-section:hover {
    box-shadow: var(--shadow-md);
}

/* Enhanced Typography Responsiveness */
@media (max-width: 991px) {
    .search-section {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .search-title {
        font-size: 1rem;
        gap: 0.625rem;
    }
    
    .search-title i {
        font-size: 0.9rem;
        width: 18px;
    }
    
    .search-subtitle {
        font-size: 0.8rem;
    }
}

@media (max-width: 767px) {
    .search-section {
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }
    
    .search-header {
        margin-bottom: 1.25rem;
        padding-bottom: 0.875rem;
        text-align: center;
    }
    
    .search-title {
        font-size: 0.95rem;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .search-title i {
        font-size: 0.875rem;
        width: 16px;
    }
    
    .search-subtitle {
        font-size: 0.775rem;
        margin-top: 0.375rem;
    }
    
    .search-field .form-label {
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
        gap: 0.375rem;
    }
    
    .search-field .form-label i {
        font-size: 0.8rem;
        width: 14px;
    }
    
    .search-field .form-text {
        font-size: 0.75rem;
        margin-top: 0.375rem;
    }
    
    .results-info {
        padding: 0.75rem;
        gap: 0.375rem;
    }
    
    .results-info i {
        font-size: 0.8rem;
        width: 14px;
    }
    
    .results-info small {
        font-size: 0.75rem;
    }
}

@media (max-width: 575px) {
    .search-section {
        padding: 1rem;
        margin-bottom: 1rem;
        margin-left: -0.5rem;
        margin-right: -0.5rem;
        border-radius: var(--radius-lg);
    }
    
    .search-header {
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
    }
    
    .search-title {
        font-size: 0.875rem;
        gap: 0.375rem;
    }
    
    .search-title i {
        font-size: 0.8rem;
        width: 14px;
    }
    
    .search-subtitle {
        font-size: 0.7rem;
        display: none; /* Hide on very small screens to save space */
    }
    
    .search-field .form-label {
        font-size: 0.75rem;
        margin-bottom: 0.375rem;
        gap: 0.25rem;
    }
    
    .search-field .form-label i {
        font-size: 0.75rem;
        width: 12px;
    }
    
    .search-field .form-text {
        font-size: 0.7rem;
        margin-top: 0.25rem;
    }
    
    .search-section .form-control,
    .search-section .form-select {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
    
    .results-info {
        padding: 0.625rem;
        gap: 0.25rem;
    }
    
    .results-info i {
        font-size: 0.75rem;
        width: 12px;
    }
    
    .results-info small {
        font-size: 0.7rem;
    }
}

/* Enhanced Search Section Styles */
.search-header {
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.search-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.625rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    line-height: 1.3;
}

.search-title i {
    color: #667eea;
    font-size: 1rem;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
}

.search-subtitle {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin: 0;
    line-height: 1.4;
    font-weight: 400;
}

.search-form-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.search-row {
    display: flex;
    flex-direction: column;
}

.search-field {
    width: 100%;
}

.search-field .form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.625rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    line-height: 1.4;
}

.search-field .form-label i {
    color: #667eea;
    opacity: 0.9;
    font-size: 0.875rem;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
}

.search-field .form-text {
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-muted);
    line-height: 1.3;
    padding-left: 0.25rem;
}

/* Enhanced Search Actions */
.search-actions {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.action-buttons-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.main-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Clear Filter Container with Smooth Transitions */
.clear-filter-container {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.clear-filter-container.inactive {
    width: 0;
    opacity: 0;
    transform: translateX(-20px);
    pointer-events: none;
}

.clear-filter-container.active {
    width: auto;
    opacity: 1;
    transform: translateX(0);
    pointer-events: all;
}

.btn-clear-filters {
    background: rgba(255, 107, 107, 0.1);
    border: 1px solid rgba(255, 107, 107, 0.3);
    color: #ff6b6b;
    padding: 0.875rem 1.5rem;
    border-radius: var(--radius-lg);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    white-space: nowrap;
    position: relative;
    overflow: hidden;
    min-height: 50px;
}

.btn-clear-filters::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 107, 107, 0.1), transparent);
    transition: left 0.6s;
}

.btn-clear-filters:hover::before {
    left: 100%;
}

.btn-clear-filters:hover {
    background: rgba(255, 107, 107, 0.15);
    border-color: #ff6b6b;
    color: #e55656;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    text-decoration: none;
}

/* Enhanced Results Info */
.results-info-container {
    width: 100%;
}

.results-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: rgba(102, 126, 234, 0.05);
    border: 1px solid rgba(102, 126, 234, 0.1);
    border-radius: var(--radius-lg);
    transition: all 0.3s ease;
}

.results-info:hover {
    background: rgba(102, 126, 234, 0.08);
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.info-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--primary-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.info-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    flex-grow: 1;
}

.info-status {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-secondary);
    line-height: 1.2;
}

.info-status.active {
    color: #667eea;
}

.info-detail {
    font-size: 0.8rem;
    color: var(--text-muted);
    line-height: 1.3;
}

.btn-primary-search,
.btn-secondary-search {
    padding: 0.875rem 2rem;
    border-radius: var(--radius-lg);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    min-height: 50px;
    position: relative;
    overflow: hidden;
}

.btn-primary-search {
    background: var(--primary-gradient);
    border: none;
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-primary-search::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.btn-primary-search:hover::before {
    left: 100%;
}

.btn-primary-search:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-xl);
}

.btn-secondary-search {
    background: linear-gradient(135deg, #718096, #4a5568);
    border: none;
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-secondary-search::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.btn-secondary-search:hover::before {
    left: 100%;
}

.btn-secondary-search:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-xl);
}

.results-info {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.875rem 1rem;
    background: rgba(102, 126, 234, 0.05);
    border-radius: var(--radius-md);
    border: 1px solid rgba(102, 126, 234, 0.1);
    gap: 0.5rem;
    line-height: 1.3;
}

.results-info i {
    color: #667eea;
    font-size: 0.875rem;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
}

.results-info small {
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--text-secondary);
}

/* Enhanced Responsive Layout */
@media (min-width: 768px) {
    .search-section {
        padding: 2rem 2.5rem;
        margin-bottom: 2.5rem;
    }
    
    .search-form-container {
        gap: 2rem;
    }
    
    .action-buttons {
        flex-direction: row;
        align-items: center;
        gap: 1.5rem;
    }
    
    .btn-primary-search,
    .btn-secondary-search {
        flex: 0 0 auto;
        min-width: 180px;
    }
    
    .results-info {
        flex: 1;
        justify-content: flex-end;
        margin-left: auto;
    }
}

@media (min-width: 992px) {
    .search-form-container {
        flex-direction: row;
        align-items: end;
        gap: 2rem;
    }
    
    .search-row {
        flex: 1;
    }
    
    .search-actions {
        flex: 0 0 auto;
        margin-top: 0;
        padding-top: 0;
        border-top: none;
        min-width: 200px;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }
}

.search-section .form-label {
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.search-section .form-control,
.search-section .form-select {
    border: 2px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 0.875rem 1.125rem;
    font-size: 0.95rem;
    background: var(--surface-color);
    color: var(--text-primary);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-sm);
}

.search-section .form-control:focus,
.search-section .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), var(--shadow-md);
    transform: translateY(-2px);
    outline: none;
}

.search-section .form-control::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

.table-container {
    background: var(--surface-color);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.table-container:hover {
    box-shadow: var(--shadow-lg);
}

.table {
    min-width: 800px;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

/* Enhanced Mobile Responsiveness */
@media (max-width: 991px) {
    .table-container {
        margin: 0 -0.5rem;
    }
    
    .table {
        font-size: 0.85rem;
        min-width: 100%;
    }
    
    .table thead th,
    .table tbody td {
        padding: 0.75rem 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .table thead th:first-child,
    .table tbody td:first-child {
        padding-left: 1rem;
    }
    
    .table thead th:last-child,
    .table tbody td:last-child {
        padding-right: 1rem;
    }
}

@media (max-width: 767px) {
    .main-container {
        padding: 0.75rem;
    }
    
    .table {
        font-size: 0.8rem;
    }
    
    .table thead th,
    .table tbody td {
        padding: 0.625rem 0.375rem;
        font-size: 0.75rem;
    }
    
    .table thead th:first-child,
    .table tbody td:first-child {
        padding-left: 0.75rem;
    }
    
    .table thead th:last-child,
    .table tbody td:last-child {
        padding-right: 0.75rem;
    }
    
    /* Hide less important columns on mobile */
    .table th:nth-child(4),
    .table td:nth-child(4) {
        display: none;
    }
    
    .btn-action {
        padding: 0.25rem 0.375rem;
        font-size: 0.7rem;
        margin: 0 0.125rem;
        min-width: auto;
    }
    
    .btn-action span {
        display: none;
    }
    
    .btn-action i {
        margin: 0;
    }
}

@media (max-width: 575px) {
    .table-container {
        margin: 0 -0.75rem;
        border-radius: var(--radius-lg);
    }
    
    .table thead th,
    .table tbody td {
        padding: 0.5rem 0.25rem;
    }
    
    .table thead th:first-child,
    .table tbody td:first-child {
        padding-left: 0.5rem;
    }
    
    .table thead th:last-child,
    .table tbody td:last-child {
        padding-right: 0.5rem;
    }
    
    /* Hide username column on very small screens */
    .table th:nth-child(6),
    .table td:nth-child(6) {
        display: none;
    }
    
    .avatar {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
        margin-right: 0.5rem;
    }
    
    .status-badge {
        padding: 0.25rem 0.5rem;
        font-size: 0.65rem;
        min-width: 60px;
    }
}

.table thead th {
    background: linear-gradient(135deg, #f7fafc, #edf2f7);
    border: none;
    padding: 1.5rem 1.75rem;
    font-weight: 700;
    color: var(--text-secondary);
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    position: relative;
    border-bottom: 2px solid var(--border-color);
}

.table thead th::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: var(--primary-gradient);
    opacity: 0.1;
}

.table tbody td {
    padding: 1.5rem 1.75rem;
    vertical-align: middle;
    border-top: 1px solid rgba(226, 232, 240, 0.5);
    background: var(--surface-color);
    color: var(--text-primary);
}

.table tbody tr {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.table tbody tr:hover td {
    background: transparent;
}

.btn-action {
    border-radius: var(--radius-md);
    margin: 0 0.25rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.825rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
}

.btn-action::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-action:hover::before {
    left: 100%;
}

.btn-action:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.btn-action.btn-outline-primary {
    background: rgba(102, 126, 234, 0.1);
    border-color: rgba(102, 126, 234, 0.3);
    color: #667eea;
}

.btn-action.btn-outline-primary:hover {
    background: var(--primary-gradient);
    border-color: transparent;
    color: white;
}

.btn-action.btn-outline-warning {
    background: rgba(250, 112, 154, 0.1);
    border-color: rgba(250, 112, 154, 0.3);
    color: #fa709a;
}

.btn-action.btn-outline-warning:hover {
    background: var(--warning-gradient);
    border-color: transparent;
    color: white;
}

.btn-action.btn-outline-danger {
    background: rgba(255, 107, 107, 0.1);
    border-color: rgba(255, 107, 107, 0.3);
    color: #ff6b6b;
}

.btn-action.btn-outline-danger:hover {
    background: var(--danger-gradient);
    border-color: transparent;
    color: white;
}

@media (max-width: 767px) {
    .btn-action {
        padding: 0.375rem 0.625rem;
        font-size: 0.75rem;
        margin: 0 0.125rem;
    }
}

.avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--primary-gradient);
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin-right: 1rem;
    font-size: 1rem;
    flex-shrink: 0;
    box-shadow: var(--shadow-md);
    border: 3px solid white;
    position: relative;
    transition: all 0.3s ease;
}

.avatar::before {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    border-radius: 50%;
    background: var(--primary-gradient);
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.avatar:hover::before {
    opacity: 0.2;
}

.avatar:hover {
    transform: scale(1.1);
    box-shadow: var(--shadow-lg);
}

@media (min-width: 768px) {
    .avatar {
        width: 52px;
        height: 52px;
        margin-right: 1.25rem;
        font-size: 1.125rem;
    }
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-width: 80px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.status-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.status-badge:hover::before {
    left: 100%;
}

.status-badge.bg-success {
    background: var(--success-gradient) !important;
    color: white;
    box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
}

.status-badge.bg-success:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(79, 172, 254, 0.6);
}

.status-badge.bg-secondary {
    background: linear-gradient(135deg, #718096, #4a5568) !important;
    color: white;
    box-shadow: 0 4px 15px rgba(113, 128, 150, 0.4);
}

.status-badge.bg-secondary:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(113, 128, 150, 0.6);
}

@media (min-width: 768px) {
    .status-badge {
        padding: 0.625rem 1.25rem;
        font-size: 0.8rem;
        min-width: 90px;
    }
}

/* Enhanced Modal/Card System */
.card-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 1050;
    display: none;
    overflow-y: auto;
    padding: 1rem;
    animation: modalFadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes modalFadeIn {
    from { 
        opacity: 0;
        backdrop-filter: blur(0px);
    }
    to { 
        opacity: 1;
        backdrop-filter: blur(8px);
    }
}

.action-card {
    position: relative;
    margin: 2rem auto;
    background: var(--surface-color);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    width: 100%;
    max-width: 680px;
    transform: none;
    animation: modalSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid var(--border-color);
    overflow: hidden;
    position: relative;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
    z-index: 1;
}

/* Enhanced Card/Modal Responsiveness */
@media (max-width: 991px) {
    .action-card {
        max-width: 95%;
        margin: 1rem auto;
    }
}

@media (max-width: 767px) {
    .card-overlay {
        padding: 0.75rem;
        overflow-y: auto;
    }
    
    .action-card {
        position: relative;
        top: auto;
        left: auto;
        transform: none;
        margin: 0;
        width: 100%;
        max-width: 100%;
        max-height: none;
        border-radius: var(--radius-lg);
    }
}

@media (max-width: 575px) {
    .card-overlay {
        padding: 0.5rem;
    }
    
    .action-card {
        border-radius: var(--radius-md);
    }
    
    .card-header {
        padding: 1rem 1.25rem;
        border-radius: var(--radius-md) var(--radius-md) 0 0;
    }
    
    .card-header h4 {
        font-size: 1rem;
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    .card-body .row .col-md-6,
    .card-body .row .col-md-4 {
        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
        margin-bottom: 1rem;
    }
    
    .card-body .form-control,
    .card-body .form-select {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
    
    .card-footer {
        padding: 1rem 1.25rem;
        border-radius: 0 0 var(--radius-md) var(--radius-md);
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .card-footer .btn {
        width: 100%;
        margin: 0;
        justify-content: center;
    }
}

/* Enhanced Card Responsiveness */
@media (max-width: 991px) {
    .action-card {
        max-width: 95%;
        margin: 1.5rem auto;
    }
    
    .card-header {
        padding: 1.75rem 2rem 1.25rem 2rem;
    }
    
    .card-header h4 {
        font-size: 1.125rem;
    }
    
    .card-header h4 i {
        width: 20px;
        height: 20px;
        font-size: 0.8rem;
    }
    
    .card-body {
        padding: 1.75rem 2rem;
    }
    
    .card-footer {
        padding: 1.25rem 2rem 1.75rem 2rem;
    }
}

@media (max-width: 767px) {
    .card-overlay {
        padding: 0.75rem;
    }
    
    .action-card {
        margin: 1rem auto;
        border-radius: var(--radius-lg);
    }
    
    .card-header {
        padding: 1.5rem 1.75rem 1rem 1.75rem;
        text-align: center;
    }
    
    .card-header h4 {
        font-size: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .card-header h4 i {
        width: 18px;
        height: 18px;
        font-size: 0.75rem;
    }
    
    .card-body {
        padding: 1.5rem 1.75rem;
    }
    
    .card-body .form-group {
        margin-bottom: 1.25rem;
    }
    
    .card-body .form-label {
        font-size: 0.85rem;
        margin-bottom: 0.625rem;
    }
    
    .card-body .form-control,
    .card-body .form-select {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
    
    .card-body .form-text {
        font-size: 0.75rem;
        margin-top: 0.375rem;
    }
    
    .card-footer {
        padding: 1rem 1.75rem 1.5rem 1.75rem;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .card-footer .btn {
        width: 100%;
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        min-height: 44px;
    }
}

@media (max-width: 575px) {
    .card-overlay {
        padding: 0.5rem;
    }
    
    .action-card {
        margin: 0.5rem auto;
        border-radius: var(--radius-md);
        max-width: 100%;
    }
    
    .card-header {
        padding: 1.25rem 1.5rem 0.875rem 1.5rem;
    }
    
    .card-header h4 {
        font-size: 0.95rem;
        gap: 0.375rem;
    }
    
    .card-header h4 i {
        width: 16px;
        height: 16px;
        font-size: 0.7rem;
    }
    
    .card-body {
        padding: 1.25rem 1.5rem;
    }
    
    .card-body .form-group {
        margin-bottom: 1rem;
    }
    
    .card-body .form-label {
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }
    
    .card-body .form-control,
    .card-body .form-select {
        padding: 0.675rem 0.875rem;
        font-size: 0.875rem;
        border-radius: var(--radius-md);
    }
    
    .card-body .form-text {
        font-size: 0.7rem;
        margin-top: 0.25rem;
    }
    
    .card-footer {
        padding: 0.875rem 1.5rem 1.25rem 1.5rem;
        gap: 0.625rem;
    }
    
    .card-footer .btn {
        padding: 0.675rem 1.25rem;
        font-size: 0.85rem;
        min-height: 40px;
        border-radius: var(--radius-md);
    }
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

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(60px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes modalSlideOut {
    from {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    to {
        opacity: 0;
        transform: translateY(-60px) scale(0.9);
    }
}

@keyframes shimmer {
    0% {
        background-position: -200px 0;
    }
    100% {
        background-position: calc(200px + 100%) 0;
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

@media (min-width: 768px) {
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translate(-50%, -40px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
    }
}

/* Enhanced Card Components */
.card-header {
    padding: 2rem 2.5rem 1.5rem 2.5rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--surface-color);
    position: relative;
    z-index: 2;
}

.card-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--border-color), transparent);
}

.card-header h4 {
    font-weight: 700;
    font-size: 1.25rem;
    margin: 0;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    line-height: 1.3;
}

.card-header h4 i {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.card-header h4 i.text-primary {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.card-header h4 i.text-info {
    background: rgba(79, 172, 254, 0.1);
    color: #4facfe;
}

.card-header h4 i.text-warning {
    background: rgba(250, 112, 154, 0.1);
    color: #fa709a;
}

.card-header h4 i.text-danger {
    background: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
}

.card-body {
    padding: 2rem 2.5rem;
    background: var(--surface-color);
    position: relative;
}

.card-body.loading {
    background: linear-gradient(
        90deg,
        var(--surface-color) 25%,
        rgba(102, 126, 234, 0.02) 50%,
        var(--surface-color) 75%
    );
    background-size: 200px 100%;
    animation: shimmer 1.5s infinite;
}

.card-footer {
    padding: 1.5rem 2.5rem 2rem 2.5rem;
    border-top: 1px solid var(--border-color);
    background: var(--surface-color);
    position: relative;
}

.card-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--border-color), transparent);
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

/* Enhanced Form Controls in Cards */
.card-body .form-group {
    margin-bottom: 1.5rem;
    position: relative;
}

.card-body .form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-body .form-label .required {
    color: #ff6b6b;
    font-size: 0.8rem;
}

.card-body .form-control,
.card-body .form-select {
    border: 2px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 0.875rem 1.125rem;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: var(--surface-color);
    color: var(--text-primary);
    box-shadow: var(--shadow-sm);
    position: relative;
}

.card-body .form-control:focus,
.card-body .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), var(--shadow-md);
    transform: translateY(-2px);
    outline: none;
}

.card-body .form-control::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

.card-body .form-text {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-top: 0.5rem;
    line-height: 1.4;
    padding-left: 0.25rem;
}

.card-body .input-group {
    position: relative;
}

.card-body .input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    z-index: 2;
}

.card-body .form-control.with-icon {
    padding-left: 2.75rem;
}

/* Enhanced Card Buttons */
.card-footer .btn {
    border-radius: var(--radius-lg);
    padding: 0.875rem 2rem;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    min-height: 48px;
}

.card-footer .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.card-footer .btn:hover::before {
    left: 100%;
}

.card-footer .btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.card-footer .btn-primary {
    background: var(--primary-gradient);
    border: none;
    color: white;
    box-shadow: var(--shadow-md);
}

.card-footer .btn-secondary {
    background: linear-gradient(135deg, #718096, #4a5568);
    border: none;
    color: white;
    box-shadow: var(--shadow-md);
}

.card-footer .btn-danger {
    background: var(--danger-gradient);
    border: none;
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-primary-custom {
    background: var(--primary-gradient);
    border: none;
    color: white;
    padding: 0.875rem 2rem;
    border-radius: var(--radius-lg);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.btn-primary-custom:hover::before {
    left: 100%;
}

.btn-secondary-custom {
    background: linear-gradient(135deg, #718096, #4a5568);
    border: none;
    color: white;
    padding: 0.875rem 2rem;
    border-radius: var(--radius-lg);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-secondary-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.btn-secondary-custom:hover::before {
    left: 100%;
}

/* Enhanced Button Responsiveness */
@media (max-width: 991px) {
    .btn-primary-custom,
    .btn-secondary-custom {
        padding: 0.75rem 1.75rem;
        font-size: 0.9rem;
    }
}

@media (max-width: 767px) {
    .btn-primary-custom,
    .btn-secondary-custom {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        min-height: 42px;
        white-space: nowrap;
    }
}

@media (max-width: 575px) {
    .btn-primary-custom,
    .btn-secondary-custom {
        padding: 0.75rem 1.25rem;
        font-size: 0.85rem;
        width: 100%;
        justify-content: center;
    }
    
    .btn-primary-custom span,
    .btn-secondary-custom span {
        display: inline; /* Ensure text shows on small screens for important buttons */
    }
}

@media (min-width: 768px) {
    .btn-primary-custom,
    .btn-secondary-custom {
        padding: 1rem 2.5rem;
        font-size: 1rem;
    }
}

.btn-primary-custom:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.btn-secondary-custom:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.btn-primary-custom:focus,
.btn-secondary-custom:focus {
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3), var(--shadow-lg);
    transform: translateY(-2px);
    outline: none;
}

.btn-primary-custom:active,
.btn-secondary-custom:active {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

/* Enhanced Visual Elements for Cards */
.card-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0%;
    height: 3px;
    background: var(--primary-gradient);
    transition: width 0.3s ease;
}

.card-loading .card-progress {
    width: 100%;
    animation: pulse 1.5s infinite;
}

.card-success {
    animation: successPulse 0.6s ease-out;
}

@keyframes successPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

.card-error {
    animation: errorShake 0.5s ease-in-out;
}

@keyframes errorShake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Enhanced Empty State in Cards */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--text-muted);
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    background: rgba(102, 126, 234, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #667eea;
    position: relative;
    overflow: hidden;
}

.empty-state-icon::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(102, 126, 234, 0.1), transparent);
    animation: rotate 3s linear infinite;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.empty-state h4 {
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.empty-state p {
    color: var(--text-muted);
    font-size: 0.9rem;
    line-height: 1.5;
}

/* Enhanced Spinner */
.spinner-border {
    width: 2rem;
    height: 2rem;
    border-width: 0.25em;
    border-color: #667eea;
    border-right-color: transparent;
}

/* Additional Mobile Optimizations */
.text-nowrap {
    white-space: nowrap !important;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Enhanced Focus Management */
.card-overlay.show {
    display: block;
}

.card-overlay.hide {
    animation: modalSlideOut 0.3s ease-out forwards;
}

/* Improved Empty State for Mobile */
@media (max-width: 767px) {
    .table-container .text-center {
        padding: 2rem 1rem;
    }
    
    .table-container .text-center .d-inline-block {
        padding: 2rem;
    }
    
    .table-container .text-center i {
        font-size: 2.5rem !important;
    }
    
    .table-container .text-center h4 {
        font-size: 1.125rem;
    }
    
    .table-container .text-center p {
        font-size: 0.875rem;
        padding: 0 1rem;
    }
}

/* Enhanced Focus States for Accessibility */
.btn:focus,
.form-control:focus,
.form-select:focus,
.page-link:focus {
    outline: 2px solid rgba(102, 126, 234, 0.5);
    outline-offset: 2px;
}

/* Smooth Scroll for Better UX */
html {
    scroll-behavior: smooth;
}

/* Loading Spinner Improvements */
.spinner-border {
    color: var(--primary-gradient);
}

/* Better Link Styling */
.page-link {
    color: var(--text-secondary);
    border-color: var(--border-color);
    transition: all 0.3s ease;
}

.page-link:hover,
.page-link:focus {
    color: #667eea;
    background-color: rgba(102, 126, 234, 0.1);
    border-color: rgba(102, 126, 234, 0.3);
}

.page-item.active .page-link {
    background: var(--primary-gradient);
    border-color: transparent;
    color: white;
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

/* Enhanced Table Action Buttons */
.action-buttons-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 60px;
    padding: 0.5rem 0;
}

.action-buttons-group {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
    align-items: stretch;
    width: 100%;
    max-width: 120px;
}

.btn-action-table {
    border-radius: var(--radius-md);
    padding: 0.5rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-width: 1.5px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 0.5rem;
    min-height: 36px;
    white-space: nowrap;
}

.btn-action-table::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s;
}

.btn-action-table:hover::before {
    left: 100%;
}

.btn-action-table:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-action-table i {
    font-size: 0.75rem;
    width: 12px;
    text-align: center;
    flex-shrink: 0;
}

.btn-action-table .btn-text {
    font-size: 0.75rem;
    font-weight: 600;
    flex-grow: 1;
    text-align: left;
}

.btn-action-table.btn-outline-primary {
    background: rgba(102, 126, 234, 0.08);
    border-color: rgba(102, 126, 234, 0.3);
    color: #667eea;
}

.btn-action-table.btn-outline-primary:hover {
    background: rgba(102, 126, 234, 0.15);
    border-color: #667eea;
    color: #5a67d8;
}

.btn-action-table.btn-outline-warning {
    background: rgba(250, 112, 154, 0.08);
    border-color: rgba(250, 112, 154, 0.3);
    color: #fa709a;
}

.btn-action-table.btn-outline-warning:hover {
    background: rgba(250, 112, 154, 0.15);
    border-color: #fa709a;
    color: #e85d75;
}

.btn-action-table.btn-outline-danger {
    background: rgba(255, 107, 107, 0.08);
    border-color: rgba(255, 107, 107, 0.3);
    color: #ff6b6b;
}

.btn-action-table.btn-outline-danger:hover {
    background: rgba(255, 107, 107, 0.15);
    border-color: #ff6b6b;
    color: #e55656;
}

/* Responsive Table Actions */
@media (min-width: 768px) {
    .action-buttons-container .action-buttons-group {
        flex-direction: row;
        max-width: 200px;
        gap: 0.25rem;
    }
    
    .btn-action-table {
        flex: 1;
        justify-content: center;
        min-width: 60px;
    }
    
    .btn-action-table .btn-text {
        display: none;
    }
}

@media (min-width: 992px) {
    .action-buttons-container .action-buttons-group {
        max-width: 240px;
        gap: 0.375rem;
    }
    
    .btn-action-table {
        padding: 0.5rem 0.875rem;
        min-width: 70px;
    }
    
    .btn-action-table .btn-text {
        display: inline;
        font-size: 0.7rem;
    }
}

@media (max-width: 767px) {
    .action-buttons-container {
        min-height: auto;
        padding: 0.25rem 0;
    }
    
    .action-buttons-container .action-buttons-group {
        gap: 0.25rem;
        max-width: 100px;
    }
    
    .btn-action-table {
        padding: 0.375rem 0.5rem;
        font-size: 0.7rem;
        min-height: 30px;
    }
    
    .btn-action-table i {
        font-size: 0.7rem;
    }
    
    .btn-action-table .btn-text {
        font-size: 0.7rem;
    }
}
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h2>Administradores</h2>
                <p>Gerencie os administradores do sistema com segurança e eficiência</p>
            </div>
            <div class="header-right">
                <div class="header-actions">
                    <!-- Statistics Card -->
                    <div class="stats-card">
                        <div class="stats-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number"><?= count($accounts ?? []) ?></div>
                            <div class="stats-label">
                                Administrador<?= count($accounts ?? []) !== 1 ? 'es' : '' ?>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <div class="action-group">
                            <!-- Primary Action Button -->
                            <button class="btn btn-add-primary" onclick="openCreateCard()">
                                <div class="btn-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="btn-content">
                                    <span class="btn-title">Novo Administrador</span>
                                    <small class="btn-subtitle">Criar conta</small>
                                </div>
                            </button>
                            
                            <!-- Secondary Actions -->
                            <div class="secondary-actions">
                                <button class="btn btn-action-secondary" title="Exportar Lista" data-bs-toggle="tooltip">
                                    <i class="fas fa-download"></i>
                                    <span class="action-text">Exportar</span>
                                </button>
                                <button class="btn btn-action-secondary" title="Atualizar Lista" data-bs-toggle="tooltip">
                                    <i class="fas fa-sync-alt"></i>
                                    <span class="action-text">Atualizar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Search Section with Vertical Layout -->
    <div class="search-section">
        <div class="search-header mb-4">
            <h5 class="search-title">
                <i class="fas fa-filter me-2"></i>Filtros de Pesquisa
            </h5>
            <p class="search-subtitle">Use os filtros abaixo para encontrar administradores específicos</p>
        </div>
        
        <form method="GET" action="<?= url('/accounts') ?>">
            <div class="search-form-container">
                <!-- Search Input Row -->
                <div class="search-row">
                    <div class="search-field">
                        <label class="form-label">
                            <i class="fas fa-search me-1"></i>Pesquisar Administradores
                        </label>
                        <input type="text" 
                               name="search" 
                               class="form-control search-input" 
                               value="<?= e($search ?? '') ?>"
                               placeholder="Ex: João Silva, joao@email.com ou jsilva..."
                               autocomplete="off"
                               spellcheck="false">
                        <small class="form-text text-muted">💡 Busque por nome completo, endereço de email ou nome de usuário</small>
                    </div>
                </div>

                <!-- Status Filter Row -->
                <div class="search-row">
                    <div class="search-field">
                        <label class="form-label">
                            <i class="fas fa-toggle-on me-1"></i>Filtrar por Status
                        </label>
                        <select name="status" class="form-select search-input">
                            <option value="">🔍 Todos os Status</option>
                            <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>
                                ✅ Somente Ativos
                            </option>
                            <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>
                                ⏸️ Somente Inativos
                            </option>
                        </select>
                        <small class="form-text text-muted">🎯 Visualize apenas administradores com o status selecionado</small>
                    </div>
                </div>

                <!-- Enhanced Action Buttons Row -->
                <div class="search-actions">
                    <div class="action-buttons-container">
                        <!-- Main Actions -->
                        <div class="main-actions">
                            <button type="submit" class="btn btn-primary-search">
                                <i class="fas fa-search"></i>
                                <span>Aplicar Filtros</span>
                            </button>
                            
                            <!-- Clear Filters Button - Always present but conditionally styled -->
                            <div class="clear-filter-container <?= (!empty($search) || !empty($status)) ? 'active' : 'inactive' ?>">
                                <a href="<?= url('/accounts') ?>" class="btn btn-clear-filters">
                                    <i class="fas fa-times"></i>
                                    <span>Limpar Filtros</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Results Information -->
                        <div class="results-info-container">
                            <div class="results-info">
                                <div class="info-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="info-content">
                                    <?php if (!empty($search) || !empty($status)): ?>
                                        <span class="info-status active">Filtros Aplicados</span>
                                        <small class="info-detail"><?= count($accounts ?? []) ?> resultado(s) encontrado(s)</small>
                                    <?php else: ?>
                                        <span class="info-status">Estado Normal</span>
                                        <small class="info-detail">Mostrando todos os administradores</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <?php if (empty($accounts)): ?>
            <div class="text-center py-5">
                <div class="mb-4">
                    <div class="d-inline-block p-4 rounded-circle bg-light">
                        <i class="fas fa-users" style="font-size: 3rem; color: var(--text-muted);"></i>
                    </div>
                </div>
                <h4 class="mb-3" style="color: var(--text-secondary);">Nenhum administrador encontrado</h4>
                <p class="mb-4" style="color: var(--text-muted);">Não há administradores cadastrados ou que correspondam aos filtros aplicados.</p>
                <button class="btn btn-primary-custom" onclick="openCreateCard()">
                    <i class="fas fa-plus"></i>
                    <span>Criar Primeiro Administrador</span>
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
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark border" style="font-family: monospace; font-size: 0.8rem;">
                                        <i class="fas fa-at me-1" style="font-size: 0.7rem; opacity: 0.7;"></i>
                                        <?= e($account['username'] ?? 'N/A') ?>
                                    </span>
                                </div>
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
                                <div class="action-buttons-container">
                                    <div class="action-buttons-group">
                                        <button class="btn btn-outline-primary btn-action-table" 
                                                onclick="viewAdmin(<?= $account['id'] ?>)" 
                                                title="Visualizar Administrador"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                            <span class="btn-text">Ver</span>
                                        </button>
                                        <button class="btn btn-outline-warning btn-action-table" 
                                                onclick="editAdmin(<?= $account['id'] ?>)" 
                                                title="Editar Administrador"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                            <span class="btn-text">Editar</span>
                                        </button>
                                        <button class="btn btn-outline-danger btn-action-table" 
                                                onclick="deleteAdmin(<?= $account['id'] ?>, '<?= e($account['name'] ?? $account['email']) ?>')" 
                                                title="Eliminar Administrador"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-trash"></i>
                                            <span class="btn-text">Excluir</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Enhanced Responsive Pagination -->
            <?php if (($pagination['total_pages'] ?? 1) > 1): ?>
                <div class="p-3 border-top">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="text-muted d-none d-md-block">
                            Mostrando <?= (($pagination['current_page'] - 1) * ($pagination['size'] ?? 15)) + 1 ?> a 
                            <?= min($pagination['current_page'] * ($pagination['size'] ?? 15), $pagination['total_elements'] ?? 0) ?> 
                            de <?= number_format($pagination['total_elements'] ?? 0) ?> registros
                        </div>
                        <div class="text-muted d-md-none text-center w-100 mb-2" style="font-size: 0.8rem;">
                            Página <?= $pagination['current_page'] ?> de <?= $pagination['total_pages'] ?>
                        </div>
                        <nav class="d-flex justify-content-center w-100 w-md-auto">
                            <ul class="pagination mb-0 flex-wrap justify-content-center">
                                <?php if ($pagination['current_page'] > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= url('/accounts') ?>?page=<?= $pagination['current_page'] - 1 ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?><?= !empty($status) ? '&status='.$status : '' ?>" style="padding: 0.5rem 0.75rem;">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php 
                                // Mobile: Show fewer pages
                                $isMobile = true; // This would be determined by user agent in real scenario
                                $start = max(1, $pagination['current_page'] - ($isMobile ? 1 : 2));
                                $end = min($pagination['total_pages'], $pagination['current_page'] + ($isMobile ? 1 : 2));
                                
                                for ($i = $start; $i <= $end; $i++): ?>
                                    <li class="page-item <?= $i === $pagination['current_page'] ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= url('/accounts') ?>?page=<?= $i ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?><?= !empty($status) ? '&status='.$status : '' ?>" style="padding: 0.5rem 0.75rem; min-width: 40px; text-align: center;">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= url('/accounts') ?>?page=<?= $pagination['current_page'] + 1 ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?><?= !empty($status) ? '&status='.$status : '' ?>" style="padding: 0.5rem 0.75rem;">
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