import {
  flexRender,
  getCoreRowModel,
  type ColumnDef as TanStackColumnDef,
  useReactTable,
} from "@tanstack/react-table";
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationLink,
  PaginationNext,
  PaginationPrevious,
} from "@/components/ui/pagination";
import { Skeleton } from "@/components/ui/skeleton";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";

// Re-export ColumnDef from TanStack Table for easier imports
export type { ColumnDef } from "@tanstack/react-table";

export interface PaginationConfig {
  /** Página atual (0-indexed) */
  page: number;
  /** Número de itens por página */
  pageSize: number;
  /** Total de elementos */
  totalElements: number;
  /** Total de páginas */
  totalPages: number;
  /** Se há próxima página */
  hasNext: boolean;
  /** Se há página anterior */
  hasPrevious: boolean;
  /** Callback quando a página muda */
  onPageChange: (page: number) => void;
  /** Texto customizado para paginação (opcional) */
  paginationText?: {
    showing: string;
    of: string;
    page: string;
    previous: string;
    next: string;
  };
}

export interface DataTableProps<TData> {
  /** Dados a serem exibidos */
  data: TData[];
  /** Definição das colunas usando TanStack Table ColumnDef */
  columns: TanStackColumnDef<TData>[];
  /** Estado de carregamento */
  isLoading?: boolean;
  /** Estado de erro */
  isError?: boolean;
  /** Mensagem de erro customizada */
  errorMessage?: string;
  /** Mensagem quando não há dados */
  emptyMessage?: string;
  /** Configuração de paginação (opcional) */
  pagination?: PaginationConfig;
  /** Classe CSS customizada para a tabela */
  className?: string;
  /** Número de linhas skeleton durante loading */
  skeletonRows?: number;
}

