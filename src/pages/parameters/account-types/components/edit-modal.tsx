import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { AccountType, UpdateAccountTypeData } from "@/types";
import AccountTypeForm from "./form";

interface EditModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  accountType: AccountType | null;
  onSubmit: (data: UpdateAccountTypeData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function EditAccountTypeModal({
  open,
  onOpenChange,
  accountType,
  onSubmit,
  isSubmitting = false,
}: EditModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Editar Tipo de Conta"
      description="Modifique os detalhes do tipo de conta"
    >
      {accountType && (
        <AccountTypeForm
          mode="edit"
          initialData={accountType}
          onSubmit={onSubmit}
          onCancel={() => onOpenChange(false)}
          isSubmitting={isSubmitting}
        />
      )}
    </ResponsiveDialog>
  );
}
