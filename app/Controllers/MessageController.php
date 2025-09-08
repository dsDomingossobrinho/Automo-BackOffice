<?php

namespace App\Controllers;

use App\Core\Controller;

class MessageController extends Controller
{
    public function index()
    {
        $page = (int)($_GET['page'] ?? 1);
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        $type = $_GET['type'] ?? '';
        
        $params = [
            'page' => $page,
            'limit' => 15,
        ];
        
        if ($search) $params['search'] = $search;
        if ($status) $params['status'] = $status;
        if ($type) $params['type'] = $type;

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/messages', $params);
            
            if ($response['success'] ?? false) {
                $messages = $response['data']['messages'] ?? [];
                $pagination = $response['data']['pagination'] ?? [];
                $stats = $response['data']['stats'] ?? [];
            } else {
                $messages = [];
                $pagination = [];
                $stats = [];
                $this->setFlash('errors', ['Erro ao carregar mensagens: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $messages = [];
            $pagination = [];
            $stats = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('messages/index', [
            'messages' => $messages,
            'pagination' => $pagination,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
            'type' => $type
        ]);
    }

    public function create()
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/messages/create-data');
            $clients = $response['data']['clients'] ?? [];
            $templates = $response['data']['templates'] ?? [];
        } catch (Exception $e) {
            $clients = [];
            $templates = [];
            $this->setFlash('errors', ['Erro ao carregar dados: ' . $e->getMessage()]);
        }

        return $this->view('messages/create', [
            'clients' => $clients,
            'templates' => $templates
        ]);
    }

    public function store()
    {
        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect('/messages/create');
        }

        $data = [
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'template_id' => (int)($_POST['template_id'] ?? 0),
            'message' => $_POST['message'] ?? '',
            'schedule_date' => $_POST['schedule_date'] ?? null,
            'type' => $_POST['type'] ?? 'sms'
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('POST', '/backoffice/messages', $data);
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Mensagem enviada com sucesso']);
                $this->redirect('/messages');
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao enviar mensagem']);
                $this->redirect('/messages/create');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/messages/create');
        }
    }

    public function show($id)
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', "/backoffice/messages/{$id}");
            
            if ($response['success'] ?? false) {
                $message = $response['data'] ?? [];
            } else {
                $this->setFlash('errors', ['Mensagem não encontrada']);
                $this->redirect('/messages');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/messages');
        }

        return $this->view('messages/show', [
            'message' => $message
        ]);
    }

    public function delete($id)
    {
        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect('/messages');
        }

        try {
            $response = $this->apiClient->authenticatedRequest('DELETE', "/backoffice/messages/{$id}");
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Mensagem excluída com sucesso']);
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao excluir mensagem']);
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        $this->redirect('/messages');
    }

    public function byClient()
    {
        $client_id = $_GET['client_id'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        
        $params = [
            'page' => $page,
            'limit' => 15,
        ];
        
        if ($client_id) {
            $params['client_id'] = $client_id;
        }

        try {
            $clientsResponse = $this->apiClient->authenticatedRequest('GET', '/backoffice/clients/list');
            $messagesResponse = $this->apiClient->authenticatedRequest('GET', '/backoffice/messages/by-client', $params);
            
            $clients = $clientsResponse['data']['clients'] ?? [];
            
            if ($messagesResponse['success'] ?? false) {
                $messages = $messagesResponse['data']['messages'] ?? [];
                $pagination = $messagesResponse['data']['pagination'] ?? [];
                $stats = $messagesResponse['data']['stats'] ?? [];
            } else {
                $messages = [];
                $pagination = [];
                $stats = [];
                $this->setFlash('errors', ['Erro ao carregar mensagens: ' . ($messagesResponse['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $clients = [];
            $messages = [];
            $pagination = [];
            $stats = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('messages/by-client', [
            'clients' => $clients,
            'messages' => $messages,
            'pagination' => $pagination,
            'stats' => $stats,
            'selected_client_id' => $client_id
        ]);
    }

    public function conversion()
    {
        $period = $_GET['period'] ?? 'month';
        $page = (int)($_GET['page'] ?? 1);
        
        $params = [
            'page' => $page,
            'limit' => 15,
            'period' => $period
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/messages/conversion', $params);
            
            if ($response['success'] ?? false) {
                $conversions = $response['data']['conversions'] ?? [];
                $pagination = $response['data']['pagination'] ?? [];
                $stats = $response['data']['stats'] ?? [];
                $chartData = $response['data']['chart'] ?? [];
            } else {
                $conversions = [];
                $pagination = [];
                $stats = [];
                $chartData = [];
                $this->setFlash('errors', ['Erro ao carregar dados de conversão: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $conversions = [];
            $pagination = [];
            $stats = [];
            $chartData = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('messages/conversion', [
            'conversions' => $conversions,
            'pagination' => $pagination,
            'stats' => $stats,
            'chartData' => $chartData,
            'period' => $period
        ]);
    }

    public function byClientAll()
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/messages/by-client/all');
            
            if ($response['success'] ?? false) {
                $data = $response['data'] ?? [];
            } else {
                $data = [];
                $this->setFlash('errors', ['Erro ao carregar dados: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $data = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('messages/by-client-all', [
            'data' => $data
        ]);
    }
}