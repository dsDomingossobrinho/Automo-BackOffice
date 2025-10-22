import { useCreateAccount } from "../../hooks/useAccounts";
import type { CreateAccountData } from "../../types";
import { ResponsiveDialog } from "../common/responsive-dialog";
import AccountForm from "../forms/AccountForm";

interface CreateAccountModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess?: (message: string) => void;
  onError?: (message: string) => void;
}

export default function CreateAccountModal({
  isOpen,
  onClose,
  onSuccess,
  onError,
}: Readonly<CreateAccountModalProps>) {
  const createMutation = useCreateAccount();

  const handleSubmit = async (data: CreateAccountData) => {
    try {
      // Ensure new accounts are created with a static accountTypeId and without a password from the UI
      const payload: CreateAccountData = {
        ...data,
        accountTypeId: data.accountTypeId ?? 1, // static account type
        password: "",
      };

      await createMutation.mutateAsync(payload);
      onSuccess?.("Conta criada com sucesso!");
      onClose();
    } catch (error: unknown) {
      let message = "Erro ao criar conta";
      if (error && typeof error === "object" && "message" in error) {
        message = (error as Error).message || message;
      } else if (typeof error === "string") {
        message = error;
      }
      onError?.(message);
    }
  };

  return (
    <ResponsiveDialog
      open={isOpen}
      onOpenChange={createMutation.isPending ? () => { } : onClose}
      title="Nova Conta"
      description="Preencha os campos abaixo para criar uma nova conta de administrador."
    >
      <AccountForm
        onSubmit={handleSubmit}
        isLoading={createMutation.isPending}
      />
    </ResponsiveDialog>
  );
}
