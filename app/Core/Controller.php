<?php
namespace App\Core;

/**
 * Base Controller Class
 */
abstract class Controller
{
    protected $view;
    protected $auth;
    protected $apiClient;
    
    public function __construct()
    {
        $this->view = new View();
        $this->auth = new Auth();
        $this->apiClient = new ApiClient();
        
        // Check authentication for protected routes
        $this->checkAuth();
    }
    
    /**
     * Check if user is authenticated for protected routes
     */
    protected function checkAuth()
    {
        $publicRoutes = ['/login', '/otp', '/', '/logout'];
        $currentUri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (($pos = strpos($currentUri, '?')) !== false) {
            $currentUri = substr($currentUri, 0, $pos);
        }
        
        if (!in_array($currentUri, $publicRoutes) && !$this->auth->isAuthenticated()) {
            $this->redirect('/login');
        }
    }
    
    /**
     * Render a view
     */
    protected function view($template, $data = [])
    {
        return $this->view->render($template, $data);
    }
    
    /**
     * Render a view without layout (raw PHP include)
     */
    protected function viewRaw($template, $data = [])
    {
        // Extract data to variables
        extract($data);
        
        // Build the full path to the view
        $viewPath = APP_PATH . '/Views/' . $template . '.php';
        
        // Check if view exists
        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: {$template}");
        }
        
        // Include the view directly
        include $viewPath;
        exit;
    }
    
    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Return JSON response (alias)
     */
    protected function jsonResponse($data, $statusCode = 200)
    {
        return $this->json($data, $statusCode);
    }
    
    /**
     * Redirect to another URL
     */
    protected function redirect($url, $statusCode = 302)
    {
        http_response_code($statusCode);
        header("Location: {$url}");
        exit;
    }
    
    /**
     * Get request data
     */
    protected function getRequestData()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        
        switch ($method) {
            case 'GET':
                return $_GET;
            case 'POST':
                return $_POST;
            case 'PUT':
            case 'DELETE':
                $input = file_get_contents('php://input');
                return json_decode($input, true) ?: [];
            default:
                return [];
        }
    }
    
    /**
     * Validate CSRF token
     */
    protected function validateCsrfToken($token)
    {
        return isset($_SESSION[CSRF_TOKEN_NAME]) && 
               hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    }
    
    /**
     * Generate CSRF token
     */
    protected function generateCsrfToken()
    {
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }
    
    /**
     * Set flash message
     */
    protected function setFlash($type, $message)
    {
        $_SESSION['flash'][$type] = $message;
    }
    
    /**
     * Get flash messages
     */
    protected function getFlash($type = null)
    {
        if ($type) {
            $message = $_SESSION['flash'][$type] ?? null;
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        
        $messages = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $messages;
    }
    
    /**
     * Paginate results
     */
    protected function paginate($data, $page = 1, $perPage = DEFAULT_PAGE_SIZE)
    {
        $page = max(1, (int)$page);
        $perPage = min(MAX_PAGE_SIZE, max(1, (int)$perPage));
        
        $total = count($data);
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;
        
        return [
            'data' => array_slice($data, $offset, $perPage),
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => $totalPages,
                'has_next' => $page < $totalPages,
                'has_prev' => $page > 1
            ]
        ];
    }
}