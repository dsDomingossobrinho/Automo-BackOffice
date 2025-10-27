import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Label } from "@/components/ui/label";
import type { Promotion } from "@/types";

interface ViewModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  promotion: Promotion | null;
}

export default function ViewPromotionModal({
  open,
  onOpenChange,
  promotion,
}: ViewModalProps) {
  return (
    <ResponsiveDialog open={open} onOpenChange={onOpenChange} title="Detalhes da Promoção">
      {promotion && (
        <div className="space-y-4">
          <div className="space-y-2">
            <Label className="text-muted-foreground">Nome:</Label>
            <p className="font-medium">{promotion.name}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Código:</Label>
            <p className="font-medium">{promotion.code}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Desconto:</Label>
            <p className="font-medium">{promotion.discount}%</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Estado:</Label>
            <p className="font-medium">{promotion.stateName || "-"}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Descrição:</Label>
            <p className="font-medium">{promotion.description || "-"}</p>
          </div>
          {promotion.createdAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Criado em:</Label>
              <p className="font-medium text-xs">{new Date(promotion.createdAt).toLocaleString("pt-PT")}</p>
            </div>
          )}
          {promotion.updatedAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Atualizado em:</Label>
              <p className="font-medium text-xs">{new Date(promotion.updatedAt).toLocaleString("pt-PT")}</p>
            </div>
          )}
        </div>
      )}
    </ResponsiveDialog>
  );
}
