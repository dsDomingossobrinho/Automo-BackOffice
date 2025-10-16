import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../services/api';

export function useOrganizationTypes() {
  return useQuery({
    queryKey: ['organization-types'],
    queryFn: async () => {
      const response = await apiClient.get('/organization-types');
      return response;
    },
  });
}
