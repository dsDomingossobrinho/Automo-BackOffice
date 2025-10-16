import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../services/api';
import type {
  Transaction,
  CreateTransactionData,
  UpdateTransactionData,
  TransactionFilters,
  FinanceSummary,
} from '../types';

/**
 * Query Keys for TanStack Query
 *
 * API Endpoints: Uses /payments (corrected from /finances/transactions to match Swagger API)
 */
export const financeKeys = {
  all: ['finances'] as const,
  lists: () => [...financeKeys.all, 'list'] as const,
  list: (filters: TransactionFilters) => [...financeKeys.lists(), filters] as const,
  details: () => [...financeKeys.all, 'detail'] as const,
  detail: (id: string) => [...financeKeys.details(), id] as const,
  summary: () => [...financeKeys.all, 'summary'] as const,
};

/**
 * Fetch transactions (payments) with filters
 */
export function useTransactions(filters: TransactionFilters = {}) {
  return useQuery({
    queryKey: financeKeys.list(filters),
    queryFn: async () => {
      const response = await apiClient.get<Transaction[]>('/payments', filters);
      return response.data || [];
    },
  });
}

/**
 * Fetch single transaction (payment) by ID
 */
export function useTransaction(id: string) {
  return useQuery({
    queryKey: financeKeys.detail(id),
    queryFn: async () => {
      const response = await apiClient.get<Transaction>(`/payments/${id}`);
      return response.data;
    },
    enabled: !!id,
  });
}

/**
 * Fetch finance summary and stats
 * Uses Swagger endpoint: GET /payments/statistics
 */
export function useFinanceSummary(filters?: Pick<TransactionFilters, 'dateFrom' | 'dateTo'>) {
  return useQuery({
    queryKey: [...financeKeys.summary(), filters],
    queryFn: async () => {
      const response = await apiClient.get<FinanceSummary>('/payments/statistics', filters);
      return response.data;
    },
  });
}

/**
 * Create new transaction (payment)
 */
export function useCreateTransaction() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateTransactionData) => {
      const response = await apiClient.post<Transaction>('/payments', data);
      return response.data;
    },
    onSuccess: () => {
      // Invalidate all transaction lists and summary
      queryClient.invalidateQueries({ queryKey: financeKeys.lists() });
      queryClient.invalidateQueries({ queryKey: financeKeys.summary() });
    },
  });
}

/**
 * Update existing transaction (payment)
 */
export function useUpdateTransaction() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: UpdateTransactionData) => {
      const { id, ...updateData } = data;
      const response = await apiClient.put<Transaction>(`/payments/${id}`, updateData);
      return response.data;
    },
    onSuccess: (data) => {
      // Invalidate all lists, summary, and specific detail
      queryClient.invalidateQueries({ queryKey: financeKeys.lists() });
      queryClient.invalidateQueries({ queryKey: financeKeys.summary() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: financeKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Delete transaction (payment)
 */
export function useDeleteTransaction() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: string) => {
      const response = await apiClient.delete<void>(`/payments/${id}`);
      return response;
    },
    onSuccess: () => {
      // Invalidate all lists and summary
      queryClient.invalidateQueries({ queryKey: financeKeys.lists() });
      queryClient.invalidateQueries({ queryKey: financeKeys.summary() });
    },
  });
}

/**
 * Update transaction (payment) status
 * Uses Swagger endpoint: PUT /payments/{id}/state
 */
export function useUpdateTransactionStatus() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ id, status }: { id: string; status: string }) => {
      const response = await apiClient.put<Transaction>(`/payments/${id}/state`, { state: status });
      return response.data;
    },
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: financeKeys.lists() });
      queryClient.invalidateQueries({ queryKey: financeKeys.summary() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: financeKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Update transaction (payment) type
 * Uses Swagger endpoint: PUT /payments/{id}/type
 */
export function useUpdateTransactionType() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ id, typeId }: { id: string; typeId: number }) => {
      const response = await apiClient.put<Transaction>(`/payments/${id}/type`, { paymentTypeId: typeId });
      return response.data;
    },
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: financeKeys.lists() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: financeKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Get revenue statistics
 * Uses Swagger endpoint: GET /statistics/revenue
 */
export function useRevenueStatistics(filters?: { stateId?: number }) {
  return useQuery({
    queryKey: ['revenue-statistics', filters],
    queryFn: async () => {
      const endpoint = filters?.stateId
        ? `/statistics/revenue/state/${filters.stateId}`
        : '/statistics/revenue';
      const response = await apiClient.get(endpoint);
      return response.data;
    },
  });
}

/**
 * Export transactions to CSV
 * Note: This endpoint may not exist in Swagger, kept for future implementation
 */
export function useExportTransactions() {
  return useMutation({
    mutationFn: async (filters: TransactionFilters = {}) => {
      // TODO: Check if export endpoint exists in backend
      const response = await apiClient.get<Blob>('/payments/export', {
        ...filters,
        format: 'csv',
      });

      // Create download link
      const blob = new Blob([response.data as any], { type: 'text/csv' });
      const url = window.URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = `payments-${new Date().toISOString().split('T')[0]}.csv`;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      window.URL.revokeObjectURL(url);

      return response;
    },
  });
}
