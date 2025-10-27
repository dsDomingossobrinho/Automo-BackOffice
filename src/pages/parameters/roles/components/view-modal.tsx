import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Label } from "@/components/ui/label";
import type { RoleInfo } from "@/types";

interface ViewModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  role: RoleInfo | null;
}

export default function ViewRoleModal({ open, onOpenChange, role }: ViewModalProps) {
  return (
    <ResponsiveDialog open={open} onOpenChange={onOpenChange} title="Detalhes do Cargo">
      {role && (
        <div className="space-y-4">
          <div className="space-y-2">
            <Label className="text-muted-foreground">Nome:</Label>
            <p className="font-medium">{role.name}</p>
          </div>
          <div className="space-y-2">
            <Label className="text-muted-foreground">Descrição:</Label>
            <p className="font-medium">{role.description || "-"}</p>
          </div>
        </div>
      )}
    </ResponsiveDialog>
  );
}
