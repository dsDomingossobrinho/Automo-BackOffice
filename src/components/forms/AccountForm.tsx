import { Loader2, Save } from "lucide-react";
import { useState, useEffect } from 'react';
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
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
export default function AccountForm({ account, onSubmit, isLoading }: Readonly<AccountFormProps>) {
  const [formData, setFormData] = useState<CreateAccountData>({
    email: account?.email || '',
    username: account?.username || '',
    password: '',
    name: account?.name || '',
    contact: account?.contact || '',
    identify_id: account?.identify_id || '',
    roleId: account?.roleId || 2,
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
        password: '',
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
  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value, type, checked } = e.target;
    const finalValue = type === 'checkbox' ? checked : value;

    setFormData((prev) => ({ ...prev, [name]: finalValue }));
    if (errors[name as keyof CreateAccountData]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  // Handle select changes
  const handleSelectChange = (value: string) => {
    setFormData((prev) => ({ ...prev, roleId: Number(value) }));
    if (errors.roleId) {
      setErrors((prev) => ({ ...prev, roleId: undefined }));
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
    for (const permission of group.permissions) {
      if (selectAll) {
        newPermissions.add(permission);
      } else {
        newPermissions.delete(permission);
      }
    }
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
        email: formData.email,
        username: formData.username,
        password: formData.password || '',
        name: formData.name,
        contact: formData.contact,
        identify_id: formData.identify_id,
        roleId: Number(formData.roleId),
        permissions: Array.from(selectedPermissions),
        accountTypeId: formData.accountTypeId,
        isBackOffice: formData.isBackOffice,
      };

      onSubmit(submitData);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
      {/* Basic Info Section */}
      <div className="space-y-4">
        <h3 className="text-sm font-semibold text-foreground border-b pb-2">
          Informação Básica
        </h3>
        
        <div className="grid gap-4 sm:grid-cols-2">
          <div className="space-y-2">
            <Label htmlFor="name">
              Nome Completo <span className="text-destructive">*</span>
            </Label>
            <Input
              id="name"
              name="name"
              value={formData.name}
              onChange={handleChange}
              className={errors.name ? 'border-destructive' : ''}
              disabled={isLoading}
              placeholder="Nome completo"
              required
            />
            {errors.name && <p className="text-sm text-destructive">{errors.name}</p>}
          </div>

          <div className="space-y-2">
            <Label htmlFor="email">
              Email <span className="text-destructive">*</span>
            </Label>
            <Input
              type="email"
              id="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              className={errors.email ? 'border-destructive' : ''}
              disabled={isLoading}
              placeholder="email@exemplo.com"
              required
            />
            {errors.email && <p className="text-sm text-destructive">{errors.email}</p>}
          </div>
        </div>

        <div className="grid gap-4 sm:grid-cols-2">
          <div className="space-y-2">
            <Label htmlFor="username">
              Username <span className="text-destructive">*</span>
            </Label>
            <Input
              id="username"
              name="username"
              value={formData.username}
              onChange={handleChange}
              className={errors.username ? 'border-destructive' : ''}
              disabled={isLoading}
              placeholder="username"
              required
            />
            {errors.username && <p className="text-sm text-destructive">{errors.username}</p>}
          </div>

          {account && (
            <div className="space-y-2">
              <Label htmlFor="password">
                Password
              </Label>
              <Input
                type="password"
                id="password"
                name="password"
                value={formData.password}
                onChange={handleChange}
                className={errors.password ? 'border-destructive' : ''}
                disabled={isLoading}
                placeholder="Deixe vazio para não alterar"
              />
              {errors.password && <p className="text-sm text-destructive">{errors.password}</p>}
            </div>
          )}
        </div>
      </div>

      {/* Contact Info Section */}
      <div className="space-y-4">
        <h3 className="text-sm font-semibold text-foreground border-b pb-2">
          Informação de Contacto
        </h3>
        
        <div className="grid gap-4 sm:grid-cols-2">
          <div className="space-y-2">
            <Label htmlFor="contact">Contacto</Label>
            <Input
              id="contact"
              name="contact"
              value={formData.contact}
              onChange={handleChange}
              disabled={isLoading}
              placeholder="+351 900 000 000"
            />
          </div>

          <div className="space-y-2">
            <Label htmlFor="identify_id">NIF</Label>
            <Input
              id="identify_id"
              name="identify_id"
              value={formData.identify_id}
              onChange={handleChange}
              disabled={isLoading}
              placeholder="123456789"
            />
          </div>
        </div>
      </div>

      {/* Role & Settings Section */}
      <div className="space-y-4">
        <h3 className="text-sm font-semibold text-foreground border-b pb-2">
          Role e Configurações
        </h3>

        <div className="space-y-2">
          <Label htmlFor="roleId">
            Role <span className="text-destructive">*</span>
          </Label>
          <Select
            value={String(formData.roleId)}
            onValueChange={handleSelectChange}
            disabled={isLoading}
          >
            <SelectTrigger>
              <SelectValue placeholder="Selecione a role" />
            </SelectTrigger>
            <SelectContent>
              {Object.entries(RoleLabels).map(([id, label]) => (
                <SelectItem key={id} value={id}>
                  {label}
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
        </div>

        <div className="flex items-center space-x-2">
          <Checkbox
            id="isBackOffice"
            checked={formData.isBackOffice}
            onCheckedChange={(checked) => {
              setFormData((prev) => ({ ...prev, isBackOffice: checked as boolean }));
            }}
            disabled={isLoading}
          />
          <Label htmlFor="isBackOffice" className="text-sm font-normal cursor-pointer">
            Conta BackOffice
          </Label>
        </div>
      </div>

      {/* Permissions Section */}
      <div className="space-y-4">
        <h3 className="text-sm font-semibold text-foreground border-b pb-2">
          Permissões
        </h3>

        <div className="space-y-6">
          {PermissionGroups.map((group) => (
            <div key={group.name} className="rounded-lg border bg-card p-4">
              <div className="flex items-center justify-between mb-3">
                <h4 className="text-sm font-medium">{group.label}</h4>
                <Button
                  type="button"
                  variant="outline"
                  size="sm"
                  onClick={() => handleSelectGroupPermissions(group, !isGroupFullySelected(group))}
                  disabled={isLoading}
                >
                  {isGroupFullySelected(group) ? 'Desselecionar Todas' : 'Selecionar Todas'}
                </Button>
              </div>
              
              <div className="grid gap-3 sm:grid-cols-2">
                {group.permissions.map((permission) => (
                  <div key={permission} className="flex items-center space-x-2">
                    <Checkbox
                      id={`perm-${permission}`}
                      checked={selectedPermissions.has(permission)}
                      onCheckedChange={() => handlePermissionToggle(permission)}
                      disabled={isLoading}
                    />
                    <Label
                      htmlFor={`perm-${permission}`}
                      className="text-sm font-normal cursor-pointer"
                    >
                      {PermissionLabels[permission]}
                    </Label>
                  </div>
                ))}
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Submit Button */}
      <div className="flex justify-end pt-4">
        <Button type="submit" disabled={isLoading}>
          {isLoading ? (
            <>
              <Loader2 className="mr-2 h-4 w-4 animate-spin" />
              A guardar...
            </>
          ) : (
            <>
              <Save className="mr-2 h-4 w-4" />
              {account ? 'Atualizar' : 'Criar'} Conta
            </>
          )}
        </Button>
      </div>
    </form>
  );
}
