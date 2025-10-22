import { Eye } from "lucide-react";
import type { ColumnDef } from "@/components/common/data-table";
import { Button } from "@/components/ui/button";
import type { RoleInfo } from "@/types";

interface RoleColumnsProps {
  onView: (role: RoleInfo) => void;
}

export const createRoleColumns = ({
  onView,
}: RoleColumnsProps): ColumnDef<RoleInfo>[] => [
    {
      accessorKey: "name",
      header: "Nome",
      cell: ({ row }) => (
        <span className="font-medium">{row.original.name}</span>
      ),
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
        </div>
      ),
    },
  ];
