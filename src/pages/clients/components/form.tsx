import { Loader2 } from "lucide-react";
import { type FormEvent, useEffect, useId, useMemo, useState } from "react";
import { Button } from "../../../components/ui/button";
import { Input } from "../../../components/ui/input";
import { Label } from "../../../components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "../../../components/ui/select";
import { useAccountTypes } from "../../../hooks/useAccountTypes";
import { useCountries } from "../../../hooks/useCountries";
import { useOrganizationTypes } from "../../../hooks/useOrganizationTypes";
import { useProvinces } from "../../../hooks/useProvinces";
import { useStates } from "../../../hooks/useStates";
import type { Client, CreateClientData } from "../../../types";

interface FormProps {
  mode: "create" | "edit";
  initialData?: Client;
  onSubmit: (data: CreateClientData) => Promise<void>;
  onCancel: () => void;
  isSubmitting?: boolean;
}

/**
 * Client Form Component
 * Reusable form for creating and editing clients
 */
export default function ClientForm({
  mode,
  initialData,
  onSubmit,
  onCancel,
  isSubmitting = false,
}: Readonly<FormProps>) {
  // Fetch reference data
  const { data: countries } = useCountries();
  const { data: accountTypes } = useAccountTypes();
  const { data: organizationTypes } = useOrganizationTypes();
  const { data: states } = useStates();

  const [selectedCountryId, setSelectedCountryId] = useState<
    number | undefined
  >(initialData?.countryId);
  const { data: provinces } = useProvinces(selectedCountryId);

  const nameId = useId();
  const emailId = useId();
  const contactoId = useId();
  const imgId = useId();
  const accountTypeIdField = useId();
  const organizationTypeIdField = useId();
  const countryIdField = useId();
  const provinceIdField = useId();
  const stateIdField = useId();

  const [formData, setFormData] = useState<CreateClientData>(
    initialData
      ? {
        name: initialData.name,
        email: initialData.email,
        img: initialData.img,
        contacto: "",
        password: "",
        accountTypeId: 1,
        countryId: initialData.countryId || 0,
        organizationTypeId: initialData.organizationTypeId || 0,
        provinceId: initialData.provinceId,
        stateId: initialData.stateId || 1,
      }
      : {
        name: "",
        email: "",
        img: "",
        contacto: "",
        password: "",
        accountTypeId: 1,
        countryId: 0,
        organizationTypeId: 0,
        provinceId: undefined,
        stateId: 1,
      },
  );

  const [errors, setErrors] = useState<Record<string, string>>({});

  // Normalize API list responses into typed arrays for template mapping
  // Handle both direct array responses and wrapped responses
  const accountTypesList = useMemo(
    () =>
      Array.isArray(accountTypes)
        ? (accountTypes as { id: number; type: string }[])
        : Array.isArray(accountTypes?.data)
          ? (accountTypes.data as { id: number; type: string }[])
          : [],
    [accountTypes],
  );

  const organizationTypesList = useMemo(
    () =>
      Array.isArray(organizationTypes)
        ? (organizationTypes as { id: number; type: string }[])
        : Array.isArray(organizationTypes?.data)
          ? (organizationTypes.data as { id: number; type: string }[])
          : [],
    [organizationTypes],
  );

  const countriesList = useMemo(
    () =>
      Array.isArray(countries)
        ? (countries as { id: number; country: string }[])
        : Array.isArray(countries?.data)
          ? (countries.data as { id: number; country: string }[])
          : [],
    [countries],
  );

  const provincesList = useMemo(
    () =>
      Array.isArray(provinces)
        ? (provinces as { id: number; province: string }[])
        : Array.isArray(provinces?.data)
          ? (provinces.data as { id: number; province: string }[])
          : [],
    [provinces],
  );

  const statesList = useMemo(
    () =>
      Array.isArray(states)
        ? (states as { id: number; state: string }[])
        : Array.isArray(states?.data)
          ? (states.data as { id: number; state: string }[])
          : [],
    [states],
  );

  // Debug: Log the data to understand the structure
  useEffect(() => {
    console.log("Select Data Debug:", {
      countries,
      countriesList,
      states,
      statesList,
      provinces,
      provincesList,
      organizationTypes,
      organizationTypesList,
    });
  }, [countries, countriesList, states, statesList, provinces, provincesList, organizationTypes, organizationTypesList]);

  // Update selected country when form data changes
  useEffect(() => {
    if (formData.countryId) {
      setSelectedCountryId(formData.countryId);
    }
  }, [formData.countryId]);

  const handleChange = (
    e: React.ChangeEvent<
      HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement
    >,
  ) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));

    // Clear error when user starts typing
    if (errors[name]) {
      setErrors((prev) => {
        const newErrors = { ...prev };
        delete newErrors[name];
        return newErrors;
      });
    }
  };

  const handleSelectChange = (name: string, value: string) => {
    const numValue = value === "" ? 0 : parseInt(value, 10);
    setFormData((prev) => ({ ...prev, [name]: numValue }));

    if (errors[name]) {
      setErrors((prev) => {
        const newErrors = { ...prev };
        delete newErrors[name];
        return newErrors;
      });
    }
  };

  const validateForm = (): boolean => {
    const newErrors: Record<string, string> = {};

    // Required fields
    if (!formData.name?.trim()) {
      newErrors.name = "Nome é obrigatório";
    }

    if (!formData.email?.trim()) {
      newErrors.email = "Email é obrigatório";
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = "Email inválido";
    }

    if (!formData.organizationTypeId || formData.organizationTypeId === 0) {
      newErrors.organizationTypeId = "Tipo de organização é obrigatório";
    }

    if (!formData.countryId || formData.countryId === 0) {
      newErrors.countryId = "País é obrigatório";
    }

    if (!formData.stateId || formData.stateId === 0) {
      newErrors.stateId = "Estado é obrigatório";
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();

    if (!validateForm()) {
      return;
    }

    await onSubmit(formData);
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
      {/* Basic Information */}
      <div className="space-y-4">
        <h3 className="text-sm font-semibold">Informações Básicas</h3>

        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div className="space-y-2">
            <Label htmlFor={nameId} className="required">
              Nome
            </Label>
            <Input
              id={nameId}
              name="name"
              value={formData.name}
              onChange={handleChange}
              disabled={isSubmitting}
              placeholder="Nome completo do cliente"
              required
            />
            {errors.name && (
              <span className="text-xs text-destructive">{errors.name}</span>
            )}
          </div>

          <div className="space-y-2">
            <Label htmlFor={emailId} className="required">
              Email
            </Label>
            <Input
              id={emailId}
              type="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              disabled={isSubmitting}
              placeholder="email@example.com"
              required
            />
            {errors.email && (
              <span className="text-xs text-destructive">{errors.email}</span>
            )}
          </div>
        </div>

        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div className="space-y-2">
            <Label htmlFor={contactoId}>Contacto</Label>
            <Input
              id={contactoId}
              name="contacto"
              value={formData.contacto || ""}
              onChange={handleChange}
              disabled={isSubmitting}
              placeholder="+351 912 345 678"
            />
          </div>

          {/* Image URL only editable in edit mode */}
          {mode === "edit" && (
            <div className="space-y-2">
              <Label htmlFor={imgId}>URL da Imagem</Label>
              <Input
                id={imgId}
                name="img"
                value={formData.img || ""}
                onChange={handleChange}
                disabled={isSubmitting}
                placeholder="https://example.com/image.jpg"
              />
            </div>
          )}
        </div>
      </div>

      {/* Location and Organization */}
      <div className="space-y-4">
        <h3 className="text-sm font-semibold">Localização e Organização</h3>

        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
          {/* Account Type only in edit mode */}
          {mode === "edit" && (
            <div className="space-y-2">
              <Label htmlFor={accountTypeIdField} className="required">
                Tipo de Conta
              </Label>
              <Select
                value={String(formData.accountTypeId)}
                onValueChange={(value) =>
                  handleSelectChange("accountTypeId", value)
                }
                disabled={isSubmitting}
              >
                <SelectTrigger id={accountTypeIdField}>
                  <SelectValue placeholder="Selecione..." />
                </SelectTrigger>
                <SelectContent>
                  {accountTypesList.map((type) => (
                    <SelectItem key={type.id} value={String(type.id)}>
                      {type.type}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
              {errors.accountTypeId && (
                <span className="text-xs text-destructive">
                  {errors.accountTypeId}
                </span>
              )}
            </div>
          )}

          <div className="space-y-2">
            <Label htmlFor={organizationTypeIdField} className="required">
              Tipo de Organização
            </Label>
            <Select
              value={String(formData.organizationTypeId)}
              onValueChange={(value) =>
                handleSelectChange("organizationTypeId", value)
              }
              disabled={isSubmitting}
            >
              <SelectTrigger id={organizationTypeIdField}>
                <SelectValue placeholder="Selecione..." />
              </SelectTrigger>
              <SelectContent>
                {organizationTypesList.map((type) => (
                  <SelectItem key={type.id} value={String(type.id)}>
                    {type.type}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
            {errors.organizationTypeId && (
              <span className="text-xs text-destructive">
                {errors.organizationTypeId}
              </span>
            )}
          </div>
        </div>

        <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div className="space-y-2">
            <Label htmlFor={countryIdField} className="required">
              País
            </Label>
            <Select
              value={String(formData.countryId)}
              onValueChange={(value) => handleSelectChange("countryId", value)}
              disabled={isSubmitting}
            >
              <SelectTrigger id={countryIdField}>
                <SelectValue placeholder="Selecione..." />
              </SelectTrigger>
              <SelectContent>
                {countriesList.map((country) => (
                  <SelectItem key={country.id} value={String(country.id)}>
                    {country.country}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
            {errors.countryId && (
              <span className="text-xs text-destructive">
                {errors.countryId}
              </span>
            )}
          </div>

          <div className="space-y-2">
            <Label htmlFor={provinceIdField}>Província</Label>
            <Select
              value={String(formData.provinceId || "")}
              onValueChange={(value) => handleSelectChange("provinceId", value)}
              disabled={isSubmitting || !formData.countryId}
            >
              <SelectTrigger id={provinceIdField}>
                <SelectValue placeholder="Selecione..." />
              </SelectTrigger>
              <SelectContent>
                {provincesList.map((province) => (
                  <SelectItem key={province.id} value={String(province.id)}>
                    {province.province}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
          </div>

          <div className="space-y-2">
            <Label htmlFor={stateIdField} className="required">
              Estado
            </Label>
            <Select
              value={String(formData.stateId)}
              onValueChange={(value) => handleSelectChange("stateId", value)}
              disabled={isSubmitting}
            >
              <SelectTrigger id={stateIdField}>
                <SelectValue placeholder="Selecione..." />
              </SelectTrigger>
              <SelectContent>
                {statesList.map((state) => (
                  <SelectItem key={state.id} value={String(state.id)}>
                    {state.state}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
            {errors.stateId && (
              <span className="text-xs text-destructive">{errors.stateId}</span>
            )}
          </div>
        </div>
      </div>

      {/* Form Actions */}
      <div className="flex justify-end gap-3 border-t pt-6">
        <Button
          type="button"
          variant="outline"
          onClick={onCancel}
          disabled={isSubmitting}
        >
          Cancelar
        </Button>
        <Button type="submit" disabled={isSubmitting}>
          {isSubmitting && <Loader2 className="mr-2 h-4 w-4 animate-spin" />}
          {mode === "create" ? "Criar Cliente" : "Guardar Alterações"}
        </Button>
      </div>
    </form>
  );
}
