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
     * Handle OTP verification (traditional form submission)
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
     * Show forgot password page
     */
    public function forgotPassword()
    {
        // If already authenticated, redirect to dashboard
        if ($this->auth->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        $this->viewRaw('auth/forgot-password');
    }
    
    /**
     * Handle forgot password request
     */
    public function processForgotPassword()
    {
        error_log("FORGOT_PASSWORD: processForgotPassword() called");
        error_log("FORGOT_PASSWORD: POST data: " . print_r($_POST, true));
        
        // Clear any existing temp login sessions to avoid conflicts
        if (isset($_SESSION['temp_login'])) {
            error_log("FORGOT_PASSWORD: Clearing existing temp_login session to avoid conflicts");
            unset($_SESSION['temp_login']);
        }
        
        try {
            $data = $this->getRequestData();
            error_log("FORGOT_PASSWORD: Request data: " . print_r($data, true));
            
            // Check if we have required data
            if (empty($data)) {
                error_log("FORGOT_PASSWORD: No data received");
                $this->setFlash('errors', ['Nenhum dado recebido']);
                $this->redirect('/forgot-password');
                return;
            }
            
            // Validate CSRF token
            $token = $data['_token'] ?? '';
            $sessionToken = $_SESSION[CSRF_TOKEN_NAME] ?? '';
            
            error_log("FORGOT_PASSWORD: Token validation - Received: $token, Session: $sessionToken");
            
            if (!$this->validateCsrfToken($token)) {
                error_log("FORGOT_PASSWORD: CSRF token validation failed");
                $this->setFlash('errors', ['Token de segurança inválido. Tente novamente.']);
                $this->redirect('/forgot-password');
                return;
            }
            
            // Validate input
            $errors = $this->validateForgotPasswordData($data);
            if (!empty($errors)) {
                error_log("FORGOT_PASSWORD: Validation errors: " . print_r($errors, true));
                $this->setFlash('errors', $errors);
                flashInput();
                $this->redirect('/forgot-password');
                return;
            }
            
            error_log("FORGOT_PASSWORD: Attempting forgot password for: " . $data['emailOrContact']);
            
            // Call forgot password API
            $result = $this->auth->forgotPassword($data['emailOrContact']);
            error_log("FORGOT_PASSWORD: Result: " . print_r($result, true));
            
            if ($result['success'] && $result['requires_otp']) {
                // Forgot password request successful - redirect to reset password page
                clearInput();
                $this->setFlash('success', $result['message']);
                $this->redirect('/reset-password');
            } else {
                // Forgot password request failed - show error and allow retry
                $this->setFlash('errors', [$result['message']]);
                flashInput();
                $this->redirect('/forgot-password');
            }
        } catch (\Exception $e) {
            error_log("FORGOT_PASSWORD: Exception: " . $e->getMessage());
            error_log("FORGOT_PASSWORD: Stack trace: " . $e->getTraceAsString());
            $this->setFlash('errors', ['Erro no sistema de recuperação de senha: ' . $e->getMessage()]);
            flashInput();
            $this->redirect('/forgot-password');
        }
    }
    
    /**
     * Show reset password page
     */
    public function resetPassword()
    {
        // Check if there's a pending forgot password request
        if (!isset($_SESSION['temp_forgot_password'])) {
            error_log("RESET_PASSWORD: No temp_forgot_password found, redirecting to forgot-password");
            $this->setFlash('errors', ['Nenhuma solicitação de recuperação de senha encontrada']);
            $this->redirect('/forgot-password');
        }
        
        // Get the email from temp forgot password data
        $email = $_SESSION['temp_forgot_password']['emailOrContact'] ?? 'Não disponível';
        error_log("RESET_PASSWORD: Showing reset password page for email: " . $email);
        
        $this->viewRaw('auth/reset-password', ['email' => $email]);
    }
    
    /**
     * Handle password reset
     */
    public function processResetPassword()
    {
        error_log("RESET_PASSWORD: processResetPassword() called");
        error_log("RESET_PASSWORD: POST data: " . print_r($_POST, true));
        
        try {
            $data = $this->getRequestData();
            error_log("RESET_PASSWORD: Request data: " . print_r($data, true));
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($data['_token'] ?? '')) {
                error_log("RESET_PASSWORD: CSRF token validation failed");
                $this->setFlash('errors', ['Token de segurança inválido']);
                $this->redirect('/reset-password');
                return;
            }
            
            // Validate input data
            $errors = $this->validateResetPasswordData($data);
            if (!empty($errors)) {
                error_log("RESET_PASSWORD: Validation errors: " . print_r($errors, true));
                $this->setFlash('errors', $errors);
                $this->redirect('/reset-password');
                return;
            }
            
            error_log("RESET_PASSWORD: Calling resetPassword for OTP: " . $data['otpCode']);
            
            // Call reset password API
            $result = $this->auth->resetPassword(
                $data['otpCode'], 
                $data['newPassword'], 
                $data['confirmPassword']
            );
            error_log("RESET_PASSWORD: Result: " . print_r($result, true));
            
            if ($result['success']) {
                // Password reset successful - clear all temp sessions and redirect to login
                unset($_SESSION['temp_forgot_password']);
                unset($_SESSION['temp_login']); // Clear any login OTP sessions too
                clearInput();
                $this->setFlash('success', $result['message']);
                $this->redirect('/login');
            } else {
                // Password reset failed - show error and allow retry
                $this->setFlash('errors', [$result['message']]);
                
                // If OTP expired or invalid, redirect to forgot password to restart the process
                if (strpos($result['message'], 'expirado') !== false || 
                    strpos($result['message'], 'inválido') !== false ||
                    strpos($result['message'], 'INVALID_CREDENTIALS') !== false ||
                    strpos($result['message'], 'Nenhuma solicitação') !== false) {
                    // Clear the temp forgot password session to restart the process
                    unset($_SESSION['temp_forgot_password']);
                    $this->redirect('/forgot-password');
                } else {
                    // Stay on reset password page to allow retry
                    $this->redirect('/reset-password');
                }
            }
        } catch (\Exception $e) {
            error_log("RESET_PASSWORD: Exception: " . $e->getMessage());
            $this->setFlash('errors', ['Erro na alteração da senha: ' . $e->getMessage()]);
            $this->redirect('/reset-password');
        }
    }
    
    /**
     * Handle resend forgot password OTP
     */
    public function resendForgotPasswordOtp()
    {
        error_log("RESEND_FORGOT_OTP: resendForgotPasswordOtp() called");
        
        try {
            // Handle both form data and JSON data
            $data = $_POST;
            if (empty($data)) {
                // Try to get JSON data
                $input = file_get_contents('php://input');
                $jsonData = json_decode($input, true);
                if ($jsonData) {
                    $data = $jsonData;
                }
            }
            
            error_log("RESEND_FORGOT_OTP: Request data: " . print_r($data, true));
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($data['_token'] ?? '')) {
                error_log("RESEND_FORGOT_OTP: CSRF token validation failed");
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Token de segurança inválido'
                ]);
                return;
            }
            
            error_log("RESEND_FORGOT_OTP: Calling resendForgotPasswordOtp");
            
            // Call resend forgot password OTP
            $result = $this->auth->resendForgotPasswordOtp();
            error_log("RESEND_FORGOT_OTP: Result: " . print_r($result, true));
            
            // Return JSON response for AJAX request
            header('Content-Type: application/json');
            echo json_encode($result);
        } catch (\Exception $e) {
            error_log("RESEND_FORGOT_OTP: Exception: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao reenviar código: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Validate forgot password form data
     */
    private function validateForgotPasswordData($data)
    {
        $errors = [];
        
        if (empty($data['emailOrContact'])) {
            $errors[] = 'Email ou contacto é obrigatório';
        }
        
        return $errors;
    }
    
    /**
     * Validate reset password form data
     */
    private function validateResetPasswordData($data)
    {
        $errors = [];
        
        if (empty($data['otpCode'])) {
            $errors[] = 'Código OTP é obrigatório';
        } elseif (!is_numeric($data['otpCode']) || strlen($data['otpCode']) !== 6) {
            $errors[] = 'Digite um código OTP válido de 6 dígitos';
        }
        
        if (empty($data['newPassword'])) {
            $errors[] = 'Nova senha é obrigatória';
        } elseif (strlen($data['newPassword']) < 6) {
            $errors[] = 'A nova senha deve ter pelo menos 6 caracteres';
        }
        
        if (empty($data['confirmPassword'])) {
            $errors[] = 'Confirmação da senha é obrigatória';
        } elseif ($data['newPassword'] !== $data['confirmPassword']) {
            $errors[] = 'As senhas não coincidem';
        }
        
        return $errors;
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
    
    /**
     * AJAX OTP verification for login
     */
    public function verifyOtpAjax()
    {
        header('Content-Type: application/json');
        
        try {
            // Handle both form data and JSON data
            $data = $_POST;
            if (empty($data)) {
                $input = file_get_contents('php://input');
                $jsonData = json_decode($input, true);
                if ($jsonData) {
                    $data = $jsonData;
                }
            }
            
            error_log("OTP_AJAX: verifyOtpAjax() called with data: " . print_r($data, true));
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($data['_token'] ?? '')) {
                error_log("OTP_AJAX: CSRF token validation failed");
                echo json_encode([
                    'success' => false,
                    'message' => 'Token de segurança inválido'
                ]);
                return;
            }
            
            // Validate OTP code
            if (empty($data['otp_code']) || !is_numeric($data['otp_code']) || strlen($data['otp_code']) !== 6) {
                error_log("OTP_AJAX: Invalid OTP code format");
                echo json_encode([
                    'success' => false,
                    'message' => 'Digite um código OTP válido de 6 dígitos'
                ]);
                return;
            }
            
            error_log("OTP_AJAX: Calling VerifyOTP for code: " . $data['otp_code']);
            
            // Call VerifyOTP endpoint
            $result = $this->auth->verifyOtp($data['otp_code']);
            error_log("OTP_AJAX: VerifyOTP result: " . print_r($result, true));
            
            if ($result['success']) {
                // Success - return redirect URL
                echo json_encode([
                    'success' => true,
                    'message' => 'Login realizado com sucesso!',
                    'redirect' => '/dashboard'
                ]);
            } else {
                // Error - return error message
                echo json_encode([
                    'success' => false,
                    'message' => $result['message']
                ]);
            }
        } catch (\Exception $e) {
            error_log("OTP_AJAX: Exception: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Erro na verificação OTP: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * AJAX password reset for recovery
     */
    public function resetPasswordAjax()
    {
        header('Content-Type: application/json');
        
        try {
            // Handle both form data and JSON data
            $data = $_POST;
            if (empty($data)) {
                $input = file_get_contents('php://input');
                $jsonData = json_decode($input, true);
                if ($jsonData) {
                    $data = $jsonData;
                }
            }
            
            error_log("RESET_AJAX: resetPasswordAjax() called with data: " . print_r($data, true));
            
            // Validate CSRF token
            if (!$this->validateCsrfToken($data['_token'] ?? '')) {
                error_log("RESET_AJAX: CSRF token validation failed");
                echo json_encode([
                    'success' => false,
                    'message' => 'Token de segurança inválido'
                ]);
                return;
            }
            
            // Validate input data
            $errors = $this->validateResetPasswordData($data);
            if (!empty($errors)) {
                error_log("RESET_AJAX: Validation errors: " . print_r($errors, true));
                echo json_encode([
                    'success' => false,
                    'message' => implode('. ', $errors)
                ]);
                return;
            }
            
            error_log("RESET_AJAX: Calling resetPassword for OTP: " . $data['otpCode']);
            
            // Call reset password API
            $result = $this->auth->resetPassword(
                $data['otpCode'], 
                $data['newPassword'], 
                $data['confirmPassword']
            );
            error_log("RESET_AJAX: Result: " . print_r($result, true));
            
            if ($result['success']) {
                // Password reset successful
                unset($_SESSION['temp_forgot_password']);
                unset($_SESSION['temp_login']);
                echo json_encode([
                    'success' => true,
                    'message' => $result['message'],
                    'redirect' => '/login'
                ]);
            } else {
                // Password reset failed
                echo json_encode([
                    'success' => false,
                    'message' => $result['message']
                ]);
            }
        } catch (\Exception $e) {
            error_log("RESET_AJAX: Exception: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Erro na alteração da senha: ' . $e->getMessage()
            ]);
        }
    }
}