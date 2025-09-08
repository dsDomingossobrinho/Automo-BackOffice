<?php
namespace App\Models;

use App\Core\Model;

/**
 * Client Model
 */
class Client extends Model
{
    protected $endpoint = '/users'; // Clients are users in the backend
    
    /**
     * Find clients with specific filters
     */
    public function findWithFilters($filters = [])
    {
        $params = [];
        
        if (!empty($filters['search'])) {
            $params['search'] = $filters['search'];
        }
        
        if (!empty($filters['stateId'])) {
            $params['stateId'] = $filters['stateId'];
        }
        
        if (!empty($filters['accountTypeId'])) {
            $params['accountTypeId'] = $filters['accountTypeId'];
        }
        
        if (!empty($filters['agentId'])) {
            $params['agentId'] = $filters['agentId'];
        }
        
        if (!empty($filters['page'])) {
            $params['page'] = $filters['page'];
        }
        
        if (!empty($filters['size'])) {
            $params['size'] = $filters['size'];
        }
        
        return $this->findAll($params);
    }
    
    /**
     * Find clients by agent
     */
    public function findByAgent($agentId, $params = [])
    {
        $params['agentId'] = $agentId;
        return $this->findAll($params);
    }
    
    /**
     * Get client statistics
     */
    public function getStatistics()
    {
        try {
            // This would need to be implemented in the backend API
            return $this->apiClient->authenticatedRequest('GET', '/users/statistics');
        } catch (\Exception $e) {
            return [
                'total' => 0,
                'active' => 0,
                'inactive' => 0,
                'thisMonth' => 0
            ];
        }
    }
    
    /**
     * Validate client data
     */
    public function validateData($data, $isUpdate = false)
    {
        $rules = [
            'name' => 'required|min:2|max:100',
            'contact' => 'required|min:9|max:20',
            'accountTypeId' => 'required|numeric'
        ];
        
        if (!empty($data['email'])) {
            $rules['email'] = 'email|max:100';
        }
        
        if (!empty($data['address'])) {
            $rules['address'] = 'max:255';
        }
        
        return $this->validate($data, $rules);
    }
    
    /**
     * Export clients data
     */
    public function exportData($format = 'csv', $filters = [])
    {
        $clients = $this->findWithFilters($filters);
        
        switch (strtolower($format)) {
            case 'csv':
                return $this->exportToCsv($clients);
            case 'json':
                return json_encode($clients);
            default:
                throw new \Exception('Unsupported export format');
        }
    }
    
    /**
     * Export to CSV format
     */
    private function exportToCsv($clients)
    {
        $csv = "ID,Nome,Email,Contacto,Tipo de Conta,Estado,Data de Criacao\n";
        
        foreach ($clients as $client) {
            $csv .= sprintf(
                "%d,%s,%s,%s,%s,%s,%s\n",
                $client['id'] ?? '',
                $this->csvEscape($client['name'] ?? ''),
                $this->csvEscape($client['email'] ?? ''),
                $this->csvEscape($client['contact'] ?? ''),
                $this->csvEscape($client['accountType']['name'] ?? ''),
                $this->csvEscape($client['state']['name'] ?? ''),
                $this->csvEscape($client['createdAt'] ?? '')
            );
        }
        
        return $csv;
    }
    
    /**
     * Escape CSV fields
     */
    private function csvEscape($field)
    {
        if (strpos($field, ',') !== false || strpos($field, '"') !== false || strpos($field, "\n") !== false) {
            return '"' . str_replace('"', '""', $field) . '"';
        }
        return $field;
    }
    
    /**
     * Get client activity log
     */
    public function getActivityLog($clientId, $limit = 50)
    {
        try {
            return $this->apiClient->authenticatedRequest('GET', "/users/{$clientId}/activity", [
                'limit' => $limit
            ]);
        } catch (\Exception $e) {
            return [];
        }
    }
    
    /**
     * Update client status
     */
    public function updateStatus($clientId, $stateId)
    {
        return $this->apiClient->authenticatedRequest('PUT', "/users/{$clientId}/status", [
            'stateId' => $stateId
        ]);
    }
    
    /**
     * Bulk operations
     */
    public function bulkDelete($ids)
    {
        return $this->apiClient->authenticatedRequest('DELETE', '/users/bulk', [
            'ids' => $ids
        ]);
    }
    
    public function bulkUpdateStatus($ids, $stateId)
    {
        return $this->apiClient->authenticatedRequest('PUT', '/users/bulk/status', [
            'ids' => $ids,
            'stateId' => $stateId
        ]);
    }
}