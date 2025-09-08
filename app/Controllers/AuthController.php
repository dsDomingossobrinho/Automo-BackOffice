<?php
namespace App\Controllers;

use App\Core\Controller;

/**
 * Authentication Controller
 */
class AuthController extends Controller
{
    /**
     * Override parent constructor to skip auth check for auth routes
     */
    public function __construct()
    {
        parent::__construct();
        // Auth routes are public, so we need to override the auth check
    }
    
    /**
     * Check authentication - override parent method for auth controller
     */
    protected function checkAuth()
    {
        // Allow access to auth routes without authentication
        return true;
    }
    
    /**
     * Show login page
     */
    public function login()
    {
        // If already authenticated, redirect to dashboard
        if ($this->auth->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        // Use the modern login view (no layout needed as it's a complete page)
        $this->viewRaw('auth/login-modern');
    }
    
    /**
     * Handle login authentication
     */
    public function authenticate()
    {
        // Debug logging
        error_log("AUTH: authenticate() called");
        error_log("AUTH: POST data: " . print_r($_POST, true));
        error_log("AUTH: Session before: " . print_r($_SESSION, true));
        
        try {
            $data = $this->getRequestData();
            error_log("AUTH: Request data: " . print_r($data, true));
            
            // Check if we have required data
            if (empty($data)) {
                error_log("AUTH: No data received");
                $this->setFlash('errors', ['No login data received']);
                $this->redirect('/login');
                return;
            }
            
            // Validate CSRF token
            $token = $data['_token'] ?? '';
            $sessionToken = $_SESSION[CSRF_TOKEN_NAME] ?? '';
            
            error_log("AUTH: Token validation - Received: $token, Session: $sessionToken");
            
            if (!$this->validateCsrfToken($token)) {
                error_log("AUTH: CSRF token validation failed");
                $this->setFlash('errors', ['Token de segurança inválido. Tente novamente.']);
                $this->redirect('/login');
                return;
            }
            
            // Validate input
            $errors = $this->validateLoginData($data);
            if (!empty($errors)) {
                error_log("AUTH: Validation errors: " . print_r($errors, true));
                $this->setFlash('errors', $errors);
                flashInput();
                $this->redirect('/login');
                return;
            }
            
            error_log("AUTH: Attempting authentication for: " . $data['email']);
            
            // Step 1: Call BackOfficeRequestOTP endpoint
            error_log("AUTH: Calling BackOfficeRequestOTP for: " . $data['email']);
            
            $result = $this->auth->authenticate($data['email'], $data['password']);
            error_log("AUTH: BackOfficeRequestOTP result: " . print_r($result, true));
            
            if ($result['success'] && $result['requires_otp']) {
                // OTP request successful - redirect to OTP page (Step 2)
                clearInput();
                $this->setFlash('success', $result['message']);
                $this->redirect('/otp');
            } else {
                // BackOfficeRequestOTP failed - show error and allow retry
                $this->setFlash('errors', [$result['message']]);
                flashInput();
                $this->redirect('/login');
            }
        } catch (\Exception $e) {
            error_log("AUTH: Exception: " . $e->getMessage());
            error_log("AUTH: Stack trace: " . $e->getTraceAsString());
            $this->setFlash('errors', ['Erro no sistema de autenticação: ' . $e->getMessage()]);
            flashInput();
            $this->redirect('/login');
        }
    }
    
    /**
     * Show OTP verification page
     */
    public function otp()
    {
        // Debug session information
        error_log("OTP: Session ID: " . session_id());
        error_log("OTP: Session data: " . print_r($_SESSION, true));
        error_log("OTP: temp_login exists: " . (isset($_SESSION['temp_login']) ? 'YES' : 'NO'));
        
        // Check if there's a pending OTP verification
        if (!isset($_SESSION['temp_login'])) {
            error_log("OTP: No temp_login found, redirecting to login");
            $this->setFlash('errors', ['Nenhuma autenticação pendente encontrada']);
            $this->redirect('/login');
        }
        
        // Get the email from temp login data
        $email = $_SESSION['temp_login']['emailOrContact'] ?? 'Não disponível';
        error_log("OTP: Showing OTP page for email: " . $email);
        
        // Use the clean OTP view without layout to prevent showing dashboard
        $this->viewRaw('auth/otp-clean', ['email' => $email]);
    }
    
    /**
     * Handle OTP verification
     */
    public function verifyOtp()
    {
        error_log("OTP: verifyOtp() called");
        error_log("OTP: POST data: " . print_r($_POST, true));
        
        try {
            $data = $this->getRequestData();
            error_log("OTP: Request data: " . print_r($data, true));
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($data['_token'] ?? '')) {
                error_log("OTP: CSRF token validation failed");
                $this->setFlash('errors', ['Token de segurança inválido']);
                $this->redirect('/otp');
                return;
            }
            
            // Validate OTP code
            if (empty($data['otp_code']) || !is_numeric($data['otp_code']) || strlen($data['otp_code']) !== 6) {
                error_log("OTP: Invalid OTP code format");
                $this->setFlash('errors', ['Digite um código OTP válido de 6 dígitos']);
                $this->redirect('/otp');
                return;
            }
            
            error_log("OTP: Calling VerifyOTP for code: " . $data['otp_code']);
            
            // Step 2: Call VerifyOTP endpoint
            $result = $this->auth->verifyOtp($data['otp_code']);
            error_log("OTP: VerifyOTP result: " . print_r($result, true));
            
            if ($result['success']) {
                // VerifyOTP successful - redirect to Dashboard (Step 3)
                clearInput();
                $this->setFlash('success', 'Login realizado com sucesso! Bem-vindo ao Automo BackOffice.');
                $this->redirect('/dashboard');
            } else {
                // VerifyOTP failed - show error and allow retry
                $this->setFlash('errors', [$result['message']]);
                
                // If OTP expired or no pending login, redirect to login (go back to Step 1)
                if (strpos($result['message'], 'expirado') !== false || 
                    strpos($result['message'], 'Nenhuma autenticação') !== false) {
                    $this->redirect('/login');
                } else {
                    // Stay on OTP page to allow retry
                    $this->redirect('/otp');
                }
            }
        } catch (\Exception $e) {
            error_log("OTP: Exception: " . $e->getMessage());
            $this->setFlash('errors', ['Erro na verificação OTP: ' . $e->getMessage()]);
            $this->redirect('/otp');
        }
    }
    
    /**
     * Handle logout
     */
    public function logout()
    {
        $this->auth->logout();
        $this->setFlash('success', 'You have been logged out successfully');
        $this->redirect('/login');
    }
    
    /**
     * Validate login form data
     */
    private function validateLoginData($data)
    {
        $errors = [];
        
        if (empty($data['email'])) {
            $errors[] = 'Email or contact is required';
        }
        
        if (empty($data['password'])) {
            $errors[] = 'Password is required';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }
        
        return $errors;
    }
}