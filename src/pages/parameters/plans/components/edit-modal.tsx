import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { SubscriptionPlan, UpdateSubscriptionPlanData } from "@/types";
import SubscriptionPlanForm from "./form";

interface EditModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  plan: SubscriptionPlan | null;
  onSubmit: (data: UpdateSubscriptionPlanData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function EditSubscriptionPlanModal({
  open,
  onOpenChange,
  plan,
  onSubmit,
  isSubmitting = false,
}: EditModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Editar Plano de Subscrição"
      description="Modifique os detalhes do plano"
    >
      {plan && (
        <SubscriptionPlanForm
          mode="edit"
          initialData={plan}
          onSubmit={onSubmit}
          onCancel={() => onOpenChange(false)}
          isSubmitting={isSubmitting}
        />
      )}
    </ResponsiveDialog>
  );
}
