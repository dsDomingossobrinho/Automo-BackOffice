import Modal from './Modal';
import TransactionForm from '../forms/TransactionForm';
import { useUpdateTransaction } from '../../hooks/useFinances';
import type { Transaction, CreateTransactionData } from '../../types';

interface EditTransactionModalProps {
  isOpen: boolean;
  onClose: () => void;
  transaction: Transaction | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Edit Transaction Modal
 */
export default function EditTransactionModal({ isOpen, onClose, transaction, onSuccess, onError }: EditTransactionModalProps) {
  const updateMutation = useUpdateTransaction();

  const handleSubmit = async (data: CreateTransactionData) => {
    if (!transaction) return;

    try {
      await updateMutation.mutateAsync({
        id: transaction.id,
        ...data,
      });
      onSuccess?.('Transação atualizada com sucesso!');
      onClose();
    } catch (error: any) {
      onError?.(error.message || 'Erro ao atualizar transação');
    }
  };

  if (!transaction) return null;

  return (
    <Modal
      isOpen={isOpen}
      onClose={updateMutation.isPending ? () => {} : onClose}
      title="Editar Transação"
      size="large"
    >
      <TransactionForm transaction={transaction} onSubmit={handleSubmit} isLoading={updateMutation.isPending} />
    </Modal>
  );
}
