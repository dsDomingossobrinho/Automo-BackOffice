import type { User } from './user';

// Authentication related types
export interface LoginCredentials {
  emailOrContact: string;
  password: string;
}

export interface OTPVerification {
  contact: string;
  otpCode: string;
}

export interface ForgotPasswordRequest {
  emailOrContact: string;
}

export interface ResetPasswordRequest {
  emailOrContact: string;
  otpCode: string;
  newPassword: string;
  confirmPassword: string;
}

export interface AuthResponse {
  success: boolean;
  message: string;
  requires_otp?: boolean;
  data?: {
    token?: string;
    userInfo?: User;
    message?: string;
  };
}

export interface AuthState {
  user: User | null;
  token: string | null;
  isAuthenticated: boolean;
  isLoading: boolean;
  error: string | null;
}

export interface TempLogin {
  emailOrContact: string;
  timestamp: number;
}
