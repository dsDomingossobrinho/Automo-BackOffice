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
            $this->view('clients/index', [
                'clients' => [],
                'states' => [],
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
            $response = $this->apiClient->authenticatedRequest('POST', '/users', [
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'contact' => $data['contact'],
                'img' => $data['img'] ?? null,
                'password' => $data['password'] ?? null,
                'accountTypeId' => (int)$data['account_type_id'],
                'stateId' => (int)($data['state_id'] ?? 1)
            ]);
            
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
                $this->setFlash('errors', ['Cliente não encontrado']);
                $this->redirect('/clients');
            }
            
            $this->view('clients/show', [
                'client' => $client,
                'has_permission_edit' => $this->auth->hasPermission('edit_clients'),
                'has_permission_delete' => $this->auth->hasPermission('delete_all')
            ]);
        } catch (\Exception $e) {
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
        if (!$this->auth->hasPermission('edit_clients')) {
            $this->setFlash('errors', ['Sem permissão para editar clientes']);
            $this->redirect('/clients');
        }
        
        try {
            $data = $this->getRequestData();
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($data['_token'] ?? '')) {
                $this->setFlash('errors', ['Token de segurança inválido']);
                $this->redirect("/clients/{$id}/edit");
            }
            
            // Validate input data
            $errors = $this->validateClientData($data, $id);
            if (!empty($errors)) {
                $this->setFlash('errors', $errors);
                flashInput();
                $this->redirect("/clients/{$id}/edit");
            }
            
            // Update client via API using /users endpoint
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'contact' => $data['contact'],
                'img' => $data['img'] ?? null,
                'accountTypeId' => (int)$data['account_type_id'],
                'stateId' => (int)$data['state_id']
            ];

            // Adicionar password apenas se foi fornecida
            if (!empty($data['password'])) {
                $updateData['password'] = $data['password'];
            }

            $response = $this->apiClient->authenticatedRequest('PUT', "/users/{$id}", $updateData);
            
            clearInput();
            $this->setFlash('success', 'Cliente actualizado com sucesso!');
            $this->redirect('/clients');
        } catch (\Exception $e) {
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
        
        if (empty($data['contact'])) {
            $errors[] = 'Contacto é obrigatório';
        }
        
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
            return $this->apiClient->authenticatedRequest('GET', '/states') ?? [];
        } catch (\Exception $e) {
            return [
                ['id' => 1, 'name' => 'ACTIVE'],
                ['id' => 2, 'name' => 'INACTIVE']
            ];
        }
    }
    
    /**
     * Get account types from API
     */
    private function getAccountTypes()
    {
        try {
            return $this->apiClient->authenticatedRequest('GET', '/account-types') ?? [];
        } catch (\Exception $e) {
            return [
                ['id' => 1, 'name' => 'INDIVIDUAL'],
                ['id' => 2, 'name' => 'CORPORATE']
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
}