<?php

namespace App\Controllers;

use App\Core\Controller;
use Exception;

class AccountController extends Controller
{
    public function index()
    {
        // Debug information
        if (DEBUG_MODE) {
            $user = $this->auth->getUser();
            $permissions = $this->auth->getPermissions();
            error_log("ACCOUNTS: User data: " . print_r($user, true));
            error_log("ACCOUNTS: User permissions: " . print_r($permissions, true));
            error_log("ACCOUNTS: Has view_accounts permission: " . ($this->auth->hasPermission('view_accounts') ? 'YES' : 'NO'));
            error_log("ACCOUNTS: Is admin: " . ($this->auth->isAdmin() ? 'YES' : 'NO'));
        }
        
        // Check if user is admin OR has specific permission
        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('view_accounts')) {
            $this->setFlash('errors', ['Sem permissão para acessar contas. Role atual: ' . implode(', ', $this->auth->getUser()['allRoleIds'] ?? [])]);
            $this->redirect('/dashboard');
        }

        $page = (int)($_GET['page'] ?? 1);
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        
        if (DEBUG_MODE) {
            error_log("ACCOUNTS: Received parameters - page: $page, search: '$search', status: '$status'");
        }
        
        $params = [
            'page' => max(0, $page - 1), // Backend uses 0-based pagination
            'size' => 6,
            'sortBy' => 'createdAt',
            'sortDirection' => 'DESC'
        ];
        
        if ($search) {
            $params['search'] = $search;
            if (DEBUG_MODE) {
                error_log("ACCOUNTS: Added search parameter: '$search'");
            }
        }
        
        if ($status) {
            // Map frontend status to backend format
            if ($status === 'active') {
                $params['stateId'] = 1; // ACTIVE state
                if (DEBUG_MODE) {
                    error_log("ACCOUNTS: Mapped 'active' status to stateId: 1");
                }
            } elseif ($status === 'inactive') {
                $params['stateId'] = 2; // INACTIVE state  
                if (DEBUG_MODE) {
                    error_log("ACCOUNTS: Mapped 'inactive' status to stateId: 2");
                }
            }
        }
        
        if (DEBUG_MODE) {
            error_log("ACCOUNTS: Final API parameters: " . print_r($params, true));
        }

