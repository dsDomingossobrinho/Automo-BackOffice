<?php
namespace App\Core;

/**
 * API Client Class - Handles communication with Automo Backend API
 */
class ApiClient
{
    private $baseUrl;
    private $timeout;
    private $defaultHeaders;
    
    public function __construct()
    {
        $this->baseUrl = rtrim(API_BASE_URL, '/');
        $this->timeout = API_TIMEOUT;
        $this->defaultHeaders = [
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: AutomoBackOffice/1.0'
        ];
    }
    
    /**
     * Make GET request
     */
    public function get($endpoint, $params = [])
    {
        $url = $this->baseUrl . $endpoint;
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $this->makeRequest('GET', $url);
    }
    
    /**
     * Make POST request
     */
    public function post($endpoint, $data = [])
    {
        $url = $this->baseUrl . $endpoint;
        return $this->makeRequest('POST', $url, $data);
    }
    
    /**
     * Make PUT request
     */
    public function put($endpoint, $data = [])
    {
        $url = $this->baseUrl . $endpoint;
        return $this->makeRequest('PUT', $url, $data);
    }
    
    /**
     * Make DELETE request
     */
    public function delete($endpoint)
    {
        $url = $this->baseUrl . $endpoint;
        return $this->makeRequest('DELETE', $url);
    }
    
    /**
     * Make authenticated request
     */
    public function authenticatedRequest($method, $endpoint, $data = [])
    {
        $auth = new Auth();
        $token = $auth->getToken();
        
        if (!$token) {
            throw new \Exception('No authentication token available');
        }
        
        $headers = array_merge($this->defaultHeaders, [
            "Authorization: Bearer {$token}"
        ]);
        
        $url = $this->baseUrl . $endpoint;
        return $this->makeRequest($method, $url, $data, $headers);
    }
    
    /**
     * Make HTTP request using cURL
     */
    private function makeRequest($method, $url, $data = null, $customHeaders = null)
    {
        $ch = curl_init();
        
        // Basic cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $customHeaders ?: $this->defaultHeaders,
            CURLOPT_SSL_VERIFYPEER => false, // For development - enable in production
            CURLOPT_SSL_VERIFYHOST => false, // For development - enable in production
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3
        ]);
        
        // Add data for POST, PUT requests
        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            throw new \Exception("cURL Error: {$error}");
        }
        
        $decodedResponse = json_decode($response, true);
        
        // Log API requests in debug mode
        if (DEBUG_MODE) {
            error_log("API Request: {$method} {$url} - Response Code: {$httpCode}");
            if ($data) {
                error_log("API Request Data: " . json_encode($data));
            }
            error_log("API Response: " . $response);
        }
        
        // Handle different HTTP status codes with consistent return format
        if ($httpCode >= 200 && $httpCode < 300) {
            return [
                'success' => true,
                'data' => $decodedResponse,
                'http_code' => $httpCode
            ];
        }
        
        // Handle error cases
        $errorMessage = $decodedResponse['message'] ?? "Unknown error";
        
        switch ($httpCode) {
            case 400:
                $errorMessage = "Dados inválidos: " . $errorMessage;
                break;
            case 401:
                $errorMessage = "Autenticação necessária: " . $errorMessage;
                break;
            case 403:
                $errorMessage = "Acesso negado: " . $errorMessage;
                break;
            case 404:
                $errorMessage = "Endpoint não encontrado: {$url}";
                break;
            case 422:
                $errorMessage = "Erro de validação: " . $errorMessage;
                break;
            case 500:
                $errorMessage = "Erro no servidor: " . $errorMessage;
                break;
            default:
                $errorMessage = "HTTP Error {$httpCode}: " . $errorMessage;
                break;
        }
        
        error_log("API Error - URL: {$url}, HTTP: {$httpCode}, Response: {$response}");
        
        return [
            'success' => false,
            'message' => $errorMessage,
            'data' => $decodedResponse,
            'http_code' => $httpCode,
            'url' => $url
        ];
    }
    
    /**
     * Upload file to API
     */
    public function uploadFile($endpoint, $filePath, $fieldName = 'file', $additionalData = [])
    {
        $auth = new Auth();
        $token = $auth->getToken();
        
        if (!$token) {
            throw new \Exception('No authentication token available');
        }
        
        if (!file_exists($filePath)) {
            throw new \Exception('File not found: ' . $filePath);
        }
        
        $ch = curl_init();
        
        $postData = [
            $fieldName => new \CURLFile($filePath)
        ];
        
        // Add additional form data
        foreach ($additionalData as $key => $value) {
            $postData[$key] = $value;
        }
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->baseUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout * 2, // Double timeout for file uploads
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$token}",
                'Accept: application/json'
                // Don't set Content-Type for multipart uploads - let cURL set it
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            throw new \Exception("File upload failed: {$error}");
        }
        
        $decodedResponse = json_decode($response, true);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return $decodedResponse;
        }
        
        throw new \Exception("File upload failed with HTTP {$httpCode}: " . 
                           ($decodedResponse['message'] ?? 'Unknown error'));
    }
    
    /**
     * Health check - test API connectivity
     */
    public function healthCheck()
    {
        try {
            $response = $this->get('/actuator/health');
            return isset($response['status']) && $response['status'] === 'UP';
        } catch (\Exception $e) {
            return false;
        }
    }
}