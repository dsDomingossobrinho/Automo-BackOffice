import { Button } from "@/components/ui/button";
import type { Admin } from "@/types/admin";

interface ActionsProps {
  admin: Admin;
  onView: (admin: Admin) => void;
  onEdit: (admin: Admin) => void;
  onDelete: (admin: Admin) => void;
}

export function AccountActions({ admin, onView, onEdit, onDelete }: ActionsProps) {
  return (
    <div className="flex items-center justify-center gap-1">
      <Button
        variant="ghost"
        size="icon"
        onClick={() => onView(admin)}
        title="Ver detalhes"
      >
        <i className="fas fa-eye"></i>
      </Button>
      <Button
        variant="ghost"
        size="icon"
        onClick={() => onEdit(admin)}
        title="Editar"
      >
        <i className="fas fa-edit"></i>
      </Button>
      <Button
        variant="ghost"
        size="icon"
        onClick={() => onDelete(admin)}
        title="Eliminar"
      >
        <i className="fas fa-trash"></i>
      </Button>
    </div>
  );
}
