import { AlertTriangle, Trash2 } from "lucide-react";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { useDeleteTransaction } from "@/hooks/useFinances";
import type { Transaction } from "@/types";

interface DeleteTransactionModalProps {
  isOpen: boolean;
  onClose: () => void;
  transaction: Transaction | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Delete Transaction Modal
 * Modal de confirmação para eliminar transação usando ResponsiveDialog
 */
export default function DeleteTransactionModal({
  isOpen,
  onClose,
  transaction,
  onSuccess,
  onError,
}: Readonly<DeleteTransactionModalProps>) {
  const deleteMutation = useDeleteTransaction();

  const handleDelete = () => {
    if (!transaction) return;

    deleteMutation.mutate(transaction.id, {
      onSuccess: () => {
        onSuccess?.("Transação eliminada com sucesso!");
        onClose();
      },
      onError: (error: unknown) => {
        const message =
          error instanceof Error ? error.message : "Erro ao eliminar transação";
        onError?.(message);
      },
    });
  };

  if (!transaction) return null;

  // Format currency
  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("pt-PT", {
      style: "currency",
      currency: "EUR",
    }).format(amount);
  };

  return (
    <ResponsiveDialog
      open={isOpen}
      onOpenChange={(open) => {
        if (!open && !deleteMutation.isPending) {
          onClose();
        }
      }}
      title="Eliminar Transação"
      description="Esta ação não pode ser revertida!"
      actions={[
        {
          label: "Cancelar",
          variant: "outline",
          onClick: onClose,
          disabled: deleteMutation.isPending,
        },
        {
          label: "Eliminar",
          variant: "destructive",
          onClick: handleDelete,
          disabled: deleteMutation.isPending,
          loading: deleteMutation.isPending,
          icon: Trash2,
        },
      ]}
    >
      <div className="flex flex-col items-center gap-4 py-4">
        <Avatar className="h-16 w-16 bg-destructive/10">
          <AvatarFallback className="bg-transparent">
            <AlertTriangle className="h-8 w-8 text-destructive" />
          </AvatarFallback>
        </Avatar>

        <div className="space-y-2 text-center">
          <p className="text-sm text-muted-foreground">
            Tem a certeza de que deseja eliminar a transação
          </p>
          <p className="font-semibold">{transaction.description}</p>
          <p className="text-sm text-muted-foreground">
            Valor:{" "}
            <span className="font-medium">{formatCurrency(transaction.amount)}</span>
          </p>
        </div>
      </div>
    </ResponsiveDialog>
  );
}
