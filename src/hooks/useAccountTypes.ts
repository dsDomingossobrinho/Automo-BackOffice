import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../services/api';

export function useAccountTypes() {
  return useQuery({
    queryKey: ['account-types'],
    queryFn: async () => {
      const response = await apiClient.get('/account-types');
      return response;
    },
  });
}
