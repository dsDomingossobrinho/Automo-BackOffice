import { useCallback, useId, useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import type { AccountType, CreateAccountTypeData, UpdateAccountTypeData } from "@/types";

interface FormProps {
  mode?: "create" | "edit";
  initialData?: AccountType;
  onSubmit: (data: CreateAccountTypeData | UpdateAccountTypeData) => Promise<void>;
  onCancel?: () => void;
  isSubmitting?: boolean;
}

export default function AccountTypeForm({
  mode = "create",
  initialData,
  onSubmit,
  onCancel,
  isSubmitting = false,
}: FormProps) {
  const typeId = useId();
  const descriptionId = useId();

  const [formData, setFormData] = useState<CreateAccountTypeData>({
    type: initialData?.type || "",
    description: initialData?.description || "",
  });

  const [errors, setErrors] = useState<Record<string, string>>({});

  const validateForm = useCallback(() => {
    const newErrors: Record<string, string> = {};

    if (!formData.type?.trim()) {
      newErrors.type = "O tipo de conta é obrigatório";
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  }, [formData]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    if (!validateForm()) return;

    try {
      await onSubmit(formData);
    } catch {
      // Error handling is done in parent component
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      {/* Type Field */}
      <div className="space-y-2">
        <Label htmlFor={typeId}>Tipo de Conta *</Label>
        <Input
          id={typeId}
          value={formData.type}
          onChange={(e) => {
            setFormData({ ...formData, type: e.target.value });
            if (errors.type) {
              setErrors({ ...errors, type: "" });
            }
          }}
          placeholder="Ex: Premium, Standard"
          disabled={isSubmitting}
        />
        {errors.type && (
          <p className="text-xs text-destructive">{errors.type}</p>
        )}
      </div>

      {/* Description Field */}
      <div className="space-y-2">
        <Label htmlFor={descriptionId}>Descrição</Label>
        <Input
          id={descriptionId}
          value={formData.description || ""}
          onChange={(e) =>
            setFormData({ ...formData, description: e.target.value })
          }
          placeholder="Descrição da conta (opcional)"
          disabled={isSubmitting}
        />
      </div>

      {/* Action Buttons */}
      <div className="flex justify-end gap-3 pt-4">
        <Button
          type="button"
          variant="outline"
          onClick={onCancel}
          disabled={isSubmitting}
        >
          Cancelar
        </Button>
        <Button type="submit" disabled={isSubmitting}>
          {isSubmitting ? (
            <>
              <i className="fas fa-spinner fa-spin mr-2"></i>
              <span>A guardar...</span>
            </>
          ) : (
            `${mode === "create" ? "Criar" : "Guardar"}`
          )}
        </Button>
      </div>
    </form>
  );
}
