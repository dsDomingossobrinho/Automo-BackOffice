import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { useUpdateTransaction } from "@/hooks/useFinances";
import type { CreateTransactionData, Transaction } from "@/types";
import TransactionForm from "../forms/TransactionForm";

interface EditTransactionModalProps {
  isOpen: boolean;
  onClose: () => void;
  transaction: Transaction | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Edit Transaction Modal
 * Modal para editar transação existente usando ResponsiveDialog
 */
export default function EditTransactionModal({
  isOpen,
  onClose,
  transaction,
  onSuccess,
  onError,
}: Readonly<EditTransactionModalProps>) {
  const updateMutation = useUpdateTransaction();

  const handleSubmit = async (data: CreateTransactionData) => {
    if (!transaction) return;

    try {
      await updateMutation.mutateAsync({
        id: transaction.id,
        ...data,
      });
      onSuccess?.("Transação atualizada com sucesso!");
      onClose();
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : "Erro ao atualizar transação";
      onError?.(message);
    }
  };

  if (!transaction) return null;

  return (
    <ResponsiveDialog
      open={isOpen}
      onOpenChange={(open) => {
        if (!open && !updateMutation.isPending) {
          onClose();
        }
      }}
      title="Editar Transação"
      description="Atualize as informações da transação"
    >
      <TransactionForm
        transaction={transaction}
        onSubmit={handleSubmit}
        isLoading={updateMutation.isPending}
      />
    </ResponsiveDialog>
  );
}
