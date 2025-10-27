import { Plus } from "lucide-react";
import { useCallback, useId, useMemo, useState } from "react";
import { toast } from "sonner";

import { type ColumnDef, DataTable } from "@/components/common/data-table";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  useCreateSubscriptionPlan,
  useDeleteSubscriptionPlan,
  useSubscriptionPlans,
  useUpdateSubscriptionPlan,
} from "@/hooks/useSubscriptionPlans";
import type {
  CreateSubscriptionPlanData,
  SubscriptionPlan,
  UpdateSubscriptionPlanData,
} from "@/types";

import CreateSubscriptionPlanModal from "./components/create-modal";
import DeleteSubscriptionPlanModal from "./components/delete-modal";
import EditSubscriptionPlanModal from "./components/edit-modal";
import { SubscriptionPlanTableActions } from "./components/table-actions";
import ViewSubscriptionPlanModal from "./components/view-modal";

export default function SubscriptionPlansPage() {
  // Local UI state
  const [searchTerm, setSearchTerm] = useState("");
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);
  const [selectedPlan, setSelectedPlan] = useState<SubscriptionPlan | null>(
    null,
  );
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const searchId = useId();

  // React Query hooks - with pagination
  const {
    data: paginatedData,
    isLoading,
    isError,
  } = useSubscriptionPlans(page, pageSize, searchTerm);
  const createMutation = useCreateSubscriptionPlan();
  const updateMutation = useUpdateSubscriptionPlan();
  const deleteMutation = useDeleteSubscriptionPlan();

  // Extract data from paginated response
  const plans = useMemo(() => paginatedData?.content || [], [paginatedData]);
  const totalElements = useMemo(
    () => paginatedData?.totalElements || 0,
    [paginatedData],
  );
  const totalPages = useMemo(
    () => paginatedData?.totalPages || 1,
    [paginatedData],
  );

  // Handle view
  const handleView = useCallback((plan: SubscriptionPlan) => {
    setSelectedPlan(plan);
    setIsViewModalOpen(true);
  }, []);

  // Handle edit
  const handleEdit = useCallback((plan: SubscriptionPlan) => {
    setSelectedPlan(plan);
    setIsEditModalOpen(true);
  }, []);

  // Handle delete
  const handleDelete = useCallback((plan: SubscriptionPlan) => {
    setSelectedPlan(plan);
    setIsDeleteModalOpen(true);
  }, []);

  // Handle create
  const handleCreate = async (data: CreateSubscriptionPlanData) => {
    try {
      await createMutation.mutateAsync(data);
      toast.success("Plano criado com sucesso!");
      setIsCreateModalOpen(false);
      setPage(0); // Reset to first page
    } catch {
      toast.error("Erro ao criar plano.");
      throw new Error("Create failed");
    }
  };

  // Handle update
  const handleUpdate = async (data: UpdateSubscriptionPlanData) => {
    if (!selectedPlan) return;
    try {
      await updateMutation.mutateAsync({
        id: selectedPlan.id,
        ...data,
      });
      toast.success("Plano atualizado com sucesso!");
      setIsEditModalOpen(false);
      setSelectedPlan(null);
    } catch {
      toast.error("Erro ao atualizar plano.");
      throw new Error("Update failed");
    }
  };

  // Handle confirm delete
  const handleConfirmDelete = async () => {
    if (!selectedPlan) return;
    try {
      await deleteMutation.mutateAsync(selectedPlan.id);
      toast.success("Plano eliminado com sucesso!");
      setIsDeleteModalOpen(false);
      setSelectedPlan(null);
      setPage(0); // Reset to first page
    } catch {
      toast.error("Erro ao eliminar plano.");
      throw new Error("Delete failed");
    }
  };

  // Clear search
  const handleClearSearch = () => {
    setSearchTerm("");
    setPage(0);
  };

  // Create table columns
  const columns: ColumnDef<SubscriptionPlan>[] = useMemo(
    () => [
      {
        accessorKey: "name",
        header: "Nome",
        cell: ({ row }) => (
          <span className="font-medium">{row.original.name}</span>
        ),
      },
      {
        accessorKey: "price",
        header: "Preço",
        cell: ({ row }) => (
          <span className="text-muted-foreground">
            {new Intl.NumberFormat("pt-PT", {
              style: "currency",
              currency: "EUR",
            }).format(row.original.price)}
          </span>
        ),
      },
      {
        accessorKey: "messageCount",
        header: "Mensagens",
        cell: ({ row }) => (
          <span className="text-muted-foreground text-sm">
            {row.original.messageCount || "-"}
          </span>
        ),
      },
      {
        accessorKey: "stateName",
        header: "Estado",
        cell: ({ row }) => (
          <span className="text-muted-foreground text-sm">
            {row.original.stateName || "-"}
          </span>
        ),
      },
      {
        id: "actions",
        header: "Ações",
        cell: ({ row }) => (
          <SubscriptionPlanTableActions
            plan={row.original}
            onView={handleView}
            onEdit={handleEdit}
            onDelete={handleDelete}
          />
        ),
      },
    ],
    [handleView, handleEdit, handleDelete],
  );

  return (
    <div className="space-y-5 xl:space-y-8">
      {/* 1. Page Header */}
      <section className="flex justify-between items-start">
        <article className="px-2 sm:px-0">
          <h1 className="text-2xl font-bold tracking-tight sm:text-3xl">
            Planos de Subscrição
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Gerir os planos de subscrição disponíveis no sistema
          </p>
        </article>

        {/* Primary Action Button */}
        <Button
          size="lg"
          onClick={() => setIsCreateModalOpen(true)}
          disabled={createMutation.isPending}
        >
          <Plus className="h-4 w-4" />
          <span>{createMutation.isPending ? "A criar..." : "Novo Plano"}</span>
        </Button>
      </section>

      {/* 2. Search Section */}
      <div className="rounded-lg border bg-card p-4">
        <div className="flex flex-wrap items-end gap-4">
          <div className="flex-1 min-w-[200px]">
            <Label htmlFor={searchId} className="mb-2 flex items-center gap-2">
              Pesquisar
            </Label>
            <Input
              id={searchId}
              value={searchTerm}
              onChange={(e) => {
                setSearchTerm(e.target.value);
                setPage(0);
              }}
              placeholder="Pesquisar por nome ou descrição"
            />
          </div>
          <Button type="button" variant="secondary" onClick={handleClearSearch}>
            Limpar
          </Button>
        </div>
      </div>

      {/* 3. Data Table */}
      <DataTable
        data={plans}
        columns={columns}
        isLoading={isLoading}
        isError={isError}
        errorMessage="Erro ao carregar planos"
        emptyMessage="Nenhum plano encontrado"
        pagination={{
          page,
          pageSize,
          totalElements,
          totalPages,
          hasNext: page + 1 < totalPages,
          hasPrevious: page > 0,
          onPageChange: setPage,
        }}
      />

      {/* Modals */}
      <ViewSubscriptionPlanModal
        open={isViewModalOpen}
        onOpenChange={setIsViewModalOpen}
        plan={selectedPlan}
      />

      <CreateSubscriptionPlanModal
        open={isCreateModalOpen}
        onOpenChange={(open) =>
          !createMutation.isPending && setIsCreateModalOpen(open)
        }
        onSubmit={handleCreate}
        isSubmitting={createMutation.isPending}
      />

      <EditSubscriptionPlanModal
        open={isEditModalOpen}
        onOpenChange={(open) =>
          !updateMutation.isPending && setIsEditModalOpen(open)
        }
        plan={selectedPlan}
        onSubmit={handleUpdate}
        isSubmitting={updateMutation.isPending}
      />

      <DeleteSubscriptionPlanModal
        open={isDeleteModalOpen}
        onOpenChange={(open) =>
          !deleteMutation.isPending && setIsDeleteModalOpen(open)
        }
        plan={selectedPlan}
        onConfirm={handleConfirmDelete}
        isDeleting={deleteMutation.isPending}
      />
    </div>
  );
}
