import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import type { Admin } from "@/types/admin";

interface ViewModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  admin: Admin | null;
}

export default function ViewModal({
  open,
  onOpenChange,
  admin,
}: ViewModalProps) {
  if (!admin) return null;

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={onOpenChange}
      title="Detalhes do Administrador"
      description="Informações completas da conta"
    >
      <div className="space-y-4">
        <div className="flex items-center gap-4">
          <Avatar className="h-16 w-16">
            <AvatarImage src={admin.img} alt={admin.name} />
            <AvatarFallback>
              {admin.name.substring(0, 2).toUpperCase()}
            </AvatarFallback>
          </Avatar>
          <div>
            <h3 className="text-lg font-semibold">{admin.name}</h3>
            <p className="text-sm text-muted-foreground">@{admin.username}</p>
          </div>
        </div>

        <div className="grid gap-3 border-t pt-4">
          <div>
            <span className="text-sm font-medium">Email:</span>
            <p className="text-sm text-muted-foreground">{admin.email}</p>
          </div>
          <div>
            <span className="text-sm font-medium">Estado:</span>
            <p className="text-sm">
              <span
                className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${admin.state === "ACTIVE"
                  ? "bg-green-100 text-green-800"
                  : admin.state === "INACTIVE"
                    ? "bg-gray-100 text-gray-800"
                    : "bg-red-100 text-red-800"
                  }`}
              >
                {admin.state}
              </span>
            </p>
          </div>
          {admin.createdAt && (
            <div>
              <span className="text-sm font-medium">Criado em:</span>
              <p className="text-sm text-muted-foreground">
                {new Date(admin.createdAt).toLocaleDateString("pt-PT")}
              </p>
            </div>
          )}
        </div>
      </div>
    </ResponsiveDialog>
  );
}
