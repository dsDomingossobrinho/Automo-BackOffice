import { Trash2 } from "lucide-react";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { State } from "@/types";

interface DeleteModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  state: State | null;
  onConfirm: () => Promise<void>;
  isDeleting?: boolean;
}

export default function DeleteStateModal({
  open,
  onOpenChange,
  state,
  onConfirm,
  isDeleting = false,
}: DeleteModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isDeleting && onOpenChange(newOpen)}
      title="Eliminar Estado"
      description="Esta ação não pode ser revertida!"
      actions={[
        {
          label: "Cancelar",
          variant: "outline",
          onClick: () => onOpenChange(false),
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
      {state && (
        <div className="flex flex-col items-center gap-4 py-4">
          <div className="rounded-full bg-destructive/10 p-3">
            <Trash2 className="h-6 w-6 text-destructive" />
          </div>
          <p className="text-center text-sm">
            Tem a certeza que deseja eliminar o estado{" "}
            <span className="font-semibold">{state.state}</span>?
          </p>
        </div>
      )}
    </ResponsiveDialog>
  );
}
