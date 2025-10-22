import { AlertTriangle, Trash2 } from "lucide-react";
import { toast } from "sonner";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { useDeleteAdmin } from "@/hooks/useAdmins";
import type { Admin } from "@/types/admin";

interface DeleteModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  admin: Admin | null;
}

export default function DeleteModal({ open, onOpenChange, admin }: DeleteModalProps) {
  const deleteMutation = useDeleteAdmin();

  const handleDelete = async () => {
    if (!admin) return;

    try {
      await deleteMutation.mutateAsync(admin.id);
      toast.success("Administrador eliminado com sucesso!");
      onOpenChange(false);
    } catch (error: unknown) {
      const message =
        error instanceof Error
          ? error.message
          : "Erro ao eliminar administrador";
      toast.error(message);
    }
  };

  if (!admin) return null;

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={deleteMutation.isPending ? () => {} : onOpenChange}
      title="Eliminar Administrador"
      description="Esta ação não pode ser revertida!"
      actions={[
        {
          label: "Cancelar",
          variant: "outline",
          onClick: () => onOpenChange(false),
          disabled: deleteMutation.isPending,
        },
        {
          label: "Eliminar",
          variant: "destructive",
          onClick: () => void handleDelete(),
          disabled: deleteMutation.isPending,
          loading: deleteMutation.isPending,
          icon: Trash2,
        },
      ]}
    >
      <div className="flex flex-col items-center gap-4 py-4">
        <div className="flex h-16 w-16 items-center justify-center rounded-full bg-destructive/10">
          <AlertTriangle className="h-8 w-8 text-destructive" />
        </div>

        <div className="space-y-2 text-center">
          <p className="text-base">
            Tem a certeza de que deseja eliminar o administrador{" "}
            <strong>{admin.name}</strong>?
          </p>
          <div className="text-sm text-muted-foreground space-y-1">
            <p>
              Email: <strong>{admin.email}</strong>
            </p>
            <p>
              Username: <strong>@{admin.username}</strong>
            </p>
          </div>
        </div>
      </div>
    </ResponsiveDialog>
  );
}
