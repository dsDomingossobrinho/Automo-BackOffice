import { Loader2 } from "lucide-react";
import { useState } from 'react';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import type { RoleInfo } from '../../types/user';

interface RoleFormProps {
  mode: 'create' | 'edit';
  initialData?: RoleInfo;
  onSubmit: (data: { role: string; description?: string }) => Promise<void> | void;
  onCancel: () => void;
  isSubmitting?: boolean;
}

export default function RoleForm({ mode, initialData, onSubmit, onCancel, isSubmitting }: Readonly<RoleFormProps>) {
  const [role, setRole] = useState(initialData?.name || '');
  const [description, setDescription] = useState(initialData?.description || '');

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    await onSubmit({ role, description });
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div className="space-y-2">
        <Label htmlFor="role" className="text-sm font-medium">
          Role <span className="text-destructive">*</span>
        </Label>
        <Input
          id="role"
          name="role"
          value={role}
          onChange={(e) => setRole(e.target.value)}
          required
          placeholder="Nome da role"
          disabled={isSubmitting}
        />
      </div>

      <div className="space-y-2">
        <Label htmlFor="description" className="text-sm font-medium">
          Descrição
        </Label>
        <Textarea
          id="description"
          name="description"
          value={description}
          onChange={(e: React.ChangeEvent<HTMLTextAreaElement>) => setDescription(e.target.value)}
          placeholder="Descrição da role (opcional)"
          disabled={isSubmitting}
          rows={3}
        />
      </div>

      <div className="flex flex-col-reverse sm:flex-row justify-end gap-2 pt-4">
        <Button
          type="button"
          variant="outline"
          onClick={onCancel}
          disabled={isSubmitting}
        >
          Cancelar
        </Button>
        <Button
          type="submit"
          disabled={isSubmitting}
        >
          {isSubmitting ? (
            <>
              <Loader2 className="mr-2 h-4 w-4 animate-spin" />
              {mode === 'create' ? 'A criar...' : 'A guardar...'}
            </>
          ) : (
            mode === 'create' ? 'Criar' : 'Guardar'
          )}
        </Button>
      </div>
    </form>
  );
}
