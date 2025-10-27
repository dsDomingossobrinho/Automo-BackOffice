import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Label } from "@/components/ui/label";
import type { State } from "@/types";

interface ViewModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  state: State | null;
}

export default function ViewStateModal({
  open,
  onOpenChange,
  state,
}: ViewModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={onOpenChange}
      title="Detalhes do Estado"
    >
      {state && (
        <div className="space-y-4">
          <div className="space-y-2">
            <Label className="text-muted-foreground">Nome:</Label>
            <p className="font-medium">{state.state}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Descrição:</Label>
            <p className="font-medium">{state.description || "-"}</p>
          </div>
          {state.createdAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Criado em:</Label>
              <p className="font-medium text-xs">
                {new Date(state.createdAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
          {state.updatedAt && (
            <div className="space-y-2">
              <Label className="text-muted-foreground">Atualizado em:</Label>
              <p className="font-medium text-xs">
                {new Date(state.updatedAt).toLocaleString("pt-PT")}
              </p>
            </div>
          )}
        </div>
      )}
    </ResponsiveDialog>
  );
}
