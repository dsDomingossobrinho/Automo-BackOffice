import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Label } from "@/components/ui/label";
import type { SubscriptionPlan } from "@/types";

interface ViewModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  plan: SubscriptionPlan | null;
}

export default function ViewSubscriptionPlanModal({
  open,
  onOpenChange,
  plan,
}: ViewModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={onOpenChange}
      title="Detalhes do Plano"
    >
      {plan && (
        <div className="space-y-4">
          <div className="space-y-2">
            <Label className="text-muted-foreground">Nome:</Label>
            <p className="font-medium">{plan.name}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Preço:</Label>
            <p className="font-medium">
              {new Intl.NumberFormat("pt-PT", {
                style: "currency",
                currency: "EUR",
              }).format(plan.price)}
            </p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">
              Quantidade de Mensagens:
            </Label>
            <p className="font-medium">{plan.messageCount || "-"}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Estado:</Label>
            <p className="font-medium">{plan.stateName || "-"}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Descrição:</Label>
            <p className="font-medium">{plan.description || "-"}</p>
          </div>
          {plan.createdAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Criado em:</Label>
              <p className="font-medium text-xs">
                {new Date(plan.createdAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
          {plan.updatedAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Atualizado em:</Label>
              <p className="font-medium text-xs">
                {new Date(plan.updatedAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
        </div>
      )}
    </ResponsiveDialog>
  );
}
