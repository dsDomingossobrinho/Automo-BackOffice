import { useCallback, useId, useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import type { CreateStateData, State, UpdateStateData } from "@/types";

interface FormProps {
  mode?: "create" | "edit";
  initialData?: State;
  onSubmit: (data: CreateStateData | UpdateStateData) => Promise<void>;
  onCancel?: () => void;
  isSubmitting?: boolean;
}

export default function StateForm({
  mode = "create",
  initialData,
  onSubmit,
  onCancel,
  isSubmitting = false,
}: FormProps) {
  const stateId = useId();
  const descriptionId = useId();

  const [formData, setFormData] = useState<CreateStateData>({
    state: initialData?.state || "",
    description: initialData?.description || "",
  });

  const [errors, setErrors] = useState<Record<string, string>>({});

  const validateForm = useCallback(() => {
    const newErrors: Record<string, string> = {};

    if (!formData.state?.trim()) {
      newErrors.state = "O nome do estado é obrigatório";
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
      {/* State Field */}
      <div className="space-y-2">
        <Label htmlFor={stateId}>Nome do Estado *</Label>
        <Input
          id={stateId}
          value={formData.state}
          onChange={(e) => {
            setFormData({ ...formData, state: e.target.value });
            if (errors.state) {
              setErrors({ ...errors, state: "" });
            }
          }}
          placeholder="Ex: Active, Inactive"
          disabled={isSubmitting}
        />
        {errors.state && (
          <p className="text-xs text-destructive">{errors.state}</p>
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
          placeholder="Descrição do estado (opcional)"
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
