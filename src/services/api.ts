import axios, { type AxiosInstance, type AxiosError } from 'axios';
import type { ApiResponse, ApiError } from '../types';

// Get environment variables
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8080';
const API_TIMEOUT = 30000; // 30 seconds

/**
 * API Client Class - Handles communication with Automo Backend API
 * Migrated from PHP app/Core/ApiClient.php
 */
class ApiClient {
  private readonly axiosInstance: AxiosInstance;
  private token: string | null = null;

  constructor() {
    this.axiosInstance = axios.create({
      baseURL: API_BASE_URL,
      timeout: API_TIMEOUT,
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'User-Agent': 'AutomoBackOffice/2.0-React',
      },
    });

    // Request interceptor - Add auth token
    this.axiosInstance.interceptors.request.use(
      (config) => {
        const token = this.getToken();
        if (token) {
          config.headers.Authorization = `Bearer ${token}`;
        }

        // Debug logging in development
        if (import.meta.env.DEV) {
          const method = config.method ? config.method.toUpperCase() : 'UNKNOWN';
          console.log(`[API] ${method} ${config.url}`, config.data);
        }

        return config;
      },
      (error) => {
        return Promise.reject(error);
      }
    );

    // Response interceptor - Handle errors globally
    this.axiosInstance.interceptors.response.use(
      (response) => {
        if (import.meta.env.DEV) {
          console.log(`[API] Response:`, response.data);
        }
        return response;
      },
      (error: AxiosError<ApiResponse>) => {
        return this.handleError(error);
      }
    );

    // Initialize token from localStorage
    this.loadTokenFromStorage();
  }

  /**
   * Load token from localStorage
   */
  private loadTokenFromStorage(): void {
    const token = localStorage.getItem('auth_token');
    if (token) {
      this.token = token;
    }
  }

  /**
   * Set authentication token
   */
  setToken(token: string | null): void {
    this.token = token;
    if (token) {
      localStorage.setItem('auth_token', token);
    } else {
      localStorage.removeItem('auth_token');
    }
  }

  /**
   * Get authentication token
   */
  getToken(): string | null {
    return this.token || localStorage.getItem('auth_token');
  }

  /**
   * Handle API errors
   */
  private handleError(error: AxiosError<ApiResponse>): Promise<ApiError> {
    const apiError: ApiError = {
      message: 'Ocorreu um erro inesperado',
      status: error.response?.status,
    };

    if (error.response) {
      // Server responded with error
      apiError.message = error.response.data?.message || error.message;
      apiError.errors = error.response.data?.errors;

      // Handle 401 - Unauthorized
      if (error.response.status === 401) {
        this.setToken(null);
        window.location.href = '/login';
      }
    } else if (error.request) {
      // Request made but no response
      apiError.message = 'Servidor não respondeu. Verifique sua conexão.';
    } else {
      // Error setting up request
      apiError.message = error.message;
    }

    if (import.meta.env.DEV) {
      console.error('[API] Error:', apiError);
    }

    return Promise.reject(apiError);
  }

  /**
   * Make GET request
   * Note: Some endpoints return data directly without ApiResponse wrapper
   */
  async get<T = any>(endpoint: string, params?: Record<string, any>): Promise<ApiResponse<T>> {
    try {
      const response = await this.axiosInstance.get(endpoint, { params });
      return response.data;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Make POST request
   * Note: Some endpoints return data directly without ApiResponse wrapper
   */
  async post<T = any>(endpoint: string, data?: any): Promise<ApiResponse<T>> {
    try {
      const response = await this.axiosInstance.post(endpoint, data);
      return response.data;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Make PUT request
   * Note: Some endpoints return data directly without ApiResponse wrapper
   */
  async put<T = any>(endpoint: string, data?: any): Promise<ApiResponse<T>> {
    try {
      const response = await this.axiosInstance.put(endpoint, data);
      return response.data;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Make DELETE request
   * Note: Some endpoints return data directly without ApiResponse wrapper
   */
  async delete<T = any>(endpoint: string): Promise<ApiResponse<T>> {
    try {
      const response = await this.axiosInstance.delete(endpoint);
      return response.data;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Make PATCH request
   */
  async patch<T = any>(endpoint: string, data?: any): Promise<ApiResponse<T>> {
    try {
      const response = await this.axiosInstance.patch<ApiResponse<T>>(endpoint, data);
      return response.data;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Upload file with multipart/form-data
   * Note: Some endpoints return data directly without ApiResponse wrapper
   */
  async uploadFile<T = any>(endpoint: string, formData: FormData): Promise<ApiResponse<T>> {
    try {
      const response = await this.axiosInstance.post(endpoint, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      return response.data;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Health check endpoint
   */
  async healthCheck(): Promise<boolean> {
    try {
      await this.axiosInstance.get('/health');
      return true;
    } catch (error) {
      return false;
    }
  }
}

// Export singleton instance
export const apiClient = new ApiClient();

// Export class for testing
export default ApiClient;
