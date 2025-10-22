import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { useCreateTransaction } from "@/hooks/useFinances";
import type { CreateTransactionData } from "@/types";
import TransactionForm from "../forms/TransactionForm";

interface CreateTransactionModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Create Transaction Modal
 * Modal para criar nova transação usando ResponsiveDialog
 */
export default function CreateTransactionModal({
  isOpen,
  onClose,
  onSuccess,
  onError,
}: Readonly<CreateTransactionModalProps>) {
  const createMutation = useCreateTransaction();

  const handleSubmit = async (data: CreateTransactionData) => {
    try {
      await createMutation.mutateAsync(data);
      onSuccess?.("Transação criada com sucesso!");
      onClose();
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : "Erro ao criar transação";
      onError?.(message);
    }
  };

  return (
    <ResponsiveDialog
      open={isOpen}
      onOpenChange={(open) => {
        if (!open && !createMutation.isPending) {
          onClose();
        }
      }}
      title="Nova Transação"
      description="Preencha os dados para criar uma nova transação"
    >
      <TransactionForm
        onSubmit={handleSubmit}
        isLoading={createMutation.isPending}
      />
    </ResponsiveDialog>
  );
}
