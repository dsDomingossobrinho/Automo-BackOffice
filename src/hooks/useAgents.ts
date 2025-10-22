import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../services/api';

export interface AgentResponse {
  id: number;
  name: string;
  stateId?: number;
  state?: string;
  // other fields as provided by the API
}

export function useAgents(params?: { page?: number; size?: number; search?: string }) {
  const queryKey = ['agents', params];

  const queryFn = async () => {
    const q: Record<string, string | number> | undefined = params
      ? {
        ...(params.page !== undefined && { page: params.page }),
        ...(params.size !== undefined && { size: params.size }),
        ...(params.search !== undefined && { search: params.search }),
      }
      : undefined;

    const response = await apiClient.get('/agents', { params: q });

    if (response && typeof response === 'object') {
      if ('data' in response && response.data !== undefined) return response.data;
      if (Array.isArray(response)) return response as unknown as AgentResponse[];
      if ('content' in response) {
        const pag = response as { content: AgentResponse[] };
        return pag.content;
      }
    }

    throw new Error('Unexpected API response structure for /agents');
  };

  return useQuery({ queryKey, queryFn, staleTime: 2 * 60 * 1000 });
}
