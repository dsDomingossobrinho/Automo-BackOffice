import { AlertTriangle, Trash2 } from 'lucide-react';
import { toast } from 'sonner';
import { ResponsiveDialog } from '../../../components/common/responsive-dialog';
import { useDeleteClient } from '../../../hooks/useClients';
import type { Client } from '../../../types';

interface DeleteModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  client: Client | null;
}

export default function DeleteClientModal({
  open,
  onOpenChange,
  client,
}: Readonly<DeleteModalProps>) {
  const deleteMutation = useDeleteClient();

  const handleDelete = async () => {
    if (!client) return;

    try {
      await deleteMutation.mutateAsync(client.id);
      toast.success('Cliente eliminado com sucesso!');
      onOpenChange(false);
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : 'Erro ao eliminar cliente';
      toast.error(message);
    }
  };

  if (!client) return null;

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={deleteMutation.isPending ? () => { } : onOpenChange}
      title="Eliminar Cliente"
      description="Esta ação não pode ser revertida!"
      actions={[
        {
          label: 'Cancelar',
          variant: 'outline',
          onClick: () => onOpenChange(false),
          disabled: deleteMutation.isPending,
        },
        {
          label: 'Eliminar',
          variant: 'destructive',
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
            Tem a certeza de que deseja eliminar o cliente{' '}
            <strong>{client.name}</strong>?
          </p>
          <div className="text-sm text-muted-foreground space-y-1">
            <p>
              Email: <strong>{client.email}</strong>
            </p>
          </div>
        </div>
      </div>
    </ResponsiveDialog>
  );
}
