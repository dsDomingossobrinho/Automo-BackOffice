<?php
/**
 * Global Helper Functions
 */

/**
 * Escape HTML entities for safe output
 */
function e($string)
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Generate URL
 */
function url($path = '/')
{
    $baseUrl = defined('BASE_URL') ? BASE_URL : '';
    
    // Ensure path starts with /
    $path = '/' . ltrim($path, '/');
    
    // Remove trailing slash from base URL if exists
    $baseUrl = rtrim($baseUrl, '/');
    
    return $baseUrl . $path;
}

/**
 * Generate asset URL
 */
function asset($path)
{
    return ASSETS_URL . '/' . ltrim($path, '/');
}

/**
 * Redirect to URL
 */
function redirect($url, $statusCode = 302)
{
    http_response_code($statusCode);
    header("Location: {$url}");
    exit;
}

/**
 * Get old input value (for form repopulation)
 */
function old($key, $default = '')
{
    return $_SESSION['old_input'][$key] ?? $default;
}

/**
 * Flash old input data
 */
function flashInput()
{
    $_SESSION['old_input'] = $_POST;
}

/**
 * Clear old input data
 */
function clearInput()
{
    unset($_SESSION['old_input']);
}

/**
 * Format date for display
 */
function formatDate($date, $format = 'd/m/Y H:i')
{
    if (!$date) return '';
    
    $dateObj = new DateTime($date);
    return $dateObj->format($format);
}

/**
 * Format currency
 */
function formatCurrency($amount, $currency = 'AOA')
{
    if (!is_numeric($amount)) return $amount;
    
    return number_format($amount, 2, ',', '.') . ' ' . $currency;
}

/**
 * Generate CSRF token input
 */
function csrfField()
{
    // Ensure CSRF_TOKEN_NAME is defined
    if (!defined('CSRF_TOKEN_NAME')) {
        define('CSRF_TOKEN_NAME', '_token');
    }
    
    // Generate token if not exists
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    
    $token = $_SESSION[CSRF_TOKEN_NAME];
    return "<input type=\"hidden\" name=\"_token\" value=\"{$token}\">";
}

/**
 * Generate method field for PUT/DELETE forms
 */
function methodField($method)
{
    return "<input type=\"hidden\" name=\"_method\" value=\"{$method}\">";
}

/**
 * Check if current page matches route
 */
function isActive($route)
{
    $currentUri = $_SERVER['REQUEST_URI'];
    
    // Remove query string
    if (($pos = strpos($currentUri, '?')) !== false) {
        $currentUri = substr($currentUri, 0, $pos);
    }
    
    return $currentUri === $route;
}

/**
 * Get current page title based on route
 */
function getPageTitle()
{
    $currentUri = $_SERVER['REQUEST_URI'];
    
    // Remove query string
    if (($pos = strpos($currentUri, '?')) !== false) {
        $currentUri = substr($currentUri, 0, $pos);
    }
    
    $titles = [
        '/dashboard' => 'Dashboard',
        '/accounts' => 'Contas & Permissões',
        '/accounts/permission' => 'Gestão de Permissões',
        '/clients' => 'Clientes Registados',
        '/clients/active' => 'Clientes Activos',
        '/clients/capted' => 'Clientes Captados',
        '/messages' => 'Mensagens Enviadas',
        '/messages/by-client' => 'Mensagens Por Cliente',
        '/messages/conversion' => 'Mensagens Por Conversão',
        '/finances' => 'Total Facturado',
        '/finances/monthly' => 'Total Mensal',
        '/finances/daily' => 'Total Diário',
        '/finances/weekly' => 'Total Semanal',
        '/invoices' => 'RPP - Recibo, Pagamentos e Planos',
        '/invoices/receipts' => 'Visualizar Recibos',
        '/invoices/planos' => 'Planos',
    ];
    
    return $titles[$currentUri] ?? 'Automo BackOffice';
}

/**
 * Generate breadcrumb trail
 */
