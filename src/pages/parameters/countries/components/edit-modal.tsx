import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { Country, UpdateCountryData } from "@/types";
import CountryForm from "./form";

interface EditModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  country: Country | null;
  onSubmit: (data: UpdateCountryData) => Promise<void>;
  isSubmitting?: boolean;
}

export default function EditCountryModal({
  open,
  onOpenChange,
  country,
  onSubmit,
  isSubmitting = false,
}: EditModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isSubmitting && onOpenChange(newOpen)}
      title="Editar País"
      description="Modifique os detalhes do país"
    >
      {country && (
        <CountryForm
          mode="edit"
          initialData={country}
          onSubmit={onSubmit}
          onCancel={() => onOpenChange(false)}
          isSubmitting={isSubmitting}
        />
      )}
    </ResponsiveDialog>
  );
}
