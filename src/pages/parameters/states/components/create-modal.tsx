import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { CreateStateData } from "@/types";
import StateForm from "./form";

interface CreateModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  onSubmit: (data: CreateStateData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function CreateStateModal({
  open,
  onOpenChange,
  onSubmit,
  isSubmitting = false,
}: CreateModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Criar Estado"
      description="Adicione um novo estado ao sistema"
    >
      <StateForm
        mode="create"
        onSubmit={onSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={isSubmitting}
      />
    </ResponsiveDialog>
  );
}
