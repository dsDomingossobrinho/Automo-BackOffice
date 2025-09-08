<?php

namespace App\Controllers;

use App\Core\Controller;

class AccountController extends Controller
{
    public function index()
    {
        if (!$this->auth->hasPermission('view_accounts')) {
            $this->setFlash('errors', ['Sem permissão para acessar contas']);
            $this->redirect('/dashboard');
        }

        $page = (int)($_GET['page'] ?? 1);
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        
        $params = [
            'page' => $page,
            'limit' => 15,
        ];
        
        if ($search) {
            $params['search'] = $search;
        }
        
        if ($status) {
            $params['status'] = $status;
        }

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/accounts', $params);
            
            if ($response['success'] ?? false) {
                $accounts = $response['data']['accounts'] ?? [];
                $pagination = $response['data']['pagination'] ?? [];
                $stats = $response['data']['stats'] ?? [];
            } else {
                $accounts = [];
                $pagination = [];
                $stats = [];
                $this->setFlash('errors', ['Erro ao carregar contas: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $accounts = [];
            $pagination = [];
            $stats = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('accounts/index', [
            'accounts' => $accounts,
            'pagination' => $pagination,
            'stats' => $stats,
            'search' => $search,
            'status' => $status
        ]);
    }

    public function create()
    {
        if (!$this->auth->hasPermission('create_accounts')) {
            $this->setFlash('errors', ['Sem permissão para criar contas']);
            $this->redirect('/accounts');
        }

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/accounts/create-data');
            $roles = $response['data']['roles'] ?? [];
        } catch (Exception $e) {
            $roles = [];
            $this->setFlash('errors', ['Erro ao carregar dados: ' . $e->getMessage()]);
        }

        return $this->view('accounts/create', [
            'roles' => $roles
        ]);
    }

    public function store()
    {
        if (!$this->auth->hasPermission('create_accounts')) {
            $this->setFlash('errors', ['Sem permissão para criar contas']);
            $this->redirect('/accounts');
        }

        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect('/accounts/create');
        }

        $data = [
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'name' => $_POST['name'] ?? '',
            'role_id' => (int)($_POST['role_id'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('POST', '/backoffice/accounts', $data);
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Conta criada com sucesso']);
                $this->redirect('/accounts');
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao criar conta']);
                $this->redirect('/accounts/create');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/accounts/create');
        }
    }

    public function show($id)
    {
        if (!$this->auth->hasPermission('view_accounts')) {
            $this->setFlash('errors', ['Sem permissão para visualizar conta']);
            $this->redirect('/accounts');
        }

        try {
            $response = $this->apiClient->authenticatedRequest('GET', "/backoffice/accounts/{$id}");
            
            if ($response['success'] ?? false) {
                $account = $response['data'] ?? [];
            } else {
                $this->setFlash('errors', ['Conta não encontrada']);
                $this->redirect('/accounts');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/accounts');
        }

        return $this->view('accounts/show', [
            'account' => $account
        ]);
    }

    public function edit($id)
    {
        if (!$this->auth->hasPermission('update_accounts')) {
            $this->setFlash('errors', ['Sem permissão para editar conta']);
            $this->redirect('/accounts');
        }

        try {
            $accountResponse = $this->apiClient->authenticatedRequest('GET', "/backoffice/accounts/{$id}");
            $rolesResponse = $this->apiClient->authenticatedRequest('GET', '/backoffice/accounts/create-data');
            
            if ($accountResponse['success'] ?? false) {
                $account = $accountResponse['data'] ?? [];
                $roles = $rolesResponse['data']['roles'] ?? [];
            } else {
                $this->setFlash('errors', ['Conta não encontrada']);
                $this->redirect('/accounts');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/accounts');
        }

        return $this->view('accounts/edit', [
            'account' => $account,
            'roles' => $roles
        ]);
    }

    public function update($id)
    {
        if (!$this->auth->hasPermission('update_accounts')) {
            $this->setFlash('errors', ['Sem permissão para editar conta']);
            $this->redirect('/accounts');
        }

        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect("/accounts/{$id}/edit");
        }

        $data = [
            'email' => $_POST['email'] ?? '',
            'name' => $_POST['name'] ?? '',
            'role_id' => (int)($_POST['role_id'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password'];
        }

        try {
            $response = $this->apiClient->authenticatedRequest('PUT', "/backoffice/accounts/{$id}", $data);
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Conta atualizada com sucesso']);
                $this->redirect('/accounts');
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao atualizar conta']);
                $this->redirect("/accounts/{$id}/edit");
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect("/accounts/{$id}/edit");
        }
    }

    public function delete($id)
    {
        if (!$this->auth->hasPermission('delete_accounts')) {
            $this->setFlash('errors', ['Sem permissão para excluir conta']);
            $this->redirect('/accounts');
        }

        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect('/accounts');
        }

        try {
            $response = $this->apiClient->authenticatedRequest('DELETE', "/backoffice/accounts/{$id}");
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Conta excluída com sucesso']);
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao excluir conta']);
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        $this->redirect('/accounts');
    }
}