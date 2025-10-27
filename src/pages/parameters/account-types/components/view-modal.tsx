import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Label } from "@/components/ui/label";
import type { AccountType } from "@/types";

interface ViewModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  accountType: AccountType | null;
}

export default function ViewAccountTypeModal({
  open,
  onOpenChange,
  accountType,
}: ViewModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={onOpenChange}
      title="Detalhes do Tipo de Conta"
    >
      {accountType && (
        <div className="space-y-4">
          <div className="space-y-2">
            <Label className="text-muted-foreground">Tipo:</Label>
            <p className="font-medium">{accountType.type}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Descrição:</Label>
            <p className="font-medium">{accountType.description || "-"}</p>
          </div>
          {accountType.createdAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Criado em:</Label>
              <p className="font-medium text-xs">
                {new Date(accountType.createdAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
          {accountType.updatedAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Atualizado em:</Label>
              <p className="font-medium text-xs">
                {new Date(accountType.updatedAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
        </div>
      )}
    </ResponsiveDialog>
  );
}
