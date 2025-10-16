import Modal from './Modal';
import { useDeleteTransaction } from '../../hooks/useFinances';
import type { Transaction } from '../../types';

interface DeleteTransactionModalProps {
  isOpen: boolean;
  onClose: () => void;
  transaction: Transaction | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Delete Transaction Modal
 * Confirmation dialog for deleting a transaction
 */
export default function DeleteTransactionModal({ isOpen, onClose, transaction, onSuccess, onError }: DeleteTransactionModalProps) {
  const deleteMutation = useDeleteTransaction();

  const handleDelete = async () => {
    if (!transaction) return;

    try {
      await deleteMutation.mutateAsync(transaction.id);
      onSuccess?.('Transação eliminada com sucesso!');
      onClose();
    } catch (error: any) {
      onError?.(error.message || 'Erro ao eliminar transação');
    }
  };

  if (!transaction) return null;

  // Format currency
  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('pt-PT', {
      style: 'currency',
      currency: 'EUR',
    }).format(amount);
  };

  return (
    <Modal isOpen={isOpen} onClose={deleteMutation.isPending ? () => {} : onClose} title="Eliminar Transação" size="small">
      <div className="delete-modal-content">
        <div className="delete-modal-icon">
          <i className="fas fa-exclamation-triangle"></i>
        </div>

        <div className="delete-modal-message">
          <p>
            Tem a certeza de que deseja eliminar a transação <strong>{transaction.description}</strong>?
          </p>
          <p className="text-muted">
            Valor: <strong>{formatCurrency(transaction.amount)}</strong>
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
