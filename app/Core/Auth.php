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
        return isset($_SESSION['user']) && isset($_SESSION['token']);
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
            
            error_log("AUTH: VerifyOTP response: " . print_r($response, true));
            
            if ($response['success'] && isset($response['data']['token'])) {
                // Extract user info from JWT token or use what backend provides
                $userInfo = $response['data']['userInfo'] ?? null;
                
                // If no userInfo provided, create basic user data from JWT payload
                if (!$userInfo && isset($response['data']['token'])) {
                    $userInfo = $this->extractUserFromToken($response['data']['token']);
                }
                
                // Store user session
                $_SESSION['user'] = $userInfo;
                $_SESSION['token'] = $response['data']['token'];
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
                case 1: // Admin
                    $permissions = array_merge($permissions, [
                        'view_all', 'create_all', 'edit_all', 'delete_all',
                        'manage_users', 'manage_permissions', 'view_finances'
                    ]);
                    break;
                case 2: // User
                    $permissions = array_merge($permissions, [
                        'view_own', 'create_basic', 'edit_own'
                    ]);
                    break;
                case 3: // Agent
                    $permissions = array_merge($permissions, [
                        'view_clients', 'create_clients', 'edit_clients',
                        'view_messages', 'send_messages'
                    ]);
                    break;
                case 4: // Manager
                    $permissions = array_merge($permissions, [
                        'view_team', 'manage_team', 'view_reports'
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
}