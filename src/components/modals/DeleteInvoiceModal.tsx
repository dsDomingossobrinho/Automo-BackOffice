import { AlertTriangle, Trash2 } from "lucide-react";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { useDeleteInvoice } from "@/hooks/useInvoices";
import type { Invoice } from "@/types";

interface DeleteInvoiceModalProps {
  isOpen: boolean;
  onClose: () => void;
  invoice: Invoice | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

/**
 * Delete Invoice Modal
 * Modal de confirmação para eliminar fatura usando ResponsiveDialog
 */
export default function DeleteInvoiceModal({
  isOpen,
  onClose,
  invoice,
  onSuccess,
  onError,
}: Readonly<DeleteInvoiceModalProps>) {
  const deleteMutation = useDeleteInvoice();

  const handleDelete = () => {
    if (!invoice) return;

    deleteMutation.mutate(invoice.id, {
      onSuccess: () => {
        onSuccess?.("Fatura eliminada com sucesso!");
        onClose();
      },
      onError: (error: unknown) => {
        const message =
          error instanceof Error ? error.message : "Erro ao eliminar fatura";
        onError?.(message);
      },
    });
  };

  if (!invoice) return null;

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
      title="Eliminar Fatura"
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
            Tem a certeza de que deseja eliminar a fatura
          </p>
          <p className="font-semibold">#{invoice.invoiceNumber}</p>
          <div className="text-sm text-muted-foreground">
            <p>
              Cliente:{" "}
              <span className="font-medium">
                {invoice.clientName || invoice.clientId}
              </span>
            </p>
            <p>
              Total:{" "}
              <span className="font-medium">{formatCurrency(invoice.total)}</span>
            </p>
          </div>
        </div>
      </div>
    </ResponsiveDialog>
  );
}
