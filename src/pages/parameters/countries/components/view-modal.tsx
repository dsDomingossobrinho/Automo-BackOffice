import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Label } from "@/components/ui/label";
import type { Country } from "@/types";

interface ViewModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  country: Country | null;
}

export default function ViewCountryModal({
  open,
  onOpenChange,
  country,
}: ViewModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={onOpenChange}
      title="Detalhes do País"
    >
      {country && (
        <div className="space-y-4">
          <div className="space-y-2">
            <Label className="text-muted-foreground">Nome:</Label>
            <p className="font-medium">{country.name}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Código:</Label>
            <p className="font-medium">{country.code || "-"}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Descrição:</Label>
            <p className="font-medium">{country.description || "-"}</p>
          </div>
          {country.createdAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Criado em:</Label>
              <p className="font-medium text-xs">
                {new Date(country.createdAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
          {country.updatedAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Atualizado em:</Label>
              <p className="font-medium text-xs">
                {new Date(country.updatedAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
        </div>
      )}
    </ResponsiveDialog>
  );
}
