import { useState, type FormEvent, useEffect } from 'react';
import type { CreateClientData, Client } from '../../types';
import { useCountries } from '../../hooks/useCountries';
import { useAccountTypes } from '../../hooks/useAccountTypes';
import { useOrganizationTypes } from '../../hooks/useOrganizationTypes';
import { useStates } from '../../hooks/useStates';
import { useProvinces } from '../../hooks/useProvinces';

interface ClientFormProps {
  mode: 'create' | 'edit';
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
}: Readonly<ClientFormProps>) {
  // Fetch reference data
  const { data: countries } = useCountries();
  const { data: accountTypes } = useAccountTypes();
  const { data: organizationTypes } = useOrganizationTypes();
  const { data: states } = useStates();

  const [selectedCountryId, setSelectedCountryId] = useState<number | undefined>(initialData?.countryId);
  const { data: provinces } = useProvinces(selectedCountryId);

  const [formData, setFormData] = useState<CreateClientData>(
    initialData ? {
      name: initialData.name,
      email: initialData.email,
      img: initialData.img,
      contacto: '',
      password: '',
      accountTypeId: 1, // Default account type
      countryId: initialData.countryId || 0,
      organizationTypeId: initialData.organizationTypeId || 0,
      provinceId: initialData.provinceId,
      stateId: initialData.stateId || 1,
    } : {
      name: '',
      email: '',
      img: '',
      contacto: '',
      password: '',
      accountTypeId: 1,
      countryId: 0,
      organizationTypeId: 0,
      provinceId: undefined,
      stateId: 1,
    }
  );

  const [errors, setErrors] = useState<Record<string, string>>({});

  // Normalize API list responses into typed arrays for template mapping
  const accountTypesList = (accountTypes?.data ?? []) as { id: number; type: string }[];
  const organizationTypesList = (organizationTypes?.data ?? []) as { id: number; type: string }[];
  const countriesList = (countries?.data ?? []) as { id: number; country: string }[];
  const provincesList = (provinces?.data ?? []) as { id: number; province: string }[];
  const statesList = (states?.data ?? []) as { id: number; state: string }[];

  // Update selected country when form data changes
  useEffect(() => {
    if (formData.countryId) {
      setSelectedCountryId(formData.countryId);
    }
  }, [formData.countryId]);

  const handleChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>
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

  const validateForm = (): boolean => {
    const newErrors: Record<string, string> = {};

    // Required fields
    if (!formData.name?.trim()) {
      newErrors.name = 'Nome é obrigatório';
    }

    if (!formData.email?.trim()) {
      newErrors.email = 'Email é obrigatório';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = 'Email inválido';
    }

    if (!formData.accountTypeId || formData.accountTypeId === 0) {
      newErrors.accountTypeId = 'Tipo de conta é obrigatório';
    }

    if (!formData.countryId || formData.countryId === 0) {
      newErrors.countryId = 'País é obrigatório';
    }

    if (!formData.organizationTypeId || formData.organizationTypeId === 0) {
      newErrors.organizationTypeId = 'Tipo de organização é obrigatório';
    }

    if (!formData.stateId || formData.stateId === 0) {
      newErrors.stateId = 'Estado é obrigatório';
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

  console.log('Form Data:', { accountTypes, organizationTypes, states, provinces, countries });

  return (
    <form onSubmit={handleSubmit} className="client-form">
      {/* Basic Information */}
      <div className="form-section">
        <h3 className="form-section-title">Informações Básicas</h3>

        <div className="form-row">
          <div className="form-group">
            <label htmlFor="name" className="form-label required">
              Nome
            </label>
            <input
              type="text"
              id="name"
              name="name"
              className={`form-control ${errors.name ? 'is-invalid' : ''}`}
              value={formData.name}
              onChange={handleChange}
              disabled={isSubmitting}
              placeholder="Nome completo do cliente"
            />
            {errors.name && <span className="form-error">{errors.name}</span>}
          </div>

          <div className="form-group">
            <label htmlFor="email" className="form-label required">
              Email
            </label>
            <input
              type="email"
              id="email"
              name="email"
              className={`form-control ${errors.email ? 'is-invalid' : ''}`}
              value={formData.email}
              onChange={handleChange}
              disabled={isSubmitting}
              placeholder="email@example.com"
            />
            {errors.email && <span className="form-error">{errors.email}</span>}
          </div>
        </div>

        <div className="form-row">
          <div className="form-group">
            <label htmlFor="contacto" className="form-label">
              Contacto
            </label>
            <input
              type="text"
              id="contacto"
              name="contacto"
              className="form-control"
              value={formData.contacto || ''}
              onChange={handleChange}
              disabled={isSubmitting}
              placeholder="+351 912 345 678"
            />
          </div>

          {/* Password removed from create modal as requested */}

          {/* Image URL only editable in edit mode (removed from create) */}
          {mode === 'edit' && (
            <div className="form-group">
              <label htmlFor="img" className="form-label">
                URL da Imagem
              </label>
              <input
                type="text"
                id="img"
                name="img"
                className="form-control"
                value={formData.img || ''}
                onChange={handleChange}
                disabled={isSubmitting}
                placeholder="https://example.com/image.jpg"
              />
            </div>
          )}
        </div>
      </div>

      {/* Location and Organization */}
      <div className="form-section">
        <h3 className="form-section-title">Localização e Organização</h3>

        <div className="form-row">
          {/* Account Type removed from create modal; show only in edit mode */}
          {mode === 'edit' && (
            <div className="form-group">
              <label htmlFor="accountTypeId" className="form-label required">
                Tipo de Conta
              </label>
              <select
                id="accountTypeId"
                name="accountTypeId"
                className={`form-control ${errors.accountTypeId ? 'is-invalid' : ''}`}
                value={formData.accountTypeId}
                onChange={handleChange}
                disabled={isSubmitting}
              >
                <option value="0">Selecione...</option>
                {accountTypesList.map((type) => (
                  <option key={type.id} value={type.id}>
                    {type.type}
                  </option>
                ))}
              </select>
              {errors.accountTypeId && <span className="form-error">{errors.accountTypeId}</span>}
            </div>
          )}

          <div className="form-group">
            <label htmlFor="organizationTypeId" className="form-label required">
              Tipo de Organização
            </label>
            <select
              id="organizationTypeId"
              name="organizationTypeId"
              className={`form-control ${errors.organizationTypeId ? 'is-invalid' : ''}`}
              value={formData.organizationTypeId}
              onChange={handleChange}
              disabled={isSubmitting}
            >
              <option value="0">Selecione...</option>
              {organizationTypesList.map((type) => (
                <option key={type.id} value={type.id}>
                  {type.type}
                </option>
              ))}
            </select>
            {errors.organizationTypeId && <span className="form-error">{errors.organizationTypeId}</span>}
          </div>
        </div>

        <div className="form-row">
          <div className="form-group">
            <label htmlFor="countryId" className="form-label required">
              País
            </label>
            <select
              id="countryId"
              name="countryId"
              className={`form-control ${errors.countryId ? 'is-invalid' : ''}`}
              value={formData.countryId}
              onChange={handleChange}
              disabled={isSubmitting}
            >
              <option value="0">Selecione...</option>
              {countriesList.map((country) => (
                <option key={country.id} value={country.id}>
                  {country.country}
                </option>
              ))}
            </select>
            {errors.countryId && <span className="form-error">{errors.countryId}</span>}
          </div>

          <div className="form-group">
            <label htmlFor="provinceId" className="form-label">
              Província
            </label>
            <select
              id="provinceId"
              name="provinceId"
              className="form-control"
              value={formData.provinceId || ''}
              onChange={handleChange}
              disabled={isSubmitting || !formData.countryId}
            >
              <option value="">Selecione...</option>
              {provincesList.map((province) => (
                <option key={province.id} value={province.id}>
                  {province.province}
                </option>
              ))}
            </select>
          </div>

          <div className="form-group">
            <label htmlFor="stateId" className="form-label required">
              Estado
            </label>
            <select
              id="stateId"
              name="stateId"
              className={`form-control ${errors.stateId ? 'is-invalid' : ''}`}
              value={formData.stateId}
              onChange={handleChange}
              disabled={isSubmitting}
            >
              <option value="0">Selecione...</option>
              {statesList.map((state) => (
                <option key={state.id} value={state.id}>
                  {state.state}
                </option>
              ))}
            </select>
            {errors.stateId && <span className="form-error">{errors.stateId}</span>}
          </div>
        </div>
      </div>

      {/* Form Actions */}
      <div className="modal-actions">
        <button
          type="button"
          className="btn btn-secondary"
          onClick={onCancel}
          disabled={isSubmitting}
        >
          Cancelar
        </button>
        <button
          type="submit"
          className="btn btn-primary"
          disabled={isSubmitting}
        >
          {isSubmitting ? (
            <>
              <span className="spinner-small"></span>
              {mode === 'create' ? 'A criar...' : 'A guardar...'}
            </>
          ) : (
            <>
              <i className={`fas fa-${mode === 'create' ? 'plus' : 'save'}`}></i>
              {mode === 'create' ? 'Criar Cliente' : 'Guardar Alterações'}
            </>
          )}
        </button>
      </div>
    </form>
  );
}
