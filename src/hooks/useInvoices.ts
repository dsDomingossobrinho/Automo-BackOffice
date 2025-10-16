import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../services/api';
import type {
  Invoice,
  CreateInvoiceData,
  UpdateInvoiceData,
  InvoiceFilters,
  InvoiceSummary,
} from '../types';

/**
 * Query Keys for TanStack Query
 *
 * API Endpoints: Uses /subscriptions (corrected from /invoices to match Swagger API)
 */
export const invoiceKeys = {
  all: ['invoices'] as const,
  lists: () => [...invoiceKeys.all, 'list'] as const,
  list: (filters: InvoiceFilters) => [...invoiceKeys.lists(), filters] as const,
  details: () => [...invoiceKeys.all, 'detail'] as const,
  detail: (id: string) => [...invoiceKeys.details(), id] as const,
  summary: () => [...invoiceKeys.all, 'summary'] as const,
};

/**
 * Fetch invoices (subscriptions) with filters
 */
export function useInvoices(filters: InvoiceFilters = {}) {
  return useQuery({
    queryKey: invoiceKeys.list(filters),
    queryFn: async () => {
      const response = await apiClient.get<Invoice[]>('/subscriptions', filters);
      return response.data || [];
    },
  });
}

/**
 * Fetch single invoice (subscription) by ID
 */
export function useInvoice(id: string) {
  return useQuery({
    queryKey: invoiceKeys.detail(id),
    queryFn: async () => {
      const response = await apiClient.get<Invoice>(`/subscriptions/${id}`);
      return response.data;
    },
    enabled: !!id,
  });
}

/**
 * Fetch invoice summary and stats
 * Uses Swagger endpoint: GET /subscription-statistics/general
 */
export function useInvoiceSummary(filters?: Pick<InvoiceFilters, 'dateFrom' | 'dateTo' | 'clientId'>) {
  return useQuery({
    queryKey: [...invoiceKeys.summary(), filters],
    queryFn: async () => {
      const response = await apiClient.get<InvoiceSummary>('/subscription-statistics/general', filters);
      return response.data;
    },
  });
}

/**
 * Create new invoice (subscription)
 */
export function useCreateInvoice() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateInvoiceData) => {
      const response = await apiClient.post<Invoice>('/subscriptions', data);
      return response.data;
    },
    onSuccess: () => {
      // Invalidate all invoice lists and summary
      queryClient.invalidateQueries({ queryKey: invoiceKeys.lists() });
      queryClient.invalidateQueries({ queryKey: invoiceKeys.summary() });
    },
  });
}

/**
 * Update existing invoice (subscription)
 */
export function useUpdateInvoice() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: UpdateInvoiceData) => {
      const { id, ...updateData } = data;
      const response = await apiClient.put<Invoice>(`/subscriptions/${id}`, updateData);
      return response.data;
    },
    onSuccess: (data) => {
      // Invalidate all lists, summary, and specific detail
      queryClient.invalidateQueries({ queryKey: invoiceKeys.lists() });
      queryClient.invalidateQueries({ queryKey: invoiceKeys.summary() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: invoiceKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Delete invoice (subscription)
 */
export function useDeleteInvoice() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: string) => {
      const response = await apiClient.delete<void>(`/subscriptions/${id}`);
      return response;
    },
    onSuccess: () => {
      // Invalidate all lists and summary
      queryClient.invalidateQueries({ queryKey: invoiceKeys.lists() });
      queryClient.invalidateQueries({ queryKey: invoiceKeys.summary() });
    },
  });
}

/**
 * Update invoice (subscription) status
 */
export function useUpdateInvoiceStatus() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ id, status }: { id: string; status: string }) => {
      const response = await apiClient.patch<Invoice>(`/subscriptions/${id}`, { status });
      return response.data;
    },
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: invoiceKeys.lists() });
      queryClient.invalidateQueries({ queryKey: invoiceKeys.summary() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: invoiceKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Get subscriptions by user
 * Uses Swagger endpoint: GET /subscriptions/user/{userId}
 */
export function useUserSubscriptions(userId: string) {
  return useQuery({
    queryKey: ['user-subscriptions', userId],
    queryFn: async () => {
      const response = await apiClient.get<Invoice[]>(`/subscriptions/user/${userId}`);
      return response.data || [];
    },
    enabled: !!userId,
  });
}

/**
 * Get subscriptions by plan
 * Uses Swagger endpoint: GET /subscriptions/plan/{planId}
 */
export function usePlanSubscriptions(planId: string) {
  return useQuery({
    queryKey: ['plan-subscriptions', planId],
    queryFn: async () => {
      const response = await apiClient.get<Invoice[]>(`/subscriptions/plan/${planId}`);
      return response.data || [];
    },
    enabled: !!planId,
  });
}

/**
 * Get expired subscriptions
 * Uses Swagger endpoint: GET /subscriptions/expired
 */
export function useExpiredSubscriptions() {
  return useQuery({
    queryKey: ['expired-subscriptions'],
    queryFn: async () => {
      const response = await apiClient.get<Invoice[]>('/subscriptions/expired');
      return response.data || [];
    },
  });
}

/**
 * Get subscription statistics by plan
 * Uses Swagger endpoint: GET /subscription-statistics/plans/{planId}
 */
export function usePlanStatistics(planId?: string) {
  return useQuery({
    queryKey: ['plan-statistics', planId],
    queryFn: async () => {
      const endpoint = planId
        ? `/subscription-statistics/plans/${planId}`
        : '/subscription-statistics/plans';
      const response = await apiClient.get(endpoint);
      return response.data;
    },
  });
}

/**
 * Get subscription statistics by plan type
 * Uses Swagger endpoint: GET /subscription-statistics/plan-type/{planTypeName}
 */
export function usePlanTypeStatistics(planType?: string) {
  return useQuery({
    queryKey: ['plan-type-statistics', planType],
    queryFn: async () => {
      const response = await apiClient.get(`/subscription-statistics/plan-type/${planType}`);
      return response.data;
    },
    enabled: !!planType,
  });
}

/**
 * Send invoice (not available in Swagger - kept for future implementation)
 * TODO: Check if send endpoint exists in backend
 */
export function useSendInvoice() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: string) => {
      // TODO: Implement send subscription notification
      const response = await apiClient.post<Invoice>(`/subscriptions/${id}/send`);
      return response.data;
    },
    onSuccess: (data) => {
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: invoiceKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Download invoice PDF (not available in Swagger - kept for future implementation)
 * TODO: Check if PDF generation endpoint exists in backend
 */
export function useDownloadInvoicePdf() {
  return useMutation({
    mutationFn: async (id: string) => {
      // TODO: Implement PDF generation
      const response = await apiClient.get<Blob>(`/subscriptions/${id}/pdf`, {
        responseType: 'blob',
      });

      // Create download link
      const blob = new Blob([response.data as any], { type: 'application/pdf' });
      const url = window.URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = `subscription-${id}.pdf`;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      window.URL.revokeObjectURL(url);

      return response;
    },
  });
}
