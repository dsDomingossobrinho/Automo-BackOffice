import {
  AlertTriangle,
  Trash2,
  UserCheck,
  UserMinus,
  Users,
  UserX,
} from "lucide-react";
import { useState } from "react";
import { toast } from "sonner";
import { type ColumnDef, DataTable } from "@/components/common/data-table";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import {
  type FilterField,
  TableFilters,
} from "@/components/common/table-filters";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import { DashboardCard } from "@/components/ui/dashboard-card";
import ClientForm from "../components/forms/ClientForm";
import {
  useClientStatistics,
  useClients,
  useCreateClient,
  useDeleteClient,
  useUpdateClient,
} from "../hooks/useClients";
import type { Client, ClientFilters, CreateClientData } from "../types";

export default function ClientsPage() {
  const [filters, setFilters] = useState<ClientFilters>({
    search: "",
    stateId: undefined,
  });
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);

  const queryFilters = {
    search: filters.search || undefined,
    page: page,
    size: pageSize,
    sortBy: "id" as const,
    sortDirection: "ASC" as const,
  };
  const { data: clientsData, isLoading, isError } = useClients(queryFilters);
  const clients = clientsData?.content || [];
  const { data: statistics } = useClientStatistics();

  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const [selectedClient, setSelectedClient] = useState<Client | null>(null);

  const handleFilterChange = (name: string, value: string | undefined) => {
    setFilters((prev) => ({ ...prev, [name]: value }));
    setPage(0);
  };

  const handleClearFilters = () => {
    setFilters({
      search: "",
      stateId: undefined,
    });
    setPage(0);
  };

  const filterFields: FilterField[] = [
    {
      name: "search",
      label: "Pesquisar",
      type: "text",
      placeholder: "Nome, email...",
      icon: "fas fa-search",
    },
  ];

  const handleCreateClient = () => {
    setSelectedClient(null);
    setIsCreateModalOpen(true);
  };

  const handleViewClient = (client: Client) => {
    setSelectedClient(client);
    setIsViewModalOpen(true);
  };

  const handleEditClient = (client: Client) => {
    setSelectedClient(client);
    setIsEditModalOpen(true);
  };

  const handleDeleteClient = (client: Client) => {
    setSelectedClient(client);
    setIsDeleteModalOpen(true);
  };

  const getStateBadge = (state: string) => {
    const badges: Record<string, { class: string; label: string }> = {
      Ativo: { class: "badge-success", label: "Ativo" },
      Inativo: { class: "badge-secondary", label: "Inativo" },
      Eliminado: { class: "badge-danger", label: "Eliminado" },
    };
    const badge = badges[state] || { class: "badge-secondary", label: state };
    return <span className={+"badge +"}>{badge.label}</span>;
  };

  const columns: ColumnDef<Client>[] = [
    {
      id: "client",
      header: "Cliente",
      cell: ({ row }) => <ClientCell client={row.original} />,
    },
    {
      accessorKey: "countryName",
      header: "País",
      cell: ({ row }) => row.original.countryName || "-",
    },
    {
      accessorKey: "organizationTypeName",
      header: "Organização",
      cell: ({ row }) => row.original.organizationTypeName || "-",
    },
    {
      id: "state",
      header: "Estado",
      cell: ({ row }) => getStateBadge(row.original.stateName || "N/A"),
    },
    {
      id: "actions",
      header: "Ações",
      cell: ({ row }) => (
        <ActionsCell
          client={row.original}
          onView={handleViewClient}
          onEdit={handleEditClient}
          onDelete={handleDeleteClient}
        />
      ),
    },
  ];

  return (
    <>
      <div className="space-y-5 xl:space-y-8">
        <section className="flex justify-between">
          <article className="px-2 sm:px-0">
            <h1 className="text-2xl font-bold tracking-tight sm:text-3xl">
              Clientes
            </h1>
            <p className="text-muted-foreground text-sm sm:text-base">
              Gestão de clientes e contactos
            </p>
          </article>

          <Button size="lg" onClick={handleCreateClient}>
            <i className="fas fa-plus"></i>
            <span>Novo Cliente</span>
          </Button>
        </section>

        <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
          <DashboardCard
            stat={{
              title: "Total Clientes",
              value: String(statistics?.totalUsers || 0),
              change: "+0%",
              changeType: "positive",
              icon: Users,
              color: "text-blue-500",
              bgColor: "bg-blue-500/10",
            }}
            index={0}
            noProgressBar
            noTrending
          />
          <DashboardCard
            stat={{
              title: "Ativos",
              value: String(statistics?.activeUsers || 0),
              change: "+0%",
              changeType: "positive",
              icon: UserCheck,
              color: "text-green-500",
              bgColor: "bg-green-500/10",
            }}
            index={1}
            noProgressBar
            noTrending
          />
          <DashboardCard
            stat={{
              title: "Inativos",
              value: String(statistics?.inactiveUsers || 0),
              change: "0%",
              changeType: "negative",
              icon: UserX,
              color: "text-gray-500",
              bgColor: "bg-gray-500/10",
            }}
            index={2}
            noProgressBar
            noTrending
          />
          <DashboardCard
            stat={{
              title: "Eliminados",
              value: String(statistics?.eliminatedUsers || 0),
              change: "0%",
              changeType: "negative",
              icon: UserMinus,
              color: "text-red-500",
              bgColor: "bg-red-500/10",
            }}
            index={3}
            noProgressBar
            noTrending
          />
        </div>

        <TableFilters
          fields={filterFields}
          values={filters}
          onChange={handleFilterChange}
          onClear={handleClearFilters}
        />

        <DataTable
          data={clients}
          columns={columns}
          isLoading={isLoading}
          isError={isError}
          errorMessage="Erro ao carregar clientes. Tente novamente."
          emptyMessage="Nenhum cliente encontrado"
          pagination={{
            page,
            pageSize,
            totalElements: clientsData?.totalElements || 0,
            totalPages: clientsData?.totalPages || 1,
            hasNext: clientsData?.hasNext || false,
            hasPrevious: clientsData?.hasPrevious || false,
            onPageChange: setPage,
          }}
        />
      </div>

      <CreateClientDialog
        open={isCreateModalOpen}
        onOpenChange={setIsCreateModalOpen}
      />

      <ViewClientDialog
        open={isViewModalOpen}
        onOpenChange={setIsViewModalOpen}
        client={selectedClient}
      />

      <EditClientDialog
        open={isEditModalOpen}
        onOpenChange={setIsEditModalOpen}
        client={selectedClient}
      />

      <DeleteClientDialog
        open={isDeleteModalOpen}
        onOpenChange={setIsDeleteModalOpen}
        client={selectedClient}
      />
    </>
  );
}

