import Modal from './Modal';
import TransactionForm from '../forms/TransactionForm';
import { useCreateTransaction } from '../../hooks/useFinances';
import type { CreateTransactionData } from '../../types';

interface CreateTransactionModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Create Transaction Modal
 */
export default function CreateTransactionModal({ isOpen, onClose, onSuccess, onError }: CreateTransactionModalProps) {
  const createMutation = useCreateTransaction();

  const handleSubmit = async (data: CreateTransactionData) => {
    try {
      await createMutation.mutateAsync(data);
      onSuccess?.('Transação criada com sucesso!');
      onClose();
    } catch (error: any) {
      onError?.(error.message || 'Erro ao criar transação');
    }
  };

  return (
    <Modal
      isOpen={isOpen}
      onClose={createMutation.isPending ? () => {} : onClose}
      title="Nova Transação"
      size="large"
    >
      <TransactionForm onSubmit={handleSubmit} isLoading={createMutation.isPending} />
    </Modal>
  );
}
