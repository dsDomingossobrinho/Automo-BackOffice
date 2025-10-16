import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../services/api';
import type { Client, CreateClientData, UpdateClientData, ClientFilters } from '../types';

/**
 * Custom hooks for Client CRUD operations
 * Using TanStack Query for data fetching and caching
 *
 * API Endpoints: Uses /users (clients are users in the API)
 * - GET /users/paginated - Get paginated users
 * - GET /users/{id} - Get single user
 * - POST /users - Create user
 * - PUT /users/{id} - Update user
 * - DELETE /users/{id} - Delete user
 */

// Paginated Response Interface (Based on Swagger PaginatedResponseUserResponse)
interface PaginatedResponse<T> {
  content: T[];
  pageNumber: number;
  pageSize: number;
  totalElements: number;
  totalPages: number;
  first: boolean;
  last: boolean;
  hasNext: boolean;
  hasPrevious: boolean;
}

// Query Keys
export const clientKeys = {
  all: ['clients'] as const,
  lists: () => [...clientKeys.all, 'list'] as const,
  list: (filters: ClientFilters) => [...clientKeys.lists(), filters] as const,
  details: () => [...clientKeys.all, 'detail'] as const,
  detail: (id: number) => [...clientKeys.details(), id] as const,
};

/**
 * Hook to fetch clients list (paginated)
 * Uses /users/paginated endpoint
 */
export function useClients(filters?: ClientFilters) {
  return useQuery({
    queryKey: clientKeys.list(filters || {}),
    queryFn: async () => {
      const params = {
        search: filters?.search || '',
        page: filters?.page || 0,
        size: filters?.size || 10,
        sortBy: filters?.sortBy || 'id',
        sortDirection: filters?.sortDirection || 'ASC',
        ...(filters?.stateId && { stateId: filters.stateId }),
      };

      const response = await apiClient.get<PaginatedResponse<Client>>('/users/paginated', params);

      // Handle both cases: wrapped in ApiResponse or direct response
      if (response && typeof response === 'object') {
        // If response has a 'data' property (wrapped in ApiResponse)
        if ('data' in response && response.data !== undefined) {
          return response.data as PaginatedResponse<Client>;
        }
        // If response is the paginated data directly
        if ('content' in response) {
          return response as unknown as PaginatedResponse<Client>;
        }
      }

      throw new Error('Unexpected API response structure');
    },
  });
}

/**
 * Hook to fetch single client
 * Uses /users/{id} endpoint
 */
export function useClient(id: number) {
  return useQuery({
    queryKey: clientKeys.detail(id),
    queryFn: async () => {
      const response = await apiClient.get<Client>(`/users/${id}`);
      // Handle both response formats: wrapped or direct
      if ('data' in response && response.data !== undefined) {
        return response.data as Client;
      }
      return response as unknown as Client;
    },
    enabled: !!id,
  });
}

/**
 * Hook to create new client
 * Uses POST /users endpoint
 */
export function useCreateClient() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateClientData) => {
      const response = await apiClient.post<Client>('/users', data);
      // Handle both response formats: wrapped or direct
      if ('data' in response && response.data !== undefined) {
        return response.data as Client;
      }
      return response as unknown as Client;
    },
    onSuccess: () => {
      // Invalidate and refetch
      queryClient.invalidateQueries({ queryKey: clientKeys.lists() });
    },
  });
}

/**
 * Hook to update existing client
 * Uses PUT /users/{id} endpoint
 */
export function useUpdateClient() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: UpdateClientData) => {
      const response = await apiClient.put<Client>(`/users/${data.id}`, data);
      // Handle both response formats: wrapped or direct
      if ('data' in response && response.data !== undefined) {
        return response.data as Client;
      }
      return response as unknown as Client;
    },
    onSuccess: (data) => {
      // Invalidate lists and specific client
      queryClient.invalidateQueries({ queryKey: clientKeys.lists() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: clientKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Hook to delete client
 * Uses DELETE /users/{id} endpoint
 */
export function useDeleteClient() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: number) => {
      const response = await apiClient.delete(`/users/${id}`);
      // The apiClient.delete already returns ApiResponse, so response.data contains the actual data
      return response.data;
    },
    onSuccess: () => {
      // Invalidate lists
      queryClient.invalidateQueries({ queryKey: clientKeys.lists() });
    },
  });
}

// Client Statistics Interface
export interface ClientStatistics {
  totalUsers: number;
  activeUsers: number;
  inactiveUsers: number;
  eliminatedUsers: number;
}

/**
 * Hook to fetch user statistics
 * Uses GET /users/statistics endpoint
 */
export function useClientStatistics() {
  return useQuery<ClientStatistics>({
    queryKey: ['clients', 'statistics'],
    queryFn: async () => {
      const response = await apiClient.get<ClientStatistics>('/users/statistics');
      // Handle both response formats: wrapped or direct
      if ('totalUsers' in response) {
        return response as unknown as ClientStatistics;
      }
      if ('data' in response && response.data !== undefined) {
        return response.data as ClientStatistics;
      }
      return response as unknown as ClientStatistics;
    },
    staleTime: 5 * 60 * 1000, // 5 minutes
  });
}
