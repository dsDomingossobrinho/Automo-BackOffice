<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $csrf_token ?>">
    <title><?= getPageTitle() ?> - <?= APP_NAME ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/automo-logo.png') ?>">
    
    <!-- Preload Critical Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/base-layout.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="logo-icon">
                        <img src="<?= asset('images/automo-logo.png') ?>" alt="Automo Logo" />
                    </div>
                    <div class="logo-text">
                        <h3>Automo</h3>
                        <p>BackOffice v<?= APP_VERSION ?></p>
                    </div>
                </div>
            </div>
            
            <ul class="sidebar-nav">
                <?php foreach ($menus as $menu): ?>
                    <?php if (isset($menu['group'])): ?>
                        <li class="nav-group"><?= e($menu['group']) ?></li>
                    <?php elseif (isset($menu['children'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="submenu" aria-expanded="false">
                                <div class="nav-link-content">
                                    <div class="nav-icon">
                                        <i class="fas fa-<?= $menu['icon'] ?? 'circle' ?>"></i>
                                    </div>
                                    <span class="nav-label"><?= e($menu['label']) ?></span>
                                </div>
                                <span class="nav-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </a>
                            <ul class="nav-submenu">
                                <?php foreach ($menu['children'] as $child): ?>
                                    <li class="nav-item">
                                        <a href="<?= url($child['to']) ?>" class="nav-sublink" 
                                           <?= isset($child['title']) ? 'title="' . e($child['title']) . '"' : '' ?>>
                                            <div class="nav-sublink-content">
                                                <div class="nav-submenu-icon">
                                                    <i class="fas fa-<?= $child['icon'] ?? 'circle' ?>"></i>
                                                </div>
                                                <span><?= e($child['label']) ?></span>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="<?= url($menu['to']) ?>" class="nav-link <?= ($_SERVER['REQUEST_URI'] === $menu['to'] || strpos($_SERVER['REQUEST_URI'], $menu['to']) === 0) ? 'active' : '' ?>">
                                <div class="nav-link-content">
                                    <div class="nav-icon">
                                        <i class="fas fa-<?= $menu['icon'] ?? 'circle' ?>"></i>
                                    </div>
                                    <span class="nav-label"><?= e($menu['label']) ?></span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="main-header">
                <div class="header-left">
                    <button class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="header-title-section">
                        <h1><?= getPageTitle() ?></h1>
                        <div class="header-breadcrumb">
                            <?php $breadcrumbs = getBreadcrumbs(); ?>
                            <?php if (count($breadcrumbs) > 1): ?>
                                <?php foreach ($breadcrumbs as $index => $crumb): ?>
                                    <?php if ($index > 0): ?>
                                        <span class="breadcrumb-separator">/</span>
                                    <?php endif; ?>
                                    <span class="breadcrumb-item <?= !$crumb['url'] ? 'active' : '' ?>">
                                        <?php if ($crumb['url']): ?>
                                            <a href="<?= url($crumb['url']) ?>"><?= e($crumb['label']) ?></a>
                                        <?php else: ?>
                                            <?= e($crumb['label']) ?>
                                        <?php endif; ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="header-right">
                    <?php if ($is_authenticated && $current_user): ?>
                        <button class="notification-btn" title="Notificações">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        
                        <div class="user-menu">
                            <div class="user-info">
                                <div class="user-avatar">
                                    <?php
                                    $displayName = $current_user['name'] ?? $current_user['firstName'] ?? '';
                                    if (empty($displayName)) {
                                        $displayName = explode('@', $current_user['email'] ?? 'Admin')[0];
                                    }
                                    echo strtoupper(substr($displayName, 0, 1));
                                    ?>
                                    <div class="user-status-indicator"></div>
                                </div>
                                <div class="user-details">
                                    <h6><?php
                                    $userName = $current_user['name'] ?? $current_user['firstName'] ?? '';
                                    if (empty($userName)) {
                                        $userName = ucfirst(explode('@', $current_user['email'] ?? 'Admin')[0]);
                                    }
                                    echo e($userName);
                                    ?></h6>
                                    <p><?= e($current_user['email'] ?? 'admin@automo.com') ?></p>
                                </div>
                                <div class="user-dropdown-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="user-dropdown">
                                <div class="dropdown-section">
                                    <a href="#" class="dropdown-item">
                                        <i class="fas fa-user"></i>
                                        <span>Meu Perfil</span>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <i class="fas fa-cog"></i>
                                        <span>Configurações</span>
                                    </a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-section">
                                    <form method="GET" action="<?= url('/logout') ?>">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </header>
            
            
            <!-- Modern Flash Messages -->
            <?php if (!empty($flash_messages)): ?>
                <div class="flash-messages-container">
                    <?php foreach ($flash_messages as $type => $messages): ?>
                        <?php if (is_array($messages)): ?>
                            <?php foreach ($messages as $message): ?>
                                <div class="alert-modern alert-<?= $type === 'errors' ? 'error' : $type ?>-modern modern-flash-alert">
                                    <i class="fas fa-<?= $type === 'success' ? 'check-circle' : ($type === 'errors' ? 'exclamation-triangle' : 'info-circle') ?>"></i>
                                    <span><?= e($message) ?></span>
                                    <button class="alert-close" onclick="this.parentElement.remove()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert-modern alert-<?= $type === 'errors' ? 'error' : $type ?>-modern modern-flash-alert">
                                <i class="fas fa-<?= $type === 'success' ? 'check-circle' : ($type === 'errors' ? 'exclamation-triangle' : 'info-circle') ?>"></i>
                                <span><?= e($messages) ?></span>
                                <button class="alert-close" onclick="this.parentElement.remove()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- Page Content -->
            <div class="page-content">
                <div class="page-container">
                    <?= $content ?>
                </div>
            </div>
        </main>
    </div>
    
    <!-- JavaScript -->
    <script src="<?= asset('js/app.js') ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle functionality
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                
                // Add overlay for mobile
                if (window.innerWidth <= 768) {
                    if (sidebar.classList.contains('show')) {
                        let overlay = document.querySelector('.sidebar-overlay');
                        if (!overlay) {
                            overlay = document.createElement('div');
                            overlay.className = 'sidebar-overlay show';
                            document.body.appendChild(overlay);
                            document.body.classList.add('sidebar-open');
                            
                            overlay.addEventListener('click', function() {
                                sidebar.classList.remove('show');
                                document.body.classList.remove('sidebar-open');
                                if (overlay.parentNode) {
                                    document.body.removeChild(overlay);
                                }
                            });
                        }
                    } else {
                        const overlay = document.querySelector('.sidebar-overlay');
                        document.body.classList.remove('sidebar-open');
                        if (overlay && overlay.parentNode) {
                            document.body.removeChild(overlay);
                        }
                    }
                }
            });
        }
        
        // Submenu toggle functionality
        const submenuToggles = document.querySelectorAll('[data-toggle="submenu"]');
        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                // Close all other submenus
                submenuToggles.forEach(otherToggle => {
                    if (otherToggle !== this) {
                        otherToggle.setAttribute('aria-expanded', 'false');
                        const otherSubmenu = otherToggle.nextElementSibling;
                        if (otherSubmenu) {
                            otherSubmenu.classList.remove('show');
                        }
                    }
                });
                
                // Toggle current submenu
                this.setAttribute('aria-expanded', !isExpanded);
                if (submenu) {
                    submenu.classList.toggle('show', !isExpanded);
                }
            });
        });
        
        // Auto-close flash messages
        const flashAlerts = document.querySelectorAll('.modern-flash-alert');
        flashAlerts.forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'slideOutRight 0.5s ease-in';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }, 5000);
        });
        
        // Add slideOutRight animation
        if (!document.getElementById('layout-animations')) {
            const style = document.createElement('style');
            style.id = 'layout-animations';
            style.textContent = `
                @keyframes slideOutRight {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
                
                .sidebar-overlay {
                    animation: fadeIn 0.3s ease;
                }
                
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
            `;
            document.head.appendChild(style);
        }
        
        // Notification system enhancement
        window.showNotification = function(message, type = 'info', duration = 4000) {
            const container = document.querySelector('.flash-messages-container') || (() => {
                const newContainer = document.createElement('div');
                newContainer.className = 'flash-messages-container';
                document.body.appendChild(newContainer);
                return newContainer;
            })();
            
            const notification = document.createElement('div');
            notification.className = `alert-modern alert-${type}-modern modern-flash-alert`;
            
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-triangle',
                warning: 'fas fa-exclamation-circle',
                info: 'fas fa-info-circle'
            };
            
            notification.innerHTML = `
                <i class="${icons[type]}"></i>
                <span>${message}</span>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            container.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.animation = 'slideOutRight 0.5s ease-in';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 500);
                }
            }, duration);
        };
        
        // Enhanced user menu functionality
        const userMenu = document.querySelector('.modern-user-menu');
        const userDropdown = document.querySelector('.user-dropdown');
        
        if (userMenu && userDropdown) {
            let timeoutId;
            
            userMenu.addEventListener('mouseenter', function() {
                clearTimeout(timeoutId);
                userDropdown.style.opacity = '1';
                userDropdown.style.visibility = 'visible';
                userDropdown.style.transform = 'translateY(0)';
            });
            
            userMenu.addEventListener('mouseleave', function() {
                timeoutId = setTimeout(() => {
                    userDropdown.style.opacity = '0';
                    userDropdown.style.visibility = 'hidden';
                    userDropdown.style.transform = 'translateY(-10px)';
                }, 300);
            });
        }
        
        // Performance monitoring
        const perfStart = performance.now();
        window.addEventListener('load', () => {
            const loadTime = Math.round(performance.now() - perfStart);
            console.log(`⚡ Layout moderno carregado em ${loadTime}ms`);
        });
        
        // Responsive handling
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const sidebar = document.querySelector('.modern-sidebar');
                const overlay = document.querySelector('.sidebar-overlay');
                
                if (window.innerWidth > 768) {
                    if (sidebar) sidebar.classList.remove('show');
                    if (overlay) document.body.removeChild(overlay);
                }
            }, 150);
        });
    });
    </script>
</body>
</html>