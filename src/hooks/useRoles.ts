import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../services/api';
import type { RoleInfo } from '../types/user';

/**
 * Fetch roles from /roles endpoint
 * Normalizes both wrapped ApiResponse and direct array responses
 */
export function useRoles() {
  return useQuery({
    queryKey: ['roles'],
    queryFn: async () => {
      const response = await apiClient.get('/roles');
      // API sometimes returns { data: [...] } or directly [...]
      const normalize = (arr: unknown[]): RoleInfo[] =>
        arr.map((item) => {
          const it = item as Record<string, unknown>;
          return {
            id: Number(it.id) || 0,
            name: (it.name as string) || (it.role as string) || String(Number(it.id) || ''),
            description: (it.description as string) || (it.desc as string) || '',
          } as RoleInfo;
        });

      if (response && typeof response === 'object' && 'data' in response) {
        const maybe = response as unknown as { data?: unknown };
        if (Array.isArray(maybe.data)) return normalize(maybe.data as unknown[]);
      }
      if (Array.isArray(response)) return normalize(response as unknown[]);
      return [] as RoleInfo[];
    },
    staleTime: 5 * 60 * 1000,
  });
}

/**
 * Create role
 */
export function useCreateRole() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: { role: string; description?: string }) => {
      const payload = { role: data.role, description: data.description };
      const response = await apiClient.post('/roles', payload);
      // handle wrapped or direct
      if (response && typeof response === 'object' && 'data' in response) {
        const maybe = response as unknown as { data?: unknown };
        return maybe.data ?? response;
      }
      return response;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['roles'] });
    },
  });
}
