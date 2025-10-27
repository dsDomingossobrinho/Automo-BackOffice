import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { CreateCountryData } from "@/types";
import CountryForm from "./form";

interface CreateModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  onSubmit: (data: CreateCountryData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function CreateCountryModal({
  open,
  onOpenChange,
  onSubmit,
  isSubmitting = false,
}: CreateModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Criar País"
      description="Adicione um novo país ao sistema"
    >
      <CountryForm
        mode="create"
        onSubmit={onSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={isSubmitting}
      />
    </ResponsiveDialog>
  );
}
