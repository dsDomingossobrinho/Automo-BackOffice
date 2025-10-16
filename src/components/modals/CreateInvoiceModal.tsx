import Modal from './Modal';
import InvoiceForm from '../forms/InvoiceForm';
import { useCreateInvoice } from '../../hooks/useInvoices';
import type { CreateInvoiceData } from '../../types';

interface CreateInvoiceModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Create Invoice Modal
 */
export default function CreateInvoiceModal({ isOpen, onClose, onSuccess, onError }: CreateInvoiceModalProps) {
  const createMutation = useCreateInvoice();

  const handleSubmit = async (data: CreateInvoiceData) => {
    try {
      await createMutation.mutateAsync(data);
      onSuccess?.('Fatura criada com sucesso!');
      onClose();
    } catch (error: any) {
      onError?.(error.message || 'Erro ao criar fatura');
    }
  };

  return (
    <Modal
      isOpen={isOpen}
      onClose={createMutation.isPending ? () => {} : onClose}
      title="Nova Fatura"
      size="large"
    >
      <InvoiceForm onSubmit={handleSubmit} isLoading={createMutation.isPending} />
    </Modal>
  );
}
