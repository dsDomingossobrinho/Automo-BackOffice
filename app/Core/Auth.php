<?php
namespace App\Core;

/**
 * Authentication Class
 */
class Auth
{
    private $apiClient;
    
    public function __construct()
    {
        $this->apiClient = new ApiClient();
    }
    
    /**
     * Check if user is authenticated
     */
    public function isAuthenticated()
    {
        // Check if session exists and has required data
        $hasUser = isset($_SESSION['user']) && !empty($_SESSION['user']);
        $hasToken = isset($_SESSION['token']) && !empty($_SESSION['token']);
        
        if (DEBUG_MODE) {
            error_log("AUTH: isAuthenticated check - hasUser: " . ($hasUser ? 'YES' : 'NO') . ", hasToken: " . ($hasToken ? 'YES' : 'NO'));
            if (isset($_SESSION['user'])) {
                error_log("AUTH: Current user: " . print_r($_SESSION['user'], true));
            }
            error_log("AUTH: Session ID: " . session_id());
        }
        
        return $hasUser && $hasToken;
    }
    
    /**
     * Request OTP using BackOfficeRequestOTP endpoint
     */
    public function authenticate($emailOrContact, $password)
    {
        try {
            error_log("AUTH: Calling BackOfficeRequestOTP endpoint");
            error_log("AUTH: API Base URL: " . API_BASE_URL);
            
            $response = $this->apiClient->post('/auth/login/backoffice/request-otp', [
                'emailOrContact' => $emailOrContact,
                'password' => $password
            ]);
            
            error_log("AUTH: BackOfficeRequestOTP response: " . print_r($response, true));
            
            if ($response['success']) {
                // Store temporary login data for OTP verification
                $_SESSION['temp_login'] = [
                    'emailOrContact' => $emailOrContact,
                    'timestamp' => time()
                ];
                
                return [
                    'success' => true,
                    'message' => $response['data']['message'] ?? 'Código OTP enviado com sucesso. Verifique seu email/SMS.',
                    'requires_otp' => true
                ];
            }
            
            return [
                'success' => false,
                'message' => $response['message'] ?? 'Falha na autenticação. Verifique suas credenciais.'
            ];
        } catch (Exception $e) {
            error_log("AUTH: Exception in BackOfficeRequestOTP: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Serviço de autenticação temporariamente indisponível. Tente novamente.'
            ];
        }
    }
    
    /**
     * Verify OTP using VerifyOTP endpoint
     */
    public function verifyOtp($otpCode)
    {
        if (!isset($_SESSION['temp_login'])) {
            return [
                'success' => false,
                'message' => 'Nenhuma autenticação pendente encontrada'
            ];
        }
        
        $tempLogin = $_SESSION['temp_login'];
        
        // Check if OTP request has expired (5 minutes)
        if (time() - $tempLogin['timestamp'] > 300) {
            unset($_SESSION['temp_login']);
            return [
                'success' => false,
                'message' => 'Código OTP expirado. Tente novamente.'
            ];
        }
        
        try {
            error_log("AUTH: Calling VerifyOTP endpoint");
            error_log("AUTH: OTP Code: " . $otpCode);
            error_log("AUTH: Contact: " . $tempLogin['emailOrContact']);
            
            $response = $this->apiClient->post('/auth/login/backoffice/verify-otp', [
                'contact' => $tempLogin['emailOrContact'],
                'otpCode' => $otpCode
            ]);
            
            if (DEBUG_MODE) {
                error_log("AUTH: VerifyOTP response: " . print_r($response, true));
            }
            
            if ($response['success'] && isset($response['data']['token'])) {
                // Extract user info from JWT token or use what backend provides
                $userInfo = $response['data']['userInfo'] ?? null;
                
                // If no userInfo provided, create basic user data from JWT payload
                if (!$userInfo && isset($response['data']['token'])) {
                    $userInfo = $this->extractUserFromToken($response['data']['token']);
                }
                
                // Store token first
                $_SESSION['token'] = $response['data']['token'];
                
                // Fetch user profile data (NAME, IDENTIFY_ID, IMG)
                $profileData = $this->fetchUserProfile();
                
                // Merge basic user info with profile data
                if ($profileData['success']) {
                    $userInfo = array_merge($userInfo ?? [], $profileData['profile']);
                    if (DEBUG_MODE) {
                        error_log("AUTH: Profile data fetched successfully: " . print_r($profileData['profile'], true));
                    }
                } else {
                    if (DEBUG_MODE) {
                        error_log("AUTH: Failed to fetch profile data: " . $profileData['message']);
                    }
                }
                
                // Store complete user session
                $_SESSION['user'] = $userInfo;
                $_SESSION['login_time'] = time();
                
                // Clear temporary login data
                unset($_SESSION['temp_login']);
                
                if (DEBUG_MODE) {
                    error_log("AUTH: Login successful for user: " . print_r($userInfo, true));
                }
                
                return [
                    'success' => true,
                    'message' => 'Autenticação realizada com sucesso',
                    'user' => $userInfo
                ];
            }
            
            return [
                'success' => false,
                'message' => $response['message'] ?? 'Código OTP inválido'
            ];
        } catch (Exception $e) {
            error_log("AUTH: Exception in VerifyOTP: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Falha na verificação do OTP. Tente novamente.'
            ];
        }
    }
    
