import { ResponsiveDialog } from "../../../components/common/responsive-dialog";
import {
  Avatar,
  AvatarFallback,
  AvatarImage,
} from "../../../components/ui/avatar";
import type { Client } from "../../../types";

interface ViewModalProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  client: Client | null;
}

export default function ViewClientModal({
  open,
  onOpenChange,
  client,
}: Readonly<ViewModalProps>) {
  if (!client) return null;

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={onOpenChange}
      title="Detalhes do Cliente"
      description="Informações completas do cliente"
    >
      <div className="space-y-4">
        <div className="flex items-center gap-4">
          <Avatar className="h-16 w-16">
            <AvatarImage src={client.img} alt={client.name} />
            <AvatarFallback>
              {client.name.substring(0, 2).toUpperCase()}
            </AvatarFallback>
          </Avatar>
          <div>
            <h3 className="text-lg font-semibold">{client.name}</h3>
            <p className="text-sm text-muted-foreground">{client.email}</p>
          </div>
        </div>

        <div className="grid gap-3 border-t pt-4">
          <div>
            <span className="text-sm font-medium">País:</span>
            <p className="text-sm text-muted-foreground">
              {client.countryName || "-"}
            </p>
          </div>
          <div>
            <span className="text-sm font-medium">Província:</span>
            <p className="text-sm text-muted-foreground">
              {client.provinceName || "-"}
            </p>
          </div>
          <div>
            <span className="text-sm font-medium">Organização:</span>
            <p className="text-sm text-muted-foreground">
              {client.organizationTypeName || "-"}
            </p>
          </div>
          <div>
            <span className="text-sm font-medium">Estado:</span>
            <p className="text-sm">
              <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary text-secondary-foreground">
                {client.stateName || "N/A"}
              </span>
            </p>
          </div>
          {client.createdAt && (
            <div>
              <span className="text-sm font-medium">Criado em:</span>
              <p className="text-sm text-muted-foreground">
                {new Date(client.createdAt).toLocaleDateString("pt-PT")}
              </p>
            </div>
          )}
        </div>
      </div>
    </ResponsiveDialog>
  );
}
