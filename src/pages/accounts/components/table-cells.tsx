import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import type { Admin } from "@/types/admin";

interface AdminCellProps {
  admin: Admin;
}

export function AdminCell({ admin }: AdminCellProps) {
  return (
    <div className="flex items-center gap-3">
      <Avatar>
        <AvatarImage src={admin.img} alt={admin.name} />
        <AvatarFallback>
          {admin.name.substring(0, 2).toUpperCase()}
        </AvatarFallback>
      </Avatar>
      <div>
        <div className="font-medium">{admin.name}</div>
        <span className="text-muted-foreground text-xs">{admin.email}</span>
      </div>
    </div>
  );
}

interface StateBadgeCellProps {
  state: string;
}

export function StateBadgeCell({ state }: StateBadgeCellProps) {
  const badges: Record<string, { class: string; label: string }> = {
    ACTIVE: { class: "badge-success", label: "Ativo" },
    INACTIVE: { class: "badge-secondary", label: "Inativo" },
    DELETED: { class: "badge-danger", label: "Eliminado" },
  };
  const badge = badges[state] || { class: "badge-secondary", label: state };
  return <span className={`badge ${badge.class}`}>{badge.label}</span>;
}
