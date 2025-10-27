import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { Promotion, UpdatePromotionData } from "@/types";
import PromotionForm from "./form";

interface EditModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  promotion: Promotion | null;
  onSubmit: (data: UpdatePromotionData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function EditPromotionModal({
  open,
  onOpenChange,
  promotion,
  onSubmit,
  isSubmitting = false,
}: EditModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Editar Promoção"
      description="Atualize os detalhes da promoção"
    >
      {promotion && (
        <PromotionForm
          mode="edit"
          initialData={promotion}
          onSubmit={onSubmit}
          onCancel={() => onOpenChange(false)}
          isSubmitting={isSubmitting}
        />
      )}
    </ResponsiveDialog>
  );
}
