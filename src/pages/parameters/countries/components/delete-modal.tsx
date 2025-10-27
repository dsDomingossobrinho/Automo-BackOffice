import { Trash2 } from "lucide-react";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import type { Country } from "@/types";

interface DeleteModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  country: Country | null;
  onConfirm: () => Promise<void>;
  isDeleting?: boolean;
}

export default function DeleteCountryModal({
  open,
  onOpenChange,
  country,
  onConfirm,
  isDeleting = false,
}: DeleteModalProps) {
  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={(newOpen) => !isDeleting && onOpenChange(newOpen)}
      title="Eliminar País"
      description="Esta ação não pode ser revertida!"
      actions={[
        {
          label: "Cancelar",
          variant: "outline",
          onClick: () => onOpenChange(false),
          disabled: isDeleting,
        },
        {
          label: "Eliminar",
          variant: "destructive",
          onClick: onConfirm,
          disabled: isDeleting,
          loading: isDeleting,
          icon: Trash2,
        },
      ]}
    >
      {country && (
        <div className="flex flex-col items-center gap-4 py-4">
          <div className="rounded-full bg-destructive/10 p-3">
            <Trash2 className="h-6 w-6 text-destructive" />
          </div>
          <p className="text-center text-sm">
            Tem a certeza que deseja eliminar o país{" "}
            <span className="font-semibold">{country.name}</span>?
          </p>
        </div>
      )}
    </ResponsiveDialog>
  );
}
