import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { Province, UpdateProvinceData } from "@/types";
import ProvinceForm from "./form";

interface EditModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  province: Province | null;
  onSubmit: (data: UpdateProvinceData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function EditProvinceModal({
  open,
  onOpenChange,
  province,
  onSubmit,
  isSubmitting = false,
}: EditModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Editar Província"
      description="Modifique os detalhes da província"
    >
      {province && (
        <ProvinceForm
          mode="edit"
          initialData={province}
          onSubmit={onSubmit}
          onCancel={() => onOpenChange(false)}
          isSubmitting={isSubmitting}
        />
      )}
    </ResponsiveDialog>
  );
}
