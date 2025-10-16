import Modal from './Modal';
import type { Account } from '../../types';
import { RoleLabels, PermissionLabels } from '../../types';

interface ViewAccountModalProps {
  isOpen: boolean;
  onClose: () => void;
  account: Account | null;
}

export default function ViewAccountModal({ isOpen, onClose, account }: ViewAccountModalProps) {
  if (!account) return null;

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('pt-PT', {
      day: '2-digit',
      month: 'long',
      year: 'numeric',
    });
  };

  const getStatusBadge = (status: string) => {
    const badges: Record<string, { class: string; label: string }> = {
      active: { class: 'badge-success', label: 'Ativa' },
      inactive: { class: 'badge-secondary', label: 'Inativa' },
      suspended: { class: 'badge-danger', label: 'Suspensa' },
      pending: { class: 'badge-warning', label: 'Pendente' },
    };
    const badge = badges[status] || { class: 'badge-secondary', label: status };
    return <span className={`badge ${badge.class}`}>{badge.label}</span>;
  };

  return (
    <Modal isOpen={isOpen} onClose={onClose} title="Detalhes da Conta" size="large">
      <div className="view-modal-content">
        {/* Account Header */}
        <div className="view-modal-header">
          <div className="view-modal-avatar">
            {account.img ? (
              <img src={account.img} alt={account.name} />
            ) : (
              <i className="fas fa-user-circle" style={{ fontSize: '48px', color: '#6366f1' }}></i>
            )}
          </div>
          <div className="view-modal-header-info">
            <h2>{account.name}</h2>
            <p className="text-muted">@{account.username}</p>
          </div>
        </div>

        {/* Account Details */}
        <div className="view-modal-section">
          <h3>Informações Gerais</h3>
          <div className="view-modal-grid">
            <div className="view-modal-field">
              <label>Email</label>
              <p>{account.email}</p>
            </div>

            <div className="view-modal-field">
              <label>Estado</label>
              <p>{getStatusBadge(account.status)}</p>
            </div>

            <div className="view-modal-field">
              <label>Role</label>
              <p>{RoleLabels[account.roleId] || account.roleId}</p>
            </div>

            <div className="view-modal-field">
              <label>BackOffice</label>
              <p>{account.isBackOffice ? 'Sim' : 'Não'}</p>
            </div>

            {account.contact && (
              <div className="view-modal-field">
                <label>Contacto</label>
                <p>{account.contact}</p>
              </div>
            )}

            {account.identify_id && (
              <div className="view-modal-field">
                <label>NIF</label>
                <p>{account.identify_id}</p>
              </div>
            )}
          </div>
        </div>

        {/* Permissions */}
        {account.permissions && account.permissions.length > 0 && (
          <div className="view-modal-section">
            <h3>Permissões</h3>
            <div className="permissions-display">
              {account.permissions.map((permission) => (
                <span key={permission} className="badge badge-info">
                  {PermissionLabels[permission] || permission}
                </span>
              ))}
            </div>
          </div>
        )}

        {/* Timestamps */}
        <div className="view-modal-section">
          <h3>Registo</h3>
          <div className="view-modal-grid">
            <div className="view-modal-field">
              <label>Criada em</label>
              <p>{formatDate(account.createdAt)}</p>
            </div>

            {account.lastLogin && (
              <div className="view-modal-field">
                <label>Último Login</label>
                <p>{formatDate(account.lastLogin)}</p>
              </div>
            )}
          </div>
        </div>
      </div>
    </Modal>
  );
}
