import { Edit, Eye, MoreHorizontal, Trash2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import type { Promotion } from "@/types";

interface TableActionsProps {
  promotion: Promotion;
  onView: (item: Promotion) => void;
  onEdit: (item: Promotion) => void;
  onDelete: (item: Promotion) => void;
}

export function PromotionTableActions({ promotion, onView, onEdit, onDelete }: TableActionsProps) {
  return (
    <div className="flex items-center gap-2">
      <Button variant="ghost" size="icon" title="Ver detalhes" onClick={() => onView(promotion)}>
        <Eye className="h-4 w-4" />
      </Button>
      <Button variant="ghost" size="icon" title="Editar" onClick={() => onEdit(promotion)}>
        <Edit className="h-4 w-4" />
      </Button>
      <DropdownMenu>
        <DropdownMenuTrigger asChild>
          <Button variant="ghost" size="icon">
            <MoreHorizontal className="h-4 w-4" />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuItem onClick={() => onDelete(promotion)} className="text-destructive">
            <Trash2 className="h-4 w-4 mr-2" />
            Eliminar
          </DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
  );
}
