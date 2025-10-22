import { Loader2, Save } from "lucide-react";
import { useEffect, useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import type { CreateTransactionData, Transaction } from "../../types";

interface TransactionFormProps {
  transaction?: Transaction;
  onSubmit: (data: CreateTransactionData) => void;
  isLoading?: boolean;
}

/**
 * Transaction Form Component
 * Reusable form for creating and editing transactions
 */
export default function TransactionForm({
  transaction,
  onSubmit,
  isLoading,
}: Readonly<TransactionFormProps>) {
  const [formData, setFormData] = useState<CreateTransactionData>({
    type: transaction?.type || "income",
    category: transaction?.category || "other",
    amount: transaction?.amount || 0,
    description: transaction?.description || "",
    date: transaction?.date || new Date().toISOString().split("T")[0],
    clientId: transaction?.clientId || "",
    invoiceId: transaction?.invoiceId || "",
    paymentMethod: transaction?.paymentMethod || "bank_transfer",
    reference: transaction?.reference || "",
    notes: transaction?.notes || "",
  });

  const [errors, setErrors] = useState<
    Partial<Record<keyof CreateTransactionData, string>>
  >({});

  // Update form when transaction changes (edit mode)
  useEffect(() => {
    if (transaction) {
      setFormData({
        type: transaction.type,
        category: transaction.category,
        amount: transaction.amount,
        description: transaction.description,
        date: transaction.date,
        clientId: transaction.clientId || "",
        invoiceId: transaction.invoiceId || "",
        paymentMethod: transaction.paymentMethod || "bank_transfer",
        reference: transaction.reference || "",
        notes: transaction.notes || "",
      });
    }
  }, [transaction]);

  // Handle input changes
  const handleChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>,
  ) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
    // Clear error for this field
    if (errors[name as keyof CreateTransactionData]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  // Handle select changes
  const handleSelectChange = (name: string) => (value: string) => {
    setFormData((prev) => ({ ...prev, [name]: value }));
    if (errors[name as keyof CreateTransactionData]) {
      setErrors((prev) => ({ ...prev, [name]: undefined }));
    }
  };

  // Validate form
  const validateForm = (): boolean => {
    const newErrors: Partial<Record<keyof CreateTransactionData, string>> = {};

    if (!formData.type) {
      newErrors.type = "Tipo é obrigatório";
    }

    if (!formData.category) {
      newErrors.category = "Categoria é obrigatória";
    }

    if (!formData.amount || formData.amount <= 0) {
      newErrors.amount = "Valor deve ser maior que 0";
    }

    if (!formData.description || formData.description.trim().length === 0) {
      newErrors.description = "Descrição é obrigatória";
    }

    if (!formData.date) {
      newErrors.date = "Data é obrigatória";
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
    { value: "sale", label: "Venda" },
    { value: "service", label: "Serviço" },
    { value: "subscription", label: "Subscrição" },
    { value: "other", label: "Outro" },
  ];

  // Expense categories
  const expenseCategories = [
    { value: "salary", label: "Salário" },
    { value: "rent", label: "Renda" },
    { value: "utilities", label: "Utilidades" },
    { value: "marketing", label: "Marketing" },
    { value: "software", label: "Software" },
    { value: "equipment", label: "Equipamento" },
    { value: "travel", label: "Viagens" },
    { value: "supplies", label: "Materiais" },
    { value: "other", label: "Outro" },
  ];

  const categories =
    formData.type === "income" ? incomeCategories : expenseCategories;

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
      {/* Transaction Type & Category */}
      <div className="grid gap-4 sm:grid-cols-2">
        <div className="space-y-2">
          <Label htmlFor="type" className="text-sm font-medium">
            Tipo de Transação <span className="text-destructive">*</span>
          </Label>
          <Select
            value={formData.type}
            onValueChange={handleSelectChange("type")}
            disabled={isLoading}
          >
            <SelectTrigger className={errors.type ? "border-destructive" : ""}>
              <SelectValue placeholder="Selecione o tipo" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="income">Receita</SelectItem>
              <SelectItem value="expense">Despesa</SelectItem>
            </SelectContent>
          </Select>
          {errors.type && (
            <p className="text-sm text-destructive">{errors.type}</p>
          )}
        </div>

        <div className="space-y-2">
          <Label htmlFor="category" className="text-sm font-medium">
            Categoria <span className="text-destructive">*</span>
          </Label>
          <Select
            value={formData.category}
            onValueChange={handleSelectChange("category")}
            disabled={isLoading}
          >
            <SelectTrigger
              className={errors.category ? "border-destructive" : ""}
            >
              <SelectValue placeholder="Selecione a categoria" />
            </SelectTrigger>
            <SelectContent>
              {categories.map((cat) => (
                <SelectItem key={cat.value} value={cat.value}>
                  {cat.label}
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
          {errors.category && (
            <p className="text-sm text-destructive">{errors.category}</p>
          )}
        </div>
      </div>

      {/* Amount & Date */}
      <div className="grid gap-4 sm:grid-cols-2">
        <div className="space-y-2">
          <Label htmlFor="amount" className="text-sm font-medium">
            Valor (€) <span className="text-destructive">*</span>
          </Label>
          <Input
            type="number"
            id="amount"
            name="amount"
            value={formData.amount}
            onChange={handleChange}
            className={errors.amount ? "border-destructive" : ""}
            disabled={isLoading}
            placeholder="0.00"
            step="0.01"
            min="0"
            required
          />
          {errors.amount && (
            <p className="text-sm text-destructive">{errors.amount}</p>
          )}
        </div>

        <div className="space-y-2">
          <Label htmlFor="date" className="text-sm font-medium">
            Data <span className="text-destructive">*</span>
          </Label>
          <Input
            type="date"
            id="date"
            name="date"
            value={formData.date}
            onChange={handleChange}
            className={errors.date ? "border-destructive" : ""}
            disabled={isLoading}
            required
          />
          {errors.date && (
            <p className="text-sm text-destructive">{errors.date}</p>
          )}
        </div>
      </div>

      {/* Description */}
      <div className="space-y-2">
        <Label htmlFor="description" className="text-sm font-medium">
          Descrição <span className="text-destructive">*</span>
        </Label>
        <Input
          type="text"
          id="description"
          name="description"
          value={formData.description}
          onChange={handleChange}
          className={errors.description ? "border-destructive" : ""}
          disabled={isLoading}
          placeholder="Descrição da transação"
          required
        />
        {errors.description && (
          <p className="text-sm text-destructive">{errors.description}</p>
        )}
      </div>

      {/* Payment Method & Reference */}
      <div className="grid gap-4 sm:grid-cols-2">
        <div className="space-y-2">
          <Label htmlFor="paymentMethod" className="text-sm font-medium">
            Método de Pagamento
          </Label>
          <Select
            value={formData.paymentMethod}
            onValueChange={handleSelectChange("paymentMethod")}
            disabled={isLoading}
          >
            <SelectTrigger>
              <SelectValue placeholder="Selecione o método" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="cash">Dinheiro</SelectItem>
              <SelectItem value="bank_transfer">
                Transferência Bancária
              </SelectItem>
              <SelectItem value="credit_card">Cartão de Crédito</SelectItem>
              <SelectItem value="debit_card">Cartão de Débito</SelectItem>
              <SelectItem value="paypal">PayPal</SelectItem>
              <SelectItem value="mbway">MB Way</SelectItem>
              <SelectItem value="other">Outro</SelectItem>
            </SelectContent>
          </Select>
        </div>

        <div className="space-y-2">
          <Label htmlFor="reference" className="text-sm font-medium">
            Referência
          </Label>
          <Input
            type="text"
            id="reference"
            name="reference"
            value={formData.reference}
            onChange={handleChange}
            disabled={isLoading}
            placeholder="Nº de referência"
          />
        </div>
      </div>

      {/* Client ID & Invoice ID */}
      <div className="grid gap-4 sm:grid-cols-2">
        <div className="space-y-2">
          <Label htmlFor="clientId" className="text-sm font-medium">
            ID do Cliente
          </Label>
          <Input
            type="text"
            id="clientId"
            name="clientId"
            value={formData.clientId}
            onChange={handleChange}
            disabled={isLoading}
            placeholder="Opcional"
          />
        </div>

        <div className="space-y-2">
          <Label htmlFor="invoiceId" className="text-sm font-medium">
            ID da Fatura
          </Label>
          <Input
            type="text"
            id="invoiceId"
            name="invoiceId"
            value={formData.invoiceId}
            onChange={handleChange}
            disabled={isLoading}
            placeholder="Opcional"
          />
        </div>
      </div>

      {/* Notes */}
      <div className="space-y-2">
        <Label htmlFor="notes" className="text-sm font-medium">
          Notas
        </Label>
        <Textarea
          id="notes"
          name="notes"
          value={formData.notes}
          onChange={handleChange}
          disabled={isLoading}
          placeholder="Notas adicionais (opcional)"
          rows={3}
        />
      </div>

      {/* Submit Button */}
      <div className="flex justify-end pt-4">
        <Button type="submit" disabled={isLoading}>
          {isLoading ? (
            <>
              <Loader2 className="mr-2 h-4 w-4 animate-spin" />A guardar...
            </>
          ) : (
            <>
              <Save className="mr-2 h-4 w-4" />
              {transaction ? "Atualizar" : "Criar"} Transação
            </>
          )}
        </Button>
      </div>
    </form>
  );
}
