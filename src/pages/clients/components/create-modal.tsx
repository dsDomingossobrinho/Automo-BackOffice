import { toast } from 'sonner';
import { ResponsiveDialog } from '../../../components/common/responsive-dialog';
import { useCreateClient } from '../../../hooks/useClients';
import type { CreateClientData } from '../../../types';
import ClientForm from './form';

interface CreateModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
}

export default function CreateClientModal({
  open,
  onOpenChange,
}: Readonly<CreateModalProps>) {
  const createMutation = useCreateClient();

  const handleSubmit = async (data: CreateClientData) => {
    try {
      await createMutation.mutateAsync(data);
      toast.success('Cliente criado com sucesso!');
      onOpenChange(false);
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : 'Erro ao criar cliente';
      toast.error(message);
    }
  };

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={createMutation.isPending ? () => { } : onOpenChange}
      title="Novo Cliente"
      description="Preencha os campos abaixo para criar um novo cliente."
    >
      <ClientForm
        mode="create"
        onSubmit={handleSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={createMutation.isPending}
      />
    </ResponsiveDialog>
  );
}