    /**
     * Request new OTP (for resend functionality)
     */
    public function requestOtp($emailOrContact, $password)
    {
        return $this->authenticate($emailOrContact, $password);
    }
    
    /**
     * Request password reset using forgot-password endpoint
     */
    public function forgotPassword($emailOrContact)
    {
        try {
            error_log("AUTH: Calling forgot-password endpoint");
            error_log("AUTH: API Base URL: " . API_BASE_URL);
            error_log("AUTH: Email/Contact: " . $emailOrContact);
            
            $response = $this->apiClient->post('/auth/forgot-password', [
                'emailOrContact' => $emailOrContact
            ]);
            
            error_log("AUTH: Forgot password response: " . print_r($response, true));
            
            if ($response['success']) {
                // Store temporary forgot password data for reset verification
                $_SESSION['temp_forgot_password'] = [
                    'emailOrContact' => $emailOrContact,
                    'timestamp' => time()
                ];
                
                return [
                    'success' => true,
                    'message' => $response['data']['message'] ?? 'Código de recuperação enviado com sucesso. Verifique seu email.',
                    'requires_otp' => true
                ];
            }
            
            return [
                'success' => false,
                'message' => $response['message'] ?? 'Email/contacto não encontrado. Verifique os dados informados.'
            ];
        } catch (Exception $e) {
            error_log("AUTH: Exception in forgot-password: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Serviço de recuperação de senha temporariamente indisponível. Tente novamente.'
            ];
        }
    }
    
    /**
     * Reset password using OTP verification
     */
    public function resetPassword($otpCode, $newPassword, $confirmPassword)
    {
        if (!isset($_SESSION['temp_forgot_password'])) {
            return [
                'success' => false,
                'message' => 'Nenhuma solicitação de recuperação de senha encontrada'
            ];
        }
        
        $tempForgot = $_SESSION['temp_forgot_password'];
        
        // Check if forgot password request has expired (15 minutes)
        if (time() - $tempForgot['timestamp'] > 900) {
            unset($_SESSION['temp_forgot_password']);
            return [
                'success' => false,
                'message' => 'Código de recuperação expirado. Solicite um novo código.'
            ];
        }
        
        // Validate passwords
        if ($newPassword !== $confirmPassword) {
            return [
                'success' => false,
                'message' => 'As senhas não coincidem. Verifique e tente novamente.'
            ];
        }
        
        if (strlen($newPassword) < 6) {
            return [
                'success' => false,
                'message' => 'A senha deve ter pelo menos 6 caracteres.'
            ];
        }
        
        try {
            error_log("AUTH: Calling reset-password endpoint");
            error_log("AUTH: Contact: " . $tempForgot['emailOrContact']);
            error_log("AUTH: OTP Code: " . $otpCode);
            
            $response = $this->apiClient->post('/auth/reset-password', [
                'emailOrContact' => $tempForgot['emailOrContact'],
                'otpCode' => $otpCode,
                'newPassword' => $newPassword
                // Note: confirmPassword is validated locally, backend only needs newPassword
            ]);
            
            if (DEBUG_MODE) {
                error_log("AUTH: Reset password response: " . print_r($response, true));
            }
            
            if ($response['success']) {
                // Clear temporary forgot password data
                unset($_SESSION['temp_forgot_password']);
                
                return [
                    'success' => true,
                    'message' => $response['data']['message'] ?? 'Senha alterada com sucesso! Você pode fazer login com sua nova senha.'
                ];
            }
            
            return [
                'success' => false,
                'message' => $response['message'] ?? 'Código inválido ou senha não pôde ser alterada'
            ];
        } catch (Exception $e) {
            error_log("AUTH: Exception in reset-password: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Falha na alteração da senha. Tente novamente.'
            ];
        }
    }
    
