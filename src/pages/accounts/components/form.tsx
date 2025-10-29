import { Loader2, Save } from "lucide-react";
import { useEffect, useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import type {
  Account,
  CreateAccountData,
} from "@/types";

interface AccountFormProps {
  account?: Account;
  onSubmit: (data: CreateAccountData) => void;
  isLoading?: boolean;
}

/**
 * Account Form Component
 * Reusable form for creating and editing accounts with role and permissions
 */
export default function AccountForm({
  account,
  onSubmit,
  isLoading,
}: Readonly<AccountFormProps>) {
  const [formData, setFormData] = useState({
    accountTypeId: account?.accountTypeId,
  });

  const [errors, setErrors] = useState<
    Partial<Record<keyof CreateAccountData, string>>
  >({});

  // Update form when account changes (edit mode)
  useEffect(() => {
    if (account) {
      setFormData({
        email: account.email,
        password: "",
        name: account.name,
        contact: account.contact || "",
        accountTypeId: account.accountTypeId,
      });
    }
  }, [account]);

  // Handle input changes
  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value, type, checked } = e.target;
    const finalValue = type === "checkbox" ? checked : value;

    setFormData((prev) => ({ ...prev, [name]: finalValue }));
    if (errors[name as keyof CreateAccountData]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  // Validate form
  const validateForm = (): boolean => {
    const newErrors: Partial<Record<keyof CreateAccountData, string>> = {};

    if (!formData.email || formData.email.trim().length === 0) {
      newErrors.email = "Email é obrigatório";
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = "Email inválido";
    }

    if (!formData.name || formData.name.trim().length === 0) {
      newErrors.name = "Nome é obrigatório";
    }

    if (formData.password && formData.password.length < 8) {
      newErrors.password = "Password deve ter no mínimo 8 caracteres";
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
        password: formData.password || "",
        name: formData.name,
        contact: formData.contact,
        accountTypeId: formData.accountTypeId,
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
              name="name"
              value={formData.name}
              onChange={handleChange}
              className={errors.name ? "border-destructive" : ""}
              disabled={isLoading}
              placeholder="Nome completo"
              required
            />
            {errors.name && (
              <p className="text-sm text-destructive">{errors.name}</p>
            )}
          </div>

          <div className="space-y-2">
            <Label htmlFor="email">
              Email <span className="text-destructive">*</span>
            </Label>
            <Input
              type="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              className={errors.email ? "border-destructive" : ""}
              disabled={isLoading}
              placeholder="email@exemplo.com"
              required
            />
            {errors.email && (
              <p className="text-sm text-destructive">{errors.email}</p>
            )}
          </div>
        </div>

        <div className="grid gap-4 sm:grid-cols-2">
          <div className="space-y-2">
            <Label htmlFor="username">
              Username <span className="text-destructive">*</span>
            </Label>
            <Input
              name="username"
              value={formData.username}
              onChange={handleChange}
              className={errors.username ? "border-destructive" : ""}
              disabled={isLoading}
              placeholder="username"
              required
            />
            {errors.username && (
              <p className="text-sm text-destructive">{errors.username}</p>
            )}
          </div>

          <div className="space-y-2">
            <Label htmlFor="password">Password</Label>
            <Input
              type="password"
              name="password"
              value={formData.password}
              onChange={handleChange}
              className={errors.password ? "border-destructive" : ""}
              disabled={isLoading}
              placeholder="Deixe vazio para não alterar"
            />
            {errors.password && (
              <p className="text-sm text-destructive">{errors.password}</p>
            )}
          </div>
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
              name="contact"
              value={formData.contact}
              onChange={handleChange}
              disabled={isLoading}
              placeholder="+244 900 000 000"
            />
          </div>
        </div>
      </div>

      {/* Submit Button */}
      <div className="flex justify-end pt-4">
        <Button type="submit" disabled={isLoading}>
          {isLoading ? (
            <>
              <Loader2 className="mr-2 h-4 w-4 animate-spin" />A guardar...
            </>
          ) : (
            <>
              <Save className="mr-2 h-4 w-4" />
              {account ? "Atualizar" : "Criar"} Conta
            </>
          )}
        </Button>
      </div>
    </form>
  );
}
