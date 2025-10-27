import { Button } from '../../../components/ui/button';
import type { Client } from '../../../types';

interface TableActionsProps {
  client: Client;
  onView: (client: Client) => void;
  onEdit: (client: Client) => void;
  onDelete: (client: Client) => void;
}

export function TableActions({
  client,
  onView,
  onEdit,
  onDelete,
}: Readonly<TableActionsProps>) {
  return (
    <div className="flex items-center justify-center gap-1">
      <Button
        variant="ghost"
        size="icon"
        onClick={() => onView(client)}
        title="Ver detalhes"
      >
        <i className="fas fa-eye"></i>
      </Button>
      <Button
        variant="ghost"
        size="icon"
        onClick={() => onEdit(client)}
        title="Editar"
      >
        <i className="fas fa-edit"></i>
      </Button>
      <Button
        variant="ghost"
        size="icon"
        onClick={() => onDelete(client)}
        title="Eliminar"
      >
        <i className="fas fa-trash"></i>
      </Button>
    </div>
  );
}
