import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../services/api';
import type {
  Account,
  CreateAccountData,
  UpdateAccountData,
  AccountFilters,
  AccountSummary,
} from '../types';

/**
 * Query Keys for TanStack Query
 *
 * API Endpoints: Uses /auth/users (corrected from /accounts to match Swagger API)
 */
export const accountKeys = {
  all: ['accounts'] as const,
  lists: () => [...accountKeys.all, 'list'] as const,
  list: (filters: AccountFilters) => [...accountKeys.lists(), filters] as const,
  details: () => [...accountKeys.all, 'detail'] as const,
  detail: (id: string) => [...accountKeys.details(), id] as const,
  summary: () => [...accountKeys.all, 'summary'] as const,
};

/**
 * Fetch accounts with filters
 */
export function useAccounts(filters: AccountFilters = {}) {
  return useQuery({
    queryKey: accountKeys.list(filters),
    queryFn: async () => {
      const response = await apiClient.get<Account[]>('/auth/users', filters);
      return response.data || [];
    },
  });
}

/**
 * Fetch single account by ID
 */
export function useAccount(id: string) {
  return useQuery({
    queryKey: accountKeys.detail(id),
    queryFn: async () => {
      const response = await apiClient.get<Account>(`/auth/users/${id}`);
      return response.data;
    },
    enabled: !!id,
  });
}

/**
 * Fetch account summary and stats
 * Uses paginated endpoint from Swagger API
 */
export function useAccountSummary() {
  return useQuery({
    queryKey: accountKeys.summary(),
    queryFn: async () => {
      const response = await apiClient.get<AccountSummary>('/auth/users/paged');
      return response.data;
    },
  });
}

/**
 * Create new account
 */
export function useCreateAccount() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateAccountData) => {
      const response = await apiClient.post<Account>('/auth/users', data);
      return response.data;
    },
    onSuccess: () => {
      // Invalidate all account lists and summary
      queryClient.invalidateQueries({ queryKey: accountKeys.lists() });
      queryClient.invalidateQueries({ queryKey: accountKeys.summary() });
    },
  });
}

/**
 * Update existing account
 */
export function useUpdateAccount() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: UpdateAccountData) => {
      const { id, ...updateData } = data;
      const response = await apiClient.put<Account>(`/auth/users/${id}`, updateData);
      return response.data;
    },
    onSuccess: (data) => {
      // Invalidate all lists, summary, and specific detail
      queryClient.invalidateQueries({ queryKey: accountKeys.lists() });
      queryClient.invalidateQueries({ queryKey: accountKeys.summary() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: accountKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Delete account
 */
export function useDeleteAccount() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: string) => {
      const response = await apiClient.delete<void>(`/auth/users/${id}`);
      return response;
    },
    onSuccess: () => {
      // Invalidate all lists and summary
      queryClient.invalidateQueries({ queryKey: accountKeys.lists() });
      queryClient.invalidateQueries({ queryKey: accountKeys.summary() });
    },
  });
}

/**
 * Activate account
 * Uses specific Swagger endpoint: POST /auth/users/{userId}/activate
 */
export function useActivateAccount() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: string) => {
      const response = await apiClient.post<Account>(`/auth/users/${id}/activate`);
      return response.data;
    },
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: accountKeys.lists() });
      queryClient.invalidateQueries({ queryKey: accountKeys.summary() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: accountKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Deactivate account
 * Uses specific Swagger endpoint: POST /auth/users/{userId}/deactivate
 */
export function useDeactivateAccount() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: string) => {
      const response = await apiClient.post<Account>(`/auth/users/${id}/deactivate`);
      return response.data;
    },
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: accountKeys.lists() });
      queryClient.invalidateQueries({ queryKey: accountKeys.summary() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: accountKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Update account permissions
 * Uses Swagger endpoint: GET /auth/users/permissions
 */
export function useUpdateAccountPermissions() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ id, permissions }: { id: string; permissions: string[] }) => {
      const response = await apiClient.put<Account>(`/auth/users/${id}`, { permissions });
      return response.data;
    },
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: accountKeys.lists() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: accountKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Reset account password
 * Uses general auth reset-password endpoint
 */
export function useResetAccountPassword() {
  return useMutation({
    mutationFn: async ({ id, newPassword }: { id: string; newPassword: string }) => {
      const response = await apiClient.post<void>(`/auth/reset-password`, { userId: id, newPassword });
      return response;
    },
  });
}
