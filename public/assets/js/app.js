/**
 * Automo BackOffice JavaScript
 */

class AutomoApp {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeComponents();
        this.setupFormValidation();
        this.setupSearch();
        this.setupAjaxDefaults();
    }

    setupEventListeners() {
        // Sidebar toggle
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Store sidebar state
                this.storeSidebarState(sidebar);
            });
        }

        // Restore sidebar state
        this.restoreSidebarState(sidebar, mainContent);

        // Mobile sidebar toggle
        const mobileSidebarToggle = document.querySelector('.mobile-sidebar-toggle');
        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        }

        // Close mobile sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar?.contains(e.target) && !e.target.closest('.sidebar-toggle')) {
                    sidebar?.classList.remove('show');
                }
            }
        });

        // Submenu toggles
        document.querySelectorAll('.nav-link[data-toggle]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const submenu = link.nextElementSibling;
                const toggle = link.querySelector('.nav-toggle');
                
                if (submenu) {
                    submenu.classList.toggle('show');
                    if (toggle) {
                        toggle.innerHTML = submenu.classList.contains('show') ? '▲' : '▼';
                    }
                }
            });
        });

        // Set active navigation
        this.setActiveNavigation();
    }

    initializeComponents() {
        // Initialize tooltips if any
        this.initTooltips();
        
        // Initialize modals
        this.initModals();
        
        // Initialize data tables
        this.initDataTables();
    }

    setActiveNavigation() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPath) {
                link.classList.add('active');
                
                // Expand parent submenu if exists
                const parentSubmenu = link.closest('.nav-submenu');
                if (parentSubmenu) {
                    parentSubmenu.classList.add('show');
                    const parentToggle = parentSubmenu.previousElementSibling;
                    if (parentToggle) {
                        const toggle = parentToggle.querySelector('.nav-toggle');
                        if (toggle) {
                            toggle.innerHTML = '▲';
                        }
                    }
                }
            }
        });
    }

    setupFormValidation() {
        // Real-time form validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                }
            });

            // Real-time validation for form fields
            form.querySelectorAll('input, textarea, select').forEach(field => {
                field.addEventListener('blur', () => {
                    this.validateField(field);
                });
            });
        });
    }

    validateForm(form) {
        let isValid = true;
        const fields = form.querySelectorAll('input[required], textarea[required], select[required]');

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        const type = field.type;
        let isValid = true;
        let errorMessage = '';

        // Remove existing error styling
        field.classList.remove('is-invalid');
        this.removeFieldError(field);

        // Required validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required';
        }

        // Email validation
        if (type === 'email' && value && !this.isValidEmail(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address';
        }

        // Password validation
        if (type === 'password' && value && value.length < 6) {
            isValid = false;
            errorMessage = 'Password must be at least 6 characters';
        }

        // Number validation
        if (type === 'number' && value && isNaN(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid number';
        }

        if (!isValid) {
            field.classList.add('is-invalid');
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    showFieldError(field, message) {
        let errorElement = field.parentElement.querySelector('.field-error');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'field-error text-danger';
            errorElement.style.fontSize = '0.875rem';
            errorElement.style.marginTop = '0.25rem';
            field.parentElement.appendChild(errorElement);
        }
        errorElement.textContent = message;
    }

    removeFieldError(field) {
        const errorElement = field.parentElement.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    setupSearch() {
        // Global search functionality
        const searchInputs = document.querySelectorAll('.search-input');
        
        searchInputs.forEach(input => {
            let searchTimeout;
            
            input.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.performSearch(e.target.value, e.target);
                }, 300);
            });
        });
    }

    performSearch(query, inputElement) {
        const table = inputElement.closest('.card').querySelector('table tbody');
        if (!table) return;

        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const match = text.includes(query.toLowerCase());
            row.style.display = match ? '' : 'none';
        });

        // Update result count
        const visibleRows = table.querySelectorAll('tr[style=""], tr:not([style])');
        this.updateSearchResults(visibleRows.length, inputElement);
    }

    updateSearchResults(count, inputElement) {
        let resultElement = inputElement.parentElement.querySelector('.search-results');
        if (!resultElement) {
            resultElement = document.createElement('small');
            resultElement.className = 'search-results text-muted';
            inputElement.parentElement.appendChild(resultElement);
        }
        
        resultElement.textContent = `${count} results found`;
    }

    setupAjaxDefaults() {
        // Setup default headers for AJAX requests
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.csrfToken = token.getAttribute('content');
        }
    }

    // AJAX Utilities
    async apiRequest(method, url, data = null) {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        };

        if (window.csrfToken) {
            options.headers['X-CSRF-TOKEN'] = window.csrfToken;
        }

        if (data) {
            options.body = JSON.stringify(data);
        }

        try {
            const response = await fetch(url, options);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API Request failed:', error);
            this.showNotification('Request failed. Please try again.', 'error');
            throw error;
        }
    }

    // Notification System
    showNotification(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : type} notification`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease-out;
        `;
        notification.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <span>${message}</span>
                <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto remove after duration
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, duration);
    }

    // Modal utilities
    initModals() {
        document.querySelectorAll('[data-modal]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = trigger.getAttribute('data-modal');
                const modal = document.getElementById(modalId);
                if (modal) {
                    this.showModal(modal);
                }
            });
        });

        // Close modals
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal') || e.target.classList.contains('modal-close')) {
                e.target.closest('.modal')?.remove();
            }
        });
    }

    showModal(modal) {
        modal.style.display = 'flex';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    hideModal(modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }

    // Table utilities
    initDataTables() {
        document.querySelectorAll('.data-table').forEach(table => {
            this.enhanceTable(table);
        });
    }

    enhanceTable(table) {
        // Add sorting functionality
        const headers = table.querySelectorAll('th[data-sortable]');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.innerHTML += ' <span class="sort-icon">⇅</span>';
            
            header.addEventListener('click', () => {
                this.sortTable(table, header);
            });
        });
    }

    sortTable(table, header) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const columnIndex = Array.from(header.parentElement.children).indexOf(header);
        const sortIcon = header.querySelector('.sort-icon');
        
        // Determine sort direction
        const isAscending = !header.classList.contains('sort-desc');
        
        // Clear all sort classes and icons
        table.querySelectorAll('th').forEach(th => {
            th.classList.remove('sort-asc', 'sort-desc');
            const icon = th.querySelector('.sort-icon');
            if (icon) icon.innerHTML = '⇅';
        });
        
        // Sort rows
        rows.sort((a, b) => {
            const aVal = a.children[columnIndex].textContent.trim();
            const bVal = b.children[columnIndex].textContent.trim();
            
            // Try to parse as numbers first
            const aNum = parseFloat(aVal);
            const bNum = parseFloat(bVal);
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return isAscending ? aNum - bNum : bNum - aNum;
            } else {
                return isAscending ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
            }
        });
        
        // Update header classes and icon
        header.classList.add(isAscending ? 'sort-asc' : 'sort-desc');
        sortIcon.innerHTML = isAscending ? '▲' : '▼';
        
        // Reorder DOM elements
        rows.forEach(row => tbody.appendChild(row));
    }

    // Utility functions
    formatDate(dateString, format = 'DD/MM/YYYY HH:mm') {
        if (!dateString) return '';
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        
        return format
            .replace('DD', day)
            .replace('MM', month)
            .replace('YYYY', year)
            .replace('HH', hours)
            .replace('mm', minutes);
    }

    formatCurrency(amount, currency = 'AOA') {
        if (typeof amount !== 'number') return amount;
        return new Intl.NumberFormat('pt-AO', {
            style: 'currency',
            currency: currency
        }).format(amount);
    }

    debounce(func, wait) {
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

    // Storage utilities with error handling
    storageAvailable() {
        try {
            const test = '__storage_test__';
            localStorage.setItem(test, test);
            localStorage.removeItem(test);
            return true;
        } catch (e) {
            return false;
        }
    }

    storeSidebarState(sidebar) {
        if (!this.storageAvailable()) return;

        try {
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        } catch (e) {
            console.warn('Failed to store sidebar state:', e.message);
        }
    }

    restoreSidebarState(sidebar, mainContent) {
        if (!this.storageAvailable()) return;

        try {
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar?.classList.add('collapsed');
                mainContent?.classList.add('expanded');
            }
        } catch (e) {
            console.warn('Failed to restore sidebar state:', e.message);
        }
    }

    initTooltips() {
        // Simple tooltip implementation
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', (e) => {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = element.getAttribute('data-tooltip');
                tooltip.style.cssText = `
                    position: absolute;
                    background: rgba(0,0,0,0.8);
                    color: white;
                    padding: 0.5rem;
                    border-radius: 3px;
                    font-size: 0.875rem;
                    z-index: 10000;
                    pointer-events: none;
                `;
                
                document.body.appendChild(tooltip);
                
                const rect = element.getBoundingClientRect();
                tooltip.style.left = rect.left + 'px';
                tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';
                
                element._tooltip = tooltip;
            });
            
            element.addEventListener('mouseleave', (e) => {
                if (element._tooltip) {
                    element._tooltip.remove();
                    delete element._tooltip;
                }
            });
        });
    }
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .notification {
        animation: slideIn 0.3s ease-out;
    }
    
    .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
        margin-left: 1rem;
    }
    
    .sort-icon {
        font-size: 0.75rem;
        margin-left: 0.5rem;
        opacity: 0.6;
    }
    
    th.sort-asc .sort-icon,
    th.sort-desc .sort-icon {
        opacity: 1;
    }
`;
document.head.appendChild(style);

// Initialize app when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.automoApp = new AutomoApp();
});

// Export for global use
window.AutomoApp = AutomoApp;