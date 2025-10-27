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
import { useCountries } from "@/hooks/useCountries";
import { useStates } from "@/hooks/useStates";
import type { CreateProvinceData, Province, UpdateProvinceData } from "@/types";

interface FormProps {
  mode?: "create" | "edit";
  initialData?: Province;
  onSubmit: (data: CreateProvinceData | UpdateProvinceData) => Promise<void>;
  onCancel?: () => void;
  isSubmitting?: boolean;
}

export default function ProvinceForm({
  mode = "create",
  initialData,
  onSubmit,
  onCancel,
  isSubmitting = false,
}: FormProps) {
  const nameId = useId();
  const descriptionId = useId();
  const countryId = useId();
  const stateId = useId();

  const [formData, setFormData] = useState<CreateProvinceData>({
    name: initialData?.name || "",
    description: initialData?.description || "",
    countryId: initialData?.countryId,
    stateId: initialData?.stateId,
  });

  const [errors, setErrors] = useState<Record<string, string>>({});

  // Fetch countries and states
  const { data: countriesData } = useCountries(0, 1000);
  const { data: statesData } = useStates(0, 1000);

  const countries = useMemo(
    () => countriesData?.content || [],
    [countriesData],
  );
  const states = useMemo(() => statesData?.content || [], [statesData]);

  const validateForm = useCallback(() => {
    const newErrors: Record<string, string> = {};

    if (!formData.name?.trim()) {
      newErrors.name = "O nome da província é obrigatório";
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
        <Label htmlFor={nameId}>Nome da Província *</Label>
        <Input
          id={nameId}
          value={formData.name}
          onChange={(e) => {
            setFormData({ ...formData, name: e.target.value });
            if (errors.name) {
              setErrors({ ...errors, name: "" });
            }
          }}
          placeholder="Ex: Luanda, São Paulo"
          disabled={isSubmitting}
        />
        {errors.name && (
          <p className="text-xs text-destructive">{errors.name}</p>
        )}
      </div>

      {/* Country Field */}
      <div className="space-y-2">
        <Label htmlFor={countryId}>País</Label>
        <Select
          value={String(formData.countryId || "")}
          onValueChange={(value) =>
            setFormData({
              ...formData,
              countryId: value ? parseInt(value) : undefined,
            })
          }
          disabled={isSubmitting}
        >
          <SelectTrigger id={countryId}>
            <SelectValue placeholder="Selecione um país" />
          </SelectTrigger>
          <SelectContent>
            {countries.map((country) => (
              <SelectItem key={country.id} value={String(country.id)}>
                {country.name}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
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
          placeholder="Descrição da província (opcional)"
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
