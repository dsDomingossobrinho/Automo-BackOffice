import { Bot, Loader2, Mail, TrendingUp, UserPlus, Users } from "lucide-react";
import { useMemo } from "react";
import { DashboardCard } from "@/components/ui/dashboard-card";
import { useAgentStatistics } from "@/hooks/useAgentStatistics";
import { type AgentResponse, useAgents } from "@/hooks/useAgents";
import type { MergedAgent } from "@/types";

export default function AgentPage() {
  // React Query hooks
  const { data: agentsResponse, isLoading: loadingAgents } = useAgents({
    page: 0,
    size: 1000,
  });
  const { data: statistics, isLoading: loadingStatistics } =
    useAgentStatistics();

  // Processar lista de agentes
  const mergedAgents = useMemo<MergedAgent[]>(() => {
    const agentsList: AgentResponse[] = Array.isArray(agentsResponse)
      ? agentsResponse
      : agentsResponse?.content || [];

    return agentsList.map((agent) => ({
      id: agent.id,
      name: agent.name,
      state: agent.state || "N/A",
      replied: 0,
      total: 0,
    }));
  }, [agentsResponse]);

  return (
    <div className="space-y-5 xl:space-y-8">
      {/* 1. Page Header */}
      <section className="flex justify-between">
        <article className="px-2 sm:px-0">
          <h1 className="text-2xl font-bold tracking-tight sm:text-3xl">
            Agente AI
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Visão geral do agente e suas métricas
          </p>
        </article>
      </section>

      {/* 2. Statistics Cards */}
      <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <DashboardCard
          stat={{
            title: "Mensagens Totais",
            value: loadingStatistics
              ? "-"
              : String(statistics?.totalMessages || 0),
            change: "+0%",
            changeType: "positive",
            icon: Mail,
            color: "text-blue-500",
            bgColor: "bg-blue-500/10",
          }}
          index={0}
          noProgressBar
          noTrending
        />
        <DashboardCard
          stat={{
            title: "Média de Mensagens p/ Conversão",
            value: loadingStatistics
              ? "-"
              : String(statistics?.avgMessagesForConversion || 0),
            change: "+0%",
            changeType: "positive",
            icon: TrendingUp,
            color: "text-green-500",
            bgColor: "bg-green-500/10",
          }}
          index={1}
          noProgressBar
          noTrending
        />
        <DashboardCard
          stat={{
            title: "Clientes",
            value: loadingStatistics
              ? "-"
              : String(statistics?.totalClients || 0),
            change: "+0%",
            changeType: "positive",
            icon: Users,
            color: "text-cyan-500",
            bgColor: "bg-cyan-500/10",
          }}
          index={2}
          noProgressBar
          noTrending
        />
        <DashboardCard
          stat={{
            title: "Leads",
            value: loadingStatistics
              ? "-"
              : String(statistics?.totalLeads || 0),
            change: "+0%",
            changeType: "positive",
            icon: UserPlus,
            color: "text-orange-500",
            bgColor: "bg-orange-500/10",
          }}
          index={3}
          noProgressBar
          noTrending
        />
      </div>

      {/* 3. Data Table */}
      <div className="rounded-lg border bg-card">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="border-b bg-muted/50">
                <th className="px-4 py-3 text-left text-sm font-medium">ID</th>
                <th className="px-4 py-3 text-left text-sm font-medium">
                  Nome
                </th>
                <th className="px-4 py-3 text-left text-sm font-medium">
                  Estado
                </th>
                <th className="px-4 py-3 text-right text-sm font-medium">
                  Mensagens p/ Conversão
                </th>
              </tr>
            </thead>
            <tbody>
              {loadingAgents && (
                <tr>
                  <td colSpan={4} className="px-4 py-8 text-center">
                    <div className="flex items-center justify-center gap-2">
                      <Loader2 className="h-4 w-4 animate-spin" />
                      <span>A carregar...</span>
                    </div>
                  </td>
                </tr>
              )}

              {!loadingAgents && mergedAgents.length === 0 && (
                <tr>
                  <td
                    colSpan={4}
                    className="px-4 py-8 text-center text-muted-foreground"
                  >
                    Nenhum agente encontrado
                  </td>
                </tr>
              )}

              {!loadingAgents &&
                mergedAgents.length > 0 &&
                mergedAgents.map((agent) => (
                  <tr
                    key={agent.id}
                    className="border-b last:border-0 hover:bg-muted/50"
                  >
                    <td className="px-4 py-3 text-sm">{agent.id}</td>
                    <td className="px-4 py-3">
                      <div className="flex items-center gap-3">
                        <div className="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10">
                          <Bot className="h-4 w-4 text-primary" />
                        </div>
                        <span className="font-medium">{agent.name}</span>
                      </div>
                    </td>
                    <td className="px-4 py-3 text-sm">{agent.state}</td>
                    <td className="px-4 py-3 text-right">
                      <strong>{agent.replied}</strong>
                    </td>
                  </tr>
                ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}
