import { useState } from 'react';
import MainLayout from '../../components/layout/MainLayout';
import Modal from '../../components/modals/Modal';
import Toast from '../../components/common/Toast';
import {
  useMessages,
  useDeleteMessage,
  useMarkMessageRead,
} from '../../hooks/useMessages';
import type {
  Message,
  MessageStatus,
  MessagePriority,
  MessageChannel,
} from '../../types';

/**
 * Messages Page Component
 * Complete management for client messages
 * Following the 4-Level Page Architecture
 */
export default function MessagesPage() {
  // Modal states
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const [selectedMessage, setSelectedMessage] = useState<Message | null>(null);

  // Filter states
  const [searchTerm, setSearchTerm] = useState('');
  const [statusFilter, setStatusFilter] = useState<MessageStatus | 'all'>('all');
  const [priorityFilter, setPriorityFilter] = useState<MessagePriority | 'all'>('all');
  const [channelFilter, setChannelFilter] = useState<MessageChannel | 'all'>('all');

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

  // Fetch messages with filters
  const filters = {
    search: searchTerm || undefined,
    status: statusFilter !== 'all' ? statusFilter : undefined,
    priority: priorityFilter !== 'all' ? priorityFilter : undefined,
    channel: channelFilter !== 'all' ? channelFilter : undefined,
  };
  const { data: messages = [], isLoading, isError, error } = useMessages(filters);

  // Mutations
  const deleteMutation = useDeleteMessage();
  const markReadMutation = useMarkMessageRead();

  // Handlers
  const handleViewMessage = async (message: Message) => {
    setSelectedMessage(message);
    setIsViewModalOpen(true);

    // Mark as read if not already
    if (!message.readAt && message.status === 'new') {
      try {
        await markReadMutation.mutateAsync(message.id);
      } catch (err) {
        // Silent fail - don't interrupt user flow
        console.error('Failed to mark message as read:', err);
      }
    }
  };

  const handleDeleteMessage = (message: Message) => {
    setSelectedMessage(message);
    setIsDeleteModalOpen(true);
  };

  const confirmDeleteMessage = async () => {
    if (!selectedMessage) return;

    try {
      await deleteMutation.mutateAsync(selectedMessage.id);
      setToast({
        isOpen: true,
        message: 'Mensagem eliminada com sucesso!',
        type: 'success',
      });
      setIsDeleteModalOpen(false);
      setSelectedMessage(null);
    } catch (err) {
      setToast({
        isOpen: true,
        message: 'Erro ao eliminar mensagem. Tente novamente.',
        type: 'error',
      });
    }
  };

  const handleClearFilters = () => {
    setSearchTerm('');
    setStatusFilter('all');
    setPriorityFilter('all');
    setChannelFilter('all');
  };

  // Status badge helpers
  const getStatusBadgeClass = (status: MessageStatus) => {
    const classes = {
      new: 'badge badge-primary',
      in_progress: 'badge badge-warning',
      replied: 'badge badge-info',
      closed: 'badge badge-success',
      archived: 'badge badge-secondary',
    };
    return classes[status] || 'badge';
  };

  const getStatusLabel = (status: MessageStatus) => {
    const labels = {
      new: 'Nova',
      in_progress: 'Em Progresso',
      replied: 'Respondida',
      closed: 'Fechada',
      archived: 'Arquivada',
    };
    return labels[status] || status;
  };

  const getPriorityBadgeClass = (priority: MessagePriority) => {
    const classes = {
      low: 'badge badge-secondary',
      normal: 'badge badge-info',
      high: 'badge badge-warning',
      urgent: 'badge badge-danger',
    };
    return classes[priority] || 'badge';
  };

  const getPriorityLabel = (priority: MessagePriority) => {
    const labels = {
      low: 'Baixa',
      normal: 'Normal',
      high: 'Alta',
      urgent: 'Urgente',
    };
    return labels[priority] || priority;
  };

  const getChannelIcon = (channel: MessageChannel) => {
    const icons = {
      email: 'fa-envelope',
      whatsapp: 'fa-brands fa-whatsapp',
      phone: 'fa-phone',
      web_form: 'fa-globe',
      chat: 'fa-comments',
    };
    return icons[channel] || 'fa-envelope';
  };

  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now.getTime() - date.getTime();
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMins / 60);
    const diffDays = Math.floor(diffHours / 24);

    if (diffMins < 1) return 'Agora';
    if (diffMins < 60) return `${diffMins}m atrás`;
    if (diffHours < 24) return `${diffHours}h atrás`;
    if (diffDays < 7) return `${diffDays}d atrás`;

    return date.toLocaleDateString('pt-PT', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
    });
  };

  return (
    <MainLayout>
      <div className="page-container">
        {/* Level 1: Page Title Section */}
        <div className="page-header">
          <div>
            <h1>
              <i className="fas fa-envelope"></i> Mensagens
            </h1>
            <p className="page-subtitle">Gestão de mensagens de clientes</p>
          </div>
        </div>

        {/* Level 2: Stats Cards */}
        <div className="stats-cards">
          <div className="stat-card stat-card-primary">
            <div className="stat-icon">
              <i className="fas fa-envelope"></i>
            </div>
            <div className="stat-content">
              <h3>{messages.filter((m) => m.status === 'new').length}</h3>
              <p>Novas</p>
            </div>
          </div>

          <div className="stat-card stat-card-warning">
            <div className="stat-icon">
              <i className="fas fa-clock"></i>
            </div>
            <div className="stat-content">
              <h3>{messages.filter((m) => m.status === 'in_progress').length}</h3>
              <p>Em Progresso</p>
            </div>
          </div>

          <div className="stat-card stat-card-success">
            <div className="stat-icon">
              <i className="fas fa-check-circle"></i>
            </div>
            <div className="stat-content">
              <h3>{messages.filter((m) => m.status === 'replied').length}</h3>
              <p>Respondidas</p>
            </div>
          </div>

          <div className="stat-card stat-card-info">
            <div className="stat-icon">
              <i className="fas fa-inbox"></i>
            </div>
            <div className="stat-content">
              <h3>{messages.length}</h3>
              <p>Total</p>
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
                placeholder="Buscar por assunto, cliente..."
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
                onChange={(e) => setStatusFilter(e.target.value as MessageStatus | 'all')}
              >
                <option value="all">Todos</option>
                <option value="new">Nova</option>
                <option value="in_progress">Em Progresso</option>
                <option value="replied">Respondida</option>
                <option value="closed">Fechada</option>
                <option value="archived">Arquivada</option>
              </select>
            </div>

            <div className="filter-group">
              <label htmlFor="priority" className="filter-label">
                <i className="fas fa-exclamation-circle"></i> Prioridade
              </label>
              <select
                id="priority"
                className="form-control"
                value={priorityFilter}
                onChange={(e) => setPriorityFilter(e.target.value as MessagePriority | 'all')}
              >
                <option value="all">Todas</option>
                <option value="low">Baixa</option>
                <option value="normal">Normal</option>
                <option value="high">Alta</option>
                <option value="urgent">Urgente</option>
              </select>
            </div>

            <div className="filter-group">
              <label htmlFor="channel" className="filter-label">
                <i className="fas fa-share-alt"></i> Canal
              </label>
              <select
                id="channel"
                className="form-control"
                value={channelFilter}
                onChange={(e) => setChannelFilter(e.target.value as MessageChannel | 'all')}
              >
                <option value="all">Todos</option>
                <option value="email">Email</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="phone">Telefone</option>
                <option value="web_form">Formulário Web</option>
                <option value="chat">Chat</option>
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
                <p>A carregar mensagens...</p>
              </div>
            )}

            {/* Error State */}
            {isError && (
              <div className="table-error">
                <i className="fas fa-exclamation-circle"></i>
                <p>Erro ao carregar mensagens: {error?.message}</p>
                <button className="btn btn-primary" onClick={() => window.location.reload()}>
                  Tentar novamente
                </button>
              </div>
            )}

            {/* Empty State */}
            {!isLoading && !isError && messages.length === 0 && (
              <div className="table-empty">
                <i className="fas fa-envelope"></i>
                <p>Nenhuma mensagem encontrada</p>
              </div>
            )}

            {/* Data Table */}
            {!isLoading && !isError && messages.length > 0 && (
              <div className="table-responsive">
                <table className="data-table">
                  <thead>
                    <tr>
                      <th>Canal</th>
                      <th>Cliente</th>
                      <th>Assunto</th>
                      <th>Status</th>
                      <th>Prioridade</th>
                      <th>Agente</th>
                      <th>Data</th>
                      <th className="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {messages.map((message) => (
                      <tr
                        key={message.id}
                        className={message.status === 'new' && !message.readAt ? 'row-unread' : ''}
                      >
                        <td>
                          <i className={`fas ${getChannelIcon(message.channel)}`}></i>
                        </td>
                        <td>
                          <div className="table-user">
                            <div className="table-user-avatar">
                              <i className="fas fa-user"></i>
                            </div>
                            <span className="table-user-name">
                              {message.clientName || 'Cliente'}
                            </span>
                          </div>
                        </td>
                        <td>
                          <span className="message-subject">{message.subject}</span>
                        </td>
                        <td>
                          <span className={getStatusBadgeClass(message.status)}>
                            {getStatusLabel(message.status)}
                          </span>
                        </td>
                        <td>
                          <span className={getPriorityBadgeClass(message.priority)}>
                            {getPriorityLabel(message.priority)}
                          </span>
                        </td>
                        <td>{message.agentName || '-'}</td>
                        <td>{formatDate(message.createdAt)}</td>
                        <td>
                          <div className="table-actions">
                            <button
                              className="btn-icon btn-icon-primary"
                              onClick={() => handleViewMessage(message)}
                              title="Ver mensagem"
                            >
                              <i className="fas fa-eye"></i>
                            </button>
                            <button
                              className="btn-icon btn-icon-danger"
                              onClick={() => handleDeleteMessage(message)}
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
            {!isLoading && !isError && messages.length > 0 && (
              <div className="table-pagination">
                <div className="pagination-info">
                  Mostrando <strong>1-{messages.length}</strong> de{' '}
                  <strong>{messages.length}</strong> mensagens
                </div>
                <div className="pagination-controls">
                  <button className="btn btn-sm btn-secondary" disabled>
                    <i className="fas fa-chevron-left"></i> Anterior
                  </button>
                  <button className="btn btn-sm btn-secondary" disabled>
                    Próximo <i className="fas fa-chevron-right"></i>
                  </button>
                </div>
              </div>
            )}
          </div>
        </div>

        {/* View Message Modal */}
        <Modal
          isOpen={isViewModalOpen}
          onClose={() => setIsViewModalOpen(false)}
          title="Detalhes da Mensagem"
          size="large"
        >
          {selectedMessage && (
            <div className="message-view">
              <div className="message-header">
                <div className="message-meta">
                  <span className={getStatusBadgeClass(selectedMessage.status)}>
                    {getStatusLabel(selectedMessage.status)}
                  </span>
                  <span className={getPriorityBadgeClass(selectedMessage.priority)}>
                    {getPriorityLabel(selectedMessage.priority)}
                  </span>
                  <span className="message-channel">
                    <i className={`fas ${getChannelIcon(selectedMessage.channel)}`}></i>
                    {selectedMessage.channel}
                  </span>
                </div>
                <div className="message-date">
                  {formatDate(selectedMessage.createdAt)}
                </div>
              </div>

              <div className="message-details">
                <div className="message-field">
                  <label>Cliente:</label>
                  <span>{selectedMessage.clientName || 'N/A'}</span>
                </div>
                <div className="message-field">
                  <label>Agente:</label>
                  <span>{selectedMessage.agentName || 'Não atribuído'}</span>
                </div>
                <div className="message-field">
                  <label>Assunto:</label>
                  <span>{selectedMessage.subject}</span>
                </div>
              </div>

              <div className="message-content">
                <h4>Conteúdo:</h4>
                <div className="message-text">{selectedMessage.content}</div>
              </div>

              {selectedMessage.tags && selectedMessage.tags.length > 0 && (
                <div className="message-tags">
                  <label>Tags:</label>
                  <div className="tags-list">
                    {selectedMessage.tags.map((tag, index) => (
                      <span key={index} className="tag">
                        {tag}
                      </span>
                    ))}
                  </div>
                </div>
              )}
            </div>
          )}
        </Modal>

        {/* Delete Message Modal */}
        <Modal
          isOpen={isDeleteModalOpen}
          onClose={() => setIsDeleteModalOpen(false)}
          title="Eliminar Mensagem"
          size="small"
        >
          {selectedMessage && (
            <div className="modal-content-delete">
              <div className="delete-warning">
                <i className="fas fa-exclamation-triangle"></i>
                <p>
                  Tem certeza que deseja eliminar a mensagem de{' '}
                  <strong>{selectedMessage.clientName}</strong>?
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
                  onClick={confirmDeleteMessage}
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
