<?php
namespace App\Core;

/**
 * Base Model Class - Handles API data operations
 */
abstract class Model
{
    protected $apiClient;
    protected $endpoint;
    protected $primaryKey = 'id';
    
    public function __construct()
    {
        $this->apiClient = new ApiClient();
    }
    
    /**
     * Find all records
     */
    public function findAll($params = [])
    {
        try {
            return $this->apiClient->authenticatedRequest('GET', $this->endpoint, $params);
        } catch (\Exception $e) {
            return [];
        }
    }
    
    /**
     * Find record by ID
     */
    public function findById($id)
    {
        try {
            return $this->apiClient->authenticatedRequest('GET', $this->endpoint . '/' . $id);
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Create new record
     */
    public function create($data)
    {
        return $this->apiClient->authenticatedRequest('POST', $this->endpoint, $data);
    }
    
    /**
     * Update existing record
     */
    public function update($id, $data)
    {
        return $this->apiClient->authenticatedRequest('PUT', $this->endpoint . '/' . $id, $data);
    }
    
    /**
     * Delete record
     */
    public function delete($id)
    {
        return $this->apiClient->authenticatedRequest('DELETE', $this->endpoint . '/' . $id);
    }
    
    /**
     * Search records
     */
    public function search($query, $params = [])
    {
        $params['search'] = $query;
        return $this->findAll($params);
    }
    
    /**
     * Paginate results
     */
    public function paginate($page = 1, $perPage = DEFAULT_PAGE_SIZE, $params = [])
    {
        $params['page'] = $page;
        $params['size'] = $perPage;
        return $this->findAll($params);
    }
    
    /**
     * Filter by state
     */
    public function findByState($stateId, $params = [])
    {
        $params['stateId'] = $stateId;
        return $this->findAll($params);
    }
    
    /**
     * Get active records (state_id = 1)
     */
    public function findActive($params = [])
    {
        return $this->findByState(1, $params);
    }
    
    /**
     * Validate data before sending to API
     */
    protected function validate($data, $rules = [])
    {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? null;
            
            if (strpos($rule, 'required') !== false && empty($value)) {
                $errors[$field] = "The {$field} field is required";
                continue;
            }
            
            if (strpos($rule, 'email') !== false && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "The {$field} field must be a valid email address";
            }
            
            if (preg_match('/min:(\d+)/', $rule, $matches)) {
                $min = (int)$matches[1];
                if (strlen($value) < $min) {
                    $errors[$field] = "The {$field} field must be at least {$min} characters";
                }
            }
            
            if (preg_match('/max:(\d+)/', $rule, $matches)) {
                $max = (int)$matches[1];
                if (strlen($value) > $max) {
                    $errors[$field] = "The {$field} field may not be greater than {$max} characters";
                }
            }
        }
        
        return $errors;
    }
}