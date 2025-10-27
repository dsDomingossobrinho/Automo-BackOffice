import { toast } from 'sonner';
import { ResponsiveDialog } from '../../../components/common/responsive-dialog';
import { useUpdateClient } from '../../../hooks/useClients';
import type { Client, CreateClientData } from '../../../types';
import ClientForm from './form';

interface EditModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  client: Client | null;
}

export default function EditClientModal({
  open,
  onOpenChange,
  client,
}: Readonly<EditModalProps>) {
  const updateMutation = useUpdateClient();

  const handleSubmit = async (data: CreateClientData) => {
    if (!client) return;

    try {
      await updateMutation.mutateAsync({
        id: client.id,
        ...data,
      });
      toast.success('Cliente atualizado com sucesso!');
      onOpenChange(false);
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : 'Erro ao atualizar cliente';
      toast.error(message);
    }
  };

  if (!client) return null;

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={updateMutation.isPending ? () => { } : onOpenChange}
      title="Editar Cliente"
      description="Atualize as informações do cliente."
    >
      <ClientForm
        mode="edit"
        initialData={client}
        onSubmit={handleSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={updateMutation.isPending}
      />
    </ResponsiveDialog>
  );
}
