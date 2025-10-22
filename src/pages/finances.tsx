import {
  Calendar,
  CalendarDays,
  CalendarRange,
  Coins,
  Download,
  Info,
  Loader2,
  Plus,
  Search,
  Tag,
  TrendingUp,
} from "lucide-react";
import { useCallback, useMemo, useState } from "react";
import { Line } from "react-chartjs-2";
import { toast } from "sonner";

import { DataTable } from "@/components/common/data-table";
import { TableFilters } from "@/components/common/table-filters";
import { createTransactionColumns } from "@/components/common/transaction-columns";
import CreateTransactionModal from "@/components/modals/CreateTransactionModal";
import DeleteTransactionModal from "@/components/modals/DeleteTransactionModal";
import EditTransactionModal from "@/components/modals/EditTransactionModal";
import ViewTransactionModal from "@/components/modals/ViewTransactionModal";
import { Button } from "@/components/ui/button";
import { DashboardCard } from "@/components/ui/dashboard-card";
import { useFinanceStatistics } from "@/hooks/useFinanceStatistics";
import {
  useExportTransactions,
  useFinanceSummary,
  useTransactions,
} from "@/hooks/useFinances";
import type { Transaction, TransactionFilters } from "@/types";

export default function FinancesPage() {
  // Filters state
  const [filters, setFilters] = useState<TransactionFilters>({
    search: "",
    type: undefined,
    category: undefined,
    status: undefined,
    dateFrom: "",
    dateTo: "",
  });

  // Modals state
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const [selectedTransaction, setSelectedTransaction] =
    useState<Transaction | null>(null);

  // React Query hooks
  const {
    data: transactions = [],
    isLoading,
    isError,
  } = useTransactions(filters);
  const { data: summary } = useFinanceSummary({
    dateFrom: filters.dateFrom,
    dateTo: filters.dateTo,
  });
  const { data: statistics, isLoading: loadingStatistics } =
    useFinanceStatistics({
      dateFrom: filters.dateFrom,
      dateTo: filters.dateTo,
    });
  const exportMutation = useExportTransactions();

  // Format currency
  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("pt-PT", {
      style: "currency",
      currency: "EUR",
    }).format(amount);
  };

  // Handle filter changes
  const handleFilterChange = (name: string, value: string | undefined) => {
    setFilters((prev) => ({ ...prev, [name]: value }));
  };

  // Clear filters
  const handleClearFilters = () => {
    setFilters({
      search: "",
      type: undefined,
      category: undefined,
      status: undefined,
      dateFrom: "",
      dateTo: "",
    });
  };

  // Handle view transaction
  const handleViewTransaction = useCallback((transaction: Transaction) => {
    setSelectedTransaction(transaction);
    setIsViewModalOpen(true);
  }, []);

  // Handle edit transaction
  const handleEditTransaction = useCallback((transaction: Transaction) => {
    setSelectedTransaction(transaction);
    setIsEditModalOpen(true);
  }, []);

  // Handle delete transaction
  const handleDeleteTransaction = useCallback((transaction: Transaction) => {
    setSelectedTransaction(transaction);
    setIsDeleteModalOpen(true);
  }, []);

  // Handle export
  const handleExport = async () => {
    try {
      await exportMutation.mutateAsync(filters);
      toast.success("Transações exportadas com sucesso!");
    } catch (error: unknown) {
      let message = "Erro ao exportar transações";
      if (error && typeof error === "object" && "message" in error) {
        message = (error as Error).message || message;
      } else if (typeof error === "string") {
        message = error;
      }
      toast.error(message);
    }
  };

  // Filter fields configuration - ATUALIZADO COM LUCIDE ICONS
  const filterFields = [
    {
      name: "search",
      label: "Pesquisar",
      type: "text" as const,
      placeholder: "Descrição, referência...",
      icon: Search,
    },
    {
      name: "type",
      label: "Tipo",
      type: "select" as const,
      icon: Tag,
      options: [
        { value: "income", label: "Receita" },
        { value: "expense", label: "Despesa" },
      ],
    },
    {
      name: "status",
      label: "Estado",
      type: "select" as const,
      icon: Info,
      options: [
        { value: "pending", label: "Pendente" },
        { value: "completed", label: "Completa" },
        { value: "cancelled", label: "Cancelada" },
        { value: "failed", label: "Falhada" },
      ],
    },
    {
      name: "dateFrom",
      label: "De",
      type: "text" as const,
      icon: Calendar,
    },
    {
      name: "dateTo",
      label: "Até",
      type: "text" as const,
      icon: Calendar,
    },
  ];

  // Create table columns
  const columns = useMemo(
    () =>
      createTransactionColumns({
        onView: handleViewTransaction,
        onEdit: handleEditTransaction,
        onDelete: handleDeleteTransaction,
      }),
    [handleViewTransaction, handleEditTransaction, handleDeleteTransaction],
  );

  // Prepare chart data
  const chartData = useMemo(() => {
    if (!summary?.byMonth) return null;

    const months = summary.byMonth.map((item) => item.month);
    const incomeData = summary.byMonth.map((item) => item.income);
    const expensesData = summary.byMonth.map((item) => item.expenses);

    return {
      labels: months,
      datasets: [
        {
          label: "Receitas",
          data: incomeData,
          borderColor: "rgb(16, 185, 129)",
          backgroundColor: "rgba(16, 185, 129, 0.1)",
          tension: 0.4,
        },
        {
          label: "Despesas",
          data: expensesData,
          borderColor: "rgb(239, 68, 68)",
          backgroundColor: "rgba(239, 68, 68, 0.1)",
          tension: 0.4,
        },
      ],
    };
  }, [summary]);

  const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: "top" as const,
      },
      title: {
        display: false,
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: (value: number | string) => {
            const num = typeof value === "number" ? value : Number(value);
            return "€" + num.toLocaleString();
          },
        },
      },
    },
  };

  return (
    <div className="space-y-5 xl:space-y-8">
      {/* 1. Page Header */}
      <section className="flex justify-between items-start">
        <article className="px-2 sm:px-0">
          <h1 className="text-2xl font-bold tracking-tight sm:text-3xl">
            Finanças
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Gestão financeira e transações
          </p>
        </article>

        <div className="flex flex-col xl:flex-row items-center gap-4">
          <p className="text-muted-foreground text-sm">
            {new Date().toLocaleDateString("pt-PT", {
              day: "2-digit",
              month: "long",
              year: "numeric",
            })}
          </p>
          {/* Primary Action Button */}
          <Button size="lg" onClick={() => setIsCreateModalOpen(true)}>
            <Plus className="h-4 w-4" />
            <span>Nova Transação</span>
          </Button>
        </div>
      </section>

      {/* 2. Statistics Cards */}
      <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <DashboardCard
          stat={{
            title: "Total Faturado",
            value: loadingStatistics
              ? "-"
              : formatCurrency(statistics?.totalIncome || 0),
            change: "+0%",
            changeType: "positive",
            icon: Coins,
            color: "text-blue-500",
            bgColor: "bg-blue-500/10",
          }}
          index={0}
          noProgressBar
          noTrending
        />
        <DashboardCard
          stat={{
            title: "Faturamento (6 meses)",
            value: loadingStatistics
              ? "-"
              : formatCurrency(statistics?.semestralIncome || 0),
            change: "+0%",
            changeType: "positive",
            icon: CalendarRange,
            color: "text-green-500",
            bgColor: "bg-green-500/10",
          }}
          index={1}
          noProgressBar
          noTrending
        />
        <DashboardCard
          stat={{
            title: "Faturamento (7 dias)",
            value: loadingStatistics
              ? "-"
              : formatCurrency(statistics?.weeklyIncome || 0),
            change: "+0%",
            changeType: "positive",
            icon: CalendarDays,
            color: "text-cyan-500",
            bgColor: "bg-cyan-500/10",
          }}
          index={2}
          noProgressBar
          noTrending
        />
        <DashboardCard
          stat={{
            title: "Faturamento (Hoje)",
            value: loadingStatistics
              ? "-"
              : formatCurrency(statistics?.dailyIncome || 0),
            change: "+0%",
            changeType: "positive",
            icon: Calendar,
            color: "text-orange-500",
            bgColor: "bg-orange-500/10",
          }}
          index={3}
          noProgressBar
          noTrending
        />
      </div>

      {/* 3. Chart Section */}
      {chartData && (
        <div className="rounded-lg border bg-card p-6">
          <h3 className="mb-4 flex items-center gap-2 text-lg font-semibold">
            <TrendingUp className="h-5 w-5" /> Receitas vs Despesas
          </h3>
          <div style={{ height: "300px" }}>
            <Line data={chartData} options={chartOptions} />
          </div>
        </div>
      )}

      {/* 4. Filters Section */}
      <TableFilters
        fields={filterFields}
        values={filters as Record<string, string | number | undefined>}
        onChange={handleFilterChange}
        onClear={handleClearFilters}
      />

      {/* Export Button */}
      <div className="flex justify-end">
        <Button
          variant="outline"
          onClick={handleExport}
          disabled={exportMutation.isPending}
        >
          {exportMutation.isPending ? (
            <>
              <Loader2 className="h-4 w-4 mr-2 animate-spin" /> A exportar...
            </>
          ) : (
            <>
              <Download className="h-4 w-4 mr-2" /> Exportar CSV
            </>
          )}
        </Button>
      </div>

      {/* 5. Data Table */}
      <DataTable
        data={transactions}
        columns={columns}
        isLoading={isLoading}
        isError={isError}
        errorMessage="Erro ao carregar transações"
        emptyMessage="Nenhuma transação encontrada"
      />

      {/* Modals */}
      <CreateTransactionModal
        isOpen={isCreateModalOpen}
        onClose={() => setIsCreateModalOpen(false)}
        onSuccess={(msg) => toast.success(msg)}
        onError={(msg) => toast.error(msg)}
      />

      <ViewTransactionModal
        isOpen={isViewModalOpen}
        onClose={() => setIsViewModalOpen(false)}
        transaction={selectedTransaction}
      />

      <EditTransactionModal
        isOpen={isEditModalOpen}
        onClose={() => setIsEditModalOpen(false)}
        transaction={selectedTransaction}
        onSuccess={(msg) => toast.success(msg)}
        onError={(msg) => toast.error(msg)}
      />

      <DeleteTransactionModal
        isOpen={isDeleteModalOpen}
        onClose={() => setIsDeleteModalOpen(false)}
        transaction={selectedTransaction}
        onSuccess={(msg) => toast.success(msg)}
        onError={(msg) => toast.error(msg)}
      />
    </div>
  );
}
