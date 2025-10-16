import { useState } from 'react';
import MainLayout from '../../components/layout/MainLayout';
import Modal from '../../components/modals/Modal';
import Toast from '../../components/common/Toast';
import ClientForm from '../../components/forms/ClientForm';
import { useClients, useCreateClient, useUpdateClient, useDeleteClient, useClientStatistics } from '../../hooks/useClients';
import type { Client, ClientStatus, CreateClientData } from '../../types';

/**
 * Clients Page Component
 * Complete CRUD management for clients
 * Following the 4-Level Page Architecture from PHP
 */
export default function ClientsPage() {
  // Modal states
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const [selectedClient, setSelectedClient] = useState<Client | null>(null);

  // Search and filter states
  const [searchTerm, setSearchTerm] = useState('');
  const [statusFilter, setStatusFilter] = useState<ClientStatus | 'all'>('all');
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

  // Fetch clients with filters
  const filters = {
    search: searchTerm || undefined,
    page: page,
    size: pageSize,
    sortBy: 'id' as const,
    sortDirection: 'ASC' as const,
  };
  const { data: clientsResponse, isLoading, isError, error } = useClients(filters);
  const clients = clientsResponse?.content || [];

  // Fetch client statistics
  const { data: statistics } = useClientStatistics();

  // Mutations
  const createMutation = useCreateClient();
  const updateMutation = useUpdateClient();
  const deleteMutation = useDeleteClient();

  // Modal handlers
  const handleViewClient = (client: Client) => {
    setSelectedClient(client);
    setIsViewModalOpen(true);
  };

  const handleEditClient = (client: Client) => {
    setSelectedClient(client);
    setIsEditModalOpen(true);
  };

  const handleDeleteClient = (client: Client) => {
    setSelectedClient(client);
    setIsDeleteModalOpen(true);
  };

  const confirmDeleteClient = async () => {
    if (!selectedClient) return;

    try {
      await deleteMutation.mutateAsync(selectedClient.id);
      setToast({
        isOpen: true,
        message: 'Cliente eliminado com sucesso!',
        type: 'success',
      });
      setIsDeleteModalOpen(false);
      setSelectedClient(null);
    } catch (err) {
      setToast({
        isOpen: true,
        message: 'Erro ao eliminar cliente. Tente novamente.',
        type: 'error',
      });
    }
  };

  const handleClearFilters = () => {
    setSearchTerm('');
    setStatusFilter('all');
    setPage(0);
  };

  const handleCreateClient = async (data: CreateClientData) => {
    try {
      await createMutation.mutateAsync(data);
      setToast({
        isOpen: true,
        message: 'Cliente criado com sucesso!',
        type: 'success',
      });
      setIsCreateModalOpen(false);
    } catch (err) {
      setToast({
        isOpen: true,
        message: 'Erro ao criar cliente. Tente novamente.',
        type: 'error',
      });
      throw err; // Re-throw to keep form in error state
    }
  };

  const handleUpdateClient = async (data: CreateClientData) => {
    if (!selectedClient) return;

    try {
      await updateMutation.mutateAsync({
        id: selectedClient.id,
        ...data
      });
      setToast({
        isOpen: true,
        message: 'Cliente atualizado com sucesso!',
        type: 'success',
      });
      setIsEditModalOpen(false);
      setSelectedClient(null);
    } catch (err) {
      setToast({
        isOpen: true,
        message: 'Erro ao atualizar cliente. Tente novamente.',
        type: 'error',
      });
      throw err;
    }
  };

  return (
    <MainLayout>
      <div className="page-container">
        {/* Page Header */}
        <div className="page-header">
          <div>
            <h1>
              <i className="fas fa-users"></i> Clientes
            </h1>
            <p className="page-subtitle">Gestão de clientes e contactos</p>
          </div>
        </div>

        {/* Primary Action Button */}
        <div className="page-actions">
          <button
            className="btn btn-primary"
            onClick={() => setIsCreateModalOpen(true)}
          >
            <i className="fas fa-plus"></i>
            <span>Novo Cliente</span>
          </button>
        </div>

        {/* Stats Cards */}
        <div className="stats-cards">
          <div className="stat-card stat-card-primary">
            <div className="stat-icon">
              <i className="fas fa-users"></i>
            </div>
            <div className="stat-content">
              <h3>{statistics?.totalUsers || 0}</h3>
              <p>Total Clientes</p>
            </div>
          </div>

          <div className="stat-card stat-card-success">
            <div className="stat-icon">
              <i className="fas fa-user-check"></i>
            </div>
            <div className="stat-content">
              <h3>{statistics?.activeUsers || 0}</h3>
              <p>Ativos</p>
            </div>
          </div>

          <div className="stat-card stat-card-warning">
            <div className="stat-icon">
              <i className="fas fa-user-slash"></i>
            </div>
            <div className="stat-content">
              <h3>{statistics?.inactiveUsers || 0}</h3>
              <p>Inativos</p>
            </div>
          </div>

          <div className="stat-card stat-card-danger">
            <div className="stat-icon">
              <i className="fas fa-user-times"></i>
            </div>
            <div className="stat-content">
              <h3>{statistics?.eliminatedUsers || 0}</h3>
              <p>Eliminados</p>
            </div>
          </div>
        </div>

        {/* Level 3: Filters Section */}
        <div className="filters-section">
          <div className="filters-row">
            <div className="filter-group">
              <label htmlFor="search" className="filter-label">
                <i className="fas fa-search"></i> Pesquisar
              </label>
              <input
                type="text"
                id="search"
                className="form-control"
                placeholder="Buscar por nome, email..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
            </div>

            <div className="filter-group">
              <label htmlFor="status" className="filter-label">
                <i className="fas fa-filter"></i> Status
              </label>
              <select
                id="status"
                className="form-control"
                value={statusFilter}
                onChange={(e) => setStatusFilter(e.target.value as ClientStatus | 'all')}
              >
                <option value="all">Todos</option>
                <option value="active">Ativo</option>
                <option value="inactive">Inativo</option>
                <option value="pending">Pendente</option>
                <option value="blocked">Bloqueado</option>
              </select>
            </div>

            <button className="btn btn-secondary" onClick={handleClearFilters}>
              <i className="fas fa-redo"></i> Limpar
            </button>
          </div>
        </div>

        {/* Level 4: Data Table Section */}
        <div className="table-section">
          <div className="table-card">
            {/* Loading State */}
            {isLoading && (
              <div className="table-loading">
                <div className="spinner"></div>
                <p>A carregar clientes...</p>
              </div>
            )}

            {/* Error State */}
            {isError && (
              <div className="table-error">
                <i className="fas fa-exclamation-circle"></i>
                <p>Erro ao carregar clientes: {error?.message}</p>
                <button className="btn btn-primary" onClick={() => window.location.reload()}>
                  Tentar novamente
                </button>
              </div>
            )}

            {/* Empty State */}
            {!isLoading && !isError && clients.length === 0 && (
              <div className="table-empty">
                <i className="fas fa-users"></i>
                <p>Nenhum cliente encontrado</p>
                <button className="btn btn-primary" onClick={() => setIsCreateModalOpen(true)}>
                  <i className="fas fa-plus"></i> Adicionar primeiro cliente
                </button>
              </div>
            )}

            {/* Data Table */}
            {!isLoading && !isError && clients.length > 0 && (
              <div className="table-responsive">
                <table className="data-table">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>País</th>
                      <th>Organização</th>
                      <th>Estado</th>
                      <th>Data de Criação</th>
                      <th className="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {clients.map((client) => (
                      <tr key={client.id}>
                        <td>
                          <div className="table-user">
                            <div className="table-user-avatar">
                              {client.img ? (
                                <img src={client.img} alt={client.name} />
                              ) : (
                                <i className="fas fa-user"></i>
                              )}
                            </div>
                            <span className="table-user-name">{client.name}</span>
                          </div>
                        </td>
                        <td>{client.email}</td>
                        <td>{client.countryName || '-'}</td>
                        <td>{client.organizationTypeName || '-'}</td>
                        <td>
                          <span className={`badge ${client.stateId === 1 ? 'badge-success' : 'badge-secondary'}`}>
                            {client.stateName || 'N/A'}
                          </span>
                        </td>
                        <td>{client.createdAt ? new Date(client.createdAt).toLocaleDateString('pt-PT') : '-'}</td>
                        <td>
                          <div className="table-actions">
                            <button
                              className="btn-icon btn-icon-primary"
                              onClick={() => handleViewClient(client)}
                              title="Ver detalhes"
                            >
                              <i className="fas fa-eye"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-warning"
                              onClick={() => handleEditClient(client)}
                              title="Editar"
                            >
                              <i className="fas fa-edit"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-danger"
                              onClick={() => handleDeleteClient(client)}
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

            {/* Pagination */}
            {!isLoading && !isError && clients.length > 0 && (
              <div className="table-pagination">
                <div className="pagination-info">
                  Mostrando <strong>{(page * pageSize) + 1}-{Math.min((page + 1) * pageSize, clientsResponse?.totalElements || 0)}</strong> de <strong>{clientsResponse?.totalElements || 0}</strong> clientes
                </div>
                <div className="pagination-controls">
                  <button
                    className="btn btn-sm btn-secondary"
                    disabled={!clientsResponse?.hasPrevious}
                    onClick={() => setPage(p => p - 1)}
                  >
                    <i className="fas fa-chevron-left"></i> Anterior
                  </button>
                  <span>Página {page + 1} de {clientsResponse?.totalPages || 1}</span>
                  <button
                    className="btn btn-sm btn-secondary"
                    disabled={!clientsResponse?.hasNext}
                    onClick={() => setPage(p => p + 1)}
                  >
                    Próximo <i className="fas fa-chevron-right"></i>
                  </button>
                </div>
              </div>
            )}
          </div>
        </div>

        {/* Modals */}
        {/* Create Client Modal */}
        <Modal
          isOpen={isCreateModalOpen}
          onClose={() => !createMutation.isPending && setIsCreateModalOpen(false)}
          title="Adicionar Cliente"
          size="large"
        >
          <ClientForm
            mode="create"
            onSubmit={handleCreateClient}
            onCancel={() => setIsCreateModalOpen(false)}
            isSubmitting={createMutation.isPending}
          />
        </Modal>

        {/* View Client Modal */}
        <Modal
          isOpen={isViewModalOpen}
          onClose={() => setIsViewModalOpen(false)}
          title="Detalhes do Cliente"
          size="medium"
        >
          {selectedClient && (
            <div className="modal-content-view">
              <div className="view-section">
                <h3>Informações Básicas</h3>
                <div className="view-grid">
                  <div className="view-item">
                    <label>Nome:</label>
                    <span>{selectedClient.name}</span>
                  </div>
                  <div className="view-item">
                    <label>Email:</label>
                    <span>{selectedClient.email}</span>
                  </div>
                  <div className="view-item">
                    <label>País:</label>
                    <span>{selectedClient.countryName || '-'}</span>
                  </div>
                  <div className="view-item">
                    <label>Província:</label>
                    <span>{selectedClient.provinceName || '-'}</span>
                  </div>
                  <div className="view-item">
                    <label>Organização:</label>
                    <span>{selectedClient.organizationTypeName || '-'}</span>
                  </div>
                  <div className="view-item">
                    <label>Estado:</label>
                    <span className={`badge ${selectedClient.stateId === 1 ? 'badge-success' : 'badge-secondary'}`}>
                      {selectedClient.stateName || 'N/A'}
                    </span>
                  </div>
                  <div className="view-item">
                    <label>Criado em:</label>
                    <span>{selectedClient.createdAt ? new Date(selectedClient.createdAt).toLocaleDateString('pt-PT') : '-'}</span>
                  </div>
                </div>
              </div>
            </div>
          )}
        </Modal>

        {/* Edit Client Modal */}
        <Modal
          isOpen={isEditModalOpen}
          onClose={() => !updateMutation.isPending && setIsEditModalOpen(false)}
          title="Editar Cliente"
          size="large"
        >
          {selectedClient && (
            <ClientForm
              mode="edit"
              initialData={selectedClient}
              onSubmit={handleUpdateClient}
              onCancel={() => setIsEditModalOpen(false)}
              isSubmitting={updateMutation.isPending}
            />
          )}
        </Modal>

        {/* Delete Client Modal */}
        <Modal
          isOpen={isDeleteModalOpen}
          onClose={() => setIsDeleteModalOpen(false)}
          title="Eliminar Cliente"
          size="small"
        >
          {selectedClient && (
            <div className="modal-content-delete">
              <div className="delete-warning">
                <i className="fas fa-exclamation-triangle"></i>
                <p>
                  Tem certeza que deseja eliminar o cliente{' '}
                  <strong>{selectedClient.name}</strong>?
                </p>
                <p className="text-muted">Esta ação não pode ser desfeita.</p>
              </div>
              <div className="modal-actions">
                <button
                  className="btn btn-secondary"
                  onClick={() => setIsDeleteModalOpen(false)}
                  disabled={deleteMutation.isPending}
                >
                  Cancelar
                </button>
                <button
                  className="btn btn-danger"
                  onClick={confirmDeleteClient}
                  disabled={deleteMutation.isPending}
                >
                  {deleteMutation.isPending ? (
                    <>
                      <span className="spinner-small"></span> A eliminar...
                    </>
                  ) : (
                    <>
                      <i className="fas fa-trash"></i> Eliminar
                    </>
                  )}
                </button>
              </div>
            </div>
          )}
        </Modal>

        {/* Toast Notifications */}
        <Toast
          isOpen={toast.isOpen}
          message={toast.message}
          type={toast.type}
          onClose={() => setToast({ ...toast, isOpen: false })}
        />
      </div>
    </MainLayout>
  );
}
