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
  SubscriptionPlan,
  CreateSubscriptionPlanData,
  UpdateSubscriptionPlanData,
} from "@/types";

interface FormProps {
  mode?: "create" | "edit";
  initialData?: SubscriptionPlan;
  onSubmit: (
    data: CreateSubscriptionPlanData | UpdateSubscriptionPlanData
  ) => Promise<void>;
  onCancel?: () => void;
  isSubmitting?: boolean;
}

export default function SubscriptionPlanForm({
  mode = "create",
  initialData,
  onSubmit,
  onCancel,
  isSubmitting = false,
}: FormProps) {
  const nameId = useId();
  const priceId = useId();
  const descriptionId = useId();
  const messageCountId = useId();
  const stateId = useId();

  const [formData, setFormData] = useState<CreateSubscriptionPlanData>({
    name: initialData?.name || "",
    price: initialData?.price || 0,
    description: initialData?.description || "",
    messageCount: initialData?.messageCount || 0,
    stateId: initialData?.stateId,
  });

  const [errors, setErrors] = useState<Record<string, string>>({});

  // Fetch states
  const { data: statesData } = useStates(0, 1000);
  const states = useMemo(() => statesData?.content || [], [statesData]);

  const validateForm = useCallback(() => {
    const newErrors: Record<string, string> = {};

    if (!formData.name?.trim()) {
      newErrors.name = "O nome do plano é obrigatório";
    }

    if (formData.price === null || formData.price === undefined || formData.price < 0) {
      newErrors.price = "O preço deve ser um valor válido";
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
        <Label htmlFor={nameId}>Nome do Plano *</Label>
        <Input
          id={nameId}
          value={formData.name}
          onChange={(e) => {
            setFormData({ ...formData, name: e.target.value });
            if (errors.name) {
              setErrors({ ...errors, name: "" });
            }
          }}
          placeholder="Ex: Premium, Standard, Basic"
          disabled={isSubmitting}
        />
        {errors.name && (
          <p className="text-xs text-destructive">{errors.name}</p>
        )}
      </div>

      {/* Price Field */}
      <div className="space-y-2">
        <Label htmlFor={priceId}>Preço *</Label>
        <Input
          id={priceId}
          type="number"
          step="0.01"
          min="0"
          value={formData.price}
          onChange={(e) => {
            setFormData({ ...formData, price: parseFloat(e.target.value) });
            if (errors.price) {
              setErrors({ ...errors, price: "" });
            }
          }}
          placeholder="0.00"
          disabled={isSubmitting}
        />
        {errors.price && (
          <p className="text-xs text-destructive">{errors.price}</p>
        )}
      </div>

      {/* Message Count Field */}
      <div className="space-y-2">
        <Label htmlFor={messageCountId}>Quantidade de Mensagens</Label>
        <Input
          id={messageCountId}
          type="number"
          min="0"
          value={formData.messageCount || 0}
          onChange={(e) =>
            setFormData({
              ...formData,
              messageCount: parseInt(e.target.value) || 0,
            })
          }
          placeholder="1000"
          disabled={isSubmitting}
        />
      </div>

      {/* State Field */}
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
            {states.map((state) => (
              <SelectItem key={state.id} value={String(state.id)}>
                {state.state || state.description || "Sem nome"}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
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
          placeholder="Descrição do plano (opcional)"
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
