import { useMutation } from '@tanstack/react-query';
import { useNavigate } from 'react-router-dom';
import { apiClient } from '../services/api';
import type { LoginCredentials, AuthResponse } from '../types';
import { useAuthStore } from '../stores/authStore';

/**
 * Custom hooks for Authentication operations
 * 
 * Using TanStack Query mutations for auth flow
 * and Zustand for state management
 * 
 * Hook to handle login (request OTP)
 */
export function useLogin() {
  const navigate = useNavigate();

  return useMutation({
    mutationFn: async (credentials: LoginCredentials) => {
      const response: any = await apiClient.post(
        '/auth/login/backoffice/request-otp',
        credentials
      );

      console.log('Login API Response:', response); // Debug log

      // Backend returns: {token: null, message: "OTP sent...", requiresOtp: true}
      // Check for requiresOtp instead of success
      const isSuccess = response.success || response.requiresOtp;

      if (!isSuccess) {
        throw new Error(response.message || 'Falha na autenticação');
      }

      // Store temp login data in auth store
      useAuthStore.setState({
        tempLogin: {
          emailOrContact: credentials.emailOrContact,
          timestamp: Date.now(),
        },
      });

      return {
        success: true,
        message: response.message || response.data?.message || 'OTP enviado com sucesso',
        requiresOtp: true,
      };
    },
    onSuccess: (data) => {
      console.log('Login mutation success, message:', data.message);
      // Clear any errors from store
      useAuthStore.setState({ error: null });

      setTimeout(() => {
        navigate('/otp', { state: { fromLogin: true } });
      }, 1500);
    },
    onError: (error: Error) => {
      console.error('Login mutation error:', error);
      useAuthStore.setState({ error: error.message });
    }
  });
}

/**
 * Hook to handle OTP verification
 */
export function useVerifyOtp() {
  const navigate = useNavigate();
  const tempLogin = useAuthStore((state) => state.tempLogin);

  return useMutation({
    mutationFn: async (otpCode: string) => {
      if (!tempLogin) {
        throw new Error('Nenhuma autenticação pendente encontrada');
      }

      // Check if OTP request has expired (5 minutes)
      if (Date.now() - tempLogin.timestamp > 5 * 60 * 1000) {
        useAuthStore.setState({ tempLogin: null });
        throw new Error('Código OTP expirado. Tente novamente.');
      }

      const response: any = await apiClient.post(
        '/auth/login/backoffice/verify-otp',
        {
          contact: tempLogin.emailOrContact,
          otpCode,
        }
      );

      console.log('Verify OTP API Response:', response); // Debug log

      // Backend returns: {token: "...", message: "...", requiresOtp: false}
      // Success is indicated by having a token and requiresOtp: false
      const token = response.token || response.data?.token;
      const isSuccess = response.success || (token && response.requiresOtp === false);

      if (!isSuccess || !token) {
        throw new Error(response.message || 'Código OTP inválido');
      }

      // Set token in API client
      apiClient.setToken(token);

      let userInfo: any = {};

      // Fetch user profile data
      try {
        const profileResponse = await apiClient.get('/auth/profile');
        console.log('Profile API Response:', profileResponse); // Debug log

        if (profileResponse.success && profileResponse.data) {
          userInfo = {
            id: profileResponse.data.id,
            name: profileResponse.data.name,
            email: profileResponse.data.email,
            identify_id: profileResponse.data.identifyId || profileResponse.data.identify_id,
            img: profileResponse.data.img || profileResponse.data.image,
            allRoleIds: profileResponse.data.roleIds || profileResponse.data.role_ids || [],
            isBackOffice: true,
          };
        }
      } catch (profileError) {
        console.error('Failed to fetch profile:', profileError);
        // Continue with basic user info if profile fetch fails
      }

      // Update auth store
      useAuthStore.setState({
        user: userInfo,
        token,
        isAuthenticated: true,
        tempLogin: null,
        error: null,
      });

      return {
        success: true,
        message: response.message || 'Autenticação realizada com sucesso',
        data: { userInfo },
      };
    },
    onSuccess: () => {
      console.log('OTP verification success, navigating to dashboard');
      // Navigate to dashboard after successful authentication
      setTimeout(() => {
        navigate('/dashboard');
      }, 1500);
    },
    onError: (error: Error) => {
      console.error('OTP verification error:', error);
      useAuthStore.setState({ error: error.message });
    },
  });
}

/**
 * Hook to handle forgot password
 */
export function useForgotPassword() {
  const navigate = useNavigate();

  return useMutation({
    mutationFn: async (emailOrContact: string) => {
      const response = await apiClient.post<AuthResponse>('/auth/forgot-password', {
        emailOrContact,
      });

      if (!response.success) {
        throw new Error(response.message || 'Email/contacto não encontrado');
      }

      // Store temp forgot password data
      useAuthStore.setState({
        tempForgotPassword: {
          emailOrContact,
          timestamp: Date.now(),
        },
      });

      return {
        success: true,
        message: response.data?.message || 'Código de recuperação enviado com sucesso',
        requiresOtp: true,
      };
    },
    onSuccess: () => {
      setTimeout(() => {
        navigate('/reset-password');
      }, 1500);
    },
  });
}

/**
 * Hook to handle password reset
 */
export function useResetPassword() {
  const navigate = useNavigate();
  const tempForgotPassword = useAuthStore((state) => state.tempForgotPassword);

  return useMutation({
    mutationFn: async ({
      otpCode,
      newPassword,
      confirmPassword,
    }: {
      otpCode: string;
      newPassword: string;
      confirmPassword: string;
    }) => {
      if (!tempForgotPassword) {
        throw new Error('Nenhuma solicitação de recuperação de senha encontrada');
      }

      // Check if request has expired (15 minutes)
      if (Date.now() - tempForgotPassword.timestamp > 15 * 60 * 1000) {
        useAuthStore.setState({ tempForgotPassword: null });
        throw new Error('Código de recuperação expirado. Solicite um novo código.');
      }

      // Validate passwords
      if (newPassword !== confirmPassword) {
        throw new Error('As senhas não coincidem. Verifique e tente novamente.');
      }

      if (newPassword.length < 6) {
        throw new Error('A senha deve ter pelo menos 6 caracteres.');
      }

      const response = await apiClient.post<AuthResponse>('/auth/reset-password', {
        emailOrContact: tempForgotPassword.emailOrContact,
        otpCode,
        newPassword,
      });

      if (!response.success) {
        throw new Error(response.message || 'Código inválido ou senha não pôde ser alterada');
      }

      useAuthStore.setState({ tempForgotPassword: null });

      return {
        success: true,
        message: response.data?.message || 'Senha alterada com sucesso!',
      };
    },
    onSuccess: () => {
      setTimeout(() => {
        navigate('/login');
      }, 1500);
    },
  });
}

/**
 * Hook to handle logout
 */
export function useLogout() {
  const navigate = useNavigate();
  const logout = useAuthStore((state) => state.logout);

  return useMutation({
    mutationFn: async () => {
      // Clear token from API client
      apiClient.setToken(null);

      // Clear auth store
      logout();

      return { success: true };
    },
    onSuccess: () => {
      // Navigate to login page
      navigate('/login');
    },
  });
}
