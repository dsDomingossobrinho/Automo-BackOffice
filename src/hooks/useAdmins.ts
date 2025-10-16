import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../services/api';
import type { Admin, CreateAdminData, UpdateAdminData, AdminFilters, AdminStatistics } from '../types/admin';

/**
 * Custom hooks for Admin CRUD operations
 * Using TanStack Query for data fetching and caching
 *
 * API Endpoints (Based on Swagger):
 * - GET /admins/paginated - Get paginated admins
 * - GET /admins/{id} - Get single admin
 * - POST /admins - Create admin
 * - PUT /admins/{id} - Update admin
 * - DELETE /admins/{id} - Delete admin
 * - GET /admins/statistics - Get admin statistics
 */

// Paginated Response Interface
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
export const adminKeys = {
  all: ['admins'] as const,
  lists: () => [...adminKeys.all, 'list'] as const,
  list: (filters: AdminFilters) => [...adminKeys.lists(), filters] as const,
  details: () => [...adminKeys.all, 'detail'] as const,
  detail: (id: number) => [...adminKeys.details(), id] as const,
  statistics: () => [...adminKeys.all, 'statistics'] as const,
};

/**
 * Hook to fetch admins list (paginated)
 * Uses GET /admins/paginated
 */
export function useAdmins(filters?: AdminFilters) {
  return useQuery({
    queryKey: adminKeys.list(filters || {}),
    queryFn: async () => {
      const params = {
        search: filters?.search || '',
        page: filters?.page || 0,
        size: filters?.size || 10,
        sortBy: filters?.sortBy || 'id',
        sortDirection: filters?.sortDirection || 'ASC',
        ...(filters?.stateId && { stateId: filters.stateId }),
      };

      // Backend returns data directly without ApiResponse wrapper
      const response = await apiClient.get<PaginatedResponse<Admin>>('/admins/paginated', params);
      return response as unknown as PaginatedResponse<Admin>;
    },
  });
}

/**
 * Hook to fetch single admin
 * Uses GET /admins/{id}
 */
export function useAdmin(id: number) {
  return useQuery({
    queryKey: adminKeys.detail(id),
    queryFn: async () => {
      // Backend returns data directly without ApiResponse wrapper
      const response = await apiClient.get<Admin>(`/admins/${id}`);
      return response as unknown as Admin;
    },
    enabled: !!id,
  });
}

/**
 * Hook to create new admin
 * Uses POST /admins
 */
export function useCreateAdmin() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateAdminData) => {
      // Backend returns data directly without ApiResponse wrapper
      const response = await apiClient.post<Admin>('/admins', data);
      return response as unknown as Admin;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: adminKeys.lists() });
      queryClient.invalidateQueries({ queryKey: adminKeys.statistics() });
    },
  });
}

/**
 * Hook to update existing admin
 * Uses PUT /admins/{id}
 */
export function useUpdateAdmin() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: UpdateAdminData) => {
      // Backend returns data directly without ApiResponse wrapper
      const response = await apiClient.put<Admin>(`/admins/${data.id}`, data);
      return response as unknown as Admin;
    },
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: adminKeys.lists() });
      if (data?.id) {
        queryClient.invalidateQueries({ queryKey: adminKeys.detail(data.id) });
      }
    },
  });
}

/**
 * Hook to delete admin
 * Uses DELETE /admins/{id}
 */
export function useDeleteAdmin() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (id: number) => {
      // Backend returns data directly without ApiResponse wrapper
      const response = await apiClient.delete(`/admins/${id}`);
      return response as unknown as void;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: adminKeys.lists() });
      queryClient.invalidateQueries({ queryKey: adminKeys.statistics() });
    },
  });
}

/**
 * Hook to fetch admin statistics
 * Uses GET /admins/statistics
 */
export function useAdminStatistics() {
  return useQuery({
    queryKey: adminKeys.statistics(),
    queryFn: async () => {
      // Backend returns data directly without ApiResponse wrapper
      const response = await apiClient.get<AdminStatistics>('/admins/statistics');
      return response as unknown as AdminStatistics;
    },
  });
}

/**
 * Hook to upload admin image
 * Uses POST /admin/upload-image
 */
export function useUploadAdminImage() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (file: File) => {
      const formData = new FormData();
      formData.append('file', file);

      // Backend returns data directly without ApiResponse wrapper
      const response = await apiClient.uploadFile<Admin>('/admin/upload-image', formData);
      return response as unknown as Admin;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: adminKeys.all });
    },
  });
}
