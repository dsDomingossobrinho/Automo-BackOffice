import { Plus } from "lucide-react";
import { useCallback, useId, useMemo, useState } from "react";
import { toast } from "sonner";

import { type ColumnDef, DataTable } from "@/components/common/data-table";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  useCreatePromotion,
  useDeletePromotion,
  usePromotions,
  useUpdatePromotion,
} from "@/hooks/usePromotions";
import type {
  CreatePromotionData,
  Promotion,
  UpdatePromotionData,
} from "@/types";

import CreatePromotionModal from "./components/create-modal";
import DeletePromotionModal from "./components/delete-modal";
import EditPromotionModal from "./components/edit-modal";
import { PromotionTableActions } from "./components/table-actions";
import ViewPromotionModal from "./components/view-modal";

export default function PromotionsPage() {
  const [searchTerm, setSearchTerm] = useState("");
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);
  const [selectedPromotion, setSelectedPromotion] = useState<Promotion | null>(
    null,
  );
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const searchId = useId();

  const {
    data: paginatedData,
    isLoading,
    isError,
  } = usePromotions(page, pageSize, searchTerm);
  const createMutation = useCreatePromotion();
  const updateMutation = useUpdatePromotion();
  const deleteMutation = useDeletePromotion();

  const promotions = useMemo(
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

  const handleView = useCallback((promotion: Promotion) => {
    setSelectedPromotion(promotion);
    setIsViewModalOpen(true);
  }, []);

  const handleEdit = useCallback((promotion: Promotion) => {
    setSelectedPromotion(promotion);
    setIsEditModalOpen(true);
  }, []);

  const handleDelete = useCallback((promotion: Promotion) => {
    setSelectedPromotion(promotion);
    setIsDeleteModalOpen(true);
  }, []);

  const handleCreate = async (data: CreatePromotionData) => {
    try {
      await createMutation.mutateAsync(data);
      toast.success("Promoção criada com sucesso!");
      setIsCreateModalOpen(false);
      setPage(0);
    } catch {
      toast.error("Erro ao criar promoção.");
      throw new Error("Create failed");
    }
  };

  const handleUpdate = async (data: UpdatePromotionData) => {
    if (!selectedPromotion) return;
    try {
      await updateMutation.mutateAsync({ id: selectedPromotion.id, ...data });
      toast.success("Promoção atualizada com sucesso!");
      setIsEditModalOpen(false);
      setSelectedPromotion(null);
    } catch {
      toast.error("Erro ao atualizar promoção.");
      throw new Error("Update failed");
    }
  };

  const handleConfirmDelete = async () => {
    if (!selectedPromotion) return;
    try {
      await deleteMutation.mutateAsync(selectedPromotion.id);
      toast.success("Promoção eliminada com sucesso!");
      setIsDeleteModalOpen(false);
      setSelectedPromotion(null);
      setPage(0);
    } catch {
      toast.error("Erro ao eliminar promoção.");
      throw new Error("Delete failed");
    }
  };

  const handleClearSearch = () => {
    setSearchTerm("");
    setPage(0);
  };

  const columns: ColumnDef<Promotion>[] = useMemo(
    () => [
      {
        accessorKey: "name",
        header: "Nome",
        cell: ({ row }) => (
          <span className="font-medium">{row.original.name}</span>
        ),
      },
      {
        accessorKey: "code",
        header: "Código",
        cell: ({ row }) => (
          <span className="text-muted-foreground">{row.original.code}</span>
        ),
      },
      {
        accessorKey: "discount",
        header: "Desconto",
        cell: ({ row }) => (
          <span className="text-muted-foreground">
            {row.original.discount}%
          </span>
        ),
      },
      {
        accessorKey: "stateName",
        header: "Estado",
        cell: ({ row }) => (
          <span className="text-muted-foreground">
            {row.original.stateName || "-"}
          </span>
        ),
      },
      {
        id: "actions",
        header: "Ações",
        cell: ({ row }) => (
          <PromotionTableActions
            promotion={row.original}
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
      <section className="flex justify-between items-start">
        <article className="px-2 sm:px-0">
          <h1 className="text-2xl font-bold tracking-tight sm:text-3xl">
            Promoções
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Gerir promoções do sistema
          </p>
        </article>

        <Button
          size="lg"
          onClick={() => setIsCreateModalOpen(true)}
          disabled={createMutation.isPending}
        >
          <Plus className="h-4 w-4" />
          <span>
            {createMutation.isPending ? "A criar..." : "Nova Promoção"}
          </span>
        </Button>
      </section>

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
              placeholder="Pesquisar por nome ou código"
            />
          </div>
          <Button type="button" variant="secondary" onClick={handleClearSearch}>
            Limpar
          </Button>
        </div>
      </div>

      <DataTable
        data={promotions}
        columns={columns}
        isLoading={isLoading}
        isError={isError}
        errorMessage="Erro ao carregar promoções"
        emptyMessage="Nenhuma promoção encontrada"
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

      <ViewPromotionModal
        open={isViewModalOpen}
        onOpenChange={setIsViewModalOpen}
        promotion={selectedPromotion}
      />

      <CreatePromotionModal
        open={isCreateModalOpen}
        onOpenChange={(open) =>
          !createMutation.isPending && setIsCreateModalOpen(open)
        }
        onSubmit={handleCreate}
        isSubmitting={createMutation.isPending}
      />

      <EditPromotionModal
        open={isEditModalOpen}
        onOpenChange={(open) =>
          !updateMutation.isPending && setIsEditModalOpen(open)
        }
        promotion={selectedPromotion}
        onSubmit={handleUpdate}
        isSubmitting={updateMutation.isPending}
      />

      <DeletePromotionModal
        open={isDeleteModalOpen}
        onOpenChange={(open) =>
          !deleteMutation.isPending && setIsDeleteModalOpen(open)
        }
        promotion={selectedPromotion}
        onConfirm={handleConfirmDelete}
        isDeleting={deleteMutation.isPending}
      />
    </div>
  );
}
