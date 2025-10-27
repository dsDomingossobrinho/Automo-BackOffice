import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { CreatePromotionData } from "@/types";
import PromotionForm from "./form";

interface CreateModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  onSubmit: (data: CreatePromotionData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function CreatePromotionModal({
  open,
  onOpenChange,
  onSubmit,
  isSubmitting = false,
}: CreateModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Criar Promoção"
      description="Adicione uma nova promoção"
    >
      <PromotionForm
        mode="create"
        onSubmit={onSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={isSubmitting}
      />
    </ResponsiveDialog>
  );
}
