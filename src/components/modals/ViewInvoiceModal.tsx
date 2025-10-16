import Modal from './Modal';
import type { Invoice } from '../../types';

interface ViewInvoiceModalProps {
  isOpen: boolean;
  onClose: () => void;
  invoice: Invoice | null;
}

/**
 * View Invoice Modal
 * Read-only view of invoice details
 */
export default function ViewInvoiceModal({ isOpen, onClose, invoice }: ViewInvoiceModalProps) {
  if (!invoice) return null;

  // Format currency
  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('pt-PT', {
      style: 'currency',
      currency: 'EUR',
    }).format(amount);
  };

  // Format date
  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('pt-PT', {
      day: '2-digit',
      month: 'long',
      year: 'numeric',
    });
  };

  // Get status badge
  const getStatusBadge = (status: string) => {
    const badges: Record<string, { class: string; label: string }> = {
      draft: { class: 'badge-secondary', label: 'Rascunho' },
      sent: { class: 'badge-info', label: 'Enviada' },
      paid: { class: 'badge-success', label: 'Paga' },
      overdue: { class: 'badge-danger', label: 'Atrasada' },
      cancelled: { class: 'badge-error', label: 'Cancelada' },
    };
    const badge = badges[status] || { class: 'badge-secondary', label: status };
    return <span className={`badge ${badge.class}`}>{badge.label}</span>;
  };

  return (
    <Modal isOpen={isOpen} onClose={onClose} title="Detalhes da Fatura" size="large">
      <div className="view-modal-content">
        {/* Invoice Header */}
        <div className="view-modal-header">
          <div className="view-modal-avatar">
            <i className="fas fa-file-invoice" style={{ color: '#3b82f6' }}></i>
          </div>
          <div className="view-modal-header-info">
            <h2>Fatura #{invoice.invoiceNumber}</h2>
            <p className="text-muted">{invoice.clientName || invoice.clientId}</p>
          </div>
        </div>

        {/* Invoice Details */}
        <div className="view-modal-section">
          <h3>Informações Gerais</h3>
          <div className="view-modal-grid">
            <div className="view-modal-field">
              <label>Estado</label>
              <p>{getStatusBadge(invoice.status)}</p>
            </div>

            <div className="view-modal-field">
              <label>Data de Emissão</label>
              <p>{formatDate(invoice.issueDate)}</p>
            </div>

            <div className="view-modal-field">
              <label>Data de Vencimento</label>
              <p>{formatDate(invoice.dueDate)}</p>
            </div>

            {invoice.paidDate && (
              <div className="view-modal-field">
                <label>Data de Pagamento</label>
                <p>{formatDate(invoice.paidDate)}</p>
              </div>
            )}
          </div>
        </div>

        {/* Invoice Items */}
        <div className="view-modal-section">
          <h3>Items</h3>
          <table className="table">
            <thead>
              <tr>
                <th>Descrição</th>
                <th className="text-right">Quantidade</th>
                <th className="text-right">Preço Unitário</th>
                <th className="text-right">Total</th>
              </tr>
            </thead>
            <tbody>
              {invoice.items.map((item, index) => (
                <tr key={index}>
                  <td>{item.description}</td>
                  <td className="text-right">{item.quantity}</td>
                  <td className="text-right">{formatCurrency(item.unitPrice)}</td>
                  <td className="text-right">{formatCurrency(item.total)}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {/* Invoice Totals */}
        <div className="view-modal-section">
          <h3>Totais</h3>
          <div className="invoice-totals">
            <div className="invoice-total-row">
              <span>Subtotal:</span>
              <strong>{formatCurrency(invoice.subtotal)}</strong>
            </div>
            <div className="invoice-total-row">
              <span>IVA ({invoice.taxRate}%):</span>
              <strong>{formatCurrency(invoice.taxAmount)}</strong>
            </div>
            {invoice.discount && invoice.discount > 0 && (
              <div className="invoice-total-row">
                <span>Desconto:</span>
                <strong className="text-danger">-{formatCurrency(invoice.discount)}</strong>
              </div>
            )}
            <div className="invoice-total-row invoice-total-final">
              <span>Total:</span>
              <strong>{formatCurrency(invoice.total)}</strong>
            </div>
          </div>
        </div>

        {/* Notes and Terms */}
        {(invoice.notes || invoice.terms) && (
          <div className="view-modal-section">
            {invoice.notes && (
              <>
                <h3>Notas</h3>
                <p>{invoice.notes}</p>
              </>
            )}

            {invoice.terms && (
              <>
                <h3>Termos e Condições</h3>
                <p>{invoice.terms}</p>
              </>
            )}
          </div>
        )}

        {/* Timestamps */}
        <div className="view-modal-section">
          <h3>Registo</h3>
          <div className="view-modal-grid">
            <div className="view-modal-field">
              <label>Criada em</label>
              <p>{formatDate(invoice.createdAt)}</p>
            </div>

            {invoice.updatedAt && (
              <div className="view-modal-field">
                <label>Atualizada em</label>
                <p>{formatDate(invoice.updatedAt)}</p>
              </div>
            )}
          </div>
        </div>
      </div>
    </Modal>
  );
}
