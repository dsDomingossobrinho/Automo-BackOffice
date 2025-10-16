import { useState } from 'react';
import MainLayout from '../../components/layout/MainLayout';
// import CreateAccountModal from '../../components/modals/CreateAccountModal';
// import ViewAccountModal from '../../components/modals/ViewAccountModal';
// import EditAccountModal from '../../components/modals/EditAccountModal';
// import DeleteAccountModal from '../../components/modals/DeleteAccountModal';
import Toast from '../../components/common/Toast';
import { useAdmins, useAdminStatistics } from '../../hooks/useAdmins';
import type { AdminFilters } from '../../types/admin';

/**
 * Accounts Page Component
 * Admin management system for BackOffice
 */
export default function AccountsPage() {
  // Filters state
  const [filters, setFilters] = useState<AdminFilters>({
    search: '',
    stateId: undefined,
  });
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);

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
  const queryFilters = {
    search: filters.search || undefined,
    page: page,
    size: pageSize,
    sortBy: 'id' as const,
    sortDirection: 'ASC' as const,
  };
  const { data: adminsData, isLoading, isError } = useAdmins(queryFilters);
  const admins = adminsData?.content || [];
  const { data: statistics } = useAdminStatistics();

  // Handle filter changes
  const handleFilterChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFilters((prev) => ({ ...prev, [name]: value || undefined }));
  };

  // Clear filters
  const handleClearFilters = () => {
    setFilters({
      search: '',
      stateId: undefined,
    });
    setPage(0);
  };

  // Placeholder handlers - TODO: Implement modal functionality
  const handleViewAdmin = () => { };
  const handleEditAdmin = () => { };
  const handleDeleteAdmin = () => { };
  const handleCreateAdmin = () => { };

  // Get status badge
  const getStateBadge = (state: string) => {
    const badges: Record<string, { class: string; label: string }> = {
      Ativo: { class: 'badge-success', label: 'Ativo' },
      Inativo: { class: 'badge-secondary', label: 'Inativo' },
      Eliminado: { class: 'badge-danger', label: 'Eliminado' },
    };
    const badge = badges[state] || { class: 'badge-secondary', label: state };
    return <span className={`badge ${badge.class}`}>{badge.label}</span>;
  };

  return (
    <MainLayout>
      <div className="page-container">
        {/* Page Header */}
        <div className="page-header">
          <div>
            <h1>
              <i className="fas fa-users-cog"></i> Contas & Permissões
            </h1>
            <p className="page-subtitle">Gestão de contas de utilizadores e permissões</p>
          </div>
        </div>

        {/* Primary Action Button */}
        <div className="page-actions">
          <button className="btn btn-primary" onClick={handleCreateAdmin}>
            <i className="fas fa-plus"></i>
            <span>Novo Admin</span>
          </button>
        </div>

        {/* Stats Cards */}
        <div className="stats-cards">
          <div className="stat-card stat-card-primary">
            <div className="stat-icon">
              <i className="fas fa-users"></i>
            </div>
            <div className="stat-content">
              <h3>{statistics?.totalAdmins || 0}</h3>
              <p>Total Administradores</p>
            </div>
          </div>

          <div className="stat-card stat-card-success">
            <div className="stat-icon">
              <i className="fas fa-user-check"></i>
            </div>
            <div className="stat-content">
              <h3>{statistics?.activeAdmins || 0}</h3>
              <p>Ativos</p>
            </div>
          </div>

          <div className="stat-card stat-card-secondary">
            <div className="stat-icon">
              <i className="fas fa-user-slash"></i>
            </div>
            <div className="stat-content">
              <h3>{statistics?.inactiveAdmins || 0}</h3>
              <p>Inativos</p>
            </div>
          </div>

          <div className="stat-card stat-card-danger">
            <div className="stat-icon">
              <i className="fas fa-user-times"></i>
            </div>
            <div className="stat-content">
              <h3>{statistics?.eliminatedAdmins || 0}</h3>
              <p>Eliminados</p>
            </div>
          </div>
        </div>

        {/* Filters Section */}
        <div className="filters-section">
          <div className="filters-row">
            <div className="filter-group">
              <label htmlFor="search" className="filter-label">
                <i className="fas fa-search"></i> Pesquisar
              </label>
              <input
                type="text"
                id="search"
                name="search"
                value={filters.search}
                onChange={handleFilterChange}
                placeholder="Nome, email..."
                className="form-control"
              />
            </div>

            <button className="btn btn-secondary" onClick={handleClearFilters}>
              <i className="fas fa-redo"></i> Limpar
            </button>
          </div>
        </div>

        {/* Data Table Section */}
        <div className="table-section">
          <div className="table-card">
            {/* Loading State */}
            {isLoading && (
              <div className="table-loading">
                <div className="spinner"></div>
                <p>A carregar contas...</p>
              </div>
            )}

            {/* Error State */}
            {isError && (
              <div className="table-error">
                <i className="fas fa-exclamation-circle"></i>
                <p>Erro ao carregar contas. Tente novamente.</p>
              </div>
            )}

            {/* Empty State */}
            {!isLoading && !isError && admins.length === 0 && (
              <div className="table-empty">
                <i className="fas fa-users"></i>
                <p>Nenhum administrador encontrado</p>
                <button className="btn btn-primary" onClick={handleCreateAdmin}>
                  <i className="fas fa-plus"></i> Adicionar primeiro administrador
                </button>
              </div>
            )}

            {/* Data Table */}
            {!isLoading && !isError && admins.length > 0 && (
              <div className="table-responsive">
                <table className="data-table">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Username</th>
                      <th>Estado</th>
                      <th className="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {admins.map((admin) => (
                      <tr key={admin.id}>
                        <td>
                          <div className="table-user">
                            <div className="table-user-avatar">
                              {admin.img ? (
                                <img src={admin.img} alt={admin.name} />
                              ) : (
                                <i className="fas fa-user"></i>
                              )}
                            </div>
                            <span className="table-user-name">{admin.name}</span>
                          </div>
                        </td>
                        <td>{admin.email}</td>
                        <td>@{admin.username || 'N/A'}</td>
                        <td>{getStateBadge(admin.state || 'N/A')}</td>
                        <td className="text-center">
                          <div className="table-actions">
                            <button
                              className="btn-icon btn-icon-primary"
                              onClick={handleViewAdmin}
                              title="Ver detalhes"
                            >
                              <i className="fas fa-eye"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-warning"
                              onClick={handleEditAdmin}
                              title="Editar"
                            >
                              <i className="fas fa-edit"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-danger"
                              onClick={handleDeleteAdmin}
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

        {/* Pagination */}
        {!isLoading && !isError && admins.length > 0 && (
          <div className="table-pagination">
            <div className="pagination-info">
              Mostrando <strong>{(page * pageSize) + 1}-{Math.min((page + 1) * pageSize, adminsData?.totalElements || 0)}</strong> de <strong>{adminsData?.totalElements || 0}</strong> administradores
            </div>
            <div className="pagination-controls">
              <button
                className="btn btn-sm btn-secondary"
                disabled={!adminsData?.hasPrevious}
                onClick={() => setPage(p => p - 1)}
              >
                <i className="fas fa-chevron-left"></i> Anterior
              </button>
              <span>Página {page + 1} de {adminsData?.totalPages || 1}</span>
              <button
                className="btn btn-sm btn-secondary"
                disabled={!adminsData?.hasNext}
                onClick={() => setPage(p => p + 1)}
              >
                Próximo <i className="fas fa-chevron-right"></i>
              </button>
            </div>
          </div>
        )}
      </div>

      {/* Modals - TODO: Atualizar para usar Admin em vez de Account */}
      {/* <CreateAccountModal
        isOpen={isCreateModalOpen}
        onClose={() => setIsCreateModalOpen(false)}
        onSuccess={(msg) => showToast(msg, 'success')}
        onError={(msg) => showToast(msg, 'error')}
      />

      <ViewAccountModal
        isOpen={isViewModalOpen}
        onClose={() => setIsViewModalOpen(false)}
        admin={selectedAdmin}
      />

      <EditAccountModal
        isOpen={isEditModalOpen}
        onClose={() => setIsEditModalOpen(false)}
        admin={selectedAdmin}
        onSuccess={(msg) => showToast(msg, 'success')}
        onError={(msg) => showToast(msg, 'error')}
      />

      <DeleteAccountModal
        isOpen={isDeleteModalOpen}
        onClose={() => setIsDeleteModalOpen(false)}
        admin={selectedAdmin}
        onSuccess={(msg) => showToast(msg, 'success')}
        onError={(msg) => showToast(msg, 'error')}
      /> */}

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
