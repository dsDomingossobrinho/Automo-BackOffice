import { useState, useMemo } from 'react';
import { Line } from 'react-chartjs-2';
import MainLayout from '../../components/layout/MainLayout';
import CreateTransactionModal from '../../components/modals/CreateTransactionModal';
import ViewTransactionModal from '../../components/modals/ViewTransactionModal';
import EditTransactionModal from '../../components/modals/EditTransactionModal';
import DeleteTransactionModal from '../../components/modals/DeleteTransactionModal';
import Toast from '../../components/common/Toast';
import { useTransactions, useFinanceSummary, useExportTransactions } from '../../hooks/useFinances';
import type { Transaction, TransactionFilters } from '../../types';

/**
 * Finances Page Component
 * Complete financial management with CRUD operations
 */
export default function FinancesPage() {
  // Filters state
  const [filters, setFilters] = useState<TransactionFilters>({
    search: '',
    type: undefined,
    category: undefined,
    status: undefined,
    dateFrom: '',
    dateTo: '',
  });

  // Modals state
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const [selectedTransaction, setSelectedTransaction] = useState<Transaction | null>(null);

  // Toast state
  const [toast, setToast] = useState<{
    isOpen: boolean;
    message: string;
    type: 'success' | 'error' | 'warning' | 'info';
  }>({
    isOpen: false,
    message: '',
    type: 'info',
  });

  // Fetch data
  const { data: transactions = [], isLoading, isError } = useTransactions(filters);
  const { data: summary } = useFinanceSummary({
    dateFrom: filters.dateFrom,
    dateTo: filters.dateTo,
  });
  const exportMutation = useExportTransactions();

  // Show toast helper
  const showToast = (message: string, type: 'success' | 'error' | 'warning' | 'info' = 'info') => {
    setToast({ isOpen: true, message, type });
  };

  // Handle filter changes
  const handleFilterChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFilters((prev) => ({ ...prev, [name]: value || undefined }));
  };

  // Clear filters
  const handleClearFilters = () => {
    setFilters({
      search: '',
      type: undefined,
      category: undefined,
      status: undefined,
      dateFrom: '',
      dateTo: '',
    });
  };

  // Handle view transaction
  const handleViewTransaction = (transaction: Transaction) => {
    setSelectedTransaction(transaction);
    setIsViewModalOpen(true);
  };

  // Handle edit transaction
  const handleEditTransaction = (transaction: Transaction) => {
    setSelectedTransaction(transaction);
    setIsEditModalOpen(true);
  };

  // Handle delete transaction
  const handleDeleteTransaction = (transaction: Transaction) => {
    setSelectedTransaction(transaction);
    setIsDeleteModalOpen(true);
  };

  // Handle export
  const handleExport = async () => {
    try {
      await exportMutation.mutateAsync(filters);
      showToast('Transações exportadas com sucesso!', 'success');
    } catch (error: any) {
      showToast(error.message || 'Erro ao exportar transações', 'error');
    }
  };

  // Format currency
  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('pt-PT', {
      style: 'currency',
      currency: 'EUR',
    }).format(amount);
  };

  // Format date
  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('pt-PT');
  };

  // Get status badge
  const getStatusBadge = (status: string) => {
    const badges: Record<string, { class: string; label: string }> = {
      pending: { class: 'badge-warning', label: 'Pendente' },
      completed: { class: 'badge-success', label: 'Completa' },
      cancelled: { class: 'badge-danger', label: 'Cancelada' },
      failed: { class: 'badge-error', label: 'Falhada' },
    };
    const badge = badges[status] || { class: 'badge-secondary', label: status };
    return <span className={`badge ${badge.class}`}>{badge.label}</span>;
  };

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
          label: 'Receitas',
          data: incomeData,
          borderColor: 'rgb(16, 185, 129)',
          backgroundColor: 'rgba(16, 185, 129, 0.1)',
          tension: 0.4,
        },
        {
          label: 'Despesas',
          data: expensesData,
          borderColor: 'rgb(239, 68, 68)',
          backgroundColor: 'rgba(239, 68, 68, 0.1)',
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
        position: 'top' as const,
      },
      title: {
        display: false,
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function (value: any) {
            return '€' + value.toLocaleString();
          },
        },
      },
    },
  };

  return (
    <MainLayout>
      <div className="page-container">
        {/* Page Header */}
        <div className="page-header">
          <div>
            <h1>
              <i className="fas fa-chart-line"></i> Finanças
            </h1>
            <p className="page-subtitle">Gestão financeira e transações</p>
          </div>
        </div>

        {/* Primary Action Button */}
        <div className="page-actions">
          <button className="btn btn-primary btn-icon" onClick={() => setIsCreateModalOpen(true)}>
            <i className="fas fa-plus"></i>
            <span>Nova Transação</span>
          </button>
        </div>

        {/* Stats Cards */}
        <div className="stats-cards">
          <div className="stat-card stat-card-success">
            <div className="stat-icon">
              <i className="fas fa-arrow-up"></i>
            </div>
            <div className="stat-content">
              <h3>{formatCurrency(summary?.totalIncome || 0)}</h3>
              <p>Receitas</p>
            </div>
          </div>

          <div className="stat-card stat-card-danger">
            <div className="stat-icon">
              <i className="fas fa-arrow-down"></i>
            </div>
            <div className="stat-content">
              <h3>{formatCurrency(summary?.totalExpenses || 0)}</h3>
              <p>Despesas</p>
            </div>
          </div>

          <div className="stat-card stat-card-primary">
            <div className="stat-icon">
              <i className="fas fa-wallet"></i>
            </div>
            <div className="stat-content">
              <h3>{formatCurrency(summary?.netProfit || 0)}</h3>
              <p>Lucro Líquido</p>
            </div>
          </div>

          <div className="stat-card stat-card-warning">
            <div className="stat-icon">
              <i className="fas fa-clock"></i>
            </div>
            <div className="stat-content">
              <h3>{summary?.pendingTransactions || 0}</h3>
              <p>Pendentes</p>
            </div>
          </div>
        </div>

        {/* Chart Section */}
        {chartData && (
          <div className="chart-section">
            <div className="chart-card">
              <h3>
                <i className="fas fa-chart-line"></i> Receitas vs Despesas
              </h3>
              <div className="chart-container" style={{ height: '300px' }}>
                <Line data={chartData} options={chartOptions} />
              </div>
            </div>
          </div>
        )}

        {/* Filters Section */}
        <div className="filters-section">
          <div className="filters-card">
            <div className="filters-row">
              {/* Search */}
              <div className="filter-group">
                <label htmlFor="search">
                  <i className="fas fa-search"></i> Pesquisar
                </label>
                <input
                  type="text"
                  id="search"
                  name="search"
                  value={filters.search}
                  onChange={handleFilterChange}
                  placeholder="Descrição, referência..."
                  className="form-control"
                />
              </div>

              {/* Type */}
              <div className="filter-group">
                <label htmlFor="type">
                  <i className="fas fa-tag"></i> Tipo
                </label>
                <select id="type" name="type" value={filters.type || ''} onChange={handleFilterChange} className="form-control">
                  <option value="">Todos</option>
                  <option value="income">Receita</option>
                  <option value="expense">Despesa</option>
                </select>
              </div>

              {/* Status */}
              <div className="filter-group">
                <label htmlFor="status">
                  <i className="fas fa-info-circle"></i> Estado
                </label>
                <select id="status" name="status" value={filters.status || ''} onChange={handleFilterChange} className="form-control">
                  <option value="">Todos</option>
                  <option value="pending">Pendente</option>
                  <option value="completed">Completa</option>
                  <option value="cancelled">Cancelada</option>
                  <option value="failed">Falhada</option>
                </select>
              </div>

              {/* Date From */}
              <div className="filter-group">
                <label htmlFor="dateFrom">
                  <i className="fas fa-calendar"></i> De
                </label>
                <input
                  type="date"
                  id="dateFrom"
                  name="dateFrom"
                  value={filters.dateFrom || ''}
                  onChange={handleFilterChange}
                  className="form-control"
                />
              </div>

              {/* Date To */}
              <div className="filter-group">
                <label htmlFor="dateTo">
                  <i className="fas fa-calendar"></i> Até
                </label>
                <input
                  type="date"
                  id="dateTo"
                  name="dateTo"
                  value={filters.dateTo || ''}
                  onChange={handleFilterChange}
                  className="form-control"
                />
              </div>
            </div>

            {/* Filter Actions */}
            <div className="filters-actions">
              <button className="btn btn-secondary btn-sm" onClick={handleClearFilters}>
                <i className="fas fa-times"></i> Limpar Filtros
              </button>
              <button className="btn btn-primary btn-sm" onClick={handleExport} disabled={exportMutation.isPending}>
                {exportMutation.isPending ? (
                  <>
                    <i className="fas fa-spinner fa-spin"></i> A exportar...
                  </>
                ) : (
                  <>
                    <i className="fas fa-download"></i> Exportar CSV
                  </>
                )}
              </button>
            </div>
          </div>
        </div>

        {/* Data Table Section */}
        <div className="table-section">
          <div className="table-card">
            {/* Loading State */}
            {isLoading && (
              <div className="table-loading">
                <i className="fas fa-spinner fa-spin"></i>
                <p>A carregar transações...</p>
              </div>
            )}

            {/* Error State */}
            {isError && (
              <div className="table-error">
                <i className="fas fa-exclamation-triangle"></i>
                <h3>Erro ao carregar transações</h3>
                <p>Não foi possível carregar os dados. Por favor, tente novamente.</p>
              </div>
            )}

            {/* Empty State */}
            {!isLoading && !isError && transactions.length === 0 && (
              <div className="table-empty">
                <i className="fas fa-coins"></i>
                <h3>Nenhuma transação encontrada</h3>
                <p>Comece por criar uma nova transação.</p>
                <button className="btn btn-primary" onClick={() => setIsCreateModalOpen(true)}>
                  <i className="fas fa-plus"></i> Nova Transação
                </button>
              </div>
            )}

            {/* Data Table */}
            {!isLoading && !isError && transactions.length > 0 && (
              <div className="table-responsive">
                <table className="table">
                  <thead>
                    <tr>
                      <th>Data</th>
                      <th>Descrição</th>
                      <th>Tipo</th>
                      <th>Categoria</th>
                      <th>Valor</th>
                      <th>Estado</th>
                      <th>Método</th>
                      <th className="text-right">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {transactions.map((transaction) => (
                      <tr key={transaction.id}>
                        <td>{formatDate(transaction.date)}</td>
                        <td>
                          <strong>{transaction.description}</strong>
                          {transaction.reference && (
                            <span className="text-muted" style={{ display: 'block', fontSize: '0.85rem' }}>
                              Ref: {transaction.reference}
                            </span>
                          )}
                        </td>
                        <td>
                          <span className={`badge ${transaction.type === 'income' ? 'badge-success' : 'badge-danger'}`}>
                            {transaction.type === 'income' ? 'Receita' : 'Despesa'}
                          </span>
                        </td>
                        <td>{transaction.category}</td>
                        <td>
                          <span
                            style={{
                              color: transaction.type === 'income' ? '#10b981' : '#ef4444',
                              fontWeight: 'bold',
                            }}
                          >
                            {transaction.type === 'income' ? '+' : '-'} {formatCurrency(transaction.amount)}
                          </span>
                        </td>
                        <td>{getStatusBadge(transaction.status)}</td>
                        <td>{transaction.paymentMethod || '-'}</td>
                        <td className="text-right">
                          <div className="table-actions">
                            <button
                              className="btn-icon btn-icon-primary"
                              onClick={() => handleViewTransaction(transaction)}
                              title="Ver detalhes"
                            >
                              <i className="fas fa-eye"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-secondary"
                              onClick={() => handleEditTransaction(transaction)}
                              title="Editar"
                            >
                              <i className="fas fa-edit"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-danger"
                              onClick={() => handleDeleteTransaction(transaction)}
                              title="Eliminar"
                            >
                              <i className="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            )}
          </div>
        </div>
      </div>

      {/* Modals */}
      <CreateTransactionModal
        isOpen={isCreateModalOpen}
        onClose={() => setIsCreateModalOpen(false)}
        onSuccess={(msg) => showToast(msg, 'success')}
        onError={(msg) => showToast(msg, 'error')}
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
        onSuccess={(msg) => showToast(msg, 'success')}
        onError={(msg) => showToast(msg, 'error')}
      />

      <DeleteTransactionModal
        isOpen={isDeleteModalOpen}
        onClose={() => setIsDeleteModalOpen(false)}
        transaction={selectedTransaction}
        onSuccess={(msg) => showToast(msg, 'success')}
        onError={(msg) => showToast(msg, 'error')}
      />

      {/* Toast */}
      <Toast
        isOpen={toast.isOpen}
        message={toast.message}
        type={toast.type}
        onClose={() => setToast({ ...toast, isOpen: false })}
      />
    </MainLayout>
  );
}
