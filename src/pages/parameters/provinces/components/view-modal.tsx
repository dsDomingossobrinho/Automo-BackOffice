import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Label } from "@/components/ui/label";
import type { Province } from "@/types";

interface ViewModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  province: Province | null;
}

export default function ViewProvinceModal({
  open,
  onOpenChange,
  province,
}: ViewModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={onOpenChange}
      title="Detalhes da Província"
    >
      {province && (
        <div className="space-y-4">
          <div className="space-y-2">
            <Label className="text-muted-foreground">Nome:</Label>
            <p className="font-medium">{province.name}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">País:</Label>
            <p className="font-medium">{province.countryName || "-"}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Estado:</Label>
            <p className="font-medium">{province.stateName || "-"}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Descrição:</Label>
            <p className="font-medium">{province.description || "-"}</p>
          </div>
          {province.createdAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Criado em:</Label>
              <p className="font-medium text-xs">
                {new Date(province.createdAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
          {province.updatedAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Atualizado em:</Label>
              <p className="font-medium text-xs">
                {new Date(province.updatedAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
        </div>
      )}
    </ResponsiveDialog>
  );
}
