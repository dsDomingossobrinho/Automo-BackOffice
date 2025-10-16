import { useState, useEffect } from 'react';
import type { Account, CreateAccountData, Permission, PermissionGroup } from '../../types';
import { RoleLabels, PermissionGroups, PermissionLabels } from '../../types';

interface AccountFormProps {
  account?: Account;
  onSubmit: (data: CreateAccountData) => void;
  isLoading?: boolean;
}

/**
 * Account Form Component
 * Reusable form for creating and editing accounts with role and permissions
 */
export default function AccountForm({ account, onSubmit, isLoading }: AccountFormProps) {
  const [formData, setFormData] = useState<CreateAccountData>({
    email: account?.email || '',
    username: account?.username || '',
    password: '',
    name: account?.name || '',
    contact: account?.contact || '',
    identify_id: account?.identify_id || '',
    roleId: account?.roleId || 2, // Default to User
    permissions: account?.permissions || [],
    accountTypeId: account?.accountTypeId,
    isBackOffice: account?.isBackOffice ?? true,
  });

  const [errors, setErrors] = useState<Partial<Record<keyof CreateAccountData, string>>>({});
  const [selectedPermissions, setSelectedPermissions] = useState<Set<Permission>>(
    new Set(account?.permissions || [])
  );

  // Update form when account changes (edit mode)
  useEffect(() => {
    if (account) {
      setFormData({
        email: account.email,
        username: account.username,
        password: '', // Don't pre-fill password
        name: account.name,
        contact: account.contact || '',
        identify_id: account.identify_id || '',
        roleId: account.roleId,
        permissions: account.permissions,
        accountTypeId: account.accountTypeId,
        isBackOffice: account.isBackOffice,
      });
      setSelectedPermissions(new Set(account.permissions));
    }
  }, [account]);

  // Handle input changes
  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value, type } = e.target;
    const finalValue = type === 'checkbox' ? (e.target as HTMLInputElement).checked : value;

    setFormData((prev) => ({ ...prev, [name]: finalValue }));
    // Clear error for this field
    if (errors[name as keyof CreateAccountData]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  // Handle permission toggle
  const handlePermissionToggle = (permission: Permission) => {
    const newPermissions = new Set(selectedPermissions);
    if (newPermissions.has(permission)) {
      newPermissions.delete(permission);
    } else {
      newPermissions.add(permission);
    }
    setSelectedPermissions(newPermissions);
    setFormData((prev) => ({ ...prev, permissions: Array.from(newPermissions) }));
  };

  // Handle select all permissions in group
  const handleSelectGroupPermissions = (group: PermissionGroup, selectAll: boolean) => {
    const newPermissions = new Set(selectedPermissions);
    group.permissions.forEach((permission) => {
      if (selectAll) {
        newPermissions.add(permission);
      } else {
        newPermissions.delete(permission);
      }
    });
    setSelectedPermissions(newPermissions);
    setFormData((prev) => ({ ...prev, permissions: Array.from(newPermissions) }));
  };

  // Check if all permissions in group are selected
  const isGroupFullySelected = (group: PermissionGroup) => {
    return group.permissions.every((p) => selectedPermissions.has(p));
  };

  // Validate form
  const validateForm = (): boolean => {
    const newErrors: Partial<Record<keyof CreateAccountData, string>> = {};

    if (!formData.email || formData.email.trim().length === 0) {
      newErrors.email = 'Email é obrigatório';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = 'Email inválido';
    }

    if (!formData.username || formData.username.trim().length === 0) {
      newErrors.username = 'Username é obrigatório';
    }

    if (!formData.name || formData.name.trim().length === 0) {
      newErrors.name = 'Nome é obrigatório';
    }

    // Password is required only for new accounts
    if (!account && (!formData.password || formData.password.length < 6)) {
      newErrors.password = 'Password deve ter no mínimo 6 caracteres';
    }

    // If password is being changed on edit, validate it
    if (account && formData.password && formData.password.length < 6) {
      newErrors.password = 'Password deve ter no mínimo 6 caracteres';
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  // Handle form submit
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (validateForm()) {
      const submitData: CreateAccountData = {
        ...formData,
        roleId: Number(formData.roleId),
        permissions: Array.from(selectedPermissions),
      };
      onSubmit(submitData);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="form">
      {/* Basic Info */}
      <div className="form-row">
        <div className="form-group">
          <label htmlFor="name" className="form-label required">
            Nome Completo
          </label>
          <input
            type="text"
            id="name"
            name="name"
            value={formData.name}
            onChange={handleChange}
            className={`form-control ${errors.name ? 'error' : ''}`}
            disabled={isLoading}
            placeholder="Nome completo"
            required
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
            value={formData.email}
            onChange={handleChange}
            className={`form-control ${errors.email ? 'error' : ''}`}
            disabled={isLoading}
            placeholder="email@exemplo.com"
            required
          />
          {errors.email && <span className="form-error">{errors.email}</span>}
        </div>
      </div>

      <div className="form-row">
        <div className="form-group">
          <label htmlFor="username" className="form-label required">
            Username
          </label>
          <input
            type="text"
            id="username"
            name="username"
            value={formData.username}
            onChange={handleChange}
            className={`form-control ${errors.username ? 'error' : ''}`}
            disabled={isLoading}
            placeholder="username"
            required
          />
          {errors.username && <span className="form-error">{errors.username}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="password" className={`form-label ${!account ? 'required' : ''}`}>
            Password {account && '(deixe vazio para não alterar)'}
          </label>
          <input
            type="password"
            id="password"
            name="password"
            value={formData.password}
            onChange={handleChange}
            className={`form-control ${errors.password ? 'error' : ''}`}
            disabled={isLoading}
            placeholder="••••••••"
            required={!account}
          />
          {errors.password && <span className="form-error">{errors.password}</span>}
        </div>
      </div>

      {/* Contact Info */}
      <div className="form-row">
        <div className="form-group">
          <label htmlFor="contact" className="form-label">
            Contacto
          </label>
          <input
            type="text"
            id="contact"
            name="contact"
            value={formData.contact}
            onChange={handleChange}
            className="form-control"
            disabled={isLoading}
            placeholder="+351 900 000 000"
          />
        </div>

        <div className="form-group">
          <label htmlFor="identify_id" className="form-label">
            NIF
          </label>
          <input
            type="text"
            id="identify_id"
            name="identify_id"
            value={formData.identify_id}
            onChange={handleChange}
            className="form-control"
            disabled={isLoading}
            placeholder="123456789"
          />
        </div>
      </div>

      {/* Role Selection */}
      <div className="form-group">
        <label htmlFor="roleId" className="form-label required">
          Role
        </label>
        <select
          id="roleId"
          name="roleId"
          value={formData.roleId}
          onChange={handleChange}
          className="form-control"
          disabled={isLoading}
          required
        >
          {Object.entries(RoleLabels).map(([id, label]) => (
            <option key={id} value={id}>
              {label}
            </option>
          ))}
        </select>
      </div>

      {/* BackOffice Checkbox */}
      <div className="form-group">
        <label className="form-checkbox">
          <input
            type="checkbox"
            name="isBackOffice"
            checked={formData.isBackOffice}
            onChange={handleChange}
            disabled={isLoading}
          />
          <span>Conta BackOffice</span>
        </label>
      </div>

      {/* Permissions */}
      <div className="form-group">
        <label className="form-label">Permissões</label>
        <div className="permissions-container">
          {PermissionGroups.map((group) => (
            <div key={group.name} className="permission-group">
              <div className="permission-group-header">
                <h4>{group.label}</h4>
                <button
                  type="button"
                  className="btn btn-sm btn-secondary"
                  onClick={() => handleSelectGroupPermissions(group, !isGroupFullySelected(group))}
                  disabled={isLoading}
                >
                  {isGroupFullySelected(group) ? 'Desselecionar Todas' : 'Selecionar Todas'}
                </button>
              </div>
              <div className="permission-list">
                {group.permissions.map((permission) => (
                  <label key={permission} className="permission-item">
                    <input
                      type="checkbox"
                      checked={selectedPermissions.has(permission)}
                      onChange={() => handlePermissionToggle(permission)}
                      disabled={isLoading}
                    />
                    <span>{PermissionLabels[permission]}</span>
                  </label>
                ))}
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Submit Button */}
      <div className="form-actions">
        <button type="submit" className="btn btn-primary" disabled={isLoading}>
          {isLoading ? (
            <>
              <i className="fas fa-spinner fa-spin"></i> A guardar...
            </>
          ) : (
            <>
              <i className="fas fa-save"></i> {account ? 'Atualizar' : 'Criar'} Conta
            </>
          )}
        </button>
      </div>
    </form>
  );
}
