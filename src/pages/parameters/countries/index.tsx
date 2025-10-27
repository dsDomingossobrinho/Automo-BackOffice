import { Plus } from "lucide-react";
import { useCallback, useId, useMemo, useState } from "react";
import { toast } from "sonner";

import { type ColumnDef, DataTable } from "@/components/common/data-table";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  useCountries,
  useCreateCountry,
  useDeleteCountry,
  useUpdateCountry,
} from "@/hooks/useCountries";
import type { Country, CreateCountryData, UpdateCountryData } from "@/types";

import CreateCountryModal from "./components/create-modal";
import DeleteCountryModal from "./components/delete-modal";
import EditCountryModal from "./components/edit-modal";
import { CountryTableActions } from "./components/table-actions";
import ViewCountryModal from "./components/view-modal";

export default function CountriesPage() {
  // Local UI state
  const [searchTerm, setSearchTerm] = useState("");
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);
  const [selectedCountry, setSelectedCountry] = useState<Country | null>(null);
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
  } = useCountries(page, pageSize, searchTerm);
  const createMutation = useCreateCountry();
  const updateMutation = useUpdateCountry();
  const deleteMutation = useDeleteCountry();

  // Extract data from paginated response
  const countries = useMemo(
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
  const handleView = useCallback((country: Country) => {
    setSelectedCountry(country);
    setIsViewModalOpen(true);
  }, []);

  // Handle edit
  const handleEdit = useCallback((country: Country) => {
    setSelectedCountry(country);
    setIsEditModalOpen(true);
  }, []);

  // Handle delete
  const handleDelete = useCallback((country: Country) => {
    setSelectedCountry(country);
    setIsDeleteModalOpen(true);
  }, []);

  // Handle create
  const handleCreate = async (data: CreateCountryData) => {
    try {
      await createMutation.mutateAsync(data);
      toast.success("País criado com sucesso!");
      setIsCreateModalOpen(false);
      setPage(0); // Reset to first page
    } catch {
      toast.error("Erro ao criar país.");
      throw new Error("Create failed");
    }
  };

  // Handle update
  const handleUpdate = async (data: UpdateCountryData) => {
    if (!selectedCountry) return;
    try {
      await updateMutation.mutateAsync({
        id: selectedCountry.id,
        ...data,
      });
      toast.success("País atualizado com sucesso!");
      setIsEditModalOpen(false);
      setSelectedCountry(null);
    } catch {
      toast.error("Erro ao atualizar país.");
      throw new Error("Update failed");
    }
  };

  // Handle confirm delete
  const handleConfirmDelete = async () => {
    if (!selectedCountry) return;
    try {
      await deleteMutation.mutateAsync(selectedCountry.id);
      toast.success("País eliminado com sucesso!");
      setIsDeleteModalOpen(false);
      setSelectedCountry(null);
      setPage(0); // Reset to first page
    } catch {
      toast.error("Erro ao eliminar país.");
      throw new Error("Delete failed");
    }
  };

  // Clear search
  const handleClearSearch = () => {
    setSearchTerm("");
    setPage(0);
  };

  // Create table columns
  const columns: ColumnDef<Country>[] = useMemo(
    () => [
      {
        accessorKey: "country",
        header: "Nome",
        cell: ({ row }) => (
          <span className="font-medium">{row.original.country}</span>
        ),
      },
      {
        accessorKey: "indicative",
        header: "Código",
        cell: ({ row }) => (
          <span className="text-muted-foreground text-sm">
            {row.original.indicative || "-"}
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
          <CountryTableActions
            country={row.original}
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
            Países
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Gerir os países disponíveis no sistema
          </p>
        </article>

        {/* Primary Action Button */}
        <Button
          size="lg"
          onClick={() => setIsCreateModalOpen(true)}
          disabled={createMutation.isPending}
        >
          <Plus className="h-4 w-4" />
          <span>{createMutation.isPending ? "A criar..." : "Novo País"}</span>
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
              placeholder="Pesquisar por nome, código ou descrição"
            />
          </div>
          <Button type="button" variant="secondary" onClick={handleClearSearch}>
            Limpar
          </Button>
        </div>
      </div>

      {/* 3. Data Table */}
      <DataTable
        data={countries}
        columns={columns}
        isLoading={isLoading}
        isError={isError}
        errorMessage="Erro ao carregar países"
        emptyMessage="Nenhum país encontrado"
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
      <ViewCountryModal
        open={isViewModalOpen}
        onOpenChange={setIsViewModalOpen}
        country={selectedCountry}
      />

      <CreateCountryModal
        open={isCreateModalOpen}
        onOpenChange={(open) =>
          !createMutation.isPending && setIsCreateModalOpen(open)
        }
        onSubmit={handleCreate}
        isSubmitting={createMutation.isPending}
      />

      <EditCountryModal
        open={isEditModalOpen}
        onOpenChange={(open) =>
          !updateMutation.isPending && setIsEditModalOpen(open)
        }
        country={selectedCountry}
        onSubmit={handleUpdate}
        isSubmitting={updateMutation.isPending}
      />

      <DeleteCountryModal
        open={isDeleteModalOpen}
        onOpenChange={(open) =>
          !deleteMutation.isPending && setIsDeleteModalOpen(open)
        }
        country={selectedCountry}
        onConfirm={handleConfirmDelete}
        isDeleting={deleteMutation.isPending}
      />
    </div>
  );
}
