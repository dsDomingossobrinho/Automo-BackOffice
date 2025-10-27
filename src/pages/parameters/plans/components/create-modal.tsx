import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { CreateSubscriptionPlanData } from "@/types";
import SubscriptionPlanForm from "./form";

interface CreateModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  onSubmit: (data: CreateSubscriptionPlanData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function CreateSubscriptionPlanModal({
  open,
  onOpenChange,
  onSubmit,
  isSubmitting = false,
}: CreateModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Criar Plano de Subscrição"
      description="Adicione um novo plano ao sistema"
    >
      <SubscriptionPlanForm
        mode="create"
        onSubmit={onSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={isSubmitting}
      />
    </ResponsiveDialog>
  );
}
