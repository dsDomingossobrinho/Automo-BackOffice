import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../services/api';

export function useCountries() {
  return useQuery({
    queryKey: ['countries'],
    queryFn: async () => {
      const response = await apiClient.get('/countries');
      return response;
    },
  });
}
