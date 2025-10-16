import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../services/api';

export function useStates() {
  return useQuery({
    queryKey: ['states'],
    queryFn: async () => {
      const response = await apiClient.get('/states');
      return response;
    },
  });
}