    /**
     * Resend forgot password OTP
     */
    public function resendForgotPasswordOtp()
    {
        if (!isset($_SESSION['temp_forgot_password'])) {
            return [
                'success' => false,
                'message' => 'Nenhuma solicitação de recuperação de senha encontrada'
            ];
        }
        
        $tempForgot = $_SESSION['temp_forgot_password'];
        
        // Use the same forgotPassword method to resend OTP
        return $this->forgotPassword($tempForgot['emailOrContact']);
    }
    
    /**
     * Get current authenticated user
     */
    public function getUser()
    {
        return $_SESSION['user'] ?? null;
    }
    
    /**
     * Get current JWT token
     */
    public function getToken()
    {
        return $_SESSION['token'] ?? null;
    }
    
    /**
     * Check if user has specific role
     */
    public function hasRole($roleId)
    {
        $user = $this->getUser();
        if (!$user || !isset($user['allRoleIds'])) {
            return false;
        }
        
        return in_array($roleId, $user['allRoleIds']);
    }
    
    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->hasRole(1); // Admin role ID is 1
    }
    
    /**
     * Check if user is back office
     */
    public function isBackOffice()
    {
        $user = $this->getUser();
        return $user && isset($user['isBackOffice']) && $user['isBackOffice'];
    }
    
    /**
     * Logout user
     */
    public function logout()
    {
        // Clear all session data
        $_SESSION = [];
        
        // Destroy session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        // Destroy session
        session_destroy();
        
        return true;
    }
    
    /**
     * Refresh token if needed
     */
    public function refreshTokenIfNeeded()
    {
        if (!$this->isAuthenticated()) {
            return false;
        }
        
        $loginTime = $_SESSION['login_time'] ?? 0;
        $tokenAge = time() - $loginTime;
        
        // Refresh if token is older than 3.5 hours (JWT expires in 4 hours)
        if ($tokenAge > 3.5 * 3600) {
            // For now, just logout and require re-authentication
            // In a real implementation, you might want to implement token refresh
            $this->logout();
            return false;
        }
        
        return true;
    }
    
    /**
     * Get user permissions
     */
    public function getPermissions()
    {
        $user = $this->getUser();
        if (!$user) {
            return [];
        }
        
        // Map roles to permissions
        $permissions = [];
        $roles = $user['allRoleIds'] ?? [];
        
        foreach ($roles as $roleId) {
            switch ($roleId) {
                case 1: // Admin - Full access to everything
                    $permissions = array_merge($permissions, [
                        // General permissions
                        'view_all', 'create_all', 'edit_all', 'delete_all',
                        
                        // Account management
                        'view_accounts', 'create_accounts', 'edit_accounts', 'delete_accounts',
                        'manage_users', 'manage_permissions',
                        
                        // Client management
                        'view_clients', 'create_clients', 'edit_clients', 'delete_clients',
                        
                        // Message management
                        'view_messages', 'create_messages', 'edit_messages', 'delete_messages',
                        'send_messages',
                        
                        // Financial management
                        'view_finances', 'create_finances', 'edit_finances', 'delete_finances',
                        
                        // Invoice management
                        'view_invoices', 'create_invoices', 'edit_invoices', 'delete_invoices',
                        
                        // Reports and analytics
                        'view_reports', 'view_analytics', 'export_data'
                    ]);
                    break;
                    
                case 2: // User - Basic access
                    $permissions = array_merge($permissions, [
                        'view_own', 'create_basic', 'edit_own',
                        'view_clients', 'view_messages'
                    ]);
                    break;
                    
                case 3: // Agent - Client and message focused
                    $permissions = array_merge($permissions, [
                        'view_clients', 'create_clients', 'edit_clients',
                        'view_messages', 'create_messages', 'send_messages',
                        'view_own', 'edit_own'
                    ]);
                    break;
                    
                case 4: // Manager - Team management and reports
                    $permissions = array_merge($permissions, [
                        'view_team', 'manage_team', 'view_reports',
                        'view_clients', 'view_messages', 'view_finances',
                        'view_accounts', 'view_analytics'
                    ]);
                    break;
            }
        }
        
        return array_unique($permissions);
    }
    
    /**
     * Check if user has permission
     */
    public function hasPermission($permission)
    {
        return in_array($permission, $this->getPermissions());
    }
    
    /**
     * Extract user information from JWT token
     */
    private function extractUserFromToken($token)
    {
        try {
            // Split JWT token into parts
            $parts = explode('.', $token);
            if (count($parts) !== 3) {
                return null;
            }
            
            // Decode payload (second part)
            $payload = json_decode(base64_decode($parts[1]), true);
            if (!$payload) {
                return null;
            }
            
            // Extract user information from JWT payload
            return [
                'id' => $payload['id'] ?? null,
                'email' => $payload['email'] ?? $payload['sub'] ?? null,
                'username' => $payload['username'] ?? null,
                'contact' => $payload['contact'] ?? null,
                'role_id' => $payload['role_id'] ?? null,
                'allRoleIds' => $payload['role_ids'] ?? [$payload['role_id'] ?? 2],
                'account_type_id' => $payload['account_type_id'] ?? null,
                'isBackOffice' => true // Since this is back office login
            ];
        } catch (Exception $e) {
            error_log("AUTH: Error extracting user from token: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Fetch user profile data after successful authentication
     */
    private function fetchUserProfile()
    {
        try {
            if (DEBUG_MODE) {
                error_log("AUTH: Fetching user profile from /auth/profile");
            }
            
            // Make authenticated request to get profile
            $response = $this->apiClient->authenticatedRequest('GET', '/auth/profile');
            
            if (DEBUG_MODE) {
                error_log("AUTH: Profile response: " . print_r($response, true));
            }
            
            if ($response['success'] && isset($response['data'])) {
                $profileData = $response['data'];
                
                // Extract the required fields: NAME, IDENTIFY_ID, IMG
                $profile = [
                    'name' => $profileData['name'] ?? null,
                    'identify_id' => $profileData['identifyId'] ?? $profileData['identify_id'] ?? null,
                    'img' => $profileData['img'] ?? $profileData['image'] ?? null,
                ];
                
                // Store in session for quick access
                $_SESSION['user_profile'] = $profile;
                
                if (DEBUG_MODE) {
                    error_log("AUTH: Profile data extracted: " . print_r($profile, true));
                }
                
                return [
                    'success' => true,
                    'profile' => $profile
                ];
            }
            
            return [
                'success' => false,
                'message' => $response['message'] ?? 'Falha ao buscar dados do perfil'
            ];
            
        } catch (Exception $e) {
            error_log("AUTH: Error fetching user profile: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao buscar dados do perfil: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Get user name from profile
     */
    public function getUserName()
    {
        $user = $this->getUser();
        return $user['name'] ?? null;
    }
    
    /**
     * Get user identify ID from profile
     */
    public function getUserIdentifyId()
    {
        $user = $this->getUser();
        return $user['identify_id'] ?? null;
    }
    
    /**
     * Get user image from profile
     */
    public function getUserImage()
    {
        $user = $this->getUser();
        return $user['img'] ?? null;
    }
}