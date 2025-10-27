import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { State, UpdateStateData } from "@/types";
import StateForm from "./form";

interface EditModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  state: State | null;
  onSubmit: (data: UpdateStateData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function EditStateModal({
  open,
  onOpenChange,
  state,
  onSubmit,
  isSubmitting = false,
}: EditModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Editar Estado"
      description="Modifique os detalhes do estado"
    >
      {state && (
        <StateForm
          mode="edit"
          initialData={state}
          onSubmit={onSubmit}
          onCancel={() => onOpenChange(false)}
          isSubmitting={isSubmitting}
        />
      )}
    </ResponsiveDialog>
  );
}
