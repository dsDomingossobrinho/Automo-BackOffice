import { useQuery } from "@tanstack/react-query";
import { useAgents } from "./useAgents";
import { useMessageCounts } from "./useMessageCounts";

export interface AgentStatistics {
  totalMessages: number;
  avgMessagesForConversion: number;
  totalClients: number;
  totalLeads: number;
  totalReplied: number;
}

export function useAgentStatistics() {
  const { data: messageCounts } = useMessageCounts();
  const { data: agentsResponse } = useAgents({ page: 0, size: 1000 });

  return useQuery({
    queryKey: ["agent-statistics", messageCounts, agentsResponse],
    queryFn: async (): Promise<AgentStatistics> => {
      const totalMessages = (messageCounts || []).reduce(
        (sum, m) => sum + (m.messageCount || 0),
        0
      );

      // Valores a serem implementados quando a lógica de negócio estiver disponível
      const totalReplied = 0;
      const avgMessagesForConversion =
        totalReplied > 0 ? +(totalMessages / totalReplied).toFixed(2) : 0;
      const totalClients = 0;
      const totalLeads = 0;

      return {
        totalMessages,
        avgMessagesForConversion,
        totalClients,
        totalLeads,
        totalReplied,
      };
    },
    enabled: !!messageCounts,
    staleTime: 5 * 60 * 1000,
  });
}
