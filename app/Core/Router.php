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
        
        // Find matching route
        $route = $this->findRoute($method, $uri);
        
        if (!$route) {
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
        include APP_PATH . '/Views/errors/404.php';
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