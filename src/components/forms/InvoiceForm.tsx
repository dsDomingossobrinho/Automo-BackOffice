import { useState, useEffect } from 'react';
import type { Invoice, CreateInvoiceData, InvoiceItem } from '../../types';

interface InvoiceFormProps {
  invoice?: Invoice;
  onSubmit: (data: CreateInvoiceData) => void;
  isLoading?: boolean;
}

/**
 * Invoice Form Component
 * Reusable form for creating and editing invoices with dynamic items
 */
export default function InvoiceForm({ invoice, onSubmit, isLoading }: InvoiceFormProps) {
  const [formData, setFormData] = useState<CreateInvoiceData>({
    clientId: invoice?.clientId || '',
    issueDate: invoice?.issueDate || new Date().toISOString().split('T')[0],
    dueDate: invoice?.dueDate || '',
    items: invoice?.items || [{ description: '', quantity: 1, unitPrice: 0, total: 0 }],
    taxRate: invoice?.taxRate || 23, // Default IVA in Portugal
    discount: invoice?.discount || 0,
    notes: invoice?.notes || '',
    terms: invoice?.terms || '',
  });

  const [errors, setErrors] = useState<Partial<Record<keyof CreateInvoiceData, string>>>({});

  // Update form when invoice changes (edit mode)
  useEffect(() => {
    if (invoice) {
      setFormData({
        clientId: invoice.clientId,
        issueDate: invoice.issueDate,
        dueDate: invoice.dueDate,
        items: invoice.items,
        taxRate: invoice.taxRate,
        discount: invoice.discount || 0,
        notes: invoice.notes || '',
        terms: invoice.terms || '',
      });
    }
  }, [invoice]);

  // Calculate totals
  const calculateTotals = () => {
    const subtotal = formData.items.reduce((sum, item) => sum + item.total, 0);
    const taxAmount = (subtotal * (formData.taxRate || 0)) / 100;
    const total = subtotal + taxAmount - (formData.discount || 0);

    return {
      subtotal: subtotal.toFixed(2),
      taxAmount: taxAmount.toFixed(2),
      total: total.toFixed(2),
    };
  };

  const totals = calculateTotals();

  // Handle input changes
  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
    // Clear error for this field
    if (errors[name as keyof CreateInvoiceData]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  // Handle item change
  const handleItemChange = (index: number, field: keyof InvoiceItem, value: string | number) => {
    const newItems = [...formData.items];
    newItems[index] = { ...newItems[index], [field]: value };

    // Recalculate item total
    if (field === 'quantity' || field === 'unitPrice') {
      const quantity = field === 'quantity' ? Number(value) : newItems[index].quantity;
      const unitPrice = field === 'unitPrice' ? Number(value) : newItems[index].unitPrice;
      newItems[index].total = quantity * unitPrice;
    }

    setFormData((prev) => ({ ...prev, items: newItems }));
  };

  // Add new item
  const handleAddItem = () => {
    setFormData((prev) => ({
      ...prev,
      items: [...prev.items, { description: '', quantity: 1, unitPrice: 0, total: 0 }],
    }));
  };

  // Remove item
  const handleRemoveItem = (index: number) => {
    if (formData.items.length === 1) return; // Keep at least one item
    const newItems = formData.items.filter((_, i) => i !== index);
    setFormData((prev) => ({ ...prev, items: newItems }));
  };

  // Validate form
  const validateForm = (): boolean => {
    const newErrors: Partial<Record<keyof CreateInvoiceData, string>> = {};

    if (!formData.clientId || formData.clientId.trim().length === 0) {
      newErrors.clientId = 'Cliente é obrigatório';
    }

    if (!formData.issueDate) {
      newErrors.issueDate = 'Data de emissão é obrigatória';
    }

    if (!formData.dueDate) {
      newErrors.dueDate = 'Data de vencimento é obrigatória';
    }

    if (formData.dueDate && formData.issueDate && formData.dueDate < formData.issueDate) {
      newErrors.dueDate = 'Data de vencimento deve ser posterior à data de emissão';
    }

    // Validate items
    const hasInvalidItems = formData.items.some(
      (item) => !item.description || item.quantity <= 0 || item.unitPrice < 0
    );

    if (hasInvalidItems) {
      newErrors.items = 'Todos os items devem ter descrição, quantidade e preço válidos';
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  // Handle form submit
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (validateForm()) {
      const submitData: CreateInvoiceData = {
        ...formData,
        taxRate: Number(formData.taxRate) || 0,
        discount: Number(formData.discount) || 0,
      };
      onSubmit(submitData);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="form">
      {/* Client and Dates */}
      <div className="form-row">
        <div className="form-group">
          <label htmlFor="clientId" className="form-label required">
            Cliente
          </label>
          <input
            type="text"
            id="clientId"
            name="clientId"
            value={formData.clientId}
            onChange={handleChange}
            className={`form-control ${errors.clientId ? 'error' : ''}`}
            disabled={isLoading}
            placeholder="ID do Cliente"
            required
          />
          {errors.clientId && <span className="form-error">{errors.clientId}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="issueDate" className="form-label required">
            Data de Emissão
          </label>
          <input
            type="date"
            id="issueDate"
            name="issueDate"
            value={formData.issueDate}
            onChange={handleChange}
            className={`form-control ${errors.issueDate ? 'error' : ''}`}
            disabled={isLoading}
            required
          />
          {errors.issueDate && <span className="form-error">{errors.issueDate}</span>}
        </div>

        <div className="form-group">
          <label htmlFor="dueDate" className="form-label required">
            Data de Vencimento
          </label>
          <input
            type="date"
            id="dueDate"
            name="dueDate"
            value={formData.dueDate}
            onChange={handleChange}
            className={`form-control ${errors.dueDate ? 'error' : ''}`}
            disabled={isLoading}
            required
          />
          {errors.dueDate && <span className="form-error">{errors.dueDate}</span>}
        </div>
      </div>

      {/* Invoice Items */}
      <div className="form-group">
        <label className="form-label required">Items da Fatura</label>
        {errors.items && <span className="form-error">{errors.items}</span>}

        <div className="invoice-items">
          {formData.items.map((item, index) => (
            <div key={index} className="invoice-item-row">
              <div className="invoice-item-field invoice-item-description">
                <input
                  type="text"
                  value={item.description}
                  onChange={(e) => handleItemChange(index, 'description', e.target.value)}
                  className="form-control"
                  placeholder="Descrição"
                  disabled={isLoading}
                  required
                />
              </div>

              <div className="invoice-item-field invoice-item-quantity">
                <input
                  type="number"
                  value={item.quantity}
                  onChange={(e) => handleItemChange(index, 'quantity', e.target.value)}
                  className="form-control"
                  placeholder="Qtd"
                  min="1"
                  step="1"
                  disabled={isLoading}
                  required
                />
              </div>

              <div className="invoice-item-field invoice-item-price">
                <input
                  type="number"
                  value={item.unitPrice}
                  onChange={(e) => handleItemChange(index, 'unitPrice', e.target.value)}
                  className="form-control"
                  placeholder="Preço Unit."
                  min="0"
                  step="0.01"
                  disabled={isLoading}
                  required
                />
              </div>

              <div className="invoice-item-field invoice-item-total">
                <input
                  type="text"
                  value={`€${item.total.toFixed(2)}`}
                  className="form-control"
                  disabled
                  readOnly
                />
              </div>

              <button
                type="button"
                className="btn-icon btn-icon-danger"
                onClick={() => handleRemoveItem(index)}
                disabled={isLoading || formData.items.length === 1}
                title="Remover item"
              >
                <i className="fas fa-trash"></i>
              </button>
            </div>
          ))}

          <button type="button" className="btn btn-secondary btn-sm" onClick={handleAddItem} disabled={isLoading}>
            <i className="fas fa-plus"></i> Adicionar Item
          </button>
        </div>
      </div>

      {/* Tax and Discount */}
      <div className="form-row">
        <div className="form-group">
          <label htmlFor="taxRate" className="form-label">
            Taxa IVA (%)
          </label>
          <input
            type="number"
            id="taxRate"
            name="taxRate"
            value={formData.taxRate}
            onChange={handleChange}
            className="form-control"
            disabled={isLoading}
            placeholder="23"
            min="0"
            max="100"
            step="0.01"
          />
        </div>

        <div className="form-group">
          <label htmlFor="discount" className="form-label">
            Desconto (€)
          </label>
          <input
            type="number"
            id="discount"
            name="discount"
            value={formData.discount}
            onChange={handleChange}
            className="form-control"
            disabled={isLoading}
            placeholder="0.00"
            min="0"
            step="0.01"
          />
        </div>
      </div>

      {/* Totals Summary */}
      <div className="invoice-totals">
        <div className="invoice-total-row">
          <span>Subtotal:</span>
          <strong>€{totals.subtotal}</strong>
        </div>
        <div className="invoice-total-row">
          <span>IVA ({formData.taxRate}%):</span>
          <strong>€{totals.taxAmount}</strong>
        </div>
        {formData.discount && formData.discount > 0 && (
          <div className="invoice-total-row">
            <span>Desconto:</span>
            <strong className="text-danger">-€{Number(formData.discount).toFixed(2)}</strong>
          </div>
        )}
        <div className="invoice-total-row invoice-total-final">
          <span>Total:</span>
          <strong>€{totals.total}</strong>
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

      {/* Terms */}
      <div className="form-group">
        <label htmlFor="terms" className="form-label">
          Termos e Condições
        </label>
        <textarea
          id="terms"
          name="terms"
          value={formData.terms}
          onChange={handleChange}
          className="form-control"
          disabled={isLoading}
          placeholder="Termos e condições (opcional)"
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
              <i className="fas fa-save"></i> {invoice ? 'Atualizar' : 'Criar'} Fatura
            </>
          )}
        </button>
      </div>
    </form>
  );
}
