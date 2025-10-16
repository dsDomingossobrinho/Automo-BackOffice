import Modal from './Modal';
import { useDeleteAccount } from '../../hooks/useAccounts';
import type { Account } from '../../types';

interface DeleteAccountModalProps {
  isOpen: boolean;
  onClose: () => void;
  account: Account | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

export default function DeleteAccountModal({ isOpen, onClose, account, onSuccess, onError }: DeleteAccountModalProps) {
  const deleteMutation = useDeleteAccount();

  const handleDelete = async () => {
    if (!account) return;

    try {
      await deleteMutation.mutateAsync(account.id);
      onSuccess?.('Conta eliminada com sucesso!');
      onClose();
    } catch (error: any) {
      onError?.(error.message || 'Erro ao eliminar conta');
    }
  };

  if (!account) return null;

  return (
    <Modal isOpen={isOpen} onClose={deleteMutation.isPending ? () => {} : onClose} title="Eliminar Conta" size="small">
      <div className="delete-modal-content">
        <div className="delete-modal-icon">
          <i className="fas fa-exclamation-triangle"></i>
        </div>

        <div className="delete-modal-message">
          <p>
            Tem a certeza de que deseja eliminar a conta de <strong>{account.name}</strong>?
          </p>
          <p className="text-muted">
            Email: <strong>{account.email}</strong>
            <br />
            Username: <strong>@{account.username}</strong>
          </p>
          <p className="warning-text">Esta ação não pode ser revertida!</p>
        </div>

        <div className="delete-modal-actions">
          <button type="button" className="btn btn-secondary" onClick={onClose} disabled={deleteMutation.isPending}>
            Cancelar
          </button>
          <button type="button" className="btn btn-danger" onClick={handleDelete} disabled={deleteMutation.isPending}>
            {deleteMutation.isPending ? (
              <>
                <i className="fas fa-spinner fa-spin"></i> A eliminar...
              </>
            ) : (
              <>
                <i className="fas fa-trash"></i> Eliminar
              </>
            )}
          </button>
        </div>
      </div>
    </Modal>
  );
}
