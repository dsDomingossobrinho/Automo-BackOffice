import { useAuthStore } from '../../stores/authStore';
import { useClients } from '../../hooks/useClients';
import { useMessages, useMessageStats } from '../../hooks/useMessages';
import { useRevenueStatistics } from '../../hooks/useStatistics';
import MainLayout from '../../components/layout/MainLayout';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  ArcElement,
  Title,
  Tooltip,
  Legend,
  Filler,
} from 'chart.js';
import { Line, Doughnut } from 'react-chartjs-2';

// Register ChartJS components
ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  ArcElement,
  Title,
  Tooltip,
  Legend,
  Filler
);

/**
 * Dashboard Page Component
 * Main dashboard view with stats and charts
 */
export default function DashboardPage() {
  const { getUserName } = useAuthStore();
  const { data: clientsResponse, isLoading: loadingClients } = useClients({ page: 0, size: 100 });
  const clients = clientsResponse?.content || [];
  const { data: messages = [], isLoading: loadingMessages } = useMessages();
  const { data: messageStats, isLoading: loadingStats } = useMessageStats();
  const { data: revenueStats, isLoading: isRevenueLoading } = useRevenueStatistics();

  // Calculate stats
  const totalClients = clients.length;
  const activeClients = clients.filter((c) => c.stateId === 1).length; // Assumindo que stateId 1 = ativo
  const totalMessages = messages.length;
  const newMessages = messages.filter((m) => m.status === 'new').length;
  const totalRevenue = revenueStats?.totalRevenue || 0;

  // Messages by month (mock data for last 6 months)
  const monthlyData = {
    labels: ['Outubro', 'Novembro', 'Dezembro', 'Janeiro', 'Fevereiro', 'Março'],
    datasets: [
      {
        label: 'Mensagens',
        data: [45, 52, 38, 65, 59, totalMessages],
        borderColor: 'rgb(59, 130, 246)',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        tension: 0.4,
        fill: true,
      },
    ],
  };

  // Messages by status
  const statusData = {
    labels: ['Novas', 'Em Progresso', 'Respondidas', 'Fechadas'],
    datasets: [
      {
        data: [
          messages.filter((m) => m.status === 'new').length,
          messages.filter((m) => m.status === 'in_progress').length,
          messages.filter((m) => m.status === 'replied').length,
          messages.filter((m) => m.status === 'closed').length,
        ],
        backgroundColor: [
          'rgba(59, 130, 246, 0.8)',
          'rgba(245, 158, 11, 0.8)',
          'rgba(16, 185, 129, 0.8)',
          'rgba(107, 114, 128, 0.8)',
        ],
        borderColor: [
          'rgb(59, 130, 246)',
          'rgb(245, 158, 11)',
          'rgb(16, 185, 129)',
          'rgb(107, 114, 128)',
        ],
        borderWidth: 2,
      },
    ],
  };

  const lineChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      },
      tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.8)',
        padding: 12,
        titleColor: '#fff',
        bodyColor: '#fff',
        borderColor: 'rgba(255, 255, 255, 0.1)',
        borderWidth: 1,
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          color: '#6b7280',
        },
        grid: {
          color: 'rgba(107, 114, 128, 0.1)',
        },
      },
      x: {
        ticks: {
          color: '#6b7280',
        },
        grid: {
          display: false,
        },
      },
    },
  };

  const doughnutChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom' as const,
        labels: {
          padding: 15,
          color: '#6b7280',
          font: {
            size: 12,
          },
        },
      },
      tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.8)',
        padding: 12,
        titleColor: '#fff',
        bodyColor: '#fff',
        borderColor: 'rgba(255, 255, 255, 0.1)',
        borderWidth: 1,
      },
    },
  };

  const isLoading = loadingClients || loadingMessages || loadingStats;

  return (
    <MainLayout>
      <div className="dashboard-container">
        {/* Page Header */}
        <div className="page-header">
          <div>
            <h1>
              <i className="fas fa-chart-line"></i> Dashboard
            </h1>
            <p className="page-subtitle">
              Bem-vindo, {getUserName() || 'Utilizador'}! Aqui está uma visão geral do sistema.
            </p>
          </div>
        </div>

        {/* Stats Cards */}
        <div className="stats-cards">
          <div className="stat-card stat-card-primary">
            <div className="stat-icon">
              <i className="fas fa-users"></i>
            </div>
            <div className="stat-content">
              <h3>{isLoading ? '-' : totalClients}</h3>
              <p>Total Clientes</p>
              <span className="stat-detail">
                {activeClients} ativos
              </span>
            </div>
          </div>

          <div className="stat-card stat-card-warning">
            <div className="stat-icon">
              <i className="fas fa-envelope"></i>
            </div>
            <div className="stat-content">
              <h3>{isLoading ? '-' : newMessages}</h3>
              <p>Mensagens Novas</p>
              <span className="stat-detail">
                {totalMessages} total
              </span>
            </div>
          </div>

          <div className="stat-card stat-card-success">
            <div className="stat-icon">
              <i className="fas fa-dollar-sign"></i>
            </div>
            <div className="stat-content">
              <h3>{loadingClients ? '-' : revenueStats?.totalRevenue?.toFixed(2) || '0.00'}</h3>
              <p>Receita Total</p>
              <span className="stat-detail">
                {revenueStats?.currency || 'AOA'}
              </span>
            </div>
          </div>

          <div className="stat-card stat-card-info">
            <div className="stat-icon">
              <i className="fas fa-chart-bar"></i>
            </div>
            <div className="stat-content">
              <h3>{isLoading ? '-' : messages.filter((m) => m.status === 'replied').length}</h3>
              <p>Mensagens Respondidas</p>
              <span className="stat-detail">
                {messages.length > 0
                  ? `${Math.round((messages.filter((m) => m.status === 'replied').length / messages.length) * 100)}%`
                  : '0%'} taxa de resposta
              </span>
            </div>
          </div>
        </div>

        {/* Charts Row */}
        <div className="charts-row">
          {/* Line Chart */}
          <div className="chart-card">
            <div className="chart-header">
              <h3>
                <i className="fas fa-chart-line"></i> Mensagens Mensais
              </h3>
              <span className="chart-subtitle">Últimos 6 meses</span>
            </div>
            <div className="chart-body">
              {isLoading ? (
                <div className="chart-loading">
                  <div className="spinner"></div>
                  <p>A carregar dados...</p>
                </div>
              ) : (
                <Line data={monthlyData} options={lineChartOptions} />
              )}
            </div>
          </div>

          {/* Doughnut Chart */}
          <div className="chart-card">
            <div className="chart-header">
              <h3>
                <i className="fas fa-chart-pie"></i> Distribuição por Status
              </h3>
              <span className="chart-subtitle">Mensagens atuais</span>
            </div>
            <div className="chart-body">
              {isLoading ? (
                <div className="chart-loading">
                  <div className="spinner"></div>
                  <p>A carregar dados...</p>
                </div>
              ) : messages.length === 0 ? (
                <div className="chart-empty">
                  <i className="fas fa-inbox"></i>
                  <p>Sem dados para mostrar</p>
                </div>
              ) : (
                <Doughnut data={statusData} options={doughnutChartOptions} />
              )}
            </div>
          </div>
        </div>

        {/* Quick Actions */}
        <div className="quick-actions">
          <h3>
            <i className="fas fa-bolt"></i> Ações Rápidas
          </h3>
          <div className="actions-grid">
            <a href="/clients" className="action-card">
              <div className="action-icon">
                <i className="fas fa-user-plus"></i>
              </div>
              <div className="action-content">
                <h4>Adicionar Cliente</h4>
                <p>Criar novo registo de cliente</p>
              </div>
            </a>

            <a href="/messages" className="action-card">
              <div className="action-icon">
                <i className="fas fa-envelope-open"></i>
              </div>
              <div className="action-content">
                <h4>Ver Mensagens</h4>
                <p>Gerir mensagens de clientes</p>
              </div>
            </a>

            <a href="/clients" className="action-card">
              <div className="action-icon">
                <i className="fas fa-search"></i>
              </div>
              <div className="action-content">
                <h4>Pesquisar Clientes</h4>
                <p>Encontrar informações de clientes</p>
              </div>
            </a>

            <a href="/dashboard" className="action-card">
              <div className="action-icon">
                <i className="fas fa-file-download"></i>
              </div>
              <div className="action-content">
                <h4>Exportar Relatório</h4>
                <p>Gerar relatórios em PDF</p>
              </div>
            </a>
          </div>
        </div>

        {/* Recent Activity */}
        {messageStats && messageStats.byAgent && messageStats.byAgent.length > 0 && (
          <div className="activity-card">
            <div className="activity-header">
              <h3>
                <i className="fas fa-users-cog"></i> Atividade por Agente
              </h3>
            </div>
            <div className="activity-body">
              <div className="activity-table">
                <table>
                  <thead>
                    <tr>
                      <th>Agente</th>
                      <th>Total</th>
                      <th>Novas</th>
                      <th>Em Progresso</th>
                      <th>Respondidas</th>
                    </tr>
                  </thead>
                  <tbody>
                    {messageStats.byAgent.map((agent) => (
                      <tr key={agent.agentId}>
                        <td>
                          <div className="agent-info">
                            <div className="agent-avatar">
                              <i className="fas fa-user"></i>
                            </div>
                            <span>{agent.agentName}</span>
                          </div>
                        </td>
                        <td><strong>{agent.total}</strong></td>
                        <td>
                          <span className="badge badge-primary">{agent.new}</span>
                        </td>
                        <td>
                          <span className="badge badge-warning">{agent.inProgress}</span>
                        </td>
                        <td>
                          <span className="badge badge-success">{agent.replied}</span>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        )}
      </div>
    </MainLayout>
  );
}
