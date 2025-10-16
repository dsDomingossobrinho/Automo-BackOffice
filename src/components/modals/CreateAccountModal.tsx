import Modal from './Modal';
import AccountForm from '../forms/AccountForm';
import { useCreateAccount } from '../../hooks/useAccounts';
import type { CreateAccountData } from '../../types';

interface CreateAccountModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

export default function CreateAccountModal({ isOpen, onClose, onSuccess, onError }: CreateAccountModalProps) {
  const createMutation = useCreateAccount();

  const handleSubmit = async (data: CreateAccountData) => {
    try {
      await createMutation.mutateAsync(data);
      onSuccess?.('Conta criada com sucesso!');
      onClose();
    } catch (error: any) {
      onError?.(error.message || 'Erro ao criar conta');
    }
  };

  return (
    <Modal
      isOpen={isOpen}
      onClose={createMutation.isPending ? () => {} : onClose}
      title="Nova Conta"
      size="large"
    >
      <AccountForm onSubmit={handleSubmit} isLoading={createMutation.isPending} />
    </Modal>
  );
}
