import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../services/api';

export function useProvinces(countryId?: number) {
  return useQuery({
    queryKey: ['provinces', countryId],
    queryFn: async () => {
      const endpoint = countryId
        ? `/provinces/country/${countryId}`
        : '/provinces';
      const response = await apiClient.get(endpoint);
      return response;
    },
    enabled: !!countryId,
  });
}
