<?php
namespace App\Core;

/**
 * Router Class - Handles URL routing and dispatching
 */
class Router
{
    private $routes = [];
    private $currentRoute = [];
    
    /**
     * Add a GET route
     */
    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }
    
    /**
     * Add a POST route
     */
    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }
    
    /**
     * Add a PUT route
     */
    public function put($uri, $action)
    {
        $this->addRoute('PUT', $uri, $action);
    }
    
    /**
     * Add a DELETE route
     */
    public function delete($uri, $action)
    {
        $this->addRoute('DELETE', $uri, $action);
    }
    
    /**
     * Add a route to the routes array
     */
    private function addRoute($method, $uri, $action)
    {
        $this->routes[$method][$uri] = $action;
    }
    
    /**
     * Dispatch the current request
     */
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Handle PUT and DELETE methods sent as POST with _method parameter
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }
        
        $uri = $this->getCurrentUri();

        // Debug logging (reduced verbosity)
        if (defined('DEBUG_MODE') && DEBUG_MODE && !$this->findRoute($method, $uri)) {
            error_log("Router Debug - 404 for: $method $uri");
        }
        
        // Find matching route
        $route = $this->findRoute($method, $uri);
        
        if (!$route) {
            if (defined('DEBUG_MODE') && DEBUG_MODE) {
                error_log("Router Debug - No route found for $method $uri");
            }
            $this->handleNotFound();
            return;
        }
        
        $this->currentRoute = $route;
        $this->callAction($route['action'], $route['params']);
    }
    
    /**
     * Get current URI from request
     */
    private function getCurrentUri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }
        
        return rtrim($uri, '/') ?: '/';
    }
    
    /**
     * Find matching route
     */
    private function findRoute($method, $uri)
    {
        if (!isset($this->routes[$method])) {
            return false;
        }
        
        foreach ($this->routes[$method] as $routeUri => $action) {
            $params = $this->matchRoute($routeUri, $uri);
            if ($params !== false) {
                return [
                    'action' => $action,
                    'params' => $params
                ];
            }
        }
        
        return false;
    }
    
    /**
     * Match route pattern with current URI
     */
    private function matchRoute($routeUri, $currentUri)
    {
        // Convert route parameters {param} to regex patterns
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routeUri);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $currentUri, $matches)) {
            array_shift($matches); // Remove full match
            return $matches;
        }
        
        return false;
    }
    
    /**
     * Call the controller action
     */
    private function callAction($action, $params = [])
    {
        list($controller, $method) = explode('@', $action);
        
        $controllerClass = "App\\Controllers\\{$controller}";
        
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller {$controllerClass} not found");
        }
        
        $controllerInstance = new $controllerClass();
        
        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Method {$method} not found in {$controllerClass}");
        }
        
        call_user_func_array([$controllerInstance, $method], $params);
    }
    
    /**
     * Handle 404 Not Found
     */
    private function handleNotFound()
    {
        http_response_code(404);
        
        // Set error-specific data
        $error_type = '404';
        $error_message = 'Página Não Encontrada';
        $error_description = 'A página que você está procurando não existe ou foi movida.';
        
        // Log the 404 error
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            error_log("404 Error - URI: " . ($_SERVER['REQUEST_URI'] ?? 'unknown') . 
                     " - Method: " . ($_SERVER['REQUEST_METHOD'] ?? 'unknown') . 
                     " - User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown'));
        }
        
        // Include the error page with proper error handling
        $error_file = APP_PATH . '/Views/errors/404.php';
        if (file_exists($error_file)) {
            include $error_file;
        } else {
            // Fallback error page if 404.php doesn't exist
            echo $this->getGenericErrorPage('404', $error_message, $error_description);
        }
    }
    
    /**
     * Generic fallback error page
     */
    private function getGenericErrorPage($code, $title, $description)
    {
        return '<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $code . ' - ' . $title . '</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        .error-container { max-width: 500px; margin: 0 auto; }
        .error-code { font-size: 4rem; color: #dc2626; margin-bottom: 1rem; }
        .error-title { font-size: 2rem; color: #374151; margin-bottom: 1rem; }
        .error-desc { color: #6b7280; margin-bottom: 2rem; }
        .btn { background: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">' . $code . '</div>
        <h1 class="error-title">' . $title . '</h1>
        <p class="error-desc">' . $description . '</p>
        <a href="/" class="btn">Voltar à Página Inicial</a>
    </div>
</body>
</html>';
    }
    
    /**
     * Generate URL for named route
     */
    public function url($uri, $params = [])
    {
        $url = BASE_URL . $uri;
        
        // Replace route parameters
        foreach ($params as $key => $value) {
            $url = str_replace("{{$key}}", $value, $url);
        }
        
        return $url;
    }
}