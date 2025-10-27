import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import RoleForm from "@/components/forms/RoleForm";

interface CreateModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  onSubmit: (data: { role: string; description?: string }) => Promise<void>;
  isSubmitting?: boolean;
}

export default function CreateRoleModal({ open, onOpenChange, onSubmit, isSubmitting = false }: CreateModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(open) => !isSubmitting && onOpenChange(open)}
      title="Criar Cargo"
    >
      <RoleForm mode="create" onSubmit={onSubmit} onCancel={() => onOpenChange(false)} isSubmitting={isSubmitting} />
    </ResponsiveDialog>
  );
}
