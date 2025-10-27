import { UserCheck, UserMinus, Users, UserX } from "lucide-react";
import { useState } from "react";
import { type ColumnDef, DataTable } from "@/components/common/data-table";
import {
  type FilterField,
  TableFilters,
} from "@/components/common/table-filters";
import { Button } from "@/components/ui/button";
import { DashboardCard } from "@/components/ui/dashboard-card";
import { useClientStatistics, useClients } from "@/hooks/useClients";
import type { Client, ClientFilters } from "@/types";
import CreateClientModal from "./components/create-modal";
import DeleteClientModal from "./components/delete-modal";
import EditClientModal from "./components/edit-modal";
import { TableActions } from "./components/table-actions";
import { ClientCell, StateBadgeCell } from "./components/table-cells";
import ViewClientModal from "./components/view-modal";

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
      cell: ({ row }) => (
        <StateBadgeCell state={row.original.stateName || "N/A"} />
      ),
    },
    {
      id: "actions",
      header: "Ações",
      cell: ({ row }) => (
        <TableActions
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
          values={filters as Record<string, string | number | undefined>}
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

      <CreateClientModal
        open={isCreateModalOpen}
        onOpenChange={setIsCreateModalOpen}
      />

      <ViewClientModal
        open={isViewModalOpen}
        onOpenChange={setIsViewModalOpen}
        client={selectedClient}
      />

      <EditClientModal
        open={isEditModalOpen}
        onOpenChange={setIsEditModalOpen}
        client={selectedClient}
      />

      <DeleteClientModal
        open={isDeleteModalOpen}
        onOpenChange={setIsDeleteModalOpen}
        client={selectedClient}
      />
    </>
  );
}
