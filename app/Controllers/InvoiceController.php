<?php

namespace App\Controllers;

use App\Core\Controller;

class InvoiceController extends Controller
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
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/invoices', $params);
            
            if ($response['success'] ?? false) {
                $invoices = $response['data']['invoices'] ?? [];
                $pagination = $response['data']['pagination'] ?? [];
                $stats = $response['data']['stats'] ?? [];
            } else {
                $invoices = [];
                $pagination = [];
                $stats = [];
                $this->setFlash('errors', ['Erro ao carregar documentos: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $invoices = [];
            $pagination = [];
            $stats = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('invoices/index', [
            'invoices' => $invoices,
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
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/invoices/create-data');
            $clients = $response['data']['clients'] ?? [];
            $services = $response['data']['services'] ?? [];
            $templates = $response['data']['templates'] ?? [];
        } catch (Exception $e) {
            $clients = [];
            $services = [];
            $templates = [];
            $this->setFlash('errors', ['Erro ao carregar dados: ' . $e->getMessage()]);
        }

        return $this->view('invoices/create', [
            'clients' => $clients,
            'services' => $services,
            'templates' => $templates
        ]);
    }

    public function store()
    {
        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect('/invoices/create');
        }

        $data = [
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'type' => $_POST['type'] ?? 'invoice',
            'due_date' => $_POST['due_date'] ?? null,
            'items' => $_POST['items'] ?? [],
            'notes' => $_POST['notes'] ?? '',
            'discount' => (float)($_POST['discount'] ?? 0),
            'tax' => (float)($_POST['tax'] ?? 0)
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('POST', '/backoffice/invoices', $data);
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Documento criado com sucesso']);
                $this->redirect('/invoices');
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao criar documento']);
                $this->redirect('/invoices/create');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/invoices/create');
        }
    }

    public function show($id)
    {
        try {
            $response = $this->apiClient->authenticatedRequest('GET', "/backoffice/invoices/{$id}");
            
            if ($response['success'] ?? false) {
                $invoice = $response['data'] ?? [];
            } else {
                $this->setFlash('errors', ['Documento não encontrado']);
                $this->redirect('/invoices');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/invoices');
        }

        return $this->view('invoices/show', [
            'invoice' => $invoice
        ]);
    }

    public function edit($id)
    {
        try {
            $invoiceResponse = $this->apiClient->authenticatedRequest('GET', "/backoffice/invoices/{$id}");
            $createDataResponse = $this->apiClient->authenticatedRequest('GET', '/backoffice/invoices/create-data');
            
            if ($invoiceResponse['success'] ?? false) {
                $invoice = $invoiceResponse['data'] ?? [];
                $clients = $createDataResponse['data']['clients'] ?? [];
                $services = $createDataResponse['data']['services'] ?? [];
                $templates = $createDataResponse['data']['templates'] ?? [];
            } else {
                $this->setFlash('errors', ['Documento não encontrado']);
                $this->redirect('/invoices');
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect('/invoices');
        }

        return $this->view('invoices/edit', [
            'invoice' => $invoice,
            'clients' => $clients,
            'services' => $services,
            'templates' => $templates
        ]);
    }

    public function update($id)
    {
        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect("/invoices/{$id}/edit");
        }

        $data = [
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'type' => $_POST['type'] ?? 'invoice',
            'due_date' => $_POST['due_date'] ?? null,
            'items' => $_POST['items'] ?? [],
            'notes' => $_POST['notes'] ?? '',
            'discount' => (float)($_POST['discount'] ?? 0),
            'tax' => (float)($_POST['tax'] ?? 0),
            'status' => $_POST['status'] ?? 'draft'
        ];

        try {
            $response = $this->apiClient->authenticatedRequest('PUT', "/backoffice/invoices/{$id}", $data);
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Documento atualizado com sucesso']);
                $this->redirect('/invoices');
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao atualizar documento']);
                $this->redirect("/invoices/{$id}/edit");
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
            $this->redirect("/invoices/{$id}/edit");
        }
    }

    public function delete($id)
    {
        if (!$this->validateCsrf()) {
            $this->setFlash('errors', ['Token de segurança inválido']);
            $this->redirect('/invoices');
        }

        try {
            $response = $this->apiClient->authenticatedRequest('DELETE', "/backoffice/invoices/{$id}");
            
            if ($response['success'] ?? false) {
                $this->setFlash('success', ['Documento excluído com sucesso']);
            } else {
                $this->setFlash('errors', [$response['message'] ?? 'Erro ao excluir documento']);
            }
        } catch (Exception $e) {
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        $this->redirect('/invoices');
    }

    public function receipts()
    {
        $page = (int)($_GET['page'] ?? 1);
        $search = $_GET['search'] ?? '';
        $date_from = $_GET['date_from'] ?? '';
        $date_to = $_GET['date_to'] ?? '';
        
        $params = [
            'page' => $page,
            'limit' => 15,
            'type' => 'receipt'
        ];
        
        if ($search) $params['search'] = $search;
        if ($date_from) $params['date_from'] = $date_from;
        if ($date_to) $params['date_to'] = $date_to;

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/invoices/receipts', $params);
            
            if ($response['success'] ?? false) {
                $receipts = $response['data']['receipts'] ?? [];
                $pagination = $response['data']['pagination'] ?? [];
                $stats = $response['data']['stats'] ?? [];
            } else {
                $receipts = [];
                $pagination = [];
                $stats = [];
                $this->setFlash('errors', ['Erro ao carregar recibos: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $receipts = [];
            $pagination = [];
            $stats = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('invoices/receipts', [
            'receipts' => $receipts,
            'pagination' => $pagination,
            'stats' => $stats,
            'search' => $search,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }

    public function plans()
    {
        $page = (int)($_GET['page'] ?? 1);
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        
        $params = [
            'page' => $page,
            'limit' => 15,
        ];
        
        if ($search) $params['search'] = $search;
        if ($status) $params['status'] = $status;

        try {
            $response = $this->apiClient->authenticatedRequest('GET', '/backoffice/plans', $params);
            
            if ($response['success'] ?? false) {
                $plans = $response['data']['plans'] ?? [];
                $pagination = $response['data']['pagination'] ?? [];
                $stats = $response['data']['stats'] ?? [];
            } else {
                $plans = [];
                $pagination = [];
                $stats = [];
                $this->setFlash('errors', ['Erro ao carregar planos: ' . ($response['message'] ?? 'Erro desconhecido')]);
            }
        } catch (Exception $e) {
            $plans = [];
            $pagination = [];
            $stats = [];
            $this->setFlash('errors', ['Erro de conexão: ' . $e->getMessage()]);
        }

        return $this->view('invoices/plans', [
            'plans' => $plans,
            'pagination' => $pagination,
            'stats' => $stats,
            'search' => $search,
            'status' => $status
        ]);
    }
}