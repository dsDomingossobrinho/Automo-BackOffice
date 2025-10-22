import { Calendar, FileText, Info, User } from "lucide-react";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { Badge } from "@/components/ui/badge";
import { Separator } from "@/components/ui/separator";
import type { Invoice } from "@/types";

interface ViewInvoiceModalProps {
  isOpen: boolean;
  onClose: () => void;
  invoice: Invoice | null;
}

/**
 * View Invoice Modal
 * Modal de visualização de detalhes da fatura usando ResponsiveDialog
 */
export default function ViewInvoiceModal({
  isOpen,
  onClose,
  invoice,
}: Readonly<ViewInvoiceModalProps>) {
  if (!invoice) return null;

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

  // Get status badge variant
  const getStatusVariant = (
    status: string
  ): "default" | "secondary" | "destructive" | "outline" => {
    const variants: Record<string, "default" | "secondary" | "destructive"> = {
      draft: "secondary",
      sent: "default",
      paid: "default",
      overdue: "destructive",
      cancelled: "destructive",
    };
    return variants[status] || "outline";
  };

  // Get status label
  const getStatusLabel = (status: string) => {
    const labels: Record<string, string> = {
      draft: "Rascunho",
      sent: "Enviada",
      paid: "Paga",
      overdue: "Atrasada",
      cancelled: "Cancelada",
    };
    return labels[status] || status;
  };

  return (
    <ResponsiveDialog
      open={isOpen}
      onOpenChange={onClose}
      title={`Fatura #${invoice.invoiceNumber}`}
      description={invoice.clientName || invoice.clientId}
    >
      <div className="space-y-6">
        {/* Invoice Header */}
        <div className="flex items-start gap-4">
          <Avatar className="h-12 w-12 bg-blue-500/10">
            <AvatarFallback className="bg-transparent">
              <FileText className="h-6 w-6 text-blue-600" />
            </AvatarFallback>
          </Avatar>
          <div className="flex-1">
            <Badge variant={getStatusVariant(invoice.status)}>
              {getStatusLabel(invoice.status)}
            </Badge>
          </div>
        </div>

        <Separator />

        {/* Invoice Details */}
        <div className="space-y-4">
          <h4 className="flex items-center gap-2 text-sm font-semibold">
            <Info className="h-4 w-4" /> Informações Gerais
          </h4>
          <div className="grid gap-4 sm:grid-cols-2">
            <div className="space-y-1">
              <div className="flex items-center gap-2 text-sm text-muted-foreground">
                <Calendar className="h-4 w-4" />
                <span>Data de Emissão</span>
              </div>
              <p className="text-sm font-medium">
                {formatDate(invoice.issueDate)}
              </p>
            </div>

            <div className="space-y-1">
              <div className="flex items-center gap-2 text-sm text-muted-foreground">
                <Calendar className="h-4 w-4" />
                <span>Data de Vencimento</span>
              </div>
              <p className="text-sm font-medium">{formatDate(invoice.dueDate)}</p>
            </div>

            {invoice.paidDate && (
              <div className="space-y-1">
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <Calendar className="h-4 w-4" />
                  <span>Data de Pagamento</span>
                </div>
                <p className="text-sm font-medium">
                  {formatDate(invoice.paidDate)}
                </p>
              </div>
            )}

            <div className="space-y-1">
              <div className="flex items-center gap-2 text-sm text-muted-foreground">
                <User className="h-4 w-4" />
                <span>Cliente</span>
              </div>
              <p className="text-sm font-medium">
                {invoice.clientName || invoice.clientId}
              </p>
            </div>
          </div>
        </div>

        {/* Invoice Items */}
        <Separator />
        <div className="space-y-4">
          <h4 className="text-sm font-semibold">Items</h4>
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead className="border-b">
                <tr className="text-muted-foreground">
                  <th className="pb-2 text-left font-medium">Descrição</th>
                  <th className="pb-2 text-right font-medium">Qtd</th>
                  <th className="pb-2 text-right font-medium">Preço Unit.</th>
                  <th className="pb-2 text-right font-medium">Total</th>
                </tr>
              </thead>
              <tbody className="divide-y">
                {invoice.items.map((item) => (
                  <tr key={item.id || `${item.description}-${item.quantity}-${item.unitPrice}`}>
                    <td className="py-2">{item.description}</td>
                    <td className="py-2 text-right">{item.quantity}</td>
                    <td className="py-2 text-right">
                      {formatCurrency(item.unitPrice)}
                    </td>
                    <td className="py-2 text-right font-medium">
                      {formatCurrency(item.total)}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Invoice Totals */}
        <Separator />
        <div className="space-y-3">
          <h4 className="text-sm font-semibold">Totais</h4>
          <div className="space-y-2">
            <div className="flex justify-between text-sm">
              <span className="text-muted-foreground">Subtotal:</span>
              <span className="font-medium">
                {formatCurrency(invoice.subtotal)}
              </span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-muted-foreground">
                IVA ({invoice.taxRate}%):
              </span>
              <span className="font-medium">
                {formatCurrency(invoice.taxAmount)}
              </span>
            </div>
            {invoice.discount && invoice.discount > 0 && (
              <div className="flex justify-between text-sm">
                <span className="text-muted-foreground">Desconto:</span>
                <span className="font-medium text-destructive">
                  -{formatCurrency(invoice.discount)}
                </span>
              </div>
            )}
            <Separator />
            <div className="flex justify-between text-base">
              <span className="font-semibold">Total:</span>
              <span className="font-bold">{formatCurrency(invoice.total)}</span>
            </div>
          </div>
        </div>

        {/* Notes and Terms */}
        {(invoice.notes || invoice.terms) && (
          <>
            <Separator />
            <div className="space-y-4">
              {invoice.notes && (
                <div className="space-y-2">
                  <h4 className="text-sm font-semibold">Notas</h4>
                  <p className="text-sm text-muted-foreground">{invoice.notes}</p>
                </div>
              )}

              {invoice.terms && (
                <div className="space-y-2">
                  <h4 className="text-sm font-semibold">Termos e Condições</h4>
                  <p className="text-sm text-muted-foreground">{invoice.terms}</p>
                </div>
              )}
            </div>
          </>
        )}

        {/* Timestamps */}
        <Separator />
        <div className="space-y-4">
          <h4 className="text-sm font-semibold">Registo</h4>
          <div className="grid gap-4 sm:grid-cols-2">
            <div className="space-y-1">
              <div className="text-sm text-muted-foreground">Criada em</div>
              <p className="text-sm font-medium">
                {formatDate(invoice.createdAt)}
              </p>
            </div>

            {invoice.updatedAt && (
              <div className="space-y-1">
                <div className="text-sm text-muted-foreground">
                  Atualizada em
                </div>
                <p className="text-sm font-medium">
                  {formatDate(invoice.updatedAt)}
                </p>
              </div>
            )}
          </div>
        </div>
      </div>
    </ResponsiveDialog>
  );
}