function getBreadcrumbs()
{
    $currentUri = $_SERVER['REQUEST_URI'];
    
    // Remove query string
    if (($pos = strpos($currentUri, '?')) !== false) {
        $currentUri = substr($currentUri, 0, $pos);
    }
    
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => '/dashboard']
    ];
    
    $routes = [
        '/accounts' => 'Contas & Permissões',
        '/accounts/permission' => 'Gestão de Permissões',
        '/clients' => 'Clientes',
        '/clients/active' => 'Activos',
        '/clients/capted' => 'Captados',
        '/messages' => 'Mensagens',
        '/messages/by-client' => 'Por Cliente',
        '/messages/conversion' => 'Por Conversão',
        '/finances' => 'Financeiro',
        '/finances/monthly' => 'Mensal',
        '/finances/daily' => 'Diário',
        '/finances/weekly' => 'Semanal',
        '/invoices' => 'Documentos',
        '/invoices/receipts' => 'Recibos',
        '/invoices/planos' => 'Planos',
    ];
    
    if (isset($routes[$currentUri]) && $currentUri !== '/dashboard') {
        $breadcrumbs[] = ['label' => $routes[$currentUri], 'url' => null];
    }
    
    return $breadcrumbs;
}

/**
 * Truncate text
 */
function truncate($text, $length = 100, $suffix = '...')
{
    if (strlen($text) <= $length) {
        return $text;
    }
    
    return substr($text, 0, $length) . $suffix;
}

/**
 * Generate pagination HTML
 */
function renderPagination($pagination, $baseUrl)
{
    if ($pagination['total_pages'] <= 1) {
        return '';
    }
    
    $html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
    
    // Previous button
    if ($pagination['has_prev']) {
        $prevPage = $pagination['current_page'] - 1;
        $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . $prevPage . '">Previous</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
    }
    
    // Page numbers
    $start = max(1, $pagination['current_page'] - 2);
    $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
    
    for ($i = $start; $i <= $end; $i++) {
        if ($i === $pagination['current_page']) {
            $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . $i . '">' . $i . '</a></li>';
        }
    }
    
    // Next button
    if ($pagination['has_next']) {
        $nextPage = $pagination['current_page'] + 1;
        $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . $nextPage . '">Next</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
    }
    
    $html .= '</ul></nav>';
    
    return $html;
}

/**
 * Get file size in human readable format
 */
function formatFileSize($bytes)
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

/**
 * Sanitize filename for upload
 */
function sanitizeFilename($filename)
{
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
    return substr($filename, 0, 255);
}

/**
 * Check if file type is allowed
 */
function isAllowedFileType($filename)
{
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($extension, UPLOAD_ALLOWED_TYPES);
}

/**
 * Generate random string
 */
function generateRandomString($length = 32)
{
    return bin2hex(random_bytes($length / 2));
}

/**
 * Get current route
 */
function getCurrentRoute()
{
    $currentUri = $_SERVER['REQUEST_URI'];
    
    // Remove query string
    if (($pos = strpos($currentUri, '?')) !== false) {
        $currentUri = substr($currentUri, 0, $pos);
    }
    
    return $currentUri;
}

/**
 * Get authenticated user data
 */
function auth()
{
    static $authInstance = null;
    
    if ($authInstance === null) {
        $authInstance = new \App\Core\Auth();
    }
    
    return $authInstance;
}

/**
 * Get current authenticated user
 */
function user()
{
    return auth()->getUser();
}

/**
 * Get current user's name
 */
function userName()
{
    return auth()->getUserName();
}

/**
 * Get current user's identify ID
 */
function userIdentifyId()
{
    return auth()->getUserIdentifyId();
}

/**
 * Get current user's image
 */
function userImage()
{
    return auth()->getUserImage();
}

/**
 * Get user display name (name or email fallback)
 */
function userDisplayName()
{
    $user = user();
    if (!$user) return null;
    
    return $user['name'] ?? $user['username'] ?? $user['email'] ?? 'Usuário';
}

/**
 * Get user avatar URL (image or default)
 */
function userAvatar()
{
    $image = userImage();
    
    if ($image) {
        // If it's a full URL, return as is
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }
        
        // If it's a relative path, construct full URL
        return asset('uploads/avatars/' . $image);
    }
    
    // Return default avatar
    return asset('images/default-avatar.png');
}

/**
 * Check if user is authenticated
 */
function isAuthenticated()
{
    return auth()->isAuthenticated();
}

/**
 * Check if user is admin
 */
function isAdmin()
{
    return auth()->isAdmin();
}