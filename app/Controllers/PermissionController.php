<?php

namespace App\Controllers;

use App\Core\Controller;

class PermissionController extends Controller
{
    public function index()
    {
        if (!$this->auth->hasPermission('view_permissions')) {
            $this->setFlash('errors', ['Sem permissão para acessar permissões']);
            $this->redirect('/dashboard');
        }

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/permissions');
            
            if ($response['success'] ?? false) {
                $roles = $response['data']['roles'] ?? [];
                $permissions = $response['data']['permissions'] ?? [];
            } else {
                $roles = [];
                $permissions = [];
                $this->setFlash('errors', ['Erro ao carregar permissões: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $roles = [];
            $permissions = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('permissions/index', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        if (!$this->auth->hasPermission('create_permissions')) {
            $this->setFlash('errors', ['Sem permissão para criar permissões']);
            $this->redirect('/accounts/permission');
        }

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/permissions/available');
            $availablePermissions = $response['data']['permissions'] ?? [];
        } catch (Exception $e) {
            $availablePermissions = [];
            $this->setFlash('errors', ['Erro ao carregar dados: ' . $e->getMessage()]);
        }

        return $this->view('permissions/create', [
            'availablePermissions' => $availablePermissions
        ]);
    }

    public function store()
    {
        if (!$this->auth->hasPermission('create_permissions')) {
            $this->setFlash('errors', ['Sem permissão para criar permissões']);
            $this->redirect('/accounts/permission');
        }

        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect('/accounts/permission/create');
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'permissions' => $_POST['permissions'] ?? []
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('POST', '/backoffice/permissions', $data);
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Papel criado com sucesso']);
                $this->redirect('/accounts/permission');
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao criar papel']);
                $this->redirect('/accounts/permission/create');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/accounts/permission/create');
        }
    }

    public function edit($id)
    {
        if (!$this->auth->hasPermission('update_permissions')) {
            $this->setFlash('errors', ['Sem permissão para editar permissões']);
            $this->redirect('/accounts/permission');
        }

        try {
            $roleResponse = $this->apiClient->authenticatedRequest('GET', "/backoffice/permissions/roles/{$id}");
            $permissionsResponse = $this->apiClient->authenticatedRequest('GET', '/backoffice/permissions/available');
            
            if ($roleResponse['success'] ?? false) {
                $role = $roleResponse['data'] ?? [];
                $availablePermissions = $permissionsResponse['data']['permissions'] ?? [];
            } else {
                $this->setFlash('errors', ['Papel não encontrado']);
                $this->redirect('/accounts/permission');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/accounts/permission');
        }

        return $this->view('permissions/edit', [
            'role' => $role,
            'availablePermissions' => $availablePermissions
        ]);
    }

    public function update($id)
    {
        if (!$this->auth->hasPermission('update_permissions')) {
            $this->setFlash('errors', ['Sem permissão para editar permissões']);
            $this->redirect('/accounts/permission');
        }

        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect("/accounts/permission/{$id}/edit");
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'permissions' => $_POST['permissions'] ?? []
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('PUT', "/backoffice/permissions/roles/{$id}", $data);
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Papel atualizado com sucesso']);
                $this->redirect('/accounts/permission');
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao atualizar papel']);
                $this->redirect("/accounts/permission/{$id}/edit");
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect("/accounts/permission/{$id}/edit");
        }
    }

    public function delete($id)
    {
        if (!$this->auth->hasPermission('delete_permissions')) {
            $this->setFlash('errors', ['Sem permissão para excluir permissões']);
            $this->redirect('/accounts/permission');
        }

        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect('/accounts/permission');
        }

        try {
            $response = $this->apiClient->authenticatedRequest('DELETE', "/backoffice/permissions/roles/{$id}");
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Papel excluído com sucesso']);
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao excluir papel']);
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        $this->redirect('/accounts/permission');
    }
}