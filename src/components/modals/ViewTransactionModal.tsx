import Modal from './Modal';
import type { Transaction } from '../../types';

interface ViewTransactionModalProps {
  isOpen: boolean;
  onClose: () => void;
  transaction: Transaction | null;
}

/**
 * View Transaction Modal
 * Read-only view of transaction details
 */
export default function ViewTransactionModal({ isOpen, onClose, transaction }: ViewTransactionModalProps) {
  if (!transaction) return null;

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

  // Get type label
  const getTypeLabel = (type: string) => {
    return type === 'income' ? 'Receita' : 'Despesa';
  };

  // Get category label
  const getCategoryLabel = (category: string) => {
    const labels: Record<string, string> = {
      sale: 'Venda',
      service: 'Serviço',
      subscription: 'Subscrição',
      other: 'Outro',
      salary: 'Salário',
      rent: 'Renda',
      utilities: 'Utilidades',
      marketing: 'Marketing',
      software: 'Software',
      equipment: 'Equipamento',
      travel: 'Viagens',
      supplies: 'Materiais',
    };
    return labels[category] || category;
  };

  // Get payment method label
  const getPaymentMethodLabel = (method: string) => {
    const labels: Record<string, string> = {
      cash: 'Dinheiro',
      bank_transfer: 'Transferência Bancária',
      credit_card: 'Cartão de Crédito',
      debit_card: 'Cartão de Débito',
      paypal: 'PayPal',
      mbway: 'MB Way',
      other: 'Outro',
    };
    return labels[method] || method;
  };

  // Get status badge
  const getStatusBadge = (status: string) => {
    const badges: Record<string, { class: string; label: string }> = {
      pending: { class: 'badge-warning', label: 'Pendente' },
      completed: { class: 'badge-success', label: 'Completa' },
      cancelled: { class: 'badge-danger', label: 'Cancelada' },
      failed: { class: 'badge-error', label: 'Falhada' },
    };
    const badge = badges[status] || { class: 'badge-secondary', label: status };
    return <span className={`badge ${badge.class}`}>{badge.label}</span>;
  };

  return (
    <Modal isOpen={isOpen} onClose={onClose} title="Detalhes da Transação" size="large">
      <div className="view-modal-content">
        {/* Transaction Header */}
        <div className="view-modal-header">
          <div className="view-modal-avatar">
            <i
              className={`fas ${transaction.type === 'income' ? 'fa-arrow-up' : 'fa-arrow-down'}`}
              style={{ color: transaction.type === 'income' ? '#10b981' : '#ef4444' }}
            ></i>
          </div>
          <div className="view-modal-header-info">
            <h2>{transaction.description}</h2>
            <p className="text-muted">
              {getTypeLabel(transaction.type)} • {getCategoryLabel(transaction.category)}
            </p>
          </div>
        </div>

        {/* Transaction Details */}
        <div className="view-modal-section">
          <h3>Informações Gerais</h3>
          <div className="view-modal-grid">
            <div className="view-modal-field">
              <label>Valor</label>
              <p
                className="amount"
                style={{ color: transaction.type === 'income' ? '#10b981' : '#ef4444', fontWeight: 'bold' }}
              >
                {transaction.type === 'income' ? '+' : '-'} {formatCurrency(transaction.amount)}
              </p>
            </div>

            <div className="view-modal-field">
              <label>Data</label>
              <p>{formatDate(transaction.date)}</p>
            </div>

            <div className="view-modal-field">
              <label>Estado</label>
              <p>{getStatusBadge(transaction.status)}</p>
            </div>

            {transaction.paymentMethod && (
              <div className="view-modal-field">
                <label>Método de Pagamento</label>
                <p>{getPaymentMethodLabel(transaction.paymentMethod)}</p>
              </div>
            )}

            {transaction.reference && (
              <div className="view-modal-field">
                <label>Referência</label>
                <p>{transaction.reference}</p>
              </div>
            )}
          </div>
        </div>

        {/* Related Information */}
        {(transaction.clientId || transaction.invoiceId) && (
          <div className="view-modal-section">
            <h3>Informações Relacionadas</h3>
            <div className="view-modal-grid">
              {transaction.clientId && (
                <div className="view-modal-field">
                  <label>Cliente</label>
                  <p>{transaction.clientName || transaction.clientId}</p>
                </div>
              )}

              {transaction.invoiceId && (
                <div className="view-modal-field">
                  <label>Fatura</label>
                  <p>{transaction.invoiceId}</p>
                </div>
              )}
            </div>
          </div>
        )}

        {/* Notes */}
        {transaction.notes && (
          <div className="view-modal-section">
            <h3>Notas</h3>
            <p>{transaction.notes}</p>
          </div>
        )}

        {/* Timestamps */}
        <div className="view-modal-section">
          <h3>Registo</h3>
          <div className="view-modal-grid">
            <div className="view-modal-field">
              <label>Criado em</label>
              <p>{formatDate(transaction.createdAt)}</p>
            </div>

            {transaction.updatedAt && (
              <div className="view-modal-field">
                <label>Atualizado em</label>
                <p>{formatDate(transaction.updatedAt)}</p>
              </div>
            )}
          </div>
        </div>
      </div>
    </Modal>
  );
}
