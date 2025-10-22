import {
  ArrowDown,
  ArrowUp,
  Calendar,
  CreditCard,
  Download,
  FileText,
  Info,
  Tag,
  User,
} from "lucide-react";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Separator } from "@/components/ui/separator";
import type { Transaction } from "@/types";

interface ViewTransactionModalProps {
  isOpen: boolean;
  onClose: () => void;
  transaction: Transaction | null;
}

/**
 * View Transaction Modal
 * Modal de visualização de detalhes da transação usando ResponsiveDialog
 */
export default function ViewTransactionModal({
  isOpen,
  onClose,
  transaction,
}: Readonly<ViewTransactionModalProps>) {
  if (!transaction) return null;

  // Format currency
  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("pt-PT", {
      style: "currency",
      currency: "EUR",
    }).format(amount);
  };

  // Format date
  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString("pt-PT", {
      day: "2-digit",
      month: "long",
      year: "numeric",
    });
  };

  // Get type label
  const getTypeLabel = (type: string) => {
    return type === "income" ? "Receita" : "Despesa";
  };

  // Get category label
  const getCategoryLabel = (category: string) => {
    const labels: Record<string, string> = {
      sale: "Venda",
      service: "Serviço",
      subscription: "Subscrição",
      other: "Outro",
      salary: "Salário",
      rent: "Renda",
      utilities: "Utilidades",
      marketing: "Marketing",
      software: "Software",
      equipment: "Equipamento",
      travel: "Viagens",
      supplies: "Materiais",
    };
    return labels[category] || category;
  };

  // Get payment method label
  const getPaymentMethodLabel = (method: string) => {
    const labels: Record<string, string> = {
      cash: "Dinheiro",
      bank_transfer: "Transferência Bancária",
      credit_card: "Cartão de Crédito",
      debit_card: "Cartão de Débito",
      paypal: "PayPal",
      mbway: "MB Way",
      other: "Outro",
    };
    return labels[method] || method;
  };

  // Get status badge variant
  const getStatusVariant = (
    status: string
  ): "default" | "secondary" | "destructive" | "outline" => {
    const variants: Record<string, "default" | "secondary" | "destructive"> = {
      pending: "secondary",
      completed: "default",
      cancelled: "destructive",
      failed: "destructive",
    };
    return variants[status] || "outline";
  };

  // Get status label
  const getStatusLabel = (status: string) => {
    const labels: Record<string, string> = {
      pending: "Pendente",
      completed: "Completa",
      cancelled: "Cancelada",
      failed: "Falhada",
    };
    return labels[status] || status;
  };

  return (
    <ResponsiveDialog
      open={isOpen}
      onOpenChange={onClose}
      title="Detalhes da Transação"
      description={`${getTypeLabel(transaction.type)} • ${getCategoryLabel(transaction.category)}`}
    >
      <div className="space-y-6">
        {/* Transaction Header */}
        <div className="flex items-start gap-4">
          <Avatar className="h-12 w-12">
            <AvatarFallback
              className={
                transaction.type === "income"
                  ? "bg-green-500/10 text-green-600"
                  : "bg-red-500/10 text-red-600"
              }
            >
              {transaction.type === "income" ? (
                <ArrowUp className="h-6 w-6" />
              ) : (
                <ArrowDown className="h-6 w-6" />
              )}
            </AvatarFallback>
          </Avatar>
          <div className="flex-1 space-y-1">
            <h3 className="font-semibold">{transaction.description}</h3>
            <p
              className="text-2xl font-bold"
              style={{
                color: transaction.type === "income" ? "#10b981" : "#ef4444",
              }}
            >
              {transaction.type === "income" ? "+" : "-"}{" "}
              {formatCurrency(transaction.amount)}
            </p>
          </div>
        </div>

        <Separator />

        {/* Transaction Details */}
        <div className="space-y-4">
          <h4 className="flex items-center gap-2 text-sm font-semibold">
            <Info className="h-4 w-4" /> Informações Gerais
          </h4>
          <div className="grid gap-4 sm:grid-cols-2">
            <div className="space-y-1">
              <div className="flex items-center gap-2 text-sm text-muted-foreground">
                <Calendar className="h-4 w-4" />
                <span>Data</span>
              </div>
              <p className="text-sm font-medium">{formatDate(transaction.date)}</p>
            </div>

            <div className="space-y-1">
              <div className="flex items-center gap-2 text-sm text-muted-foreground">
                <Tag className="h-4 w-4" />
                <span>Estado</span>
              </div>
              <Badge variant={getStatusVariant(transaction.status)}>
                {getStatusLabel(transaction.status)}
              </Badge>
            </div>

            {transaction.paymentMethod && (
              <div className="space-y-1">
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <CreditCard className="h-4 w-4" />
                  <span>Método de Pagamento</span>
                </div>
                <p className="text-sm font-medium">
                  {getPaymentMethodLabel(transaction.paymentMethod)}
                </p>
              </div>
            )}

            {transaction.reference && (
              <div className="space-y-1">
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <FileText className="h-4 w-4" />
                  <span>Referência</span>
                </div>
                <p className="text-sm font-medium">{transaction.reference}</p>
              </div>
            )}
          </div>
        </div>

        {/* Related Information */}
        {(transaction.clientId || transaction.invoiceId) && (
          <>
            <Separator />
            <div className="space-y-4">
              <h4 className="flex items-center gap-2 text-sm font-semibold">
                <User className="h-4 w-4" /> Informações Relacionadas
              </h4>
              <div className="grid gap-4 sm:grid-cols-2">
                {transaction.clientId && (
                  <div className="space-y-1">
                    <div className="text-sm text-muted-foreground">Cliente</div>
                    <p className="text-sm font-medium">
                      {transaction.clientName || transaction.clientId}
                    </p>
                  </div>
                )}

                {transaction.invoiceId && (
                  <div className="space-y-1">
                    <div className="text-sm text-muted-foreground">Fatura</div>
                    <p className="text-sm font-medium">{transaction.invoiceId}</p>
                  </div>
                )}
              </div>
            </div>
          </>
        )}

        {/* Notes */}
        {transaction.notes && (
          <>
            <Separator />
            <div className="space-y-2">
              <h4 className="text-sm font-semibold">Notas</h4>
              <p className="text-sm text-muted-foreground">{transaction.notes}</p>
            </div>
          </>
        )}

        {/* Receipt */}
        {transaction.receiptUrl && (
          <>
            <Separator />
            <div className="space-y-4">
              <h4 className="text-sm font-semibold">Recibo</h4>
              <div className="space-y-4">
                <Button variant="outline" size="sm" asChild>
                  <a
                    href={transaction.receiptUrl}
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <Download className="mr-2 h-4 w-4" /> Abrir Recibo
                  </a>
                </Button>
                <div className="overflow-hidden rounded-lg border">
                  <img
                    src={transaction.receiptUrl}
                    alt="Recibo"
                    className="h-auto w-full max-w-sm"
                  />
                </div>
              </div>
            </div>
          </>
        )}

        {/* Timestamps */}
        <Separator />
        <div className="space-y-4">
          <h4 className="text-sm font-semibold">Registo</h4>
          <div className="grid gap-4 sm:grid-cols-2">
            <div className="space-y-1">
              <div className="text-sm text-muted-foreground">Criado em</div>
              <p className="text-sm font-medium">
                {formatDate(transaction.createdAt)}
              </p>
            </div>

            {transaction.updatedAt && (
              <div className="space-y-1">
                <div className="text-sm text-muted-foreground">Atualizado em</div>
                <p className="text-sm font-medium">
                  {formatDate(transaction.updatedAt)}
                </p>
              </div>
            )}
          </div>
        </div>
      </div>
    </ResponsiveDialog>
  );
}
