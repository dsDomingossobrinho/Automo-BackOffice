import { useCallback, useId, useMemo, useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { useStates } from "@/hooks/useStates";
import type {
  CreatePromotionData,
  Promotion,
  UpdatePromotionData,
} from "@/types";

interface FormProps {
  mode?: "create" | "edit";
  initialData?: Promotion;
  onSubmit: (data: CreatePromotionData | UpdatePromotionData) => Promise<void>;
  onCancel?: () => void;
  isSubmitting?: boolean;
}

export default function PromotionForm({
  mode = "create",
  initialData,
  onSubmit,
  onCancel,
  isSubmitting = false,
}: FormProps) {
  const nameId = useId();
  const codeId = useId();
  const discountId = useId();
  const descriptionId = useId();
  const stateId = useId();

  const [formData, setFormData] = useState<CreatePromotionData>({
    name: initialData?.name || "",
    code: initialData?.code || "",
    discount: initialData?.discount || 0,
    description: initialData?.description || "",
    stateId: initialData?.stateId,
  });

  const [errors, setErrors] = useState<Record<string, string>>({});

  const { data: statesData } = useStates(0, 1000);
  const states = useMemo(() => statesData?.content || [], [statesData]);

  const validateForm = useCallback(() => {
    const newErrors: Record<string, string> = {};

    if (!formData.name?.trim()) {
      newErrors.name = "O nome é obrigatório";
    }

    if (!formData.code?.trim()) {
      newErrors.code = "O código é obrigatório";
    }

    if (
      formData.discount === null ||
      formData.discount === undefined ||
      formData.discount < 0
    ) {
      newErrors.discount = "O desconto deve ser um valor válido";
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
      // parent handles errors
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div className="space-y-2">
        <Label htmlFor={nameId}>Nome *</Label>
        <Input
          id={nameId}
          value={formData.name}
          onChange={(e) => {
            setFormData({ ...formData, name: e.target.value });
            if (errors.name) setErrors({ ...errors, name: "" });
          }}
          disabled={isSubmitting}
        />
        {errors.name && (
          <p className="text-xs text-destructive">{errors.name}</p>
        )}
      </div>

      <div className="space-y-2">
        <Label htmlFor={codeId}>Código *</Label>
        <Input
          id={codeId}
          value={formData.code}
          onChange={(e) => {
            setFormData({ ...formData, code: e.target.value });
            if (errors.code) setErrors({ ...errors, code: "" });
          }}
          disabled={isSubmitting}
        />
        {errors.code && (
          <p className="text-xs text-destructive">{errors.code}</p>
        )}
      </div>

      <div className="space-y-2">
        <Label htmlFor={discountId}>Desconto (%) *</Label>
        <Input
          id={discountId}
          type="number"
          step="0.01"
          min="0"
          value={formData.discount}
          onChange={(e) =>
            setFormData({
              ...formData,
              discount: parseFloat(e.target.value) || 0,
            })
          }
          disabled={isSubmitting}
        />
        {errors.discount && (
          <p className="text-xs text-destructive">{errors.discount}</p>
        )}
      </div>

      <div className="space-y-2">
        <Label htmlFor={stateId}>Estado</Label>
        <Select
          value={String(formData.stateId || "")}
          onValueChange={(value) =>
            setFormData({
              ...formData,
              stateId: value ? parseInt(value) : undefined,
            })
          }
          disabled={isSubmitting}
        >
          <SelectTrigger id={stateId}>
            <SelectValue placeholder="Selecione um estado" />
          </SelectTrigger>
          <SelectContent>
            {states.map((s) => (
              <SelectItem key={s.id} value={String(s.id)}>
                {s.state || s.description || "Sem nome"}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      </div>

      <div className="space-y-2">
        <Label htmlFor={descriptionId}>Descrição</Label>
        <Input
          id={descriptionId}
          value={formData.description || ""}
          onChange={(e) =>
            setFormData({ ...formData, description: e.target.value })
          }
          disabled={isSubmitting}
        />
      </div>

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
