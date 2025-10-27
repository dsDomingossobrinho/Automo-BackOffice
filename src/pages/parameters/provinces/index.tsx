import { Plus } from "lucide-react";
import { useCallback, useId, useMemo, useState } from "react";
import { toast } from "sonner";

import { type ColumnDef, DataTable } from "@/components/common/data-table";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  useCreateProvince,
  useDeleteProvince,
  useProvinces,
  useUpdateProvince,
} from "@/hooks/useProvinces";
import type { CreateProvinceData, Province, UpdateProvinceData } from "@/types";

import CreateProvinceModal from "./components/create-modal";
import DeleteProvinceModal from "./components/delete-modal";
import EditProvinceModal from "./components/edit-modal";
import { ProvinceTableActions } from "./components/table-actions";
import ViewProvinceModal from "./components/view-modal";

export default function ProvincesPage() {
  // Local UI state
  const [searchTerm, setSearchTerm] = useState("");
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);
  const [selectedProvince, setSelectedProvince] = useState<Province | null>(
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
  } = useProvinces(page, pageSize, searchTerm);
  const createMutation = useCreateProvince();
  const updateMutation = useUpdateProvince();
  const deleteMutation = useDeleteProvince();

  // Extract data from paginated response
  const provinces = useMemo(
    () => paginatedData?.content || [],
    [paginatedData],
  );
  const totalElements = useMemo(
    () => paginatedData?.totalElements || 0,
    [paginatedData],
  );
  const totalPages = useMemo(
    () => paginatedData?.totalPages || 1,
    [paginatedData],
  );

  // Handle view
  const handleView = useCallback((province: Province) => {
    setSelectedProvince(province);
    setIsViewModalOpen(true);
  }, []);

  // Handle edit
  const handleEdit = useCallback((province: Province) => {
    setSelectedProvince(province);
    setIsEditModalOpen(true);
  }, []);

  // Handle delete
  const handleDelete = useCallback((province: Province) => {
    setSelectedProvince(province);
    setIsDeleteModalOpen(true);
  }, []);

  // Handle create
  const handleCreate = async (data: CreateProvinceData) => {
    try {
      await createMutation.mutateAsync(data);
      toast.success("Província criada com sucesso!");
      setIsCreateModalOpen(false);
      setPage(0); // Reset to first page
    } catch {
      toast.error("Erro ao criar província.");
      throw new Error("Create failed");
    }
  };

  // Handle update
  const handleUpdate = async (data: UpdateProvinceData) => {
    if (!selectedProvince) return;
    try {
      await updateMutation.mutateAsync({
        id: selectedProvince.id,
        ...data,
      });
      toast.success("Província atualizada com sucesso!");
      setIsEditModalOpen(false);
      setSelectedProvince(null);
    } catch {
      toast.error("Erro ao atualizar província.");
      throw new Error("Update failed");
    }
  };

  // Handle confirm delete
  const handleConfirmDelete = async () => {
    if (!selectedProvince) return;
    try {
      await deleteMutation.mutateAsync(selectedProvince.id);
      toast.success("Província eliminada com sucesso!");
      setIsDeleteModalOpen(false);
      setSelectedProvince(null);
      setPage(0); // Reset to first page
    } catch {
      toast.error("Erro ao eliminar província.");
      throw new Error("Delete failed");
    }
  };

  // Clear search
  const handleClearSearch = () => {
    setSearchTerm("");
    setPage(0);
  };

  // Create table columns
  const columns: ColumnDef<Province>[] = useMemo(
    () => [
      {
        accessorKey: "province",
        header: "Nome",
        cell: ({ row }) => (
          <span className="font-medium">{row.original.province}</span>
        ),
      },
      {
        accessorKey: "countryName",
        header: "País",
        cell: ({ row }) => (
          <span className="text-muted-foreground text-sm">
            {row.original.countryName || "-"}
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
          <ProvinceTableActions
            province={row.original}
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
            Províncias
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Gerir as províncias disponíveis no sistema
          </p>
        </article>

        {/* Primary Action Button */}
        <Button
          size="lg"
          onClick={() => setIsCreateModalOpen(true)}
          disabled={createMutation.isPending}
        >
          <Plus className="h-4 w-4" />
          <span>
            {createMutation.isPending ? "A criar..." : "Nova Província"}
          </span>
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
              placeholder="Pesquisar por nome, país ou estado"
            />
          </div>
          <Button type="button" variant="secondary" onClick={handleClearSearch}>
            Limpar
          </Button>
        </div>
      </div>

      {/* 3. Data Table */}
      <DataTable
        data={provinces}
        columns={columns}
        isLoading={isLoading}
        isError={isError}
        errorMessage="Erro ao carregar províncias"
        emptyMessage="Nenhuma província encontrada"
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
      <ViewProvinceModal
        open={isViewModalOpen}
        onOpenChange={setIsViewModalOpen}
        province={selectedProvince}
      />

      <CreateProvinceModal
        open={isCreateModalOpen}
        onOpenChange={(open) =>
          !createMutation.isPending && setIsCreateModalOpen(open)
        }
        onSubmit={handleCreate}
        isSubmitting={createMutation.isPending}
      />

      <EditProvinceModal
        open={isEditModalOpen}
        onOpenChange={(open) =>
          !updateMutation.isPending && setIsEditModalOpen(open)
        }
        province={selectedProvince}
        onSubmit={handleUpdate}
        isSubmitting={updateMutation.isPending}
      />

      <DeleteProvinceModal
        open={isDeleteModalOpen}
        onOpenChange={(open) =>
          !deleteMutation.isPending && setIsDeleteModalOpen(open)
        }
        province={selectedProvince}
        onConfirm={handleConfirmDelete}
        isDeleting={deleteMutation.isPending}
      />
    </div>
  );
}
