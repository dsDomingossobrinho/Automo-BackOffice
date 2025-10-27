import { Plus } from "lucide-react";
import { useCallback, useId, useMemo, useState } from "react";
import { toast } from "sonner";

import { type ColumnDef, DataTable } from "@/components/common/data-table";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  useAccountTypes,
  useCreateAccountType,
  useDeleteAccountType,
  useUpdateAccountType,
} from "@/hooks/useAccountTypes";
import type {
  AccountType,
  CreateAccountTypeData,
  UpdateAccountTypeData,
} from "@/types";

import CreateAccountTypeModal from "./components/create-modal";
import DeleteAccountTypeModal from "./components/delete-modal";
import EditAccountTypeModal from "./components/edit-modal";
import { AccountTypeTableActions } from "./components/table-actions";
import ViewAccountTypeModal from "./components/view-modal";

export default function AccountTypesPage() {
  // Local UI state
  const [searchTerm, setSearchTerm] = useState("");
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);
  const [selectedAccountType, setSelectedAccountType] =
    useState<AccountType | null>(null);
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  const searchId = useId();

  // React Query hooks
  const { data: accountTypes = [], isLoading, isError } = useAccountTypes();
  const createMutation = useCreateAccountType();
  const updateMutation = useUpdateAccountType();
  const deleteMutation = useDeleteAccountType();

  // Client-side filtering/pagination
  const filtered = useMemo(
    () =>
      accountTypes.filter(
        (at) =>
          at?.type?.toLowerCase()?.includes(searchTerm?.toLowerCase()) ||
          at?.description?.toLowerCase()?.includes(searchTerm?.toLowerCase()),
      ),
    [accountTypes, searchTerm],
  );

  const total = filtered.length;
  const totalPages = Math.max(1, Math.ceil(total / pageSize));
  const paged = useMemo(
    () => filtered.slice(page * pageSize, (page + 1) * pageSize),
    [filtered, page, pageSize],
  );

  // Handle view
  const handleView = useCallback((accountType: AccountType) => {
    setSelectedAccountType(accountType);
    setIsViewModalOpen(true);
  }, []);

  // Handle edit
  const handleEdit = useCallback((accountType: AccountType) => {
    setSelectedAccountType(accountType);
    setIsEditModalOpen(true);
  }, []);

  // Handle delete
  const handleDelete = useCallback((accountType: AccountType) => {
    setSelectedAccountType(accountType);
    setIsDeleteModalOpen(true);
  }, []);

  // Handle create
  const handleCreate = async (data: CreateAccountTypeData) => {
    try {
      await createMutation.mutateAsync(data);
      toast.success("Tipo de conta criado com sucesso!");
      setIsCreateModalOpen(false);
    } catch {
      toast.error("Erro ao criar tipo de conta.");
      throw new Error("Create failed");
    }
  };

  // Handle update
  const handleUpdate = async (data: UpdateAccountTypeData) => {
    if (!selectedAccountType) return;
    try {
      await updateMutation.mutateAsync({
        id: selectedAccountType.id,
        ...data,
      });
      toast.success("Tipo de conta atualizado com sucesso!");
      setIsEditModalOpen(false);
      setSelectedAccountType(null);
    } catch {
      toast.error("Erro ao atualizar tipo de conta.");
      throw new Error("Update failed");
    }
  };

  // Handle confirm delete
  const handleConfirmDelete = async () => {
    if (!selectedAccountType) return;
    try {
      await deleteMutation.mutateAsync(selectedAccountType.id);
      toast.success("Tipo de conta eliminado com sucesso!");
      setIsDeleteModalOpen(false);
      setSelectedAccountType(null);
    } catch {
      toast.error("Erro ao eliminar tipo de conta.");
      throw new Error("Delete failed");
    }
  };

  // Clear search
  const handleClearSearch = () => {
    setSearchTerm("");
    setPage(0);
  };

  // Create table columns
  const columns: ColumnDef<AccountType>[] = useMemo(
    () => [
      {
        accessorKey: "type",
        header: "Tipo",
        cell: ({ row }) => (
          <span className="font-medium">{row.original.type}</span>
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
          <AccountTypeTableActions
            accountType={row.original}
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
            Tipos de Contas
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Gerir os tipos de contas disponíveis no sistema
          </p>
        </article>

        {/* Primary Action Button */}
        <Button
          size="lg"
          onClick={() => setIsCreateModalOpen(true)}
          disabled={createMutation.isPending}
        >
          <Plus className="h-4 w-4" />
          <span>{createMutation.isPending ? "A criar..." : "Novo Tipo"}</span>
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
              placeholder="Pesquisar por tipo ou descrição"
            />
          </div>
          <Button type="button" variant="secondary" onClick={handleClearSearch}>
            Limpar
          </Button>
        </div>
      </div>

      {/* 3. Data Table */}
      <DataTable
        data={paged}
        columns={columns}
        isLoading={isLoading}
        isError={isError}
        errorMessage="Erro ao carregar tipos de contas"
        emptyMessage="Nenhum tipo de conta encontrado"
        pagination={{
          page,
          pageSize,
          totalElements: total,
          totalPages,
          hasNext: page + 1 < totalPages,
          hasPrevious: page > 0,
          onPageChange: setPage,
        }}
      />

      {/* Modals */}
      <ViewAccountTypeModal
        open={isViewModalOpen}
        onOpenChange={setIsViewModalOpen}
        accountType={selectedAccountType}
      />

      <CreateAccountTypeModal
        open={isCreateModalOpen}
        onOpenChange={(open) =>
          !createMutation.isPending && setIsCreateModalOpen(open)
        }
        onSubmit={handleCreate}
        isSubmitting={createMutation.isPending}
      />

      <EditAccountTypeModal
        open={isEditModalOpen}
        onOpenChange={(open) =>
          !updateMutation.isPending && setIsEditModalOpen(open)
        }
        accountType={selectedAccountType}
        onSubmit={handleUpdate}
        isSubmitting={updateMutation.isPending}
      />

      <DeleteAccountTypeModal
        open={isDeleteModalOpen}
        onOpenChange={(open) =>
          !deleteMutation.isPending && setIsDeleteModalOpen(open)
        }
        accountType={selectedAccountType}
        onConfirm={handleConfirmDelete}
        isDeleting={deleteMutation.isPending}
      />
    </div>
  );
}
