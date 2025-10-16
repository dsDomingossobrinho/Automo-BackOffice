import { useState } from 'react';
import MainLayout from '../../components/layout/MainLayout';
import CreateInvoiceModal from '../../components/modals/CreateInvoiceModal';
import ViewInvoiceModal from '../../components/modals/ViewInvoiceModal';
import EditInvoiceModal from '../../components/modals/EditInvoiceModal';
import DeleteInvoiceModal from '../../components/modals/DeleteInvoiceModal';
import Toast from '../../components/common/Toast';
import { useDownloadInvoicePdf, useInvoices, useInvoiceSummary, useSendInvoice } from '../../hooks/useInvoices';
import type { Invoice, InvoiceFilters } from '../../types';

/**
 * Invoices Page Component
 * Complete invoice management system with CRUD operations
 */
export default function InvoicesPage() {
  // Filters state
  const [filters, setFilters] = useState<InvoiceFilters>({
    search: '',
    status: undefined,
    dateFrom: '',
    dateTo: '',
  });

  // Modals state
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const [selectedInvoice, setSelectedInvoice] = useState<Invoice | null>(null);

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
  const { data: invoices = [], isLoading, isError } = useInvoices(filters);
  const { data: summary } = useInvoiceSummary({
    dateFrom: filters.dateFrom,
    dateTo: filters.dateTo,
  });
  const sendMutation = useSendInvoice();
  const downloadPDFMutation = useDownloadInvoicePdf();

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
      status: undefined,
      dateFrom: '',
      dateTo: '',
    });
  };

  // Handle view invoice
  const handleViewInvoice = (invoice: Invoice) => {
    setSelectedInvoice(invoice);
    setIsViewModalOpen(true);
  };

  // Handle edit invoice
  const handleEditInvoice = (invoice: Invoice) => {
    setSelectedInvoice(invoice);
    setIsEditModalOpen(true);
  };

  // Handle delete invoice
  const handleDeleteInvoice = (invoice: Invoice) => {
    setSelectedInvoice(invoice);
    setIsDeleteModalOpen(true);
  };

  // Handle send invoice
  const handleSendInvoice = async (invoice: Invoice) => {
    try {
      await sendMutation.mutateAsync(invoice.id);
      showToast('Fatura enviada com sucesso!', 'success');
    } catch (error: any) {
      showToast(error.message || 'Erro ao enviar fatura', 'error');
    }
  };

  // Handle download PDF
  const handleDownloadPDF = async (invoice: Invoice) => {
    try {
      await downloadPDFMutation.mutateAsync(invoice.id);
      showToast('PDF descarregado com sucesso!', 'success');
    } catch (error: any) {
      showToast(error.message || 'Erro ao descarregar PDF', 'error');
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
      draft: { class: 'badge-secondary', label: 'Rascunho' },
      sent: { class: 'badge-info', label: 'Enviada' },
      paid: { class: 'badge-success', label: 'Paga' },
      overdue: { class: 'badge-danger', label: 'Atrasada' },
      cancelled: { class: 'badge-error', label: 'Cancelada' },
    };
    const badge = badges[status] || { class: 'badge-secondary', label: status };
    return <span className={`badge ${badge.class}`}>{badge.label}</span>;
  };

  return (
    <MainLayout>
      <div className="page-container">
        {/* Page Header */}
        <div className="page-header">
          <div>
            <h1>
              <i className="fas fa-file-invoice"></i> Faturas
            </h1>
            <p className="page-subtitle">Gestão de faturas e pagamentos</p>
          </div>
        </div>

        {/* Primary Action Button */}
        <div className="page-actions">
          <button className="btn btn-primary btn-icon" onClick={() => setIsCreateModalOpen(true)}>
            <i className="fas fa-plus"></i>
            <span>Nova Fatura</span>
          </button>
        </div>

        {/* Stats Cards */}
        <div className="stats-cards">
          <div className="stat-card stat-card-primary">
            <div className="stat-icon">
              <i className="fas fa-file-invoice-dollar"></i>
            </div>
            <div className="stat-content">
              <h3>{summary?.totalInvoices || 0}</h3>
              <p>Total Faturas</p>
            </div>
          </div>

          <div className="stat-card stat-card-success">
            <div className="stat-icon">
              <i className="fas fa-check-circle"></i>
            </div>
            <div className="stat-content">
              <h3>{formatCurrency(summary?.paidAmount || 0)}</h3>
              <p>Pagas</p>
            </div>
          </div>

          <div className="stat-card stat-card-warning">
            <div className="stat-icon">
              <i className="fas fa-hourglass-half"></i>
            </div>
            <div className="stat-content">
              <h3>{formatCurrency(summary?.pendingAmount || 0)}</h3>
              <p>Pendentes</p>
            </div>
          </div>

          <div className="stat-card stat-card-danger">
            <div className="stat-icon">
              <i className="fas fa-exclamation-triangle"></i>
            </div>
            <div className="stat-content">
              <h3>{formatCurrency(summary?.overdueAmount || 0)}</h3>
              <p>Vencidas</p>
            </div>
          </div>
        </div>

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
                  placeholder="Nº fatura, cliente..."
                  className="form-control"
                />
              </div>

              {/* Status */}
              <div className="filter-group">
                <label htmlFor="status">
                  <i className="fas fa-info-circle"></i> Estado
                </label>
                <select id="status" name="status" value={filters.status || ''} onChange={handleFilterChange} className="form-control">
                  <option value="">Todos</option>
                  <option value="draft">Rascunho</option>
                  <option value="sent">Enviada</option>
                  <option value="paid">Paga</option>
                  <option value="overdue">Atrasada</option>
                  <option value="cancelled">Cancelada</option>
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
                <p>A carregar faturas...</p>
              </div>
            )}

            {/* Error State */}
            {isError && (
              <div className="table-error">
                <i className="fas fa-exclamation-triangle"></i>
                <h3>Erro ao carregar faturas</h3>
                <p>Não foi possível carregar os dados. Por favor, tente novamente.</p>
              </div>
            )}

            {/* Empty State */}
            {!isLoading && !isError && invoices.length === 0 && (
              <div className="table-empty">
                <i className="fas fa-file-invoice"></i>
                <h3>Nenhuma fatura encontrada</h3>
                <p>Comece por criar uma nova fatura.</p>
                <button className="btn btn-primary" onClick={() => setIsCreateModalOpen(true)}>
                  <i className="fas fa-plus"></i> Nova Fatura
                </button>
              </div>
            )}

            {/* Data Table */}
            {!isLoading && !isError && invoices.length > 0 && (
              <div className="table-responsive">
                <table className="table">
                  <thead>
                    <tr>
                      <th>Nº Fatura</th>
                      <th>Cliente</th>
                      <th>Data Emissão</th>
                      <th>Vencimento</th>
                      <th>Total</th>
                      <th>Estado</th>
                      <th className="text-right">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {invoices.map((invoice) => (
                      <tr key={invoice.id}>
                        <td>
                          <strong>#{invoice.invoiceNumber}</strong>
                        </td>
                        <td>{invoice.clientName || invoice.clientId}</td>
                        <td>{formatDate(invoice.issueDate)}</td>
                        <td>{formatDate(invoice.dueDate)}</td>
                        <td>
                          <strong>{formatCurrency(invoice.total)}</strong>
                        </td>
                        <td>{getStatusBadge(invoice.status)}</td>
                        <td className="text-right">
                          <div className="table-actions">
                            <button
                              className="btn-icon btn-icon-primary"
                              onClick={() => handleViewInvoice(invoice)}
                              title="Ver detalhes"
                            >
                              <i className="fas fa-eye"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-secondary"
                              onClick={() => handleEditInvoice(invoice)}
                              title="Editar"
                              disabled={invoice.status === 'paid' || invoice.status === 'cancelled'}
                            >
                              <i className="fas fa-edit"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-info"
                              onClick={() => handleSendInvoice(invoice)}
                              title="Enviar"
                              disabled={invoice.status === 'paid' || invoice.status === 'cancelled' || sendMutation.isPending}
                            >
                              <i className="fas fa-paper-plane"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-success"
                              onClick={() => handleDownloadPDF(invoice)}
                              title="Download PDF"
                              disabled={downloadPDFMutation.isPending}
                            >
                              <i className="fas fa-file-pdf"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-danger"
                              onClick={() => handleDeleteInvoice(invoice)}
                              title="Eliminar"
                              disabled={invoice.status === 'paid'}
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
      <CreateInvoiceModal
        isOpen={isCreateModalOpen}
        onClose={() => setIsCreateModalOpen(false)}
        onSuccess={(msg) => showToast(msg, 'success')}
        onError={(msg) => showToast(msg, 'error')}
      />

      <ViewInvoiceModal
        isOpen={isViewModalOpen}
        onClose={() => setIsViewModalOpen(false)}
        invoice={selectedInvoice}
      />

      <EditInvoiceModal
        isOpen={isEditModalOpen}
        onClose={() => setIsEditModalOpen(false)}
        invoice={selectedInvoice}
        onSuccess={(msg) => showToast(msg, 'success')}
        onError={(msg) => showToast(msg, 'error')}
      />

      <DeleteInvoiceModal
        isOpen={isDeleteModalOpen}
        onClose={() => setIsDeleteModalOpen(false)}
        invoice={selectedInvoice}
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
