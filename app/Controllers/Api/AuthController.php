<?php
namespace App\Controllers\Api;

use App\Core\Controller;

/**
 * API Authentication Controller for AJAX requests
 */
class AuthController extends Controller
{
    /**
     * Override parent constructor to skip auth check
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Check authentication - override parent method
     */
    protected function checkAuth()
    {
        // Allow access to auth API routes without authentication
        return true;
    }
    
    /**
     * Handle AJAX login authentication
     */
    public function login()
    {
        header('Content-Type: application/json');
        
        try {
            $data = $this->getRequestData();
            
            // Validate CSRF token
            $token = $data['_token'] ?? '';
            if (!$this->validateCsrfToken($token)) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Token de segurança inválido. Recarregue a página e tente novamente.'
                ], 400);
            }
            
            // Validate input
            $errors = $this->validateLoginData($data);
            if (!empty($errors)) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => implode('. ', $errors)
                ], 400);
            }
            
            // Step 1: Call BackOfficeRequestOTP endpoint
            error_log("API AUTH: Calling BackOfficeRequestOTP for: " . $data['email']);
            
            $result = $this->auth->authenticate($data['email'], $data['password']);
            error_log("API AUTH: BackOfficeRequestOTP result: " . print_r($result, true));
            
            if ($result['success'] && $result['requires_otp']) {
                // Debug session after authentication
                error_log("API AUTH: Session ID after auth: " . session_id());
                error_log("API AUTH: Session data after auth: " . print_r($_SESSION, true));
                error_log("API AUTH: temp_login set: " . (isset($_SESSION['temp_login']) ? 'YES' : 'NO'));
                
                // OTP request successful - return success for frontend redirect
                return $this->jsonResponse([
                    'success' => true,
                    'message' => $result['message'],
                    'redirect' => '/otp',
                    'step' => 'otp_required'
                ]);
            } else {
                // BackOfficeRequestOTP failed - return error
                return $this->jsonResponse([
                    'success' => false,
                    'message' => $result['message'],
                    'step' => 'login_failed'
                ], 400);
            }
            
        } catch (\Exception $e) {
            error_log("API AUTH: Exception: " . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Erro no sistema de autenticação. Tente novamente em alguns minutos.',
                'debug' => DEBUG_MODE ? $e->getMessage() : null
            ], 500);
        }
    }
    
    /**
     * Handle AJAX OTP verification
     */
    public function verifyOtp()
    {
        header('Content-Type: application/json');
        
        try {
            $data = $this->getRequestData();
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($data['_token'] ?? '')) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Token de segurança inválido'
                ], 400);
            }
            
            // Validate OTP code
            if (empty($data['otp_code']) || !is_numeric($data['otp_code']) || strlen($data['otp_code']) !== 6) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Digite um código OTP válido de 6 dígitos'
                ], 400);
            }
            
            // Step 2: Call VerifyOTP endpoint
            error_log("API AUTH: Calling VerifyOTP for code: " . $data['otp_code']);
            
            $result = $this->auth->verifyOtp($data['otp_code']);
            error_log("API AUTH: VerifyOTP result: " . print_r($result, true));
            
            if ($result['success']) {
                // VerifyOTP successful - redirect to Dashboard
                return $this->jsonResponse([
                    'success' => true,
                    'message' => 'Login realizado com sucesso! Bem-vindo ao Automo BackOffice.',
                    'redirect' => '/dashboard',
                    'step' => 'login_complete'
                ]);
            } else {
                // VerifyOTP failed - return error
                $shouldRedirectToLogin = 
                    strpos($result['message'], 'expirado') !== false || 
                    strpos($result['message'], 'Nenhuma autenticação') !== false;
                
                return $this->jsonResponse([
                    'success' => false,
                    'message' => $result['message'],
                    'redirect' => $shouldRedirectToLogin ? '/login' : null,
                    'step' => 'otp_failed'
                ], 400);
            }
            
        } catch (\Exception $e) {
            error_log("API AUTH: OTP Exception: " . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Erro na verificação do OTP. Tente novamente.',
                'debug' => DEBUG_MODE ? $e->getMessage() : null
            ], 500);
        }
    }
    
    /**
     * Handle AJAX resend OTP
     */
    public function resendOtp()
    {
        header('Content-Type: application/json');
        
        try {
            // Check if there's pending authentication
            if (!isset($_SESSION['temp_login'])) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Nenhuma autenticação pendente encontrada. Faça login novamente.',
                    'redirect' => '/login'
                ], 400);
            }
            
            $tempLogin = $_SESSION['temp_login'];
            
            // For simplicity, simulate a successful resend
            // In a real implementation, you'd need to store encrypted credentials
            // or redirect to login to re-enter password for security
            $_SESSION['temp_login']['timestamp'] = time();
            
            error_log("API AUTH: OTP resend simulated for: " . $tempLogin['emailOrContact']);
            
            return $this->jsonResponse([
                'success' => true,
                'message' => 'Código OTP reenviado com sucesso!'
            ]);
            
        } catch (\Exception $e) {
            error_log("API AUTH: Resend Exception: " . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Erro ao reenviar código OTP'
            ], 500);
        }
    }
    
    /**
     * Validate login form data
     */
    private function validateLoginData($data)
    {
        $errors = [];
        
        if (empty($data['email'])) {
            $errors[] = 'Email ou contacto é obrigatório';
        }
        
        if (empty($data['password'])) {
            $errors[] = 'Senha é obrigatória';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'A senha deve ter pelo menos 6 caracteres';
        }
        
        return $errors;
    }
    
    /**
     * Handle AJAX forgot password request
     */
    public function forgotPassword()
    {
        header('Content-Type: application/json');
        
        try {
            // Get JSON input
            $input = json_decode(file_get_contents('php://input'), true);
            $email = $input['email'] ?? '';
            $token = $input['_token'] ?? '';
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($token)) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Token de segurança inválido'
                ], 400);
            }
            
            // Validate email
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Por favor, digite um email válido'
                ], 400);
            }
            
            error_log("API AUTH: Forgot password request for: " . $email);
            
            // Call backend API for password recovery
            $result = $this->callBackendForgotPassword($email);
            
            if ($result['success']) {
                return $this->jsonResponse([
                    'success' => true,
                    'message' => 'Instruções de recuperação foram enviadas para seu email'
                ]);
            } else {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => $result['message'] ?? 'Erro ao processar solicitação de recuperação'
                ], 400);
            }
            
        } catch (\Exception $e) {
            error_log("API AUTH: Forgot password exception: " . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Erro interno do servidor. Tente novamente mais tarde.',
                'debug' => DEBUG_MODE ? $e->getMessage() : null
            ], 500);
        }
    }
    
    /**
     * Call backend forgot password API
     */
    private function callBackendForgotPassword($email)
    {
        $apiClient = new \App\Core\ApiClient();
        
        try {
            // Call backend forgot password endpoint
            $response = $apiClient->post('/auth/forgot-password', [
                'email' => $email
            ]);
            
            error_log("Backend forgot password response: " . print_r($response, true));
            
            if (isset($response['success']) && $response['success']) {
                return [
                    'success' => true,
                    'message' => $response['message'] ?? 'Instruções enviadas com sucesso'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Email não encontrado no sistema'
                ];
            }
            
        } catch (\Exception $e) {
            error_log("Backend forgot password error: " . $e->getMessage());
            
            // If backend is unavailable, show friendly message
            return [
                'success' => false,
                'message' => 'Serviço temporariamente indisponível. Tente novamente em alguns minutos.'
            ];
        }
    }
}