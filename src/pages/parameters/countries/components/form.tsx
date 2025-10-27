import { useCallback, useId, useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import type { Country, CreateCountryData, UpdateCountryData } from "@/types";

interface FormProps {
  mode?: "create" | "edit";
  initialData?: Country;
  onSubmit: (data: CreateCountryData | UpdateCountryData) => Promise<void>;
  onCancel?: () => void;
  isSubmitting?: boolean;
}

export default function CountryForm({
  mode = "create",
  initialData,
  onSubmit,
  onCancel,
  isSubmitting = false,
}: FormProps) {
  const nameId = useId();
  const codeId = useId();
  const descriptionId = useId();

  const [formData, setFormData] = useState<CreateCountryData>({
    name: initialData?.name || "",
    code: initialData?.code || "",
    description: initialData?.description || "",
  });

  const [errors, setErrors] = useState<Record<string, string>>({});

  const validateForm = useCallback(() => {
    const newErrors: Record<string, string> = {};

    if (!formData.name?.trim()) {
      newErrors.name = "O nome do país é obrigatório";
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
      {/* Name Field */}
      <div className="space-y-2">
        <Label htmlFor={nameId}>Nome do País *</Label>
        <Input
          id={nameId}
          value={formData.name}
          onChange={(e) => {
            setFormData({ ...formData, name: e.target.value });
            if (errors.name) {
              setErrors({ ...errors, name: "" });
            }
          }}
          placeholder="Ex: Portugal, Brasil"
          disabled={isSubmitting}
        />
        {errors.name && (
          <p className="text-xs text-destructive">{errors.name}</p>
        )}
      </div>

      {/* Code Field */}
      <div className="space-y-2">
        <Label htmlFor={codeId}>Código</Label>
        <Input
          id={codeId}
          value={formData.code || ""}
          onChange={(e) =>
            setFormData({ ...formData, code: e.target.value })
          }
          placeholder="Ex: PT, BR"
          disabled={isSubmitting}
        />
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
          placeholder="Descrição do país (opcional)"
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
