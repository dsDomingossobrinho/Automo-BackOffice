import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { CreateProvinceData } from "@/types";
import ProvinceForm from "./form";

interface CreateModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  onSubmit: (data: CreateProvinceData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function CreateProvinceModal({
  open,
  onOpenChange,
  onSubmit,
  isSubmitting = false,
}: CreateModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Criar Província"
      description="Adicione uma nova província ao sistema"
    >
      <ProvinceForm
        mode="create"
        onSubmit={onSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={isSubmitting}
      />
    </ResponsiveDialog>
  );
}