        try {
            // Use the correct admin endpoint with pagination
            $response = $this->apiClient->authenticatedRequest('GET', '/admins/paginated', $params);
            
            if (DEBUG_MODE) {
                error_log("ACCOUNTS: API Response from /admins/paginated: " . print_r($response, true));
            }
            
            if ($response['success'] ?? false) {
                // The PaginatedResponse is returned directly in response['data']
                $paginatedData = $response['data'] ?? [];
                $accounts = $paginatedData['content'] ?? [];
                $pagination = [
                    'current_page' => ($paginatedData['pageNumber'] ?? 0) + 1,
                    'total_pages' => $paginatedData['totalPages'] ?? 1,
                    'total_elements' => $paginatedData['totalElements'] ?? 0,
                    'size' => $paginatedData['pageSize'] ?? 10,
                    'has_next' => $paginatedData['hasNext'] ?? false,
                    'has_previous' => $paginatedData['hasPrevious'] ?? false
                ];
                
                $stats = [
                    'total_admins' => $pagination['total_elements'],
                    'active_admins' => count(array_filter($accounts, fn($a) => ($a['state'] ?? '') === 'ACTIVE')),
                    'inactive_admins' => count(array_filter($accounts, fn($a) => ($a['state'] ?? '') !== 'ACTIVE'))
                ];
            } else {
                $accounts = [];
                $pagination = ['current_page' => 1, 'total_pages' => 1, 'total_elements' => 0, 'size' => 10];
                $stats = ['total_admins' => 0, 'active_admins' => 0, 'inactive_admins' => 0];
                $this->setFlash('errors', ['Erro ao carregar administradores: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $accounts = [];
            $pagination = ['current_page' => 1, 'total_pages' => 1, 'total_elements' => 0, 'size' => 10];
            $stats = ['total_admins' => 0, 'active_admins' => 0, 'inactive_admins' => 0];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        // Get auxiliary data for modals
        $accountTypes = $this->getAccountTypes();
        $states = $this->getStates();

        $this->view('accounts/index', [
            'accounts' => $accounts,
            'pagination' => $pagination,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
            'page' => $page,
            'accountTypes' => $accountTypes,
            'states' => $states
        ]);
    }

    public function create()
    {
        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('create_accounts')) {
            $this->setFlash('errors', ['Sem permissão para criar administradores']);
            $this->redirect('/accounts');
        }

        // Get auxiliary data from real backend endpoints
        $roles = $this->getRoles();
        $accountTypes = $this->getAccountTypes();
        $states = $this->getStates();
        
        $this->view('accounts/create', [
            'roles' => $roles,
            'accountTypes' => $accountTypes,
            'states' => $states
        ]);
    }

    public function store()
    {
        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('create_accounts')) {
            $this->json(['success' => false, 'message' => 'Sem permissão para criar administradores'], 403);
            return;
        }

        $data = $this->getRequestData();

        if (DEBUG_MODE) {
            error_log("ACCOUNTS CREATE: Raw request data: " . print_r($data, true));
            error_log("ACCOUNTS CREATE: Content-Type: " . ($_SERVER['CONTENT_TYPE'] ?? 'not set'));
            error_log("ACCOUNTS CREATE: Request method: " . $_SERVER['REQUEST_METHOD']);
        }

        // Validate required fields based on AdminDto structure
        $required = ['name', 'email', 'password', 'accountTypeId'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $this->json(['success' => false, 'message' => "Campo {$field} é obrigatório"], 400);
                return;
            }
        }

        // Validate stateId is required
        if (!isset($data['stateId']) || $data['stateId'] === '') {
            $this->json(['success' => false, 'message' => 'Campo stateId é obrigatório'], 400);
            return;
        }

        try {
            // Prepare data for admin creation endpoint
            $adminData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'accountTypeId' => (int)$data['accountTypeId'],
                'stateId' => (int)$data['stateId']
            ];

            // Add optional fields only if provided
            if (!empty($data['contact'])) {
                $adminData['contact'] = $data['contact'];
            }

            if (!empty($data['img'])) {
                $adminData['img'] = $data['img'];
            }

            // Use the correct admin creation endpoint
            $response = $this->apiClient->authenticatedRequest('POST', '/admins', $adminData);
            
            // Check if this is an AJAX request
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
            
            if ($response['success'] ?? false) {
                if ($isAjax) {
                    $this->json(['success' => true, 'message' => 'Administrador criado com sucesso']);
                } else {
                    $this->setFlash('success', ['Administrador criado com sucesso']);
                    $this->redirect('/accounts');
                }
            } else {
                if ($isAjax) {
                    // Handle field-specific errors from backend
                    $errorResponse = [
                        'success' => false,
                        'message' => $response['message'] ?? 'Erro ao criar administrador'
                    ];

                    // Include field errors if they exist in the response data
                    if (isset($response['data']['fieldErrors'])) {
                        $errorResponse['errors'] = $response['data']['fieldErrors'];
                    } elseif (isset($response['errors'])) {
                        $errorResponse['errors'] = $response['errors'];
                    }

                    $this->json($errorResponse, 400);
                } else {
                    $this->setFlash('errors', [$response['message'] ?? 'Erro ao criar administrador']);
                    $this->redirect('/accounts/create');
                }
            }
        } catch (Exception $e) {
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Erro de conexão: ' . $e->getMessage()], 500);
            } else {
                $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
                $this->redirect('/accounts/create');
            }
        }
    }

    public function show($id)
    {
        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('view_accounts')) {
            // Check if this is an AJAX request
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
            
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Sem permissão para visualizar administradores'], 403);
                return;
            } else {
                $this->setFlash('errors', ['Sem permissão para visualizar administradores']);
                $this->redirect('/accounts');
            }
        }

        try {
            $response = $this->apiClient->authenticatedRequest('GET', "/admins/{$id}");
            
            if ($response['success'] ?? false) {
                $account = $response['data'] ?? [];
                
                // Check if this is an AJAX request
                $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
                
                if ($isAjax) {
                    // Return JSON data for modal
                    $this->json(['success' => true, 'data' => $account]);
                    return;
                }
            } else {
                // Check if this is an AJAX request
                $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
                
                if ($isAjax) {
                    $this->json(['success' => false, 'message' => 'Administrador não encontrado'], 404);
                    return;
                } else {
                    $this->setFlash('errors', ['Administrador não encontrado']);
                    $this->redirect('/accounts');
                    return;
                }
            }
        } catch (Exception $e) {
            // Check if this is an AJAX request
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
            
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Erro ao carregar administrador'], 500);
                return;
            } else {
                $this->setFlash('errors', ['Erro ao carregar administrador']);
                $this->redirect('/accounts');
                return;
            }
        }

        $this->view('accounts/show', [
            'account' => $account
        ]);
    }

    public function edit($id)
    {
        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('edit_accounts')) {
            // Check if this is an AJAX request
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
            
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Sem permissão para editar administradores'], 403);
                return;
            } else {
                $this->setFlash('errors', ['Sem permissão para editar administradores']);
                $this->redirect('/accounts');
            }
        }

        try {
            $accountResponse = $this->apiClient->authenticatedRequest('GET', "/admins/{$id}");
            
            if ($accountResponse['success'] ?? false) {
                $account = $accountResponse['data'] ?? [];
                
                // Check if this is an AJAX request
                $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
                
                if ($isAjax) {
                    // Return JSON data for modal
                    $this->json(['success' => true, 'data' => $account]);
                    return;
                }
                
                $roles = $this->getRoles();
                $accountTypes = $this->getAccountTypes();
                $states = $this->getStates();
            } else {
                // Check if this is an AJAX request
                $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
                
                if ($isAjax) {
                    $this->json(['success' => false, 'message' => 'Administrador não encontrado'], 404);
                    return;
                } else {
                    $this->setFlash('errors', ['Administrador não encontrado']);
                    $this->redirect('/accounts');
                    return;
                }
            }
        } catch (Exception $e) {
            // Check if this is an AJAX request
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
            
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Erro ao carregar dados'], 500);
                return;
            } else {
                $this->setFlash('errors', ['Erro ao carregar dados']);
                $this->redirect('/accounts');
                return;
            }
        }

        $this->view('accounts/edit', [
            'account' => $account,
            'roles' => $roles,
            'accountTypes' => $accountTypes,
            'states' => $states
        ]);
    }

    public function update($id)
    {
        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('edit_accounts')) {
            $this->json(['success' => false, 'message' => 'Sem permissão para editar administradores'], 403);
            return;
        }

        $data = $this->getRequestData();
        
        try {
            // Prepare update data, including contact if provided
            $updateData = [
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
                'accountTypeId' => isset($data['accountTypeId']) ? (int)$data['accountTypeId'] : null,
                'stateId' => isset($data['stateId']) ? (int)$data['stateId'] : null,
                'img' => $data['img'] ?? null
            ];
            
            // Add contact if provided
            if (!empty($data['contact'])) {
                $updateData['contact'] = $data['contact'];
            }
            
            // Add password only if provided (for password change)
            if (!empty($data['password'])) {
                $updateData['password'] = $data['password'];
            }
            
            // Update admin using the correct endpoint
            $response = $this->apiClient->authenticatedRequest('PUT', "/admins/{$id}", $updateData);

            // Check if this is an AJAX request
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

            if ($response['success'] ?? false) {
                if ($isAjax) {
                    $this->json(['success' => true, 'message' => 'Administrador atualizado com sucesso']);
                } else {
                    $this->setFlash('success', ['Administrador atualizado com sucesso']);
                    $this->redirect('/accounts');
                }
            } else {
                if ($isAjax) {
                    // Pass through field errors from backend if available
                    $errorResponse = [
                        'success' => false, 
                        'message' => $response['message'] ?? 'Erro ao atualizar administrador'
                    ];
                    
                    // Include field errors if they exist in the response data
                    if (isset($response['data']['fieldErrors'])) {
                        $errorResponse['fieldErrors'] = $response['data']['fieldErrors'];
                    }
                    
                    $this->json($errorResponse, 400);
                } else {
                    $this->setFlash('errors', ['Erro ao atualizar administrador: ' . ($response['message'] ?? 'Erro desconhecido')]);
                    $this->redirect("/accounts/{$id}/edit");
                }
            }
        } catch (Exception $e) {
            // Check if this is an AJAX request
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
            
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Erro ao atualizar administrador: ' . $e->getMessage()], 500);
            } else {
                $this->setFlash('errors', ['Erro ao atualizar administrador: ' . $e->getMessage()]);
                $this->redirect("/accounts/{$id}/edit");
            }
        }
    }

    public function delete($id)
    {
        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('delete_accounts')) {
            $this->json(['success' => false, 'message' => 'Sem permissão para excluir administradores'], 403);
            return;
        }

        try {
            // Use the correct admin deletion endpoint (soft delete)
            $response = $this->apiClient->authenticatedRequest('DELETE', "/admins/{$id}");
            
            // Check if this is an AJAX request
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
            
            if ($response['success'] ?? false) {
                if ($isAjax) {
                    $this->json(['success' => true, 'message' => 'Administrador eliminado com sucesso']);
                } else {
                    $this->setFlash('success', ['Administrador eliminado com sucesso']);
                    $this->redirect('/accounts');
                }
            } else {
                if ($isAjax) {
                    $this->json(['success' => false, 'message' => $response['message'] ?? 'Erro ao eliminar administrador'], 400);
                } else {
                    $this->setFlash('errors', [$response['message'] ?? 'Erro ao eliminar administrador']);
                    $this->redirect('/accounts');
                }
            }
        } catch (Exception $e) {
            // Check if this is an AJAX request
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
            
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Erro de conexão: ' . $e->getMessage()], 500);
            } else {
                $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
                $this->redirect('/accounts');
            }
        }
    }

    // AJAX endpoints for status change
    public function activate($id)
    {
        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('edit_accounts')) {
            $this->json(['success' => false, 'message' => 'Sem permissão'], 403);
            return;
        }

        try {
            // First, get the current admin data
            $adminResponse = $this->apiClient->authenticatedRequest('GET', "/admins/{$id}");
            
            if (!($adminResponse['success'] ?? false)) {
                $this->json(['success' => false, 'message' => 'Administrador não encontrado']);
                return;
            }
            
            $admin = $adminResponse['data'];
            
            // Update admin state to ACTIVE (stateId = 1) with complete data
            // Note: Password and contact are not changed (backend will keep existing values)
            $response = $this->apiClient->authenticatedRequest('PUT', "/admins/{$id}", [
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => '', // Empty string - backend will not change password
                'contact' => '+244 000 000 000', // Placeholder contact - TODO: get real contact from auth
                'accountTypeId' => 1, // ADMIN account type for back office
                'stateId' => 1, // ACTIVE state
                'img' => $admin['img']
            ]);
            $this->json($response);
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Erro ao ativar administrador']);
        }
    }

    public function deactivate($id)
    {
        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('edit_accounts')) {
            $this->json(['success' => false, 'message' => 'Sem permissão'], 403);
            return;
        }

        try {
            // First, get the current admin data
            $adminResponse = $this->apiClient->authenticatedRequest('GET', "/admins/{$id}");
            
            if (!($adminResponse['success'] ?? false)) {
                $this->json(['success' => false, 'message' => 'Administrador não encontrado']);
                return;
            }
            
            $admin = $adminResponse['data'];
            
            // Update admin state to INACTIVE (stateId = 2) with complete data
            // Note: Password and contact are not changed (backend will keep existing values)
            $response = $this->apiClient->authenticatedRequest('PUT', "/admins/{$id}", [
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => '', // Empty string - backend will not change password
                'contact' => '+244 000 000 000', // Placeholder contact - TODO: get real contact from auth
                'accountTypeId' => 1, // ADMIN account type for back office
                'stateId' => 2, // INACTIVE state
                'img' => $admin['img']
            ]);
            $this->json($response);
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Erro ao desativar administrador']);
        }
    }

    // Helper methods to get auxiliary data from real backend endpoints
    private function getRoles()
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/roles');
            
            if ($response['success'] ?? false) {
                return $response['data'] ?? [];
            }
            
            // Fallback to default roles if endpoint fails
            return [
                ['id' => 1, 'role' => 'ADMIN', 'description' => 'Administrator'],
                ['id' => 2, 'role' => 'USER', 'description' => 'Regular User'],
                ['id' => 3, 'role' => 'AGENT', 'description' => 'Agent'],
                ['id' => 4, 'role' => 'MANAGER', 'description' => 'Manager']
            ];
        } catch (Exception $e) {
            return [
                ['id' => 1, 'role' => 'ADMIN', 'description' => 'Administrator'],
                ['id' => 2, 'role' => 'USER', 'description' => 'Regular User'],
                ['id' => 3, 'role' => 'AGENT', 'description' => 'Agent'],
                ['id' => 4, 'role' => 'MANAGER', 'description' => 'Manager']
            ];
        }
    }

    private function getAccountTypes()
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/account-types');
            
            if ($response['success'] ?? false) {
                return $response['data'] ?? [];
            }
            
            // Fallback to default account types
            return [
                ['id' => 1, 'type' => 'INDIVIDUAL', 'description' => 'Back Office Individual'],
                ['id' => 2, 'type' => 'CORPORATE', 'description' => 'Corporate Account']
            ];
        } catch (Exception $e) {
            return [
                ['id' => 1, 'type' => 'INDIVIDUAL', 'description' => 'Back Office Individual'],
                ['id' => 2, 'type' => 'CORPORATE', 'description' => 'Corporate Account']
            ];
        }
    }

    private function getStates()
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/states');
            
            if ($response['success'] ?? false) {
                return $response['data'] ?? [];
            }
            
            // Fallback to default states
            return [
                ['id' => 1, 'state' => 'ACTIVE', 'description' => 'Active'],
                ['id' => 2, 'state' => 'INACTIVE', 'description' => 'Inactive'],
                ['id' => 3, 'state' => 'PENDING', 'description' => 'Pending'],
                ['id' => 4, 'state' => 'ELIMINATED', 'description' => 'Eliminated']
            ];
        } catch (Exception $e) {
            return [
                ['id' => 1, 'state' => 'ACTIVE', 'description' => 'Active'],
                ['id' => 2, 'state' => 'INACTIVE', 'description' => 'Inactive'],
                ['id' => 3, 'state' => 'PENDING', 'description' => 'Pending'],
                ['id' => 4, 'state' => 'ELIMINATED', 'description' => 'Eliminated']
            ];
        }
    }

    /**
     * AJAX endpoint for real-time search and filtering
     */
    public function ajaxSearch()
    {
        // Check for AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            $this->json(['success' => false, 'message' => 'Only AJAX requests allowed'], 400);
            return;
        }

        if (!$this->auth->isAdmin() && !$this->auth->hasPermission('view_accounts')) {
            $this->json(['success' => false, 'message' => 'Sem permissão para acessar contas'], 403);
            return;
        }

        $page = (int)($_GET['page'] ?? 1);
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        
        if (DEBUG_MODE) {
            error_log("AJAX SEARCH: Received parameters - page: $page, search: '$search', status: '$status'");
        }
        
        $params = [
            'page' => max(0, $page - 1), // Backend uses 0-based pagination
            'size' => 6,
            'sortBy' => 'createdAt',
            'sortDirection' => 'DESC'
        ];
        
        if ($search) {
            $params['search'] = $search;
            if (DEBUG_MODE) {
                error_log("AJAX SEARCH: Added search parameter: '$search'");
            }
        }
        
        if ($status) {
            // Map frontend status to backend format
            if ($status === 'active') {
                $params['stateId'] = 1; // ACTIVE state
                if (DEBUG_MODE) {
                    error_log("AJAX SEARCH: Mapped 'active' status to stateId: 1");
                }
            } elseif ($status === 'inactive') {
                $params['stateId'] = 2; // INACTIVE state  
                if (DEBUG_MODE) {
                    error_log("AJAX SEARCH: Mapped 'inactive' status to stateId: 2");
                }
            }
        }
        
        if (DEBUG_MODE) {
            error_log("AJAX SEARCH: Final API parameters: " . print_r($params, true));
        }

        try {
            // Use the correct admin endpoint with pagination
            $response = $this->apiClient->authenticatedRequest('GET', '/admins/paginated', $params);
            
            if (DEBUG_MODE) {
                error_log("AJAX SEARCH: API Response from /admins/paginated: " . print_r($response, true));
            }
            
            if ($response['success'] ?? false) {
                // The PaginatedResponse is returned directly in response['data']
                $paginatedData = $response['data'] ?? [];
                $accounts = $paginatedData['content'] ?? [];
                $pagination = [
                    'current_page' => ($paginatedData['pageNumber'] ?? 0) + 1,
                    'total_pages' => $paginatedData['totalPages'] ?? 1,
                    'total_elements' => $paginatedData['totalElements'] ?? 0,
                    'size' => $paginatedData['pageSize'] ?? 10,
                    'has_next' => $paginatedData['hasNext'] ?? false,
                    'has_previous' => $paginatedData['hasPrevious'] ?? false
                ];
                
                $stats = [
                    'total_admins' => $pagination['total_elements'],
                    'active_admins' => count(array_filter($accounts, fn($a) => ($a['state'] ?? '') === 'ACTIVE')),
                    'inactive_admins' => count(array_filter($accounts, fn($a) => ($a['state'] ?? '') !== 'ACTIVE'))
                ];

                // Return JSON response with data
                $this->json([
                    'success' => true,
                    'data' => [
                        'accounts' => $accounts,
                        'pagination' => $pagination,
                        'stats' => $stats,
                        'search' => $search,
                        'status' => $status
                    ]
                ]);
            } else {
                $this->json([
                    'success' => false, 
                    'message' => $response['message'] ?? 'Erro ao carregar administradores',
                    'data' => [
                        'accounts' => [],
                        'pagination' => ['current_page' => 1, 'total_pages' => 1, 'total_elements' => 0, 'size' => 10],
                        'stats' => ['total_admins' => 0, 'active_admins' => 0, 'inactive_admins' => 0]
                    ]
                ]);
            }
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                error_log("AJAX SEARCH: Exception occurred: " . $e->getMessage());
            }
            
            $this->json([
                'success' => false,
                'message' => 'Erro de conexão: ' . $e->getMessage(),
                'data' => [
                    'accounts' => [],
                    'pagination' => ['current_page' => 1, 'total_pages' => 1, 'total_elements' => 0, 'size' => 10],
                    'stats' => ['total_admins' => 0, 'active_admins' => 0, 'inactive_admins' => 0]
                ]
            ]);
        }
    }
}