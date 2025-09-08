<?php
namespace App\Controllers;

use App\Core\Controller;

/**
 * Resend OTP Controller
 */
class ResendOtpController extends Controller
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
        // Allow access to resend OTP without authentication
        return true;
    }
    
    /**
     * Handle resend OTP request
     */
    public function resend()
    {
        error_log("RESEND: resendOtp() called");
        error_log("RESEND: POST data: " . print_r($_POST, true));
        
        try {
            $data = $this->getRequestData();
            error_log("RESEND: Request data: " . print_r($data, true));
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($data['_token'] ?? '')) {
                error_log("RESEND: CSRF token validation failed");
                $this->setFlash('errors', ['Token de segurança inválido']);
                $this->redirect('/otp');
                return;
            }
            
            // Check if there's pending authentication
            if (!isset($_SESSION['temp_login'])) {
                error_log("RESEND: No pending authentication found");
                $this->setFlash('errors', ['Nenhuma autenticação pendente encontrada. Faça login novamente.']);
                $this->redirect('/login');
                return;
            }
            
            $tempLogin = $_SESSION['temp_login'];
            error_log("RESEND: Temp login data: " . print_r($tempLogin, true));
            
            // We need the password to call BackOfficeRequestOTP again
            // Since we don't store the password for security reasons,
            // we'll need to redirect to login or ask for password again
            if (!isset($data['password']) || empty($data['password'])) {
                $this->setFlash('errors', ['Para reenviar o código, é necessário confirmar a senha.']);
                $this->redirect('/login');
                return;
            }
            
            error_log("RESEND: Calling BackOfficeRequestOTP again");
            
            // Call BackOfficeRequestOTP endpoint again
            $result = $this->auth->requestOtp($tempLogin['emailOrContact'], $data['password']);
            error_log("RESEND: BackOfficeRequestOTP result: " . print_r($result, true));
            
            if ($result['success']) {
                // Update timestamp for new OTP request
                $_SESSION['temp_login']['timestamp'] = time();
                
                $this->setFlash('success', $result['message']);
                $this->redirect('/otp');
            } else {
                // Resend failed - show error and allow retry
                $this->setFlash('errors', [$result['message']]);
                $this->redirect('/otp');
            }
            
        } catch (\Exception $e) {
            error_log("RESEND: Exception: " . $e->getMessage());
            $this->setFlash('errors', ['Erro ao reenviar código OTP: ' . $e->getMessage()]);
            $this->redirect('/otp');
        }
    }
    
    /**
     * Simple resend using backend API endpoint
     */
    public function simpleResend()
    {
        error_log("RESEND: simpleResend() called - using backend /auth/login/backoffice/resend-otp");
        
        try {
            // Check if there's pending authentication
            if (!isset($_SESSION['temp_login'])) {
                error_log("RESEND: No pending authentication found");
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Nenhuma autenticação pendente encontrada. Faça login novamente.'
                ]);
                return;
            }
            
            $tempLogin = $_SESSION['temp_login'];
            error_log("RESEND: Temp login data: " . print_r($tempLogin, true));
            
            // Call the backend resend OTP endpoint
            $response = $this->apiClient->post('/auth/login/backoffice/resend-otp', [
                'emailOrContact' => $tempLogin['emailOrContact']
            ]);
            
            error_log("RESEND: Backend resend OTP response: " . print_r($response, true));
            
            if ($response['success']) {
                // Update timestamp for new OTP request
                $_SESSION['temp_login']['timestamp'] = time();
                
                $this->jsonResponse([
                    'success' => true,
                    'message' => $response['message'] ?? 'Código OTP reenviado com sucesso!'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => $response['message'] ?? 'Erro ao reenviar código OTP'
                ]);
            }
            
        } catch (\Exception $e) {
            error_log("RESEND: Exception: " . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Erro ao reenviar código OTP: ' . $e->getMessage()
            ]);
        }
    }
}