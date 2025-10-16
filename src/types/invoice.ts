// Invoice related types

export interface Invoice {
  id: string;
  invoiceNumber: string;
  clientId: string;
  clientName?: string;
  status: InvoiceStatus;
  issueDate: string;
  dueDate: string;
  paidDate?: string;
  subtotal: number;
  taxRate: number;
  taxAmount: number;
  discount?: number;
  total: number;
  items: InvoiceItem[];
  notes?: string;
  terms?: string;
  createdAt: string;
  updatedAt?: string;
}

export interface InvoiceItem {
  id?: string;
  description: string;
  quantity: number;
  unitPrice: number;
  total: number;
}

export const InvoiceStatus = {
  Draft: 'draft',
  Sent: 'sent',
  Paid: 'paid',
  Overdue: 'overdue',
  Cancelled: 'cancelled',
} as const;

export type InvoiceStatus = typeof InvoiceStatus[keyof typeof InvoiceStatus];

export interface CreateInvoiceData {
  clientId: string;
  issueDate: string;
  dueDate: string;
  items: InvoiceItem[];
  taxRate?: number;
  discount?: number;
  notes?: string;
  terms?: string;
}

export interface UpdateInvoiceData extends Partial<CreateInvoiceData> {
  id: string;
  status?: InvoiceStatus;
  paidDate?: string;
}

export interface InvoiceFilters {
  search?: string;
  status?: InvoiceStatus;
  clientId?: string;
  dateFrom?: string;
  dateTo?: string;
  amountMin?: number;
  amountMax?: number;
  sortBy?: 'invoiceNumber' | 'issueDate' | 'dueDate' | 'total';
  sortOrder?: 'asc' | 'desc';
  page?: number;
  limit?: number;
}

export interface InvoiceSummary {
  totalInvoices: number;
  totalAmount: number;
  paidAmount: number;
  pendingAmount: number;
  overdueAmount: number;
  byStatus: {
    status: InvoiceStatus;
    count: number;
    total: number;
  }[];
}
