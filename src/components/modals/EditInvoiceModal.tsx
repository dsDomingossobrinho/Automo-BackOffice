import Modal from './Modal';
import InvoiceForm from '../forms/InvoiceForm';
import { useUpdateInvoice } from '../../hooks/useInvoices';
import type { Invoice, CreateInvoiceData } from '../../types';

interface EditInvoiceModalProps {
  isOpen: boolean;
  onClose: () => void;
  invoice: Invoice | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Edit Invoice Modal
 */
export default function EditInvoiceModal({ isOpen, onClose, invoice, onSuccess, onError }: EditInvoiceModalProps) {
  const updateMutation = useUpdateInvoice();

  const handleSubmit = async (data: CreateInvoiceData) => {
    if (!invoice) return;

    try {
      await updateMutation.mutateAsync({
        id: invoice.id,
        ...data,
      });
      onSuccess?.('Fatura atualizada com sucesso!');
      onClose();
    } catch (error: any) {
      onError?.(error.message || 'Erro ao atualizar fatura');
    }
  };

  if (!invoice) return null;

  return (
    <Modal
      isOpen={isOpen}
      onClose={updateMutation.isPending ? () => {} : onClose}
      title="Editar Fatura"
      size="large"
    >
      <InvoiceForm invoice={invoice} onSubmit={handleSubmit} isLoading={updateMutation.isPending} />
    </Modal>
  );
}
