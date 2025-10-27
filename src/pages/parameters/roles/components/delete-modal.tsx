import { Trash2 } from "lucide-react";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { RoleInfo } from "@/types";

interface DeleteModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  role: RoleInfo | null;
  onConfirm: () => Promise<void>;
  isDeleting?: boolean;
}

export default function DeleteRoleModal({ open, onOpenChange, role, onConfirm, isDeleting = false }: DeleteModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isDeleting && onOpenChange(newOpen)}
      title="Eliminar Cargo"
      description="Esta ação não pode ser revertida!"
      actions={[
        {
          label: "Cancelar",
          variant: "outline",
          onClick: () => {
            onOpenChange(false);
          },
          disabled: isDeleting,
        },
        {
          label: "Eliminar",
          variant: "destructive",
          onClick: onConfirm,
          disabled: isDeleting,
          loading: isDeleting,
          icon: Trash2,
        },
      ]}
    >
      {role && (
        <p className="text-sm">
          Tem a certeza que deseja eliminar o cargo <span className="font-semibold">{role.name}</span>?
        </p>
      )}
    </ResponsiveDialog>
  );
}
