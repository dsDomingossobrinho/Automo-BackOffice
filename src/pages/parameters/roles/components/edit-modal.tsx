import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import RoleForm from "@/components/forms/RoleForm";
import type { RoleInfo } from "@/types";

interface EditModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  role: RoleInfo | null;
  onSubmit: (data: { role: string; description?: string }) => Promise<void>;
  isSubmitting?: boolean;
}

export default function EditRoleModal({ open, onOpenChange, role, onSubmit, isSubmitting = false }: EditModalProps) {
  return (
    <ResponsiveDialog open={open} onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)} title="Editar Cargo">
      {role && (
        <RoleForm
          mode="edit"
          initialData={role}
          onSubmit={onSubmit}
          onCancel={() => {
            onOpenChange(false);
          }}
          isSubmitting={isSubmitting}
        />
      )}
    </ResponsiveDialog>
  );
}
