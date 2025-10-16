import { useState, useEffect } from 'react';
import type {
  Transaction,
  CreateTransactionData,
} from '../../types';

interface TransactionFormProps {
  transaction?: Transaction;
  onSubmit: (data: CreateTransactionData) => void;
  isLoading?: boolean;
}

/**
 * Transaction Form Component
 * Reusable form for creating and editing transactions
 */
export default function TransactionForm({ transaction, onSubmit, isLoading }: TransactionFormProps) {
  const [formData, setFormData] = useState<CreateTransactionData>({
    type: transaction?.type || 'income',
    category: transaction?.category || 'other',
    amount: transaction?.amount || 0,
    description: transaction?.description || '',
    date: transaction?.date || new Date().toISOString().split('T')[0],
    clientId: transaction?.clientId || '',
    invoiceId: transaction?.invoiceId || '',
    paymentMethod: transaction?.paymentMethod || 'bank_transfer',
    reference: transaction?.reference || '',
    notes: transaction?.notes || '',
  });

  const [errors, setErrors] = useState<Partial<Record<keyof CreateTransactionData, string>>>({});

  // Update form when transaction changes (edit mode)
  useEffect(() => {
    if (transaction) {
      setFormData({
        type: transaction.type,
        category: transaction.category,
        amount: transaction.amount,
        description: transaction.description,
        date: transaction.date,
        clientId: transaction.clientId || '',
        invoiceId: transaction.invoiceId || '',
        paymentMethod: transaction.paymentMethod || 'bank_transfer',
        reference: transaction.reference || '',
        notes: transaction.notes || '',
      });
    }
  }, [transaction]);

  // Handle input changes
  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
    // Clear error for this field
    if (errors[name as keyof CreateTransactionData]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  // Validate form
  const validateForm = (): boolean => {
    const newErrors: Partial<Record<keyof CreateTransactionData, string>> = {};

    if (!formData.type) {
      newErrors.type = 'Tipo é obrigatório';
    }

    if (!formData.category) {
      newErrors.category = 'Categoria é obrigatória';
    }

    if (!formData.amount || formData.amount <= 0) {
      newErrors.amount = 'Valor deve ser maior que 0';
    }

    if (!formData.description || formData.description.trim().length === 0) {
      newErrors.description = 'Descrição é obrigatória';
    }

    if (!formData.date) {
      newErrors.date = 'Data é obrigatória';
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  // Handle form submit
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (validateForm()) {
      // Convert amount to number and remove empty optional fields
      const submitData: CreateTransactionData = {
        ...formData,
        amount: Number(formData.amount),
        clientId: formData.clientId || undefined,
        invoiceId: formData.invoiceId || undefined,
        reference: formData.reference || undefined,
        notes: formData.notes || undefined,
      };
      onSubmit(submitData);
    }
  };

  // Income categories
  const incomeCategories = [
    { value: 'sale', label: 'Venda' },
    { value: 'service', label: 'Serviço' },
    { value: 'subscription', label: 'Subscrição' },
    { value: 'other', label: 'Outro' },
  ];

  // Expense categories
  const expenseCategories = [
    { value: 'salary', label: 'Salário' },
    { value: 'rent', label: 'Renda' },
    { value: 'utilities', label: 'Utilidades' },
    { value: 'marketing', label: 'Marketing' },
    { value: 'software', label: 'Software' },
    { value: 'equipment', label: 'Equipamento' },
    { value: 'travel', label: 'Viagens' },
    { value: 'supplies', label: 'Materiais' },
    { value: 'other', label: 'Outro' },
  ];

  const categories = formData.type === 'income' ? incomeCategories : expenseCategories;

  return (
    <form onSubmit={handleSubmit} className="form">
      {/* Transaction Type */}
      <div className="form-row">
        <div className="form-group">
          <label htmlFor="type" className="form-label required">
            Tipo de Transação
          </label>
          <select
            id="type"
            name="type"
            value={formData.type}
            onChange={handleChange}
            className={`form-control ${errors.type ? 'error' : ''}`}
            disabled={isLoading}
            required
          >
            <option value="income">Receita</option>
            <option value="expense">Despesa</option>
          </select>
          {errors.type && <span className="form-error">{errors.type}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="category" className="form-label required">
            Categoria
          </label>
          <select
            id="category"
            name="category"
            value={formData.category}
            onChange={handleChange}
            className={`form-control ${errors.category ? 'error' : ''}`}
            disabled={isLoading}
            required
          >
            <option value="">Selecione...</option>
            {categories.map((cat) => (
              <option key={cat.value} value={cat.value}>
                {cat.label}
              </option>
            ))}
          </select>
          {errors.category && <span className="form-error">{errors.category}</span>}
        </div>
      </div>

      {/* Amount and Date */}
      <div className="form-row">
        <div className="form-group">
          <label htmlFor="amount" className="form-label required">
            Valor (€)
          </label>
          <input
            type="number"
            id="amount"
            name="amount"
            value={formData.amount}
            onChange={handleChange}
            className={`form-control ${errors.amount ? 'error' : ''}`}
            disabled={isLoading}
            placeholder="0.00"
            step="0.01"
            min="0"
            required
          />
          {errors.amount && <span className="form-error">{errors.amount}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="date" className="form-label required">
            Data
          </label>
          <input
            type="date"
            id="date"
            name="date"
            value={formData.date}
            onChange={handleChange}
            className={`form-control ${errors.date ? 'error' : ''}`}
            disabled={isLoading}
            required
          />
          {errors.date && <span className="form-error">{errors.date}</span>}
        </div>
      </div>

      {/* Description */}
      <div className="form-group">
        <label htmlFor="description" className="form-label required">
          Descrição
        </label>
        <input
          type="text"
          id="description"
          name="description"
          value={formData.description}
          onChange={handleChange}
          className={`form-control ${errors.description ? 'error' : ''}`}
          disabled={isLoading}
          placeholder="Descrição da transação"
          required
        />
        {errors.description && <span className="form-error">{errors.description}</span>}
      </div>

      {/* Payment Method and Reference */}
      <div className="form-row">
        <div className="form-group">
          <label htmlFor="paymentMethod" className="form-label">
            Método de Pagamento
          </label>
          <select
            id="paymentMethod"
            name="paymentMethod"
            value={formData.paymentMethod}
            onChange={handleChange}
            className="form-control"
            disabled={isLoading}
          >
            <option value="cash">Dinheiro</option>
            <option value="bank_transfer">Transferência Bancária</option>
            <option value="credit_card">Cartão de Crédito</option>
            <option value="debit_card">Cartão de Débito</option>
            <option value="paypal">PayPal</option>
            <option value="mbway">MB Way</option>
            <option value="other">Outro</option>
          </select>
        </div>

        <div className="form-group">
          <label htmlFor="reference" className="form-label">
            Referência
          </label>
          <input
            type="text"
            id="reference"
            name="reference"
            value={formData.reference}
            onChange={handleChange}
            className="form-control"
            disabled={isLoading}
            placeholder="Nº de referência"
          />
        </div>
      </div>

      {/* Client ID and Invoice ID (optional) */}
      <div className="form-row">
        <div className="form-group">
          <label htmlFor="clientId" className="form-label">
            ID do Cliente
          </label>
          <input
            type="text"
            id="clientId"
            name="clientId"
            value={formData.clientId}
            onChange={handleChange}
            className="form-control"
            disabled={isLoading}
            placeholder="Opcional"
          />
        </div>

        <div className="form-group">
          <label htmlFor="invoiceId" className="form-label">
            ID da Fatura
          </label>
          <input
            type="text"
            id="invoiceId"
            name="invoiceId"
            value={formData.invoiceId}
            onChange={handleChange}
            className="form-control"
            disabled={isLoading}
            placeholder="Opcional"
          />
        </div>
      </div>

      {/* Notes */}
      <div className="form-group">
        <label htmlFor="notes" className="form-label">
          Notas
        </label>
        <textarea
          id="notes"
          name="notes"
          value={formData.notes}
          onChange={handleChange}
          className="form-control"
          disabled={isLoading}
          placeholder="Notas adicionais (opcional)"
          rows={3}
        />
      </div>

      {/* Submit Button */}
      <div className="form-actions">
        <button type="submit" className="btn btn-primary" disabled={isLoading}>
          {isLoading ? (
            <>
              <i className="fas fa-spinner fa-spin"></i> A guardar...
            </>
          ) : (
            <>
              <i className="fas fa-save"></i> {transaction ? 'Atualizar' : 'Criar'} Transação
            </>
          )}
        </button>
      </div>
    </form>
  );
}
