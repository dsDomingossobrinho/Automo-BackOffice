// Account Type domain types

export interface AccountType {
  id: number;
  type: string;
  description?: string;
  createdAt?: string;
  updatedAt?: string;
}

export interface CreateAccountTypeData {
  type: string;
  description?: string;
}

export interface UpdateAccountTypeData {
  type: string;
  description?: string;
}

export type AccountTypeResponse = AccountType;