export function DataTable<TData>({
  data,
  columns,
  isLoading = false,
  isError = false,
  errorMessage = "Erro ao carregar dados",
  emptyMessage = "Nenhum dado encontrado",
  pagination,
  className = "",
  skeletonRows = 5,
}: Readonly<DataTableProps<TData>>) {
  // Textos padrão de paginação
  const defaultPaginationText = {
    showing: "Mostrando",
    of: "de",
    page: "Página",
    previous: "Anterior",
    next: "Próximo",
  };

  const paginationText = pagination?.paginationText || defaultPaginationText;

  // Inicializa o React Table
  const table = useReactTable({
    data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    manualPagination: true, // Paginação manual (controlada externamente)
  });

  return (
    <div className={`data-table-container ${className}`}>
      {/* Tabela */}
      <div className="table-section">
        <div className="[&>div]:rounded-sm [&>div]:border">
          <Table>
            <TableHeader>
              {table.getHeaderGroups().map((headerGroup) => (
                <TableRow key={headerGroup.id} className="hover:bg-transparent">
                  {headerGroup.headers.map((header) => (
                    <TableHead key={header.id}>
                      {header.isPlaceholder
                        ? null
                        : flexRender(
                          header.column.columnDef.header,
                          header.getContext(),
                        )}
                    </TableHead>
                  ))}
                </TableRow>
              ))}
            </TableHeader>
            <TableBody>
              {/* Loading State */}
              {isLoading &&
                Array.from(
                  { length: skeletonRows },
                  (_, i) => `skeleton-row-${i}`,
                ).map((skeletonId) => (
                  <TableRow key={skeletonId}>
                    {Array.from(
                      { length: columns.length },
                      (__, j) => `${skeletonId}-col-${j}`,
                    ).map((cellId) => (
                      <TableCell key={cellId}>
                        <Skeleton className="h-8 w-full" />
                      </TableCell>
                    ))}
                  </TableRow>
                ))}

              {/* Error State */}
              {isError && !isLoading && (
                <TableRow>
                  <TableCell
                    colSpan={columns.length}
                    className="text-center py-8"
                  >
                    <div className="text-red-500">
                      <i className="fas fa-exclamation-circle mb-2 text-2xl block"></i>
                      <p className="font-medium">{errorMessage}</p>
                    </div>
                  </TableCell>
                </TableRow>
              )}

              {/* Empty State */}
              {!isLoading &&
                !isError &&
                table.getRowModel().rows.length === 0 && (
                  <TableRow>
                    <TableCell
                      colSpan={columns.length}
                      className="text-center py-8"
                    >
                      <div className="text-muted-foreground">
                        <i className="fas fa-inbox mb-2 text-2xl block"></i>
                        <p className="font-medium">{emptyMessage}</p>
                      </div>
                    </TableCell>
                  </TableRow>
                )}

              {/* Data Rows */}
              {!isLoading &&
                !isError &&
                table.getRowModel().rows.length > 0 &&
                table.getRowModel().rows.map((row) => (
                  <TableRow key={row.id}>
                    {row.getVisibleCells().map((cell) => (
                      <TableCell key={cell.id}>
                        {flexRender(
                          cell.column.columnDef.cell,
                          cell.getContext(),
                        )}
                      </TableCell>
                    ))}
                  </TableRow>
                ))}
            </TableBody>
          </Table>
        </div>
      </div>

      {/* Pagination */}
      {pagination && !isLoading && (
        <div className="w-full flex flex-col sm:flex-row items-center justify-between gap-4 py-4">
          {/* Info de paginação */}
          <div className="w-full text-sm text-muted-foreground">
            {paginationText.showing}{" "}
            <strong>
              {pagination.page * pagination.pageSize + 1}-
              {Math.min(
                (pagination.page + 1) * pagination.pageSize,
                pagination.totalElements,
              )}
            </strong>{" "}
            {paginationText.of} <strong>{pagination.totalElements}</strong>
          </div>

          {/* Controles de paginação com shadcn */}
          <Pagination className="justify-end m-0">
            <PaginationContent>
              <PaginationItem>
                <PaginationPrevious
                  onClick={() =>
                    pagination.hasPrevious &&
                    pagination.onPageChange(pagination.page - 1)
                  }
                  className={
                    pagination.hasPrevious
                      ? "cursor-pointer"
                      : "pointer-events-none opacity-50"
                  }
                />
              </PaginationItem>

              {/* Renderiza números de página */}
              {generatePageNumbers(pagination.page, pagination.totalPages).map(
                (pageNum, idx) => {
                  if (pageNum === -1) {
                    return (
                      <PaginationItem
                        key={`ellipsis-${pagination.page}-${idx}`}
                      >
                        <PaginationEllipsis />
                      </PaginationItem>
                    );
                  }

                  return (
                    <PaginationItem key={pageNum}>
                      <PaginationLink
                        onClick={() => pagination.onPageChange(pageNum)}
                        isActive={pageNum === pagination.page}
                        className="cursor-pointer"
                      >
                        {pageNum + 1}
                      </PaginationLink>
                    </PaginationItem>
                  );
                },
              )}

              <PaginationItem>
                <PaginationNext
                  onClick={() =>
                    pagination.hasNext &&
                    pagination.onPageChange(pagination.page + 1)
                  }
                  className={
                    pagination.hasNext
                      ? "cursor-pointer"
                      : "pointer-events-none opacity-50"
                  }
                />
              </PaginationItem>
            </PaginationContent>
          </Pagination>
        </div>
      )}
    </div>
  );
}

/**
 * Gera array de números de página para exibir na paginação
 * Mostra até 7 páginas: [1] ... [n-1] [n] [n+1] ... [total]
 */
function generatePageNumbers(
  currentPage: number,
  totalPages: number,
): number[] {
  const pages: number[] = [];
  const maxVisible = 7;

  if (totalPages <= maxVisible) {
    // Se tem poucas páginas, mostra todas
    for (let i = 0; i < totalPages; i++) {
      pages.push(i);
    }
  } else {
    // Sempre mostra primeira página
    pages.push(0);

    if (currentPage <= 3) {
      // Início: [1] [2] [3] [4] [5] ... [total]
      for (let i = 1; i < 5; i++) {
        pages.push(i);
      }
      pages.push(-1, totalPages - 1); // Ellipsis + última página
    } else if (currentPage >= totalPages - 4) {
      // Fim: [1] ... [n-4] [n-3] [n-2] [n-1] [n]
      pages.push(-1); // Ellipsis
      for (let i = totalPages - 5; i < totalPages; i++) {
        pages.push(i);
      }
    } else {
      // Meio: [1] ... [n-1] [n] [n+1] ... [total]
      pages.push(
        -1,
        currentPage - 1,
        currentPage,
        currentPage + 1,
        -1,
        totalPages - 1,
      );
    }
  }

  return pages;
}

export default DataTable;
