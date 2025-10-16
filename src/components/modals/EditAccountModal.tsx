import Modal from './Modal';
import AccountForm from '../forms/AccountForm';
import { useUpdateAccount } from '../../hooks/useAccounts';
import type { Account, CreateAccountData } from '../../types';

interface EditAccountModalProps {
  isOpen: boolean;
  onClose: () => void;
  account: Account | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

export default function EditAccountModal({ isOpen, onClose, account, onSuccess, onError }: EditAccountModalProps) {
  const updateMutation = useUpdateAccount();

  const handleSubmit = async (data: CreateAccountData) => {
    if (!account) return;

    try {
      await updateMutation.mutateAsync({
        id: account.id,
        ...data,
      });
      onSuccess?.('Conta atualizada com sucesso!');
      onClose();
    } catch (error: any) {
      onError?.(error.message || 'Erro ao atualizar conta');
    }
  };

  if (!account) return null;

  return (
    <Modal
      isOpen={isOpen}
      onClose={updateMutation.isPending ? () => {} : onClose}
      title="Editar Conta"
      size="large"
    >
      <AccountForm account={account} onSubmit={handleSubmit} isLoading={updateMutation.isPending} />
    </Modal>
  );
}
