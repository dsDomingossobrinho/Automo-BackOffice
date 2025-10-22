import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../services/api';

export interface MessageCountResponse {
  id: number;
  leadId: number;
  leadName?: string;
  messageCount: number;
  stateId?: number;
  stateName?: string;
  createdAt?: string;
  updatedAt?: string;
}

export function useMessageCounts() {
  return useQuery({
    queryKey: ['message-counts'],
    queryFn: async () => {
      const response = await apiClient.get<MessageCountResponse[]>('/message-counts');

      if (response && typeof response === 'object') {
        if ('data' in response && response.data !== undefined) {
          return response.data as MessageCountResponse[];
        }
        if (Array.isArray(response)) {
          return response as unknown as MessageCountResponse[];
        }
      }

      throw new Error('Unexpected API response structure for /message-counts');
    },
    staleTime: 2 * 60 * 1000,
  });
}
