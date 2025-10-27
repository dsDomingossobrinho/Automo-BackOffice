import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { CreateAccountTypeData } from "@/types";
import AccountTypeForm from "./form";

interface CreateModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  onSubmit: (data: CreateAccountTypeData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function CreateAccountTypeModal({
  open,
  onOpenChange,
  onSubmit,
  isSubmitting = false,
}: CreateModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Criar Tipo de Conta"
      description="Adicione um novo tipo de conta ao sistema"
    >
      <AccountTypeForm
        mode="create"
        onSubmit={onSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={isSubmitting}
      />
    </ResponsiveDialog>
  );
}
