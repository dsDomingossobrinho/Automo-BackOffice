import { AlertTriangle } from "lucide-react";
import { useDeleteAccount } from "../../hooks/useAccounts";
import type { Account } from "../../types";
import { ResponsiveDialog } from "../common/responsive-dialog";
import { Button } from "../ui/button";

interface DeleteAccountModalProps {
  isOpen: boolean;
  onClose: () => void;
  account: Account | null;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

export default function DeleteAccountModal({
  isOpen,
  onClose,
  account,
  onSuccess,
  onError,
}: Readonly<DeleteAccountModalProps>) {
  const deleteMutation = useDeleteAccount();

  const handleDelete = async () => {
    if (!account) return;

    try {
      await deleteMutation.mutateAsync(account.id);
      onSuccess?.("Conta eliminada com sucesso!");
      onClose();
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : "Erro ao eliminar conta";
      onError?.(message);
    }
  };

  if (!account) return null;

  return (
    <ResponsiveDialog
      open={isOpen}
      onOpenChange={deleteMutation.isPending ? () => { } : onClose}
      title="Eliminar Conta"
      description="Esta ação não pode ser revertida!"
      footer={
        <div className="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 w-full">
          <Button
            type="button"
            variant="outline"
            onClick={onClose}
            disabled={deleteMutation.isPending}
          >
            Cancelar
          </Button>
          <Button
            type="button"
            variant="destructive"
            onClick={handleDelete}
            disabled={deleteMutation.isPending}
          >
            {deleteMutation.isPending ? (
              <>
                <i className="fas fa-spinner fa-spin mr-2" /> A eliminar...
              </>
            ) : (
              <>
                <i className="fas fa-trash mr-2" /> Eliminar
              </>
            )}
          </Button>
        </div>
      }
    >
      <div className="flex flex-col items-center gap-4 py-4">
        <div className="flex h-16 w-16 items-center justify-center rounded-full bg-destructive/10">
          <AlertTriangle className="h-8 w-8 text-destructive" />
        </div>

        <div className="space-y-2 text-center">
          <p className="text-base">
            Tem a certeza de que deseja eliminar a conta de{" "}
            <strong>{account.name}</strong>?
          </p>
          <div className="text-sm text-muted-foreground space-y-1">
            <p>
              Email: <strong>{account.email}</strong>
            </p>
            <p>
              Username: <strong>@{account.username}</strong>
            </p>
          </div>
        </div>
      </div>
    </ResponsiveDialog>
  );
}
