<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Client;

/**
 * Client Controller - Manages client CRUD operations
 */
class ClientController extends Controller
{
    private $clientModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->clientModel = new Client();
    }
    
    /**
     * Display all clients (users)
     */
    public function index()
    {
        try {
            $page = (int)($_GET['page'] ?? 1);
            $search = $_GET['search'] ?? '';
            $stateId = $_GET['state'] ?? '';

            $params = [
                'page' => $page - 1, // Backend usa 0-based indexing
                'size' => DEFAULT_PAGE_SIZE,
                'sortBy' => 'id',
                'sortDirection' => 'DESC'
            ];

            if ($search) {
                $params['search'] = $search;
            }

            if ($stateId) {
                $params['stateId'] = $stateId;
            }

            // Usar endpoint /users/paginated ao invés de clients
            $response = $this->apiClient->authenticatedRequest('GET', '/users/paginated', $params);
            $clients = $response['data']['content'] ?? $response['content'] ?? $response ?? [];

            // Debug: Log the actual response structure (disabled)
            // if (DEBUG_MODE) {
            //     error_log("DEBUG Clients Response: " . print_r($response, true));
            //     error_log("DEBUG Clients Array: " . print_r($clients, true));
            //     error_log("DEBUG Clients Count: " . (is_array($clients) ? count($clients) : 'NOT_ARRAY'));
            // }
            
            // Get available states for filter
            $states = $this->getAvailableStates();

            // Get account types for create form
            $accountTypes = $this->getAccountTypes();

            // Get statistics
            $statistics = $this->getClientStatistics();

            // Extrair dados de paginação
            $responseData = $response['data'] ?? $response;
            $pagination = [
                'current_page' => $page,
                'total_pages' => $responseData['totalPages'] ?? 1,
                'total_elements' => $responseData['totalElements'] ?? count($clients),
                'page_size' => $responseData['pageSize'] ?? DEFAULT_PAGE_SIZE,
                'has_next' => $responseData['hasNext'] ?? false,
                'has_previous' => $responseData['hasPrevious'] ?? false
            ];

            $this->view('clients/index', [
                'clients' => $clients,
                'states' => $states,
                'account_types' => $accountTypes,
                'statistics' => $statistics,
                'pagination' => $pagination,
                'current_page' => $page,
                'search' => $search,
                'selected_state' => $stateId,
                'has_permission_create' => $this->auth->hasPermission('create_clients'),
                'has_permission_edit' => $this->auth->hasPermission('edit_clients'),
                'has_permission_delete' => $this->auth->hasPermission('delete_all')
            ]);
        } catch (\Exception $e) {
            $this->setFlash('errors', ['Erro ao carregar clientes: ' . $e->getMessage()]);

            // Get fallback data for forms
            $states = $this->getAvailableStates();
            $accountTypes = $this->getAccountTypes();

            $this->view('clients/index', [
                'clients' => [],
                'states' => $states,
                'account_types' => $accountTypes,
                'statistics' => [
                    'totalUsers' => 0,
                    'activeUsers' => 0,
                    'inactiveUsers' => 0,
                    'eliminatedUsers' => 0
                ],
                'pagination' => [
                    'current_page' => 1,
                    'total_pages' => 1,
                    'total_elements' => 0,
                    'page_size' => DEFAULT_PAGE_SIZE,
                    'has_next' => false,
                    'has_previous' => false
                ],
                'current_page' => 1,
                'search' => $search ?? '',
                'selected_state' => $stateId ?? '',
                'api_error' => true
            ]);
        }
    }
    
    /**
     * Show active clients only
     */
    public function active()
    {
        try {
            $page = (int)($_GET['page'] ?? 1);
            $search = $_GET['search'] ?? '';
            
            $params = [
                'page' => $page,
                'size' => DEFAULT_PAGE_SIZE,
                'stateId' => 1 // ACTIVE state
            ];
            
            if ($search) {
                $params['search'] = $search;
            }
            
            $response = $this->clientModel->findAll($params);
            $clients = $response['content'] ?? $response ?? [];
            
            $this->view('clients/active', [
                'clients' => $clients,
                'current_page' => $page,
                'search' => $search
            ]);
        } catch (\Exception $e) {
            $this->setFlash('errors', ['Erro ao carregar clientes activos: ' . $e->getMessage()]);
            $this->view('clients/active', [
                'clients' => [],
                'api_error' => true
            ]);
        }
    }
    
    /**
     * Show clients captured by agents
     */
    public function capted()
    {
        try {
            $page = (int)($_GET['page'] ?? 1);
            $search = $_GET['search'] ?? '';
            $agentId = $_GET['agent'] ?? '';
            
            $params = [
                'page' => $page,
                'size' => DEFAULT_PAGE_SIZE
            ];
            
            if ($search) {
                $params['search'] = $search;
            }
            
            if ($agentId) {
                $params['agentId'] = $agentId;
            }
            
            // Get clients with agent information
            $response = $this->clientModel->findAll($params);
            $clients = $response['content'] ?? $response ?? [];
            
            // Get available agents for filter
            $agents = $this->getAvailableAgents();
            
            $this->view('clients/capted', [
                'clients' => $clients,
                'agents' => $agents,
                'current_page' => $page,
                'search' => $search,
                'selected_agent' => $agentId
            ]);
        } catch (\Exception $e) {
            $this->setFlash('errors', ['Erro ao carregar clientes captados: ' . $e->getMessage()]);
            $this->view('clients/capted', [
                'clients' => [],
                'agents' => [],
                'api_error' => true
            ]);
        }
    }
    
    /**
     * Show create client form
     */
    public function create()
    {
        if (!$this->auth->hasPermission('create_clients')) {
            $this->setFlash('errors', ['Sem permissão para criar clientes']);
            $this->redirect('/clients');
        }
        
        try {
            $states = $this->getAvailableStates();
            $accountTypes = $this->getAccountTypes();
            
            $this->view('clients/create', [
                'states' => $states,
                'account_types' => $accountTypes,
                'errors' => $this->getFlash('errors'),
                'success' => $this->getFlash('success')
            ]);
        } catch (\Exception $e) {
            $this->setFlash('errors', ['Erro ao carregar formulário: ' . $e->getMessage()]);
            $this->redirect('/clients');
        }
    }
    
    /**
     * Store new client
     */
    public function store()
    {
        if (!$this->auth->hasPermission('create_clients')) {
            $this->setFlash('errors', ['Sem permissão para criar clientes']);
            $this->redirect('/clients');
        }
        
        try {
            $data = $this->getRequestData();
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($data['_token'] ?? '')) {
                $this->setFlash('errors', ['Token de segurança inválido']);
                flashInput();
                $this->redirect('/clients/create');
            }
            
            // Validate input data
            $errors = $this->validateClientData($data);
            if (!empty($errors)) {
                $this->setFlash('errors', $errors);
                flashInput();
                $this->redirect('/clients/create');
            }
            
            // Create client via API using /users endpoint
            // Preparar payload apenas com campos não vazios
            $payload = [
                'name' => $data['name'],
                'accountTypeId' => (int)$data['account_type_id'],
                'stateId' => (int)($data['state_id'] ?? 1)
            ];

            // Adicionar campos opcionais apenas se não estiverem vazios
            if (!empty($data['email'])) {
                $payload['email'] = $data['email'];
            }

            if (!empty($data['contact'])) {
                $payload['contacto'] = $data['contact'];
            }

            if (!empty($data['img'])) {
                $payload['img'] = $data['img'];
            }

            if (!empty($data['password'])) {
                $payload['password'] = $data['password'];
            }

            // Campos geográficos - Organization Type é obrigatório
            if (!empty($data['organization_type_id']) && (int)$data['organization_type_id'] > 0) {
                $payload['organizationTypeId'] = (int)$data['organization_type_id'];
            } else {
                // Organization Type é obrigatório, usar Individual como default
                $payload['organizationTypeId'] = 1;
            }

            if (!empty($data['country_id']) && (int)$data['country_id'] > 0) {
                $payload['countryId'] = (int)$data['country_id'];
            }

            if (!empty($data['province_id']) && (int)$data['province_id'] > 0) {
                $payload['provinceId'] = (int)$data['province_id'];
            }

            $response = $this->apiClient->authenticatedRequest('POST', '/users', $payload);
            
            clearInput();
            $this->setFlash('success', 'Cliente criado com sucesso!');
            $this->redirect('/clients');
        } catch (\Exception $e) {
            $this->setFlash('errors', ['Erro ao criar cliente: ' . $e->getMessage()]);
            flashInput();
            $this->redirect('/clients/create');
        }
    }
    
    /**
     * Show client details
     */
    public function show($id)
    {
        try {
            $client = $this->apiClient->authenticatedRequest('GET', "/users/{$id}");

            if (!$client) {
                // Se é uma requisição AJAX, retornar JSON
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    http_response_code(404);
                    echo json_encode(['error' => 'Cliente não encontrado']);
                    exit;
                }

                $this->setFlash('errors', ['Cliente não encontrado']);
                $this->redirect('/clients');
            }

            // Se é uma requisição AJAX, retornar JSON
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode($client);
                exit;
            }

            $this->view('clients/show', [
                'client' => $client,
                'has_permission_edit' => $this->auth->hasPermission('edit_clients'),
                'has_permission_delete' => $this->auth->hasPermission('delete_all')
            ]);
        } catch (\Exception $e) {
            // Se é uma requisição AJAX, retornar JSON
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode([
                    'error' => 'Erro ao carregar cliente',
                    'message' => $e->getMessage()
                ]);
                exit;
            }

            $this->setFlash('errors', ['Erro ao carregar cliente: ' . $e->getMessage()]);
            $this->redirect('/clients');
        }
    }
    
    /**
     * Show edit client form
     */
    public function edit($id)
    {
        if (!$this->auth->hasPermission('edit_clients')) {
            $this->setFlash('errors', ['Sem permissão para editar clientes']);
            $this->redirect('/clients');
        }
        
        try {
            $client = $this->apiClient->authenticatedRequest('GET', "/users/{$id}");
            
            if (!$client) {
                $this->setFlash('errors', ['Cliente não encontrado']);
                $this->redirect('/clients');
            }
            
            $states = $this->getAvailableStates();
            $accountTypes = $this->getAccountTypes();
            
            $this->view('clients/edit', [
                'client' => $client,
                'states' => $states,
                'account_types' => $accountTypes,
                'errors' => $this->getFlash('errors'),
                'success' => $this->getFlash('success')
            ]);
        } catch (\Exception $e) {
            $this->setFlash('errors', ['Erro ao carregar cliente: ' . $e->getMessage()]);
            $this->redirect('/clients');
        }
    }
    
    /**
     * Update client
     */
    public function update($id)
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (!$this->auth->hasPermission('edit_clients')) {
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Sem permissão para editar clientes'], 403);
            }
            $this->setFlash('errors', ['Sem permissão para editar clientes']);
            $this->redirect('/clients');
        }

        try {
            $data = $this->getRequestData();

            // For AJAX requests, get JSON data
            if ($isAjax) {
                $input = file_get_contents('php://input');
                $jsonData = json_decode($input, true);
                if ($jsonData) {
                    $data = $jsonData;
                }
            }

            // Validate CSRF token (skip for AJAX as it doesn't use forms)
            if (!$isAjax && !$this->validateCsrfToken($data['_token'] ?? '')) {
                $this->setFlash('errors', ['Token de segurança inválido']);
                $this->redirect("/clients/{$id}/edit");
            }

            // Validate input data
            $errors = $this->validateClientData($data, $id);
            if (!empty($errors)) {
                if ($isAjax) {
                    $this->json(['success' => false, 'message' => 'Dados inválidos', 'errors' => $errors], 400);
                }
                $this->setFlash('errors', $errors);
                flashInput();
                $this->redirect("/clients/{$id}/edit");
            }
            
            // Update client via API using /users endpoint
            // Preparar payload apenas com campos não vazios
            $updateData = [
                'name' => $data['name'],
                'accountTypeId' => (int)$data['account_type_id'],
                'stateId' => (int)$data['state_id']
            ];

            // Adicionar campos opcionais apenas se não estiverem vazios
            if (!empty($data['email'])) {
                $updateData['email'] = $data['email'];
            }

            if (!empty($data['contact'])) {
                $updateData['contacto'] = $data['contact'];
            }

            if (!empty($data['img'])) {
                $updateData['img'] = $data['img'];
            }

            if (!empty($data['password'])) {
                $updateData['password'] = $data['password'];
            }

            // Campos geográficos - Organization Type é obrigatório
            if (!empty($data['organization_type_id']) && (int)$data['organization_type_id'] > 0) {
                $updateData['organizationTypeId'] = (int)$data['organization_type_id'];
            } else {
                // Organization Type é obrigatório, manter valor existente ou usar Individual
                $updateData['organizationTypeId'] = 1;
            }

            if (!empty($data['country_id']) && (int)$data['country_id'] > 0) {
                $updateData['countryId'] = (int)$data['country_id'];
            }

            if (!empty($data['province_id']) && (int)$data['province_id'] > 0) {
                $updateData['provinceId'] = (int)$data['province_id'];
            }

            $response = $this->apiClient->authenticatedRequest('PUT', "/users/{$id}", $updateData);

            if ($isAjax) {
                $this->json(['success' => true, 'message' => 'Cliente actualizado com sucesso!', 'data' => $response]);
            }

            clearInput();
            $this->setFlash('success', 'Cliente actualizado com sucesso!');
            $this->redirect('/clients');
        } catch (\Exception $e) {
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Erro ao actualizar cliente: ' . $e->getMessage()], 500);
            }
            $this->setFlash('errors', ['Erro ao actualizar cliente: ' . $e->getMessage()]);
            $this->redirect("/clients/{$id}/edit");
        }
    }
    
    /**
     * Delete client
     */
    public function delete($id)
    {
        if (!$this->auth->hasPermission('delete_all')) {
            $this->json(['success' => false, 'message' => 'Sem permissão para eliminar clientes'], 403);
        }
        
        try {
            // Delete client via API using /users endpoint
            $response = $this->apiClient->authenticatedRequest('DELETE', "/users/{$id}");
            
            $this->json(['success' => true, 'message' => 'Cliente eliminado com sucesso']);
        } catch (\Exception $e) {
            $this->json(['success' => false, 'message' => 'Erro ao eliminar cliente: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Validate client data
     */
    private function validateClientData($data, $excludeId = null)
    {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors[] = 'Nome é obrigatório';
        } elseif (strlen($data['name']) < 2) {
            $errors[] = 'Nome deve ter pelo menos 2 caracteres';
        }
        
        // Contact is optional - no validation needed
        
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email inválido';
        }
        
        if (empty($data['account_type_id']) || !is_numeric($data['account_type_id'])) {
            $errors[] = 'Tipo de conta é obrigatório';
        }
        
        return $errors;
    }
    
    /**
     * Get available states from API
     */
    private function getAvailableStates()
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/states');

            if ($response['success'] ?? false) {
                return $response['data'] ?? [];
            }

            return $this->apiClient->authenticatedRequest('GET', '/states') ?? [];
        } catch (\Exception $e) {
            return [
                ['id' => 1, 'state' => 'ACTIVE', 'description' => 'Active'],
                ['id' => 2, 'state' => 'INACTIVE', 'description' => 'Inactive'],
                ['id' => 3, 'state' => 'PENDING', 'description' => 'Pending'],
                ['id' => 4, 'state' => 'ELIMINATED', 'description' => 'Eliminated']
            ];
        }
    }
    
    /**
     * Get account types from API
     */
    private function getAccountTypes()
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/account-types');

            if ($response['success'] ?? false) {
                return $response['data'] ?? [];
            }

            return $this->apiClient->authenticatedRequest('GET', '/account-types') ?? [];
        } catch (\Exception $e) {
            return [
                ['id' => 1, 'type' => 'INDIVIDUAL', 'description' => 'Back Office Individual'],
                ['id' => 2, 'type' => 'CORPORATE', 'description' => 'Corporate Account']
            ];
        }
    }
    
    /**
     * Get available agents from API
     */
    private function getAvailableAgents()
    {
        try {
            return $this->apiClient->authenticatedRequest('GET', '/agents') ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get client statistics from API
     */
    private function getClientStatistics()
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/users/statistics');
            return $response['data'] ?? $response ?? [
                'totalUsers' => 0,
                'activeUsers' => 0,
                'inactiveUsers' => 0,
                'eliminatedUsers' => 0
            ];
        } catch (\Exception $e) {
            return [
                'totalUsers' => 0,
                'activeUsers' => 0,
                'inactiveUsers' => 0,
                'eliminatedUsers' => 0
            ];
        }
    }

    /**
     * API endpoint para buscar um usuário específico
     */
    public function apiShow($id)
    {
        header('Content-Type: application/json');

        // Debug temporário
        error_log("=== ClientController::apiShow CALLED with ID: {$id} ===");

        try {
            error_log("Making API request to /users/{$id}");
            $userData = $this->apiClient->authenticatedRequest('GET', "/users/{$id}");
            error_log("API response: " . json_encode($userData));

            if (!$userData) {
                error_log("No user data returned from API");
                http_response_code(404);
                echo json_encode(['error' => 'Usuário não encontrado']);
                exit;
            }

            echo json_encode($userData);
            exit;

        } catch (\Exception $e) {
            error_log("Exception in apiShow: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'error' => 'Erro ao buscar usuário',
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * API endpoint para atualizar um usuário específico
     */
    public function apiUpdate($id)
    {
        header('Content-Type: application/json');

        try {
            $data = $this->getRequestData();

            // Construir payload baseado na documentação
            $payload = [
                'name' => $data['name'],
                'accountTypeId' => (int)($data['accountTypeId'] ?? 1),
                'stateId' => (int)($data['stateId'] ?? 1)
            ];

            // Adicionar campos opcionais apenas se não estiverem vazios
            if (!empty($data['contacto'])) {
                $payload['contacto'] = $data['contacto'];
            }

            if (!empty($data['email'])) {
                $payload['email'] = $data['email'];
            }

            if (!empty($data['img'])) {
                $payload['img'] = $data['img'];
            }

            if (!empty($data['organizationTypeId'])) {
                $payload['organizationTypeId'] = (int)$data['organizationTypeId'];
            }

            if (!empty($data['countryId'])) {
                $payload['countryId'] = (int)$data['countryId'];
            }

            if (!empty($data['provinceId'])) {
                $payload['provinceId'] = (int)$data['provinceId'];
            }

            $response = $this->apiClient->authenticatedRequest('PUT', "/users/{$id}", $payload);

            if ($response) {
                echo json_encode($response);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erro ao atualizar usuário']);
            }
            exit;

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Erro ao atualizar usuário',
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * Test route para debug
     */
    public function testRoute()
    {
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Route is working', 'timestamp' => date('Y-m-d H:i:s')]);
        exit;
    }

    /**
     * API endpoint para buscar um usuário específico (método alternativo)
     */
    public function apiShowUser($id)
    {
        header('Content-Type: application/json');

        // Debug temporário
        error_log("=== ClientController::apiShowUser CALLED with ID: {$id} ===");

        try {
            error_log("Making API request to /users/{$id}");
            $userData = $this->apiClient->authenticatedRequest('GET', "/users/{$id}");
            error_log("API response: " . json_encode($userData));

            if (!$userData) {
                error_log("No user data returned from API");
                http_response_code(404);
                echo json_encode(['error' => 'Usuário não encontrado']);
                exit;
            }

            echo json_encode($userData);
            exit;

        } catch (\Exception $e) {
            error_log("Exception in apiShowUser: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'error' => 'Erro ao buscar usuário',
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * API endpoint para atualizar um usuário específico (método alternativo)
     */
    public function apiUpdateUser($id)
    {
        header('Content-Type: application/json');

        try {
            $data = $this->getRequestData();

            // Construir payload baseado na documentação
            $payload = [
                'name' => $data['name'],
                'accountTypeId' => (int)($data['accountTypeId'] ?? 1),
                'stateId' => (int)($data['stateId'] ?? 1)
            ];

            // Adicionar campos opcionais apenas se não estiverem vazios
            if (!empty($data['contacto'])) {
                $payload['contacto'] = $data['contacto'];
            }

            if (!empty($data['email'])) {
                $payload['email'] = $data['email'];
            }

            if (!empty($data['img'])) {
                $payload['img'] = $data['img'];
            }

            if (!empty($data['organizationTypeId'])) {
                $payload['organizationTypeId'] = (int)$data['organizationTypeId'];
            }

            if (!empty($data['countryId'])) {
                $payload['countryId'] = (int)$data['countryId'];
            }

            if (!empty($data['provinceId'])) {
                $payload['provinceId'] = (int)$data['provinceId'];
            }

            $response = $this->apiClient->authenticatedRequest('PUT', "/users/{$id}", $payload);

            if ($response) {
                echo json_encode($response);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erro ao atualizar usuário']);
            }
            exit;

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Erro ao atualizar usuário',
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }
}