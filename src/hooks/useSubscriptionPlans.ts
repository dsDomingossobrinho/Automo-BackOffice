import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../services/api';
import type {
  SubscriptionPlan,
  SubscriptionPlansPaginatedResponse,
  CreateSubscriptionPlanData,
  UpdateSubscriptionPlanData,
} from '@/types';

// Fetch subscription plans with pagination
export function useSubscriptionPlans(page = 0, size = 10, search?: string) {
  return useQuery({
    queryKey: ['subscription-plans', page, size, search],
    queryFn: async () => {
      const response = await apiClient.get<SubscriptionPlansPaginatedResponse>(
        '/subscription-plans/paginated',
        {
          page,
          size,
          ...(search && { search }),
        }
      );
      // Handle both direct response and wrapped response formats
      if ('content' in response) {
        return response as unknown as SubscriptionPlansPaginatedResponse;
      }

      const dataField = 'data' in response
        ? (response as unknown as { data: SubscriptionPlansPaginatedResponse }).data
        : undefined;

      return dataField || (response as unknown as SubscriptionPlansPaginatedResponse);
    },
    staleTime: 5 * 60 * 1000,
  });
}

// Create subscription plan
export function useCreateSubscriptionPlan() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateSubscriptionPlanData) => {
      return await apiClient.post<SubscriptionPlan>('/subscription-plans', data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['subscription-plans'] });
    },
  });
}

// Update subscription plan
export function useUpdateSubscriptionPlan() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({
      id,
      ...data
    }: UpdateSubscriptionPlanData & { id: number }) => {
      return await apiClient.put<SubscriptionPlan>(
        `/subscription-plans/${id}`,
        data
      );
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['subscription-plans'] });
    },
  });
}

// Delete subscription plan
export function useDeleteSubscriptionPlan() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: number) => {
      return await apiClient.delete(`/subscription-plans/${id}`);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['subscription-plans'] });
    },
  });
}
