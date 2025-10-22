import { Edit, Eye, Trash2 } from "lucide-react";
import type { ColumnDef } from "@/components/common/data-table";
import { Button } from "@/components/ui/button";
import type { Transaction } from "@/types";

// Funções auxiliares
const formatCurrency = (amount: number) => {
  return new Intl.NumberFormat("pt-PT", {
    style: "currency",
    currency: "EUR",
  }).format(amount);
};

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString("pt-PT");
};

const getStatusBadge = (status: string) => {
  const badges: Record<string, { class: string; label: string }> = {
    pending: { class: "bg-yellow-500/10 text-yellow-500", label: "Pendente" },
    completed: { class: "bg-green-500/10 text-green-500", label: "Completa" },
    cancelled: { class: "bg-red-500/10 text-red-500", label: "Cancelada" },
    failed: { class: "bg-red-500/10 text-red-500", label: "Falhada" },
  };
  const badge = badges[status] || {
    class: "bg-gray-500/10 text-gray-500",
    label: status,
  };

  return (
    <span
      className={`inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ${badge.class}`}
    >
      {badge.label}
    </span>
  );
};

interface TransactionColumnsProps {
  onView: (transaction: Transaction) => void;
  onEdit: (transaction: Transaction) => void;
  onDelete: (transaction: Transaction) => void;
}

export const createTransactionColumns = ({
  onView,
  onEdit,
  onDelete,
}: TransactionColumnsProps): ColumnDef<Transaction>[] => [
    {
      id: "amount",
      header: "Valor do pagamento",
      cell: ({ row }) => (
        <span
          className="font-bold"
          style={{
            color: row.original.type === "income" ? "#10b981" : "#ef4444",
          }}
        >
          {row.original.type === "income" ? "+" : "-"}{" "}
          {formatCurrency(row.original.amount)}
        </span>
      ),
    },
    {
      accessorKey: "type",
      header: "Tipo",
      cell: ({ row }) => (
        <span
          className={`inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ${row.original.type === "income"
              ? "bg-green-500/10 text-green-500"
              : "bg-red-500/10 text-red-500"
            }`}
        >
          {row.original.type === "income" ? "Receita" : "Despesa"}
        </span>
      ),
    },
    {
      accessorKey: "status",
      header: "Estado",
      cell: ({ row }) => getStatusBadge(row.original.status),
    },
    {
      accessorKey: "date",
      header: "Data",
      cell: ({ row }) => formatDate(row.original.date),
    },
    {
      accessorKey: "createdAt",
      header: "Data submissão",
      cell: ({ row }) => formatDate(row.original.createdAt),
    },
    {
      id: "actions",
      header: "Ações",
      cell: ({ row }) => (
        <div className="flex items-center justify-end gap-1">
          <Button
            variant="ghost"
            size="icon"
            onClick={() => onView(row.original)}
            title="Ver detalhes"
          >
            <Eye className="h-4 w-4" />
          </Button>
          <Button
            variant="ghost"
            size="icon"
            onClick={() => onEdit(row.original)}
            title="Editar"
          >
            <Edit className="h-4 w-4" />
          </Button>
          <Button
            variant="ghost"
            size="icon"
            onClick={() => onDelete(row.original)}
            title="Eliminar"
          >
            <Trash2 className="h-4 w-4" />
          </Button>
        </div>
      ),
    },
  ];