function CreateClientDialog({
  open,
  onOpenChange,
}: Readonly<{
  open: boolean;
  onOpenChange: (open: boolean) => void;
}>) {
  const createMutation = useCreateClient();

  const handleSubmit = async (data: CreateClientData) => {
    try {
      await createMutation.mutateAsync(data);
      toast.success("Cliente criado com sucesso!");
      onOpenChange(false);
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : "Erro ao criar cliente";
      toast.error(message);
    }
  };

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={createMutation.isPending ? () => { } : onOpenChange}
      title="Novo Cliente"
      description="Preencha os campos abaixo para criar um novo cliente."
    >
      <ClientForm
        mode="create"
        onSubmit={handleSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={createMutation.isPending}
      />
    </ResponsiveDialog>
  );
}

function ViewClientDialog({
  open,
  onOpenChange,
  client,
}: Readonly<{
  open: boolean;
  onOpenChange: (open: boolean) => void;
  client: Client | null;
}>) {
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
              <span
                className={+"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium +"}
              >
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

function EditClientDialog({
  open,
  onOpenChange,
  client,
}: Readonly<{
  open: boolean;
  onOpenChange: (open: boolean) => void;
  client: Client | null;
}>) {
  const updateMutation = useUpdateClient();

  const handleSubmit = async (data: CreateClientData) => {
    if (!client) return;

    try {
      await updateMutation.mutateAsync({
        id: client.id,
        ...data,
      });
      toast.success("Cliente atualizado com sucesso!");
      onOpenChange(false);
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : "Erro ao atualizar cliente";
      toast.error(message);
    }
  };

  if (!client) return null;

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={updateMutation.isPending ? () => { } : onOpenChange}
      title="Editar Cliente"
      description="Atualize as informações do cliente."
    >
      <ClientForm
        mode="edit"
        initialData={client}
        onSubmit={handleSubmit}
        onCancel={() => onOpenChange(false)}
        isSubmitting={updateMutation.isPending}
      />
    </ResponsiveDialog>
  );
}

function DeleteClientDialog({
  open,
  onOpenChange,
  client,
}: Readonly<{
  open: boolean;
  onOpenChange: (open: boolean) => void;
  client: Client | null;
}>) {
  const deleteMutation = useDeleteClient();

  const handleDelete = async () => {
    if (!client) return;

    try {
      await deleteMutation.mutateAsync(client.id);
      toast.success("Cliente eliminado com sucesso!");
      onOpenChange(false);
    } catch (error: unknown) {
      const message =
        error instanceof Error ? error.message : "Erro ao eliminar cliente";
      toast.error(message);
    }
  };

  if (!client) return null;

  return (
    <ResponsiveDialog
      open={open}
      onOpenChange={deleteMutation.isPending ? () => { } : onOpenChange}
      title="Eliminar Cliente"
      description="Esta ação não pode ser revertida!"
      actions={[
        {
          label: "Cancelar",
          variant: "outline",
          onClick: () => onOpenChange(false),
          disabled: deleteMutation.isPending,
        },
        {
          label: "Eliminar",
          variant: "destructive",
          onClick: () => void handleDelete(),
          disabled: deleteMutation.isPending,
          loading: deleteMutation.isPending,
          icon: Trash2,
        },
      ]}
    >
      <div className="flex flex-col items-center gap-4 py-4">
        <div className="flex h-16 w-16 items-center justify-center rounded-full bg-destructive/10">
          <AlertTriangle className="h-8 w-8 text-destructive" />
        </div>

        <div className="space-y-2 text-center">
          <p className="text-base">
            Tem a certeza de que deseja eliminar o cliente{" "}
            <strong>{client.name}</strong>?
          </p>
          <div className="text-sm text-muted-foreground space-y-1">
            <p>
              Email: <strong>{client.email}</strong>
            </p>
          </div>
        </div>
      </div>
    </ResponsiveDialog>
  );
}

function ClientCell({ client }: Readonly<{ client: Client }>) {
  return (
    <div className="flex items-center gap-3">
      <Avatar>
        <AvatarImage src={client.img} alt={client.name} />
        <AvatarFallback>
          {client.name.substring(0, 2).toUpperCase()}
        </AvatarFallback>
      </Avatar>
      <div>
        <div className="font-medium">{client.name}</div>
        <span className="text-muted-foreground text-xs">{client.email}</span>
      </div>
    </div>
  );
}

function ActionsCell({
  client,
  onView,
  onEdit,
  onDelete,
}: Readonly<{
  client: Client;
  onView: (client: Client) => void;
  onEdit: (client: Client) => void;
  onDelete: (client: Client) => void;
}>) {
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
