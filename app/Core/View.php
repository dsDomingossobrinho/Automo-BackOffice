<?php
namespace App\Core;

/**
 * View Class - Handles template rendering
 */
class View
{
    private $data = [];
    private $layout = 'app';
    
    /**
     * Render a view template
     */
    public function render($template, $data = [], $layout = null)
    {
        $this->data = array_merge($this->data, $data);
        $layout = $layout ?: $this->layout;
        
        // Add global view data
        $this->addGlobalData();
        
        // Extract data to variables
        extract($this->data);
        
        ob_start();
        
        // Include the view template
        $viewFile = APP_PATH . "/Views/{$template}.php";
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new \Exception("View template {$template} not found");
        }
        
        $content = ob_get_clean();
        
        // If no layout, return content directly
        if (!$layout) {
            echo $content;
            return;
        }
        
        // Render with layout
        $layoutFile = APP_PATH . "/Views/layouts/{$layout}.php";
        if (file_exists($layoutFile)) {
            include $layoutFile;
        } else {
            throw new \Exception("Layout {$layout} not found");
        }
    }
    
    /**
     * Set layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    /**
     * Add data to view
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }
    
    /**
     * Add global data available to all views
     */
    private function addGlobalData()
    {
        $auth = new Auth();
        
        $this->data['app_name'] = APP_NAME;
        $this->data['app_version'] = APP_VERSION;
        $this->data['base_url'] = BASE_URL;
        $this->data['assets_url'] = ASSETS_URL;
        $this->data['current_user'] = $auth->getUser();
        $this->data['is_authenticated'] = $auth->isAuthenticated();
        $this->data['csrf_token'] = $this->generateCsrfToken();
        $this->data['flash_messages'] = $this->getFlashMessages();
        $this->data['menus'] = $this->getMenus();
    }
    
    /**
     * Generate CSRF token
     */
    private function generateCsrfToken()
    {
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }
    
    /**
     * Get flash messages
     */
    private function getFlashMessages()
    {
        $messages = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $messages;
    }
    
    /**
     * Get sidebar menus
     */
    private function getMenus()
    {
        return [
            ['group' => 'Main'],
            ['to' => '/dashboard', 'label' => 'Dashboard', 'icon' => 'tachometer-alt'],

            ['group' => 'Param. & Estatística'],
            ['to' => '/accounts', 'label' => 'Contas & Permissões', 'icon' => 'users-cog'],
            ['to' => '/accounts/permission', 'label' => 'Gestão de Permissões', 'icon' => 'shield-alt'],

            ['group' => 'Estatísticas Gerais'],
            [
                'to' => '', 'label' => 'Clientes', 'icon' => 'users',
                'children' => [
                    ['to' => '/clients', 'label' => 'Registados', 'icon' => 'user-plus'],
                    ['to' => '/clients/active', 'label' => 'Activos', 'icon' => 'user-check'],
                ],
            ],
            [
                'to' => '', 'label' => 'Mensagens', 'icon' => 'comments',
                'children' => [
                    ['to' => '/messages', 'label' => 'Enviadas (Total)', 'icon' => 'paper-plane'],
                    ['to' => '/messages/by-client', 'label' => 'Por Cliente', 'icon' => 'user-tag'],
                ],
            ],

            ['group' => 'Estatísticas por Agente'],
            ['to' => '/clients/capted', 'label' => 'Clientes Captados', 'icon' => 'user-friends'],
            [
                'to' => '', 'label' => 'Mensagens', 'icon' => 'chart-line',
                'children' => [
                    ['to' => '/messages/conversion', 'label' => 'Por Conversão', 'icon' => 'chart-pie'],
                    ['to' => '/messages/by-client/all', 'label' => 'Por Cliente (Total)', 'icon' => 'chart-bar'],
                ],
            ],

            ['group' => 'Param. & Financeiro'],
            [
                'to' => '', 'label' => 'Financeiro', 'icon' => 'chart-area',
                'children' => [
                    ['to' => '/finances', 'label' => 'Total Facturado', 'icon' => 'money-bill-wave'],
                    ['to' => '/finances/monthly', 'label' => 'Total Mensal', 'icon' => 'calendar-month'],
                    ['to' => '/finances/daily', 'label' => 'Total Diário', 'icon' => 'calendar-day'],
                    ['to' => '/finances/weekly', 'label' => 'Total Semanal', 'icon' => 'calendar-week'],
                ],
            ],
            [
                'to' => '', 'label' => 'Documentos', 'icon' => 'file-invoice-dollar',
                'children' => [
                    ['to' => '/invoices', 'label' => 'RPP', 'title' => 'Recibo, Pagamentos e Planos', 'icon' => 'receipt'],
                    ['to' => '/invoices/receipts', 'label' => 'Visualizar Recibos', 'icon' => 'file-pdf'],
                    ['to' => '/invoices/planos', 'label' => 'Planos', 'icon' => 'clipboard-list'],
                ],
            ],
        ];
    }
}