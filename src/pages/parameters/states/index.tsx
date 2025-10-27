import { Plus } from "lucide-react";
import { useCallback, useId, useMemo, useState } from "react";
import { toast } from "sonner";

import { type ColumnDef, DataTable } from "@/components/common/data-table";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  useCreateState,
  useDeleteState,
  useStates,
  useUpdateState,
} from "@/hooks/useStates";
import type { CreateStateData, State, UpdateStateData } from "@/types";

import CreateStateModal from "./components/create-modal";
import DeleteStateModal from "./components/delete-modal";
import EditStateModal from "./components/edit-modal";
import { StateTableActions } from "./components/table-actions";
import ViewStateModal from "./components/view-modal";

export default function StatesPage() {
  // Local UI state
  const [searchTerm, setSearchTerm] = useState("");
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);
  const [selectedState, setSelectedState] = useState<State | null>(null);
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
  } = useStates(page, pageSize, searchTerm);
  const createMutation = useCreateState();
  const updateMutation = useUpdateState();
  const deleteMutation = useDeleteState();

  // Extract data from paginated response
  const states = useMemo(() => paginatedData?.content || [], [paginatedData]);
  const totalElements = useMemo(
    () => paginatedData?.totalElements || 0,
    [paginatedData],
  );
  const totalPages = useMemo(
    () => paginatedData?.totalPages || 1,
    [paginatedData],
  );

  // Handle view
  const handleView = useCallback((state: State) => {
    setSelectedState(state);
    setIsViewModalOpen(true);
  }, []);

  // Handle edit
  const handleEdit = useCallback((state: State) => {
    setSelectedState(state);
    setIsEditModalOpen(true);
  }, []);

  // Handle delete
  const handleDelete = useCallback((state: State) => {
    setSelectedState(state);
    setIsDeleteModalOpen(true);
  }, []);

  // Handle create
  const handleCreate = async (data: CreateStateData) => {
    try {
      await createMutation.mutateAsync(data);
      toast.success("Estado criado com sucesso!");
      setIsCreateModalOpen(false);
      setPage(0); // Reset to first page
    } catch {
      toast.error("Erro ao criar estado.");
      throw new Error("Create failed");
    }
  };

  // Handle update
  const handleUpdate = async (data: UpdateStateData) => {
    if (!selectedState) return;
    try {
      await updateMutation.mutateAsync({
        id: selectedState.id,
        ...data,
      });
      toast.success("Estado atualizado com sucesso!");
      setIsEditModalOpen(false);
      setSelectedState(null);
    } catch {
      toast.error("Erro ao atualizar estado.");
      throw new Error("Update failed");
    }
  };

  // Handle confirm delete
  const handleConfirmDelete = async () => {
    if (!selectedState) return;
    try {
      await deleteMutation.mutateAsync(selectedState.id);
      toast.success("Estado eliminado com sucesso!");
      setIsDeleteModalOpen(false);
      setSelectedState(null);
      setPage(0); // Reset to first page
    } catch {
      toast.error("Erro ao eliminar estado.");
      throw new Error("Delete failed");
    }
  };

  // Clear search
  const handleClearSearch = () => {
    setSearchTerm("");
    setPage(0);
  };

  // Create table columns
  const columns: ColumnDef<State>[] = useMemo(
    () => [
      {
        accessorKey: "state",
        header: "Nome",
        cell: ({ row }) => (
          <span className="font-medium">{row.original.state}</span>
        ),
      },
      {
        accessorKey: "description",
        header: "Descrição",
        cell: ({ row }) => (
          <span className="text-muted-foreground text-sm">
            {row.original.description || "-"}
          </span>
        ),
      },
      {
        id: "actions",
        header: "Ações",
        cell: ({ row }) => (
          <StateTableActions
            state={row.original}
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
            Estados
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Gerir os estados disponíveis no sistema
          </p>
        </article>

        {/* Primary Action Button */}
        <Button
          size="lg"
          onClick={() => setIsCreateModalOpen(true)}
          disabled={createMutation.isPending}
        >
          <Plus className="h-4 w-4" />
          <span>{createMutation.isPending ? "A criar..." : "Novo Estado"}</span>
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
        data={states}
        columns={columns}
        isLoading={isLoading}
        isError={isError}
        errorMessage="Erro ao carregar estados"
        emptyMessage="Nenhum estado encontrado"
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
      <ViewStateModal
        open={isViewModalOpen}
        onOpenChange={setIsViewModalOpen}
        state={selectedState}
      />

      <CreateStateModal
        open={isCreateModalOpen}
        onOpenChange={(open) =>
          !createMutation.isPending && setIsCreateModalOpen(open)
        }
        onSubmit={handleCreate}
        isSubmitting={createMutation.isPending}
      />

      <EditStateModal
        open={isEditModalOpen}
        onOpenChange={(open) =>
          !updateMutation.isPending && setIsEditModalOpen(open)
        }
        state={selectedState}
        onSubmit={handleUpdate}
        isSubmitting={updateMutation.isPending}
      />

      <DeleteStateModal
        open={isDeleteModalOpen}
        onOpenChange={(open) =>
          !deleteMutation.isPending && setIsDeleteModalOpen(open)
        }
        state={selectedState}
        onConfirm={handleConfirmDelete}
        isDeleting={deleteMutation.isPending}
      />
    </div>
  );
}
