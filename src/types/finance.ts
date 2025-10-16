// Finance related types

export interface Transaction {
  id: string;
  type: TransactionType;
  category: TransactionCategory;
  amount: number;
  description: string;
  date: string;
  clientId?: string;
  clientName?: string;
  invoiceId?: string;
  status: TransactionStatus;
  paymentMethod?: PaymentMethod;
  reference?: string;
  notes?: string;
  createdAt: string;
  updatedAt?: string;
}

export const TransactionType = {
  Income: 'income',
  Expense: 'expense',
} as const;

export type TransactionType = typeof TransactionType[keyof typeof TransactionType];

export const TransactionCategory = {
  // Income categories
  Sale: 'sale',
  Service: 'service',
  Subscription: 'subscription',
  Other: 'other',
  // Expense categories
  Salary: 'salary',
  Rent: 'rent',
  Utilities: 'utilities',
  Marketing: 'marketing',
  Software: 'software',
  Equipment: 'equipment',
  Travel: 'travel',
  Supplies: 'supplies',
} as const;

export type TransactionCategory = typeof TransactionCategory[keyof typeof TransactionCategory];

export const TransactionStatus = {
  Pending: 'pending',
  Completed: 'completed',
  Cancelled: 'cancelled',
  Failed: 'failed',
} as const;

export type TransactionStatus = typeof TransactionStatus[keyof typeof TransactionStatus];

export const PaymentMethod = {
  Cash: 'cash',
  BankTransfer: 'bank_transfer',
  CreditCard: 'credit_card',
  DebitCard: 'debit_card',
  PayPal: 'paypal',
  MBWay: 'mbway',
  Other: 'other',
} as const;

export type PaymentMethod = typeof PaymentMethod[keyof typeof PaymentMethod];

export interface CreateTransactionData {
  type: TransactionType;
  category: TransactionCategory;
  amount: number;
  description: string;
  date: string;
  clientId?: string;
  invoiceId?: string;
  paymentMethod?: PaymentMethod;
  reference?: string;
  notes?: string;
}

export interface UpdateTransactionData extends Partial<CreateTransactionData> {
  id: string;
  status?: TransactionStatus;
}

export interface TransactionFilters {
  search?: string;
  type?: TransactionType;
  category?: TransactionCategory;
  status?: TransactionStatus;
  paymentMethod?: PaymentMethod;
  clientId?: string;
  dateFrom?: string;
  dateTo?: string;
  amountMin?: number;
  amountMax?: number;
  sortBy?: 'date' | 'amount' | 'createdAt';
  sortOrder?: 'asc' | 'desc';
  page?: number;
  limit?: number;
}

export interface FinanceSummary {
  totalIncome: number;
  totalExpenses: number;
  netProfit: number;
  pendingTransactions: number;
  completedTransactions: number;
  byCategory: {
    category: TransactionCategory;
    total: number;
    count: number;
  }[];
  byMonth: {
    month: string;
    income: number;
    expenses: number;
    profit: number;
  }[];
}
