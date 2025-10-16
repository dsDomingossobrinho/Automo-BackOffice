import Modal from './Modal';
import { useDeleteInvoice } from '../../hooks/useInvoices';
import type { Invoice } from '../../types';

interface DeleteInvoiceModalProps {
  isOpen: boolean;
  onClose: () => void;
  invoice: Invoice | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Delete Invoice Modal
 * Confirmation dialog for deleting an invoice
 */
export default function DeleteInvoiceModal({ isOpen, onClose, invoice, onSuccess, onError }: DeleteInvoiceModalProps) {
  const deleteMutation = useDeleteInvoice();

  const handleDelete = async () => {
    if (!invoice) return;

    try {
      await deleteMutation.mutateAsync(invoice.id);
      onSuccess?.('Fatura eliminada com sucesso!');
      onClose();
    } catch (error: any) {
      onError?.(error.message || 'Erro ao eliminar fatura');
    }
  };

  if (!invoice) return null;

  // Format currency
  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('pt-PT', {
      style: 'currency',
      currency: 'EUR',
    }).format(amount);
  };

  return (
    <Modal isOpen={isOpen} onClose={deleteMutation.isPending ? () => {} : onClose} title="Eliminar Fatura" size="small">
      <div className="delete-modal-content">
        <div className="delete-modal-icon">
          <i className="fas fa-exclamation-triangle"></i>
        </div>

        <div className="delete-modal-message">
          <p>
            Tem a certeza de que deseja eliminar a fatura <strong>#{invoice.invoiceNumber}</strong>?
          </p>
          <p className="text-muted">
            Cliente: <strong>{invoice.clientName || invoice.clientId}</strong>
            <br />
            Total: <strong>{formatCurrency(invoice.total)}</strong>
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
