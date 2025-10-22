import { Plus, ShieldCheck } from "lucide-react";
import { useCallback, useId, useMemo, useState } from "react";
import { toast } from "sonner";

import { DataTable } from "@/components/common/data-table";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { createRoleColumns } from "@/components/common/role-columns";
import RoleForm from "@/components/forms/RoleForm";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { useCreateRole, useRoles } from "@/hooks/useRoles";
import type { RoleInfo } from "@/types";

export default function RolesPage() {
  // Local UI state
  const [searchTerm, setSearchTerm] = useState("");
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);
  const [selectedRole, setSelectedRole] = useState<RoleInfo | null>(null);
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
  const searchId = useId();

  // React Query hooks
  const { data: roles = [], isLoading, isError } = useRoles();
  const createMutation = useCreateRole();

  // Client-side filtering/pagination
  const filtered = useMemo(
    () =>
      roles.filter((r) =>
        r?.name?.toLowerCase()?.includes(searchTerm?.toLowerCase()),
      ),
    [roles, searchTerm],
  );

  const total = filtered.length;
  const totalPages = Math.max(1, Math.ceil(total / pageSize));
  const paged = useMemo(
    () => filtered.slice(page * pageSize, (page + 1) * pageSize),
    [filtered, page, pageSize],
  );

  // Handle view role
  const handleView = useCallback((role: RoleInfo) => {
    setSelectedRole(role);
    setIsViewModalOpen(true);
  }, []);

  // Handle create role
  const handleCreate = async (data: { role: string; description?: string }) => {
    try {
      await createMutation.mutateAsync(data);
      toast.success("Cargo criado com sucesso!");
      setIsCreateModalOpen(false);
    } catch (err) {
      toast.error("Erro ao criar cargo.");
      throw err;
    }
  };

  // Clear search
  const handleClearSearch = () => {
    setSearchTerm("");
    setPage(0);
  };

  // Create table columns
  const columns = useMemo(
    () => createRoleColumns({ onView: handleView }),
    [handleView],
  );

  return (
    <div className="space-y-5 xl:space-y-8">
      {/* 1. Page Header */}
      <section className="flex justify-between items-start">
        <article className="px-2 sm:px-0">
          <h1 className="text-2xl font-bold tracking-tight sm:text-3xl">
            Cargos
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Gerir cargos e permissões do sistema
          </p>
        </article>

        {/* Primary Action Button */}
        <Button
          size="lg"
          onClick={() => setIsCreateModalOpen(true)}
          disabled={createMutation.isPending}
        >
          <Plus className="h-4 w-4" />
          <span>{createMutation.isPending ? "A criar..." : "Novo Cargo"}</span>
        </Button>
      </section>

      {/* 2. Search Section */}
      <div className="rounded-lg border bg-card p-4">
        <div className="flex flex-wrap items-end gap-4">
          <div className="flex-1 min-w-[200px]">
            <Label htmlFor={searchId} className="mb-2 flex items-center gap-2">
              <ShieldCheck className="h-4 w-4" /> Pesquisar
            </Label>
            <Input
              id={searchId}
              value={searchTerm}
              onChange={(e) => {
                setSearchTerm(e.target.value);
                setPage(0);
              }}
              placeholder="Pesquisar por nome"
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
        errorMessage="Erro ao carregar cargos"
        emptyMessage="Nenhum cargo encontrado"
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

      {/* View Role Modal */}
      <ResponsiveDialog
        open={isViewModalOpen}
        onOpenChange={setIsViewModalOpen}
        title="Detalhes do Cargo"
      >
        {selectedRole && (
          <div className="space-y-4">
            <div className="space-y-2">
              <Label className="text-muted-foreground">Nome:</Label>
              <p className="font-medium">{selectedRole.name}</p>
            </div>
            <div className="space-y-2">
              <Label className="text-muted-foreground">Descrição:</Label>
              <p className="font-medium">{selectedRole.description || "-"}</p>
            </div>
          </div>
        )}
      </ResponsiveDialog>

      {/* Create Role Modal */}
      <ResponsiveDialog
        open={isCreateModalOpen}
        onOpenChange={(open) =>
          !createMutation.isPending && setIsCreateModalOpen(open)
        }
        title="Criar Cargo"
      >
        <RoleForm
          mode="create"
          onSubmit={handleCreate}
          onCancel={() => setIsCreateModalOpen(false)}
          isSubmitting={createMutation.isPending}
        />
      </ResponsiveDialog>
    </div>
  );
}
