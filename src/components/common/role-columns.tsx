import { Edit, Eye, Trash2 } from "lucide-react";
import type { ColumnDef } from "@/components/common/data-table";
import { Button } from "@/components/ui/button";
import type { RoleInfo } from "@/types";

interface RoleColumnsProps {
  onView: (role: RoleInfo) => void;
  onEdit: (role: RoleInfo) => void;
  onDelete: (role: RoleInfo) => void;
}

export const createRoleColumns = ({
  onView,
  onEdit,
  onDelete,
}: RoleColumnsProps): ColumnDef<RoleInfo>[] => [
    {
      accessorKey: "name",
      header: "Nome",
      cell: ({ row }) => <span className="font-medium">{row.original.name}</span>,
    },
    {
      accessorKey: "description",
      header: "Descrição",
      cell: ({ row }) => (
        <span className="text-muted-foreground">
          {row.original.description || "-"}
        </span>
      ),
    },
    {
      id: "actions",
      header: "Ações",
      cell: ({ row }) => (
        <div className="flex items-center justify-center gap-1">
          <Button
            variant="ghost"
            size="icon"
            onClick={() => onView(row.original)}
            title="Ver detalhes"
          >
            <Eye className="h-4 w-4" />
          </Button>
          <Button
            variant="ghost"
            size="icon"
            onClick={() => onEdit(row.original)}
            title="Editar"
          >
            <Edit className="h-4 w-4" />
          </Button>
          <Button
            variant="ghost"
            size="icon"
            onClick={() => onDelete(row.original)}
            title="Eliminar"
          >
            <Trash2 className="h-4 w-4" />
          </Button>
        </div>
      ),
    },
  ];
