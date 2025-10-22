import { toast } from "sonner";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { useCreateAdmin } from "@/hooks/useAdmins";
import type { CreateAccountData } from "@/types";
import AccountForm from "./form";

interface CreateModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
}

export default function CreateModal({ open, onOpenChange }: CreateModalProps) {
  const createMutation = useCreateAdmin();

  const handleSubmit = async (data: CreateAccountData) => {
    try {
      const payload = {
        email: data.email,
        name: data.name,
        img: data.img,
        password: data.password || "",
        contact: data.contact,
        accountTypeId: data.accountTypeId ?? 1,
        stateId: 1, // Default to Active state
      };

      await createMutation.mutateAsync(payload);
      toast.success("Administrador criado com sucesso!");
      onOpenChange(false);
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : "Erro ao criar administrador";
      toast.error(message);
    }
  };

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={createMutation.isPending ? () => {} : onOpenChange}
      title="Novo Administrador"
      description="Preencha os campos abaixo para criar uma nova conta de administrador."
    >
      <AccountForm
        onSubmit={handleSubmit}
        isLoading={createMutation.isPending}
      />
    </ResponsiveDialog>
  );
}
