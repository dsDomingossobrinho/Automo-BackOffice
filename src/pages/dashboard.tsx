import { ActivityIcon, DollarSignIcon, EyeIcon, UsersIcon } from "lucide-react";
import { DashboardCard } from "@/components/ui/dashboard-card";
import { RecentActivity } from "@/components/widgets/recent-activity";
import { RevenueChart } from "@/components/widgets/revenue-chart";
import { SystemStatus } from "@/components/widgets/system-status";
import { useClients } from "../hooks/useClients";
import { useMessages } from "../hooks/useMessages";
import { useRevenueStatistics } from "../hooks/useStatistics";
import { useAuthStore } from "../stores/authStore";

export default function DashboardPage() {
  const { user } = useAuthStore();
  const { data: clientsResponse, isLoading: loadingClients } = useClients({
    page: 0,
    size: 100,
  });
  const clients = clientsResponse?.content || [];
  const { data: messages = [], isLoading: loadingMessages } = useMessages();
  const { data: revenueStats, isLoading: isRevenueLoading } =
    useRevenueStatistics();

  // Calculate stats
  const totalClients = clients.length;
  const totalMessages = messages.length;
  const newMessages = messages.filter((m) => m.status === "new").length;
  const totalRevenue = revenueStats?.totalRevenue || 0;

  const isLoading = loadingClients || loadingMessages || isRevenueLoading;

  const stats = [
    {
      title: "Total de Utilizadores",
      value: totalClients.toString(),
      changeType: "positive" as const,
      icon: UsersIcon,
      color: "text-blue-500",
      bgColor: "bg-blue-500/10",
    },
    {
      title: "Receita",
      value: `$${totalRevenue.toLocaleString()}`,
      changeType: "positive" as const,
      icon: DollarSignIcon,
      color: "text-green-500",
      bgColor: "bg-green-500/10",
    },
    {
      title: "Sessões Ativas",
      value: totalMessages.toString(),
      changeType: "positive" as const,
      icon: ActivityIcon,
      color: "text-purple-500",
      bgColor: "bg-purple-500/10",
    },
    {
      title: "Mensagens Novas",
      value: newMessages.toString(),
      changeType: "negative" as const,
      icon: EyeIcon,
      color: "text-orange-500",
      bgColor: "bg-orange-500/10",
    },
  ];

  return (
    <section className="space-y-4 xl:space-y-5">
      <article className="px-2 sm:px-0">
        <h1 className="text-2xl font-bold tracking-tight sm:text-3xl">
          Bem-vindo {user?.name}!
        </h1>
        <p className="text-muted-foreground text-sm sm:text-base">
          Aqui está o que está acontecendo com sua plataforma hoje.
        </p>
      </article>

      {/* Stats Cards */}
      <article className="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4">
        {stats.map((stat, index) => (
          <DashboardCard key={stat.title} stat={stat} index={index} />
        ))}
      </article>

      {/* Main Content Grid */}
      <article className="w-full grid gap-4 sm:gap-6">
        {/* Charts Section */}
        <RevenueChart />

        {/* Sidebar Section */}
        <div className="gap-4 sm:gap-6 grid grid-cols-1 xl:grid-cols-2">
          <SystemStatus />
          <RecentActivity />
        </div>
      </article>
    </section>
  );
}
